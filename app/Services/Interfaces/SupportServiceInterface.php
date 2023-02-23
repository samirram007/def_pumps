<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface SupportServiceInterface
{

    public function SupportList():array;
    public function SupportAdd(Request $request):array;
    public function SupportStore(Request $request ):array;
    public function ChatBody(Request $request):array;
}
