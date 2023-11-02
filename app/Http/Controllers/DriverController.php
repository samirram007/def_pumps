<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        //dd( $data['collection']);
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;


        $data['roles'] = $this->roles;
        $info['title'] = "Search Driver";
        $info['size'] = "modal-md";
        $data['info'] = $info;
        $data['driver_create_route']=route($this->routeRole .'.driver.create');
        // $data['driver_edit_route']=route($this->routeRole .'.driver.edit');
        // $data['driver_delete_route']=route($this->routeRole .'.driver.delete');

        return view('module.driver.index',$data);

    }
    public function create(){

        //dd( $data['collection']);
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;


        $data['roles'] = $this->roles;
        $info['title'] = "Add Driver";
        $info['size'] = "modal-md";
        $data['info'] = $info;
        $data['office']=Office::GetOfficeById($user['officeId']);
        $data['officeId']=$user['officeId'];

        // return view('module.driver.create',$data);

        $html = view('module.driver.create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $html,
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'driverName' => 'required|max:255',
            'contactNumber' => 'required|max:10',
            'licenceNo' => 'nullable',
        ]);
        // process the data
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }
        $data=[
            'driverName' => base64_encode($request->input('driverName')) ,
            'contactNumber' =>  $request->input('contactNumber'),
            'licenceNo' =>  $request->input('licenceNo'),
            'officeId'=>$request->input('officeId')
        ];
     //dd(json_encode($data));
        $response = Driver::SaveDriver($data);
       return response()->json([
            "status" => true,
            "message" => "Driver created successfully"
        ]);
    }
    public function edit($id){

        $data['editData']=Driver::GetDriver($id);
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;


        $data['roles'] = $this->roles;
        $info['title'] = "Edit Driver";
        $info['size'] = "modal-md";
        $data['info'] = $info;
        $data['office']=Office::GetOfficeById($user['officeId']);
        $data['officeId']=$user['officeId'];

        $html = view('module.driver.edit', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $html,
        ]);
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'driverName' => 'required|max:255',
            'contactNumber' => 'required|max:10',
            'licenceNo' => 'nullable',
        ]);
        // process the data
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }
        $data=[
            'driverId'=>$request->input('driverId'),
            'driverName' => base64_encode($request->input('driverName')) ,
            'contactNumber' =>  $request->input('contactNumber'),
            'licenceNo' =>  $request->input('licenceNo'),
            'officeId'=>$request->input('officeId')
        ];
     //dd(json_encode($data));
        $response = Driver::UpdateDriver($data);
       return response()->json([
            "status" => true,
            "message" => "Driver updated successfully"
        ]);
    }


}
