<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hub extends Model
{
    // 9804838929
    use HasFactory;
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }
    public static function GetHubList(){
        return Helper::GetResource('City/GetHubAll');

    }
    public static function GetHub($id){
        return Helper::GetResource('City/GetHub/'.$id);
    }
    public static function StoreHub($data){
        return Helper::PostResource('City/StoreHub',$data);
    }
    public static function UpdateHub($data){
        return Helper::PostResource('City/UpdateHub',$data);
    }
}
