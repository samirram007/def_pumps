<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface OfficeRepositoryInterface
{


    public function GetOfficeById($officeId):array;
}


