<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Godown extends Model
{
    use HasFactory;
    public static function GetCurrentStockWithGodownByOfficeId($officeId)
    {

        return Helper::GetResource('Godown/GetCurrentStockWithGodownByOfficeId/'.$officeId);

    }
}
