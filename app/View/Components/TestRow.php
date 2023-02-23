<?php

namespace App\View\Components;

use App\Models\Test;
use Illuminate\View\Component;

class TestRow extends Component
{
    public $collection;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->collection= Test::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data['collection']=$this->collection;
        //dd($data);
        return view('components.test-row',$data);
    }
}
