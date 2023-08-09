<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    protected $roles;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user=null;
    public function __construct()
    {
        $roles = session()->has('roles')? json_decode(json_encode(session()->get('roles')), true): session()->put('roles',ApiController::GetRoles());

        $del_val=['SuperAdmin','CompanyAdmin'];
        if($roles){
            foreach ($roles as $key => $value) {
                if (!in_array($value['name'], $del_val)) {
                    $this->roles[$value['name']] = $value['name'];
                }
            }
        }
        $user=   session()->has('userData')?json_decode(json_encode(session()->get('userData')),true):ApiController::user(session()->get('loginid'));
        $roleName=session()->get('roleName');

         $this->user=json_decode(json_encode($user),true);
        $this->roleName=session()->get('roleName');
        $this->routeRole= str_replace(' ','_',strtolower($this->roleName));
    }

    public function index(){

        $data['collection']=Driver::GetDrivers();

        return view('module.driver.index',$data);

    }
    public function create(){
        return view('module.driver.create',$data);
    }
    public function store(Request $request){

    }
    public function edit($id){
        $data['collection']=Driver::GetDriver($id);
        return view('module.driver.edit',$data);
    }
    public function update(Request $request){

    }


}
