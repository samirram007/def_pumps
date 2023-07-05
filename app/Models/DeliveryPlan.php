<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DeliveryPlan extends Model
{
    use HasFactory;
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }

    #override
    public static function get_all()
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan')->json();
        return $res;
    }
    public static function GetManufacturingHub(){
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/ManufacturingHub')->json();
        return $res;
    }
    public static function GetDeliveryRequest($data){
        //dd(json_encode($data));
        $headers = ["Accept" => "application/json", "Content-Type"=>"application/json"];
        $res = Http::withHeaders($headers)->post('http://115.124.120.251:5060/api/v1/route_plan',$data)->json();
       // dd($res);
        return $res;
    }
    public static function SaveDeliveryPlan($data){
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/CreatePlan',$data);
       // dd($res);
        return $res;
    }
    public static function ApproveDeliveryPlanDetails($data){
       // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/ApproveDeliveryPlanDetailsQuantity',$data);
       // dd($res);
        return $res;
    }
    public static function UpdateDeliveryPlanStatus($data){
       // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/UpdatePlanStatus',$data);
       // dd($res);
        return $res;
    }
    public static function UpdateReceiveDelivery($data){
       // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/UpdateReceivingStatus',$data);
       // dd($res);
        return $res;
    }
    public static function GetDeliveryPlan($id){
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/'.$id)->json();
       // dd($res);
        return $res;
    }
    public static function GetDeliveryStatus(){
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryStatus')->json();
       // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsByOfficeId($id){
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsByOfficeId/'.$id)->json();
       // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsFilter($officeId,$fromDate,$toDate){
       // dd(json_encode($officeId));
       // dd($fromDate);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsFilter/'.$officeId.'/'.$fromDate.'/'.$toDate)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsById($id){
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsById/'.$id)->json();
       // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsByDeliveryPlanId($id){
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsByDeliveryPlanId/'.$id)->json();
       // dd($res);
        return $res;
    }

}
