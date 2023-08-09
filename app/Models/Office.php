<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }

    public static function GetMasterOfficeList($officeId){
        //dd(env('API_RESOURCE_URL') . 'Office/getCompanyWisePump/'.$officeId.'/1?OfficeTypeIds=1');
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'Office/getCompanyWisePump/'.$officeId.'/-1?OfficeTypeIds=1')->json();
        return $res;
    }

}
