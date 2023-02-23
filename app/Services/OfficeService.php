<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\OfficeRepository;
use App\Services\Interfaces\OfficeServiceInterface;
use App\Repositories\Interfaces\OfficeRepositoryInterface;



class OfficeService   implements OfficeServiceInterface
{

    protected $officeRepository ;


    function __construct(OfficeRepository $officeRepository)
    {
        $this->officeRepository = $officeRepository;
    }
    public function GetOfficeById($officeId):array
    {
        return $this->officeRepository->GetOfficeById($officeId);
    }
}
