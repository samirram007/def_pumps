<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class OfficeWizard extends Model
{
    use HasFactory;
    protected $token;
    public function __construct()
    {
        $this->token = Session::has('_token') ? Session::get('_token') : '';
    }
    #override
    public static function get_payload($userId)
    {

        return Helper::GetResource('OfficeWizard/GetPayload/' . $userId);

    }
    public static function set_payload($payload)
    {

        return Helper::PostResource('OfficeWizard/StorePayload', $payload);

    }

}
