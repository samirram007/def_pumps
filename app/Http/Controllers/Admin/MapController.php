<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;

class MapController extends Controller
{
    protected $paymentMode=[];
    protected $roles;
    protected $routeRole='companyadmin';
    protected $roleName='companyadmin';
    protected $user=null;

    public function __construct()
    {


        // $roles=ApiController::GetRoles();
        $roles = session()->has('roles')? json_decode(json_encode(session()->get('roles')), true): session()->put('roles',ApiController::GetRoles());

        $del_val=['SuperAdmin','CompanyAdmin'];
        if($roles){
            foreach ($roles as $key => $value) {
                if (!in_array($value['name'], $del_val)) {
                    $this->roles[$value['name']] = $value['name'];
                }
            }
        }
             $user=   session()->has('userData')?json_decode(json_encode(session()->get('userData')),true):ApiController::user(session()->get('loginid'));
             $roleName=session()->get('roleName');

        $this->user=json_decode(json_encode($user),true);
        $this->roleName=session()->get('roleName');
        $this->routeRole= str_replace(' ','_',strtolower($this->roleName));
    }

    public function map($id='')
    {
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $data['product_types']=ApiController::GetProductType($user['officeId']);

        $data['office']=ApiController::GetOffice($user['officeId']);
        // dd($user);
        $officeId=  $user['officeId'] ; //'D5355D33-02CF-40B0-5246-08DA286D7F4A';
       // dd($officeId);
        // $url=$id==''?'http://115.124.120.251:5250/api/master/views/powerstations/pmp': base64_decode($id);
        if($data['routeRole']=='companyadmin'){
            $url=  env('API_RESOURCE_URL') .'Office/getCompanyWisePump/'.$officeId.'/1?OfficeTypeIds=2,3';
        }else{
            $url=  env('API_RESOURCE_URL') .'Office/getCompanyWisePump/'.$officeId.'/1?OfficeTypeIds=2,3';
        }

       // $url=  env('API_RESOURCE_URL') .'Office/getCompanyWisePump/'.$officeId.'/1?OfficeTypeIds=2,3';

        // $headers = [ "Accept" => "application/json",];
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get($url)->json();

        //dd($data);
        $cnt=0;

        asort($res);
        $res['map_data'] = array_values($res);
        foreach($res['map_data'] as $key=>$val){
            $res['map_data'][$key]['flag']=$res['map_data'][$key]['officeTypeName'];
          //  $cnt++;
        }
       // dd($res['map_data']);

        $data['TITLE']='Def Pumps';
        $data['map_data'] = json_encode($res['map_data']);

       // dd($data['routeRole']);
        return view('module.map.map_index' , $data);
    }
    public function map_filter(Request $request){
       // dd($request->all());
        $map_filter = $request->map_filter;

        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;


        $data['office']=ApiController::GetOffice($user['officeId']);
        // dd($user);
        $officeId=  $user['officeId'] ; //'D5355D33-02CF-40B0-5246-08DA286D7F4A';
        // $url=$id==''?'http://115.124.120.251:5250/api/master/views/powerstations/pmp': base64_decode($id);


        if($data['routeRole']=='companyadmin'){
            $url=  env('API_RESOURCE_URL') .'Office/getCompanyWisePump/'.$officeId.'/'.$map_filter.'?OfficeTypeIds=2,3';
        }else{
            $url=  env('API_RESOURCE_URL') .'Office/getCompanyWisePump/'.$officeId.'/'.$map_filter.'?OfficeTypeIds=2,3';
        }
        //dd($url);
        // $headers = [ "Accept" => "application/json",];
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*",];
        $res = Http::withHeaders($headers)->get($url)->json();

        //dd($data);
        $cnt=0;

        asort($res);
        $res['map_data'] = array_values($res);

        foreach($res['map_data'] as $key=>$val){
            $res['map_data'][$key]['flag']=$res['map_data'][$key]['officeTypeName'];
          //  $cnt++;
        }
        //dd($res['map_data']);

        $data['TITLE']='Def Pumps';
        $data['map_data'] = json_encode($res['map_data']);

        //dd($data['map_data']);
        //$html= view('module.map.map' , $data)->render();

        return response()->json(['status'=>true,'res'=>    $data]);

    }
}
