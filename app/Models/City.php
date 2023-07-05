<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City    extends Model
{
    use HasFactory;
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }
    public static function SearchCity($str){

        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "application/json"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'City/Search/'.$str)->json();
        return $res;
    }

}
