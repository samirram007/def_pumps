<?php
namespace App\Repositories;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Repositories\Interfaces\OfficeRepositoryInterface;

class OfficeRepository   implements OfficeRepositoryInterface
{
    public function GetOfficeById($officeId):array
    {
        return ApiController::GetOffice($officeId);
    }
}
