<?php

namespace App\Models;

use App\Helpers\Helper;
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
        return Helper::GetResource('DeliveryPlan');
        // $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        // $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan')->json();
        // return $res;
    }
    public static function GetManufacturingHub()
    {
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/ManufacturingHub')->json();
        return $res;
    }
    public static function GetDeliveryRequest($data)
    {
        //dd(json_encode($data),env('API_ROUTE_URL').'api/v1/route_plan');
        $headers = ["Accept" => "application/json", "Content-Type" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_ROUTE_URL') . 'v1/route_plan', $data)->json();
        //dd($res);
        return $res;
    }
    public static function SaveDeliveryPlan($data)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/CreatePlan', $data);
        // dd($res);
        return $res;
    }
    public static function UpdateDeliveryPlan($data)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/UpdatePlan', $data);
        // dd($res);
        return $res;
    }
    public static function ApproveDeliveryPlanDetails($data)
    {
        // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/ApproveDeliveryPlanDetailsQuantity', $data);
        // dd($res);
        return $res;
    }
    public static function ApproveDeliveryPlanDetailsByAdmin($data)
    {
        //  dd(gettype($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/ApproveDeliveryPlanDetailsQuantityByAdmin', $data);
        // dd($res);
        return $res;
    }
    public static function UpdateDeliveryPlanStatus($data)
    {
        // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/UpdatePlanStatus', $data);
        // dd($res);
        return $res;
    }
    public static function UpdateReceiveDelivery($data)
    {
        // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/UpdateReceivingStatus', $data);
        // dd($res);
        return $res;
    }
    public static function AssignDriver($data)
    {
        // dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'DeliveryPlan/AssignDriver', $data);
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlan($id)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/' . $id)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryStatus()
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryStatus')->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanByOfficeId($id)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanByOfficeId/' . $id)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanAllByOfficeId($id)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanAllByOfficeId/' . $id)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanByDeliveryPlanIdOfficeId($deliveryPlanId, $officeId)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanByDeliveryPlanIdOfficeId/' . $deliveryPlanId . '/' . $officeId)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsByOfficeId($id)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsByOfficeId/' . $id)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsByDeliveryPlanIdOfficeId($deliveryPlanId, $officeId)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsByDeliveryPlanIdOfficeId/' . $deliveryPlanId . '/' . $officeId)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsFilter($officeId, $fromDate, $toDate)
    {
        // dd(json_encode($officeId));
        // dd($fromDate);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsFilter/' . $officeId . '/' . $fromDate . '/' . $toDate)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsById($id)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsById/' . $id)->json();
        // dd($res);
        return $res;
    }
    public static function GetDeliveryPlanDetailsByDeliveryPlanId($id)
    {
        //dd(json_encode($data));
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'DeliveryPlan/DeliveryPlanDetailsByDeliveryPlanId/' . $id)->json();
        // dd($res);
        return $res;
    }

}
