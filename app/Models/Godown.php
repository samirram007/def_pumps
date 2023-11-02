<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Godown extends Model
{
    use HasFactory;
    public static function GetCurrentStockWithGodownByOfficeId($officeId)
    {

        return Helper::GetResource('Godown/GetCurrentStockWithGodownByOfficeId/'.$officeId);

    }
    public static  function SetGodownType($godowns)
    {
        $godown_types = ApiController::GodownTypes();

        foreach ($godowns as $key => $godown) {

            foreach ($godown_types as $godown_type) {
                if ($godown_type['godownTypeId'] == $godown['godownTypeId']) {
                    $godowns[$key]['godownTypeName'] = $godown_type['godownTypeName'];
                }

            }

        }
        return $godowns;
    }
}
