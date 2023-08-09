<?php

namespace App\Http\Controllers\PumpAdmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $roles;
    protected $routeRole='pumpadmin';
    protected $roleName='pumpadmin';
    protected $user=null;
    public function __construct()
    {
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
        //dd(getType(json_decode(json_encode(session()->get('userData')),true)));
        $roleName=session()->get('roleName');

        $this->user=json_decode(json_encode($user),true);
        $this->roleName=session()->get('roleName');
        $this->routeRole= str_replace(' ','_',strtolower($this->roleName));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= (object)$this->user;
        $roleName=$user->roleName;
        // $offices=ApiController::GetOfficeList($user->officeId);
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;

        $param_data=[
             'userId'=>$user->id,
             'roleName'=>'',
             'officeId'=>$user->officeId,
        ];
       // dd(json_encode($param_data));
        $users=ApiController::UserListByEmployeeId($param_data);

       // $users=User::getUsers();

         $loginId = session()->get('loginId');
         $del_val=["SuperAdmin",'CompanyAdmin',"PumpAdmin"];
         foreach ($users as $key => $value){
             if (in_array($value['roleName'],$del_val)){
                 unset($users[$key]);
             }
             if($value['isActive']==0){
                 unset($users[$key]);
             }
         }
         $data['roles'] =  $this->roles;
         $data['collections'] =$users;
        // load the view and pass the users
        return view('module.user.user_index',$data);

    }
    public function organisation_users_index($id)
    {
        $user=$this->user;
        $roleName=$this->roleName;

        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
       $office=[ApiController::GetOffice($id)];

       $param_data=[
            'userId'=>'',
            'roleName'=>'',
            'officeId'=>$id,
       ];
      // dd(json_encode($param_data));
       $users=ApiController::UserListByEmployeeId($param_data);

       //param to fetch admin for selected Office
       $param_data=[
        'userId'=>'',
        'roleName'=>'PumpAdmin',
        'officeId'=>$id,
        ];
        //$admin=ApiController::UserByRole($param_data['roleName']);
        $admin=User::getUsers();
        foreach ($admin as $key => $value){
            if (!in_array($value['officeId'],[$id])){
                unset($admin[$key]);
            }

        }
        $users=array_merge($users,$admin);

        $loginId = Session::get('loginId');
        $del_val=["SuperAdmin","CompanyAdmin","PumpAdmin"];
        foreach ($users as $key => $value){
            if (in_array($value['roleName'],$del_val)){
                unset($users[$key]);
            }
            if($value['isActive']==0){
                unset($users[$key]);
            }
        }
        //dd($users);
        $data['roles'] =  $this->roles;
        $data['collections'] =$users;
        $data['office'] =  $office[0];
        // dd($data['office']);
        //dd($data['collections']);
        // load the view and pass the users
        return view('module.user.user_index',$data);

    }
    public function create($id=null)
    {
        // return $this->create($id);
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        return view('module.user.user_create',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function office_user_create($id=null)
    {
        $user=   $this->user;
        //dd($user);
        $roleName=$this->roleName;

        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
       $office=[ApiController::GetOffice($user['officeId'])];
       $id=$user['officeId'];

        $data['roles'] =  $this->roles;
      //  dd($data['roles']);
        $del_val=["SuperAdmin","CompanyAdmin","PumpAdmin"];
        foreach ($data['roles']  as $key => $value){
            if(in_array($value,$del_val)){
                unset($data['roles'][$key]);
            }
            // if ($value== $del_val){
            //     unset($data['roles'][$key]);
            // }
        }
        if($id==null){
            $data['officeList'] =  ApiController::GetOfficeAll();
        }
        else{
            if($office[0]['masterOfficeId']==null){
                $data['officeList'] =  ApiController::GetOfficeByMasterOfficeId($user['officeId']);
                $data['masterOffice']=$office;
            }
            else{
                $data['officeList'] =  $office;
                $data['masterOffice']=[ApiController::GetOffice($office[0]['masterOfficeId'])];
            }

        }
        $info['title']="Create User";
        $info['size']="modal-lg";
        $GetView= view('module.user.user_create',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);
        //return view('superadmin.user.user_create',$data);
    }
    public function show_filter()
    {
        $user=$this->user;
        $roleName=$this->roleName;

        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
       $office=[ApiController::GetOffice($user['officeId'])];
         $id=$user['officeId'];
        $filter_array=[
            'officeId'=>'',
            'roleName'=>'',
    ];
    if($id==null){
        $data['officeList'] =  ApiController::GetOfficeAll();
    }
    else{
        if($office[0]['masterOfficeId']==null){
            $data['officeList'] =  ApiController::GetOfficeByMasterOfficeId($user['officeId']);
            $data['masterOffice']=$office;
        }
        else{
            $data['officeList'] =  $office;
            $data['masterOffice']=[ApiController::GetOffice($office[0]['masterOfficeId'])];
        }

    }

        $data['roles'] =  $this->roles;
        $del_val=["SuperAdmin","CompanyAdmin","PumpAdmin"];
        foreach ($data['roles']  as $key => $value){
            if(in_array($value,$del_val)){
                unset($data['roles'][$key]);
            }
        }
//dd($data['roles'] );
        $data['filter_array'] =Session::has('filter_array') ? Session::get('filter_array') : $filter_array;
        $view= view('module.user.user_filter',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $view
        ]);
    }
    public function show_office_user_filter($id=null)
    {
        $user=$this->user;
        $roleName=$this->roleName;

        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
       $office=[ApiController::GetOffice($user['officeId'])];
       $data['office']=$office;
         $id=$user['officeId'];

        $filter_array=[
            'officeId'=>'',
            'roleName'=>'',
    ];
    if($id==null){
        $data['officeList'] =  ApiController::GetOfficeAll();
    }
    else{
        if($office[0]['masterOfficeId']==null){
            $data['officeList'] =  ApiController::GetOfficeByMasterOfficeId($user['officeId']);
            $data['masterOffice']=$office;
        }
        else{
            $data['officeList'] =  $office;
            $data['masterOffice']=[ApiController::GetOffice($office[0]['masterOfficeId'])];
        }

    }

        $data['roles'] =  $this->roles;
        $del_val=["SuperAdmin","CompanyAdmin","PumpAdmin"];
        foreach ($data['roles']  as $key => $value){
            if (in_array($value,$del_val)){
                unset($data['roles'][$key]);
            }
        }

        $data['filter_array'] =Session::has('filter_array') ? Session::get('filter_array') : $filter_array;
        $view= view('module.user.user_filter',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $view
        ]);
    }
    public function show_filter_result(Request $request)
    {
        $user=$this->user;
        $roleName=$this->roleName;

        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
       $office=[ApiController::GetOffice($user['officeId'])];

        $masterOfficeId=$request->masterOfficeId;
        $office=[ApiController::GetOffice($masterOfficeId)];
        // $user= (object)ApiController::user(Session::get('loginid'));

        $param_data=[
             'userId'=>'',
             'roleName'=>'',
             'officeId'=>$masterOfficeId,
        ];
       // dd(json_encode($param_data));
        $users=ApiController::UserListByEmployeeId($param_data);


        if($masterOfficeId==null){
            $masterOfficeId=$request->officeId;
        }
        $param_data=[
            'userId'=>'',
            'roleName'=>'Admin',
            'officeId'=>$masterOfficeId,
            ];
            //$admin=ApiController::UserByRole($param_data['roleName']);
            $admin=User::getUsers();
            foreach ($admin as $key => $value){
                if (!in_array($value['officeId'],[$masterOfficeId])){
                    unset($admin[$key]);
                }

            }
            $users=array_merge($users,$admin);
        // dd($users);
        $loginId = Session::get('loginId');
        $del_val=["SuperAdmin"];

        if(strtolower($request->roleName)=='admin'){
            $del_val=["SuperAdmin"];
        }
        foreach ($users as $key => $value){
            if (in_array($value['roleName'], $del_val)){
                if($value['officeId']!=$masterOfficeId || $value['roleName']=='SuperAdmin'){
                    unset($users[$key]);
                }
            }
        }
        $data['roles'] =  $this->roles;
        $filter_array=[
                'officeId'=>$request->officeId,
                'masterOfficeId'=>$request->masterOfficeId,
                'roleName'=>$request->roleName,
            ];
            if(strtolower($request->roleName)=='admin'){
                $filter_array['masterOfficeId']=$request->masterOfficeId;
                $filter_array['roleName']=$request->roleName;
                $users=collect($users)->where('officeId', $request->get('masterOfficeId'))
                ->where('roleName', $request->roleName)->all();
            }else{
                if($request->roleName!=''){

                    $filter_array['roleName']=$request->roleName;
                    $users=collect($users)->where('roleName', $request->get('roleName'))->all();
                }
                if($request->officeId!=''){
                    $filter_array['officeId']=$request->officeId;
                    $users=collect($users)->where('officeId', $request->get('officeId'))->all();
                }
            }

        Session::put('filter_array',$filter_array);

        $data['collections'] =$users;
        //dd($office[0]);
        $data['office']=$office[0];
        $view= view('module.user.user_filter_result',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $view
        ]);
    }

    public function store(Request $request)
    {
        // validate the data

        $validator=Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'nullable|max:255|email',
            'phoneNumber' => 'required|max:10|regex:/^[0-9]{10}$/',
            'roleName' => 'required',
            'officeId' => 'required',
        ]);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {

                return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        }

        // ContactNoExistCheck

        if(User::ContactNoExistCheck($request->phoneNumber))
        {
            return response()->json([
                "status" => false,
                "errors" => ["Contact Number Already Exist"]
            ]);
            // return redirect('/user/create')->with('error', 'Contact Number already exist');
        }
        if(User::EmailExistCheck($request->email))
        {
            return response()->json([
                "status" => false,
                "errors" => ["Email Already Exist"]
            ]);
            // return redirect('/user/create')->with('error', 'Email already exist');
        }
        // if(ApiController::UserNameCheck($request->userName))
        // {
        //     return response()->json([
        //         "status" => false,
        //         "errors" => "User Name Already Exist"
        //     ]);
        //     // return redirect('/user/create')->with('error', 'UserName already exist');
        // }

        // get the data
        $data = $request->all();
        $data['name'] = base64_encode($request->name);
        $data['email'] =$request->email;
        $data['phoneNumber'] =$request->phoneNumber;
        $data['officeId'] =$request->officeId;
        $data['userType'] =$request->roleName;
        $data['password'] = bcrypt('12345678');
        $data['documents'] =[];
        $data['createdBy'] = Session::get('loginid');


        // create a new user
        $user =  User::createUser($data);
       // dd(json_encode($user));
        if($user['status'])
        {
            return response()->json([
                "status" => true,
                "message" => "User Created Successfully"
            ]);
        }
        else
        {
            return response()->json([
                "status" => false,
                "message" => "User Not Created"
            ]);
        }
        // redirect to the new user page
        // return redirect()->route('superadmin.user.index')->with('success', 'User created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($user_id)
    {

        $user=$this->user;
        $roleName=$this->roleName;

        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $office=[ApiController::GetOffice($user['officeId'])];
        $id=$user['officeId'];

        $data['editData']=(object)ApiController::User($user_id);
        // $data['editData']->name=base64_decode($data['editData']->name);
        //$id=$data['editData']->officeId; //$id as $officeid

        $data['roles'] =  $this->roles;
       // dd($data['roles']);
        $del_val=["SuperAdmin","CompanyAdmin","PumpAdmin" ];
        foreach ($data['roles']  as $key => $value){
            if(in_array($value,$del_val)){
                unset($data['roles'][$key]);
            }
        }
        if($id==null){
            $data['officeList'] =  ApiController::GetOfficeAll();
        }
        else{
            if($office[0]['masterOfficeId']==null){
                $data['officeList'] =  ApiController::GetOfficeByMasterOfficeId($user['officeId']);
                $data['masterOffice']=$office;
            }
            else{
                $data['officeList'] =  $office;
                $data['masterOffice']=ApiController::GetOffice($office[0]['masterOfficeId']);
            }

        }

        //dd($data['editData']);
        $info['title']="Edit User";
        $info['size']="modal-lg";
        $GetView= view('module.user.user_edit',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);

        //return view('superadmin.user.user_edit',$data);
    }
    public function office_user_edit($user_id,$id=null)
    {

        // $data['officeList'] =  ApiController::GetMasterOfficeList();
        // $data['officeList'] =  ApiController::GetOfficeAll();
        // $data['roles'] =  $this->roles;
        $data['editData']=(object)ApiController::User($user_id);
        // $data['editData']->name=base64_decode($data['editData']->name);
        //$id=$data['editData']->officeId; //$id as $officeid

        $data['roles'] =  $this->roles;
       // dd($data['roles']);
        $del_val="SuperAdmin";
        foreach ($data['roles']  as $key => $value){
            if ($value== $del_val){
                unset($data['roles'][$key]);
            }
        }
       // dd($data['roles']);
        if($id==null){
            $data['officeList'] =  ApiController::GetOfficeAll();
        }
        else{
            $data['masterOffice']=ApiController::GetOffice($id);
            //dd($data['masterOffice']);
            if($data['masterOffice'][0]['masterOfficeId']==null){
                $data['officeList'] =  ApiController::GetOfficeByMasterOfficeId($id);

            }
            else{
                $data['officeList'] =  $data['masterOffice'];
            }
            // $data['officeList'] =  ApiController::GetOfficeByMasterOfficeId($id);
            // $data['MasterOffice']=ApiController::GetOffice($id);
        }


       // dd($data);
        $info['title']="Edit User";
        $info['size']="modal-lg";
        $GetView= view('module.user.user_edit',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
        ]);

        //return view('superadmin.user.user_edit',$data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=(object)User::User($id);
        if($user!=null){
            $validator=Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'nullable|max:255|email',
                'phoneNumber' => 'required|max:10|regex:/^[0-9]{10}$/',
                'roleName' => 'required',
            ]);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {

                    return response()->json([
                        "status" => false,
                        "errors" => $validator->errors()
                    ]);
            }


           // $data = $request->all();
            $data['id']=$request->id;
            $data['name'] = base64_encode($request->name);
            $data['email'] =$request->email;
            $data['phoneNumber'] =$request->phoneNumber;
            $data['userType'] =$request->roleName;
            $data['officeId'] =$request->officeId;
            // $data['documents'] =[];

            $data['updatedBy'] = Session::get('loginid');
            // dd("update");
            //dd(json_encode($data,true));
            $response =  User::updateUser($data);
            if($response['status'])
            {
                return response()->json([
                    "status" => true,
                    "message" => "User Updated Successfully"
                ]);
            }
            else
            {
                return response()->json([
                    "status" => false,
                    "message" => "User Not Updated"
                ]);
            }


        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletedBy=Session::get('loginid');
        $response =  ApiController::deleteUser($id,$deletedBy);
        //dd($response);
        if($response['status'])
        {
            return redirect()->route('pumpadmin.user.index')->with('success', 'User deleted successfully');

        }
        else
        {
            return redirect()->route('pumpadmin.user.index')->with('error', 'User Not Deleted');

        }
    }
     //user profile
     public function profile($loginid)
     {
        $data['user']= $this->user;
        $data['routeRole']=$this->routeRole;
        $data['roleName']=$this->roleName;
        foreach($data['user']['documents'] as $document){
            if($document['documentTypeId']==2){
                $data['user']['image']=env('LIVE_SERVER').'/upload/UserDoc/'.$document['path'];
                // $user['image']=env('LIVE_SERVER').'/upload/UserDoc/'.$document['path'];
            }
        }
        $data['user']= (object)$data['user'];
        $data['title']="Profile";
        return view('module.user.profile',$data);

     }
}
