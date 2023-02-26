<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

class StockController extends Controller
{
    protected $roles;
    protected $routeRole='pumpadmin';
    protected $roleName='pumpadmin';
    protected $user=null;
    public function __construct()
    {
        $roles=ApiController::GetRoles();
        $del_val=['SuperAdmin','CompanyAdmin'];
        foreach ($roles as $key => $value){
               if (!in_array($value['name'],$del_val)){
                 $this->roles[$value['name']]=$value['name'];
               }

        }
        $user=   session()->has('userData')?json_decode(json_encode(session()->get('userData')),true):ApiController::user(session()->get('loginid'));
        $this->user=json_decode(json_encode($user),true);
        $this->roleName=session()->get('roleName');
        $this->routeRole= str_replace(' ','_',strtolower($this->roleName));
    }
    public function current_stock($id)
    {
        $user=$this->user;
        $roleName=$this->roleName;

        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;

         $data['current_stock']=ApiController::GetCurrentStockByOfficeId($id);
         //dd($data['current_stock']);
        $data['office']=ApiController::GetOffice($id);
         // dd($data['office']);
        // $data['latest_rate']=ApiController::GetProductTypeWithRate($id);
        //dd($data['latest_rate']);
        $info['title']="Current Stock";
        $info['size']="modal-lg";

        $html=view('module.stock.current_stock',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $html
        ]);
    }

    public function store_current_stock(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'productTypeId' => 'required',
            'currentStock' => 'required',
            'officeId' => 'required',
        ]);
        $data=[];

        //  dd(date('c'));
        foreach ($request->input('productTypeId') as $key => $value) {
            // dd($request->input('currentStock')[$key]==$request->input('stock')[$key]? 'true':'false');
            if($request->input('currentStock')[$key]!=$request->input('stock')[$key]){
                $sdata=[
                    'productTypeId' => $request->input('productTypeId')[$key],
                    'currentStock' => $request->input('currentStock')[$key],
                    'officeId' => $request->input('officeId'),
                    'updatedBy' => session()->get('loginid'),
                ];
               array_push($data,$sdata);
            }
        }

        if(count($data)==0){
            return response()->json([
                "status" => false,
                "message" => "No data found to update"
            ]);
        }
        //  dd(json_encode($data));
        $response = ApiController::UpdateCurrentStock($data);
        if($response['status']==false){
            return response()->json([
                "status" => false,
                "message" => $response->message
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "Current Stock updated successfully"
        ]);
    }
}
