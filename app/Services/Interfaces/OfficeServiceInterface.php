<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface OfficeServiceInterface
{


    public function GetOfficeById($officeId):array;
}
