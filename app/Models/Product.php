<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
class Product extends Model
{
    use HasFactory;
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }
    #override
    public static function get_all($office_id)
    {
        //dd($data);
        $headers = ["Authorization" => "Bearer " . Session::get('_token'), "Accept" => "*"];
        $res = Http::withHeaders($headers)->get(env('API_RESOURCE_URL') . 'ProductType/'.$office_id)->json();
        return $res;
    }
}
