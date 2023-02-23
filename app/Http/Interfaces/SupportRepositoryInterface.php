<?php
namespace App\Http\Interfaces;

use Illuminate\Http\Request;



interface SupportRepositoryInterface{


public function SupportList();
public function SupportAdd(Request $request);
public function SupportStore(Request $request );
public function SupportDetailsStore(Request $request );
public function changeReadStatus($data);
public function ChatBody($supportId);
}
