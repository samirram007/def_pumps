<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Helper
{
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }
    public static function getSupport($id): array
    {
        return [
            'id' => $id,
            'name' => 'Support',
            'email' => '',
            'phone' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
        ];
    }
    public static function GetResource($url){
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . $url)->json();
        return $res;
    }
    public static function PostResource($url,$data){
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->post(env('API_RESOURCE_URL') . $url,$data);
        return $res;
    }
}
