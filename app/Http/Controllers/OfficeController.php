<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OfficeService;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    protected $supportService;
    protected $roles;
    protected $routeRole='superadmin';
    protected $roleName='superadmin';
    protected $user=null;
    protected $officeService;
    protected $limit;

    public function __construct(OfficeService $officeService)
    {
        $this->officeService =  $officeService;
        $this->limit = 10;
        $roles=ApiController::GetRoles();
       $del_val=['SuperAdmin'];
       foreach ($roles as $key => $value){
              if (!in_array($value['name'],$del_val)){
                $this->roles[$value['name']]=$value['name'];
              }
        }
        $user=   session()->has('userData')?json_decode(json_encode(session()->get('userData')),true):ApiController::user(session()->get('loginid'));
        $roleName=session()->get('roleName');

        $this->user=json_decode(json_encode($user),true);
        $this->roleName=session()->get('roleName');
        $this->routeRole= str_replace(' ','_',strtolower($this->roleName));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {
        // get all the users from Api
        $user=(object)$this->user;

        $fiscalYearId=Session::has('fiscalYearId')?  Session::get('fiscalYearId') :  $user->fiscalYear['fiscalYearId'];

        $offices=ApiController::GetOfficeListWithInvoiceNo($id,$fiscalYearId);
        $offices=array_filter($offices, function($var) use ($id){
            return ($var['level'] == 1);
        });

        // $offices=ApiController::GetOfficeList($id);
        $data['MasterOffice'] =[ApiController::GetOffice($id)];

        $data['collections'] =$offices;
        // load the view and pass the users
        return view('superadmin.office.office_index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // load the create form (app/views/users/create.blade.php)


        $data['roleName']=$this->roleName;
        $data['routeRole']=$this->routeRole;
        $user=(object)$this->user;

        $data['masterOfficeId'] =$id;
        //dd($data['masterOfficeId']);
        $data['officeTypes'] =  ApiController::GetOfficeTypeList();
        $data['gstTypes'] =  ApiController::GetGstTypeList();

        $info['title']="Create Office";
        $info['size']="modal-lg";


        $GetView= view('superadmin.office.office_create',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

 public function store(Request $request)
    {
        // validate the data

        $validator = Validator::make($request->all(), [
            'officeName' => 'required|max:255',
            'masterOfficeId' => 'nullable',
            'officeContactNo' => 'nullable|numeric|digits:10',
            'officeEmail' => 'nullable|max:255|email',
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
                'officeTypeId' =>  $request->input('officeTypeId'),
                'masterOfficeId' => $request->input('masterOfficeId'),
                'registeredAddress' => base64_encode($request->input('registeredAddress')),
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
                'countryId' => null,
                'gstNumber' => $request->input('gstNumber'),
                'gstTypeId' => $request->input('gstTypeId'),
                'panNumber' => null,
                'isActive' => true
            ];
         //dd(json_encode($data));
            $response = ApiController::CreateOffice($data);
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

        $data['roleName']=$this->roleName;
        $data['routeRole']=$this->routeRole;
        $office=[ApiController::GetOffice($id)];

        $data['officeTypes'] =  ApiController::GetOfficeTypeList();
        $data['gstTypes'] =  ApiController::GetGstTypeList();
        $data['editData'] = (object)$office[0];
        $info['title']="Create Office";
        $info['size']="modal-lg";

        //dd($data['editData'] );
        $GetView= view('superadmin.office.office_edit',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);


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
       // dd($request->all());
        // validate the data
        $validator = Validator::make($request->all(), [
            'officeName' => 'required|max:255',
            'masterOfficeId' => 'nullable',
            'officeContactNo' => 'nullable|numeric|digits:10',
            'officeEmail' => 'nullable|max:255|email',
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
            // update office

            $data=[
                'officeId' => $id,
                'officeName' => base64_encode($request->input('officeName')) ,
                'officeTypeId' =>$request->input('officeTypeId'),
                'masterOfficeId' => $request->input('masterOfficeId'),
                'officeAddress' => base64_encode($request->input('officeAddress')),
                'registeredAddress' => base64_encode($request->input('registeredAddress')),
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

        //    dd(json_encode($data));
            $response = ApiController::UpdateOffice($data);
            return response()->json([
                "status" => true,
                "message" => "Updation successfull"
            ]);
            //return redirect()->route('superadmin.office.index',$request->input('masterOfficeId'))->with('success', 'Office updated successfully');
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

    public function address_search(Request $request)
    {
       // dd($request->all());
        $data['addressList'] = ApiController::GetAddressList($request->input('address'))->json();
       //  dd($data['addressList']);
        $GetView= view('module.office._partial.address_list',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);
    }
}
