<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }

    public static function GetDrivers(){
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Driver/DriverList')->json();
        return $res;
    }
    public static function SaveDriver($data){
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Driver/CreateDriver',$data);
        return $res;
    }
    public static function GetDriver($id){
       // dd($id);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Driver/GetDriverById/'.$id)->json();
       dd($res);
        return $res;
    }
    public static function UpdateDriver($data){
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . 'Driver/UpdateDriver',$data);
        return $res;
    }

}
