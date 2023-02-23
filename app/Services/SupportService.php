<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\SupportRepository;
use App\Services\Interfaces\SupportServiceInterface;
use App\Repositories\Interfaces\SupportRepositoryInterface;



class SupportService   implements SupportServiceInterface
{

    protected $supportRepository ;


    function __construct(SupportRepository $supportRepository)
    {
        $this->supportRepository = $supportRepository;
    }
    public function SupportList():array{
        return $this->supportRepository->SupportList();
    }
    public function SupportAdd(Request $request):array{
        return $this->supportRepository->SupportAdd($request);
    }
    public function SupportStore(Request $request ):array{
        return $this->supportRepository->SupportStore($request);
    }
    public function ChatBody(Request $request):array{
        return $this->supportRepository->ChatBody($request);
    }

}
