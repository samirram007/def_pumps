<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CityController extends Controller
{
    protected $roles;
    protected $routeRole='companyadmin';
    protected $roleName='companyadmin';
    protected $user=null;

    public function __construct(){
        // $roles=ApiController::GetRoles();
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

        function city_search_form()  {
            $user=$this->user;
            $data['roleName']=$this->roleName;
            $data['routeRole']= $this->routeRole;


            $data['roles'] = $this->roles;
            $info['title'] = "Search City";
            $info['size'] = "modal-md";
            $data['info'] = $info;

            $GetView = view('module.city.search_form', $data)->render();
            return response()->json([
                "status" => true,
                "html" => $GetView,
            ]);

        }
        function city_search($str)  {

             $cities=City::SearchCity($str);
            // dd($cities);
            return response()->json([
                "status" => true,
                "cities" => $cities,
            ]);

        }
        function city_add(Request $request)  {

        }
}
