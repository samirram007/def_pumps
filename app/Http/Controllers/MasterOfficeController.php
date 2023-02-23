<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the users from Api
        $offices=ApiController::GetMasterOfficeList();
//dd($offices);
        foreach ($offices as $key => $value){

            if ($value['masterOfficeId'] != null){
                $offices[$key]['MasterOffice']=[ApiController::GetOffice($value['masterOfficeId'])];
            }
        }
        //dd($offices);
          $data['collections'] =$offices;
        // load the view and pass the users
        return view('superadmin.master_office.master_office_index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // load the create form (app/views/users/create.blade.php)
        $data['masterOfficeId'] =null;
        $offices=ApiController::GetMasterOfficeList();

        foreach ($offices as $key => $value){
            //dd($value);
            if ($value['masterOfficeId'] != null){
                unset($offices[$key]);
            }
        }
        //dd($offices);
        $data['offices'] =$offices;
        $data['officeTypes'] =  ApiController::GetOfficeTypeList();
        $data['officeTypes'] = array_filter($data['officeTypes'], function($var) use ($data){
            return ($var['officeTypeId'] == 1);
        });
        $data['gstTypes'] =  ApiController::GetGstTypeList();

        $info['title']="Create Organisation";
        $info['size']="modal-lg";

        $GetView= view('superadmin.master_office.master_office_create',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);
       // return view('superadmin.master_office.master_office_create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        // validate the data
        $validator = Validator::make($request->all(), [
            'officeName' => 'required|max:255'
        ]);
        // process the data
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        } else {
            if($request->input('gstTypeId')>0){
                $validator = Validator::make($request->all(), [
                    'gstNumber' => 'required|min:13|max:15'
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        "status" => false,
                        "errors" => $validator->errors()
                    ]);
                }
            }
            // store the user
            $data=[
                'officeName' => base64_encode($request->input('officeName')) ,
                'officeTypeId' =>$request->input('officeTypeId'),
                'masterOfficeId' => null,
                'officeAddress' => base64_encode($request->input('officeAddress')),
                'officeContactNo' => $request->input('officeContactNo'),
                'officeEmail' => $request->input('officeEmail'),
                'longitude' => $request->input('longitude'),
                'latitude' => $request->input('latitude'),
                'appName' => null,
                'tagLine'=>null,
                'logo' => null,
                'pin' => null,
                'stateId' => 0,
                'countryId' => 0,
                'gstNumber' => $request->input('gstNumber'),
                'gstTypeId' => $request->input('gstTypeId'),
                'panNumber' => null,
                'isActive' => true
            ];
       // dd(json_encode($data));
            $response = ApiController::CreateOffice($data);
          //  dd($response['status']);
            if(!$response['status']){
                return response()->json([
                    "status" => false,
                    "message" => "Office creation failed"
                ]);

            }
           return response()->json([
                "status" => true,
                "message" => "Office created successfully"
            ]);

            //return redirect()->route('superadmin.office.index')->with('success', 'Office created successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the user
        $data['masterOfficeId'] =null;
        $office=[ApiController::GetOffice($id)];
        $data['editData']=(object)$office[0];
        $data['officeTypes'] =  ApiController::GetOfficeTypeList();
        $data['officeTypes'] = array_filter($data['officeTypes'], function($var) use ($data){
            return ($var['officeTypeId'] == 1);
        });
        $data['gstTypes'] =  ApiController::GetGstTypeList();
        $data['offices'] =ApiController::GetMasterOfficeList();
        $info['title']="Edit Office";
        $info['size']="modal-lg";
        $GetView= view('superadmin.master_office.master_office_edit',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);
    }
    public function features($id)
    {
        // get the user

         $data['office']=ApiController::GetOffice($id);
        $FeatureTypeList=ApiController::GetFeatureTypeList();

        $OfficeFeatureMapperList=ApiController::GetOfficeFeatureMapperList($id);
      //  dd($OfficeFeatureMapperList);
        $FeaturesIds=[];
        foreach ($OfficeFeatureMapperList as $key => $value){
            $FeaturesIds[]=$value['featureTypeId'];
        }
        foreach ($FeatureTypeList as $key => $value){
            $FeatureTypeList[$key]['IsActive']=false;
            $FeatureTypeList[$key]['officeId']=$id;

            if(in_array($FeatureTypeList[$key]['featureTypeId'],$FeaturesIds)){
                $FeatureTypeList[$key]['IsActive']=true;
            }
        }
        $data['FeatureTypeList']=$FeatureTypeList;
        $info['title']="Edit Office";
        $info['size']="modal-lg";
        $GetView= view('superadmin.master_office.master_office_features',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);
    }
public function features_toggle(Request $request)
{
    $data=[
        'officeId'=>$request->input('officeId'),
        'featureTypeId'=>$request->input('featureTypeId'),
        'isActive'=>$request->input('isActive')=='true'?true:false
    ];
    // dd(json_encode($data,true));
    $response = ApiController::ToggleOfficeFeatureMapper($data);
    if($response->status()===200){
        return response()->json([
            "status" => true,
            "message" => "Office Feature Mapper created successfully"
        ]);
    }else{
        return response()->json([
            "status" => false,
            "message" => "Office Feature Mapper not created successfully"
        ]);
    }

}
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate the data
        $validator = Validator::make($request->all(), [
            'officeName' => 'required|max:255',
        ]);
        // process the data
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        } else {
            if($request->input('gstTypeId')>0){
                $validator = Validator::make($request->all(), [
                    'gstNumber' => 'required|min:13|max:15'
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        "status" => false,
                        "errors" => $validator->errors()
                    ]);
                }
            }
            // store the user
            $data=[
                'officeId' => $id,
                'officeName' => base64_encode($request->input('officeName')) ,
                'officeTypeId' => $request->input('officeTypeId'),
                'masterOfficeId' => null,
                'officeAddress' => base64_encode($request->input('officeAddress')),
                'officeContactNo' => $request->input('officeContactNo'),
                'officeEmail' => $request->input('officeEmail'),
                'longitude' => $request->input('longitude'),
                'latitude' => $request->input('latitude'),
                'appName' => null,
                'tagLine'=>null,
                'logo' => null,
                'pin' => null,
                'stateId' => 0,
                'countryId' => 0,
                'gstNumber' => $request->input('gstNumber'),
                'gstTypeId' => $request->input('gstTypeId'),
                'panNumber' => null,
                'isActive' => true
            ];

            $response = ApiController::UpdateOffice($data);
            if(!$response['status']){
                return response()->json([
                    "status" => false,
                    "message" => "Office update failed"
                ]);

            }
           return response()->json([
                "status" => true,
                "message" => "Office updated successfully"
            ]);

            //return redirect()->route('superadmin.office.index')->with('success', 'Office created successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
