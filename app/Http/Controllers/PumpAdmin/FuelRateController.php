<?php

namespace App\Http\Controllers\PumpAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class FuelRateController extends Controller
{
    protected $roles;
    protected $routeRole='pumpadmin';
    protected $roleName='pumpadmin';
    protected $user=null;
    public function __construct()
    {
        $roles=ApiController::GetRoles();
        $del_val=['SuperAdmin','CompanyAdmin','PumpAdmin'];
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
    public function latest_rate($id)
    {

        $user=$this->user;
        $roleName=$this->roleName;

        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
       //$office=ApiController::GetOffice($id);

        $data['latest_rate']=ApiController::GetLatestPriceByOfficeId($id);
        $data['office']=ApiController::GetOffice($id);
        // dd($data['office']);
        // $data['latest_rate']=ApiController::GetProductTypeWithRate($id);
        //dd($data['latest_rate']);
        $info['title']="Latest Rate";
        $info['size']="modal-lg";

        $html=view('module.fuel_rate.latest_rate',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $html
        ]);
    }

    public function store_latest_rate(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'productTypeId' => 'required',
            'rate' => 'required',
            'officeId' => 'required',
        ]);
        $data=[];

        //  dd(date('c'));
        foreach ($request->input('productTypeId') as $key => $value) {
            if($request->input('rate')[$key]!=$request->input('currentRate')[$key]){
                $sdata=[
                    'productTypeId' => $value,
                    'rate' => $request->input('rate')[$key],
                    'date' => date('c'),
                    'officeId' => $request->input('officeId'),
                ];
               array_push($data,$sdata);
            }
        }
       // dd($data);
        if(count($data)==0){
            return response()->json([
                "status" => false,
                "message" => "No data found to update"
            ]);
        }
         //dd(json_encode($data));
        $response = ApiController::UpdateLatestPrice($data);
        if($response['status']==false){
            return response()->json([
                "status" => false,
                "message" => $response->message
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "Latest Price updated successfully"
        ]);
    }
    public function store_invoice_no(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'fiscalYearId' => 'required',
            'invoice_no' => 'required',
            'officeId' => 'required',
        ]);


        $data=[
            'fiscalYearId' => $request->input('fiscalYearId'),
            'lastInvoiceNo' => $request->input('invoice_no') ,
            'organizationId' => $request->input('officeId'),
        ];


         //dd(json_encode($data));
        $response = ApiController::AddOfficeLastInvoiceDetails($data);
       // dd($response);
        if($response['status']==false){
            return response()->json([
                "status" => false,
                "message" => $response['message']
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => $response['message']
        ]);
    }



}
