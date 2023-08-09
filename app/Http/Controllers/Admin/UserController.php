<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $roles;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user = null;
    protected $users = null;
    public function __construct()
    {
        // $roles = ApiController::GetRoles();
        $roles = session()->has('roles')? json_decode(json_encode(session()->get('roles')), true): session()->put('roles',ApiController::GetRoles());

        $del_val = ['SuperAdmin'];
        if($roles){
            foreach ($roles as $key => $value) {
                if (!in_array($value['name'], $del_val)) {
                    $this->roles[$value['name']] = $value['name'];
                }
            }
        }
        $user = session()->has('userData') ? json_decode(json_encode(session()->get('userData')), true) : ApiController::user(session()->get('loginid'));
        $roleName = session()->get('roleName');

        $this->user = json_decode(json_encode($user), true);
        $this->roleName = session()->get('roleName');
        $this->routeRole = str_replace(' ', '_', strtolower($this->roleName));
        // dd(session()->has('users'));
        if (session()->has('users')) {
            $this->users = json_decode(json_encode(session()->get('users')), true);
        } else {
            $param_data = [
                'userId' => $this->user['id'],
                'roleName' => '',
                'officeId' => $this->user['officeId'],
            ];
            $this->users = ApiController::UserListByEmployeeId($param_data);

            session()->put('users', $this->users);

        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$user= (object)ApiController::user(Session::get('loginid'));
        $user = (object) $this->user;

        $users = $this->users;
        //  dd($users);
        // $users=User::getUsers();

        $loginId = session()->get('loginId');
        $del_val = ["SuperAdmin"];
        foreach ($users as $key => $value) {
            if (in_array($value['roleName'], $del_val)) {
                unset($users[$key]);
            }
            if ($value['isActive'] == 0) {
                unset($users[$key]);
            }
        }
        $data['roles'] = $this->roles;
        $data['collections'] = $users;
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        //dd($data['collections']);
        // load the view and pass the users
        return view('companyadmin.user.user_index', $data);

    }
    public function office_users_index($id)
    {

        $office = (object) [ApiController::GetOffice($id)][0];

        $user = (object) $this->user;
        //  dd($this->users);
        if ($this->user['officeId'] == $id) {
            //     $param_data=[
            //         'userId'=>$this->user['id'],
            //         'roleName'=>'',
            //         'officeId'=>$id,
            //    ];
            // dd($this->user);
            $this->user['office'] = [
                'officeId' => $this->user['officeId'],
                'officeName' => $this->user['officeName'],
            ];
            $users = [$this->user];

        } else {
            $users = $this->users;
        }

        $loginId = session()->get('loginId');
        $del_val = ["SuperAdmin"];
        foreach ($users as $key => $value) {
            if (in_array($value['roleName'], $del_val)) {
                unset($users[$key]);
            } else if ($value['officeId'] != $id) {
                unset($users[$key]);
            }

            // if($value['isActive']==0){
            //     unset($users[$key]);
            // }
        }
        $data['roles'] = $this->roles;
        $data['collections'] = $users;
        $data['office'] = $office;
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        // load the view and pass the users
        return view('companyadmin.user.user_index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // load the create form (app/views/users/create.blade.php)
        $user = (object) $this->user;
        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);
        //dd($data['officeList']);
        $data['roles'] = $this->roles;
        $info['title'] = "Create User";
        $info['size'] = "modal-lg";
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        $GetView = view('module.user.user_create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
        //return view('companyadmin.user.user_create',$data);
    }
    public function office_user_create($id)
    {
        // load the create form (app/views/users/create.blade.php)
        $user = (object) $this->user;
        $data['officeList'] = [ApiController::GetOffice($id)];
        //dd($data['officeList']);
        $data['roles'] = $this->roles;
        $info['title'] = "Create User";
        $info['size'] = "modal-lg";
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        $GetView = view('module.user.user_create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
        //return view('companyadmin.user.user_create',$data);
    }
    public function show_filter()
    {

        $user = (object) $this->user;
        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $filter_array = [
            'officeId' => '',
            'masterOfficeId' => $user->officeId,
            'roleName' => '',
        ];

        $data['roles'] = $this->roles;
        $del_val = "SuperAdmin";
        foreach ($data['roles'] as $key => $value) {
            if ($value == $del_val) {
                unset($data['roles'][$key]);
            }
        }
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        $data['filter_array'] = session()->has('filter_array') ? session()->get('filter_array') : $filter_array;
        $view = view('companyadmin.user.user_filter', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $view,
        ]);
    }
    public function show_officeuser_filter($id)
    {
        $filter_array = [
            'officeId' => '',
            'roleName' => '',
        ];

        $user = (object) $this->user;
        //dd($user);
        $data['officeList'] = [ApiController::GetOffice($id)];

        $data['roles'] = $this->roles;
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        $data['filter_array'] = Session::has('filter_array') ? Session::get('filter_array') : $filter_array;
        $view = view('companyadmin.user.user_filter', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $view,
        ]);
    }
    public function show_filter_result(Request $request)
    {
        // get all the users from Api
        $user = $this->user;
        $office = [ApiController::GetOffice($user['officeId'])];
        // dd($office);
        $masterOfficeId = $office[0]['masterOfficeId'];
        if ($office[0]['officeTypeId'] == 1) {
            $masterOfficeId = $office[0]['officeId'];
        }
        // if($masterOfficeId==null){
        //     $masterOfficeId=$office[0]['officeId'];
        // }
        // dd($masterOfficeId);
        //dd($office->masterOfficeId);
        $param_data = [
            'userId' => '',
            'roleName' => '',
            'officeId' => $masterOfficeId,
        ];
        // dd(json_encode($param_data));
        $users = ApiController::UserListByEmployeeId($param_data);
        // dd($users);
        $loginId = session()->get('loginId');
        $del_val = ["SuperAdmin"];
        foreach ($users as $key => $value) {
            if (in_array($value['roleName'], $del_val)) {
                unset($users[$key]);
            }
            if ($value['isActive'] == 0) {
                unset($users[$key]);
            }
        }
        $data['roles'] = $this->roles;
        $filter_array = [
            'officeId' => $request->officeId,
            'roleName' => $request->roleName,
        ];

        if ($request->roleName != '') {

            $filter_array['roleName'] = $request->roleName;
            $users = collect($users)->where('roleName', $request->get('roleName'))->all();
        }
        if ($request->officeId != '') {
            $filter_array['officeId'] = $request->officeId;
            $users = collect($users)->where('officeId', $request->get('officeId'))->all();
        }
        session()->put('filter_array', $filter_array);

        $data['collections'] = $users;
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        // dd($data);
        $view = view('companyadmin.user.user_filter_result', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $view,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data

        $validator = Validator::make($request->all(), [
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
                "errors" => $validator->errors(),
            ]);
        }

        // ContactNoExistCheck

        if (User::ContactNoExistCheck($request->phoneNumber)) {
            // dd("Contact Number Already Exist");
            return response()->json([
                "status" => false,
                "errors" => ["Contact Number Already Exist"],
            ]);
            // return redirect('/user/create')->with('error', 'Contact Number already exist');
        }
        if (User::EmailExistCheck($request->email)) {
            return response()->json([
                "status" => false,
                "errors" => ["Email Already Exist"],
            ]);
            // return redirect('/user/create')->with('error', 'Email already exist');
        }

        // get the data
        $data = $request->all();
        $data['name'] = base64_encode($request->name);
        $data['email'] = $request->email;
        $data['phoneNumber'] = $request->phoneNumber;
        $data['userType'] = $request->roleName;
        $data['password'] = bcrypt('12345678');
        $data['documents'] = [];
        $data['createdBy'] = Session::get('loginid');

        // create a new user
        $user = User::createUser($data);
        // dd(json_encode($user));
        if ($user['status']) {
            $param_data = [
                'userId' => $this->user['id'],
                'roleName' => '',
                'officeId' => $this->user['officeId'],
            ];
            $this->users = User::UserListByEmployeeId($param_data);

            session()->put('users', $this->users);
            return response()->json([
                "status" => true,
                "message" => "User Created Successfully",
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "User Not Created",
            ]);
        }
        // redirect to the new user page
        // return redirect()->route('companyadmin.user.index')->with('success', 'User created successfully');

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = (object) $this->user;
        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);

        $data['editData'] = (object) ApiController::User($id);
        $data['is_self'] = $user->roleName == $data['editData']->roleName ? true : false;
        $data['roles'] = $data['is_self'] == true ? array($data['editData']->roleName) : $this->roles;
        if ($data['is_self'] == true) {
            $data['officeList'] = [ApiController::GetOffice($user->officeId)];
        }
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        $info['title'] = "Edit User";
        $info['size'] = "modal-lg";
        $GetView = view('module.user.user_edit', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);

        //return view('companyadmin.user.user_edit',$data);
    }
    public function office_user_edit($id, $office_id)
    {
        $user = (object) $this->user;
        $data['officeList'] = [ApiController::GetOffice($office_id)];
        //dd($data['officeList']);
        $data['roles'] = $this->roles;
        $data['editData'] = (object) ApiController::User($id);
        // dd($data['editData']);
        $info['title'] = "Edit User";
        $info['size'] = "modal-lg";
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        $GetView = view('module.user.user_edit', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);

        //return view('companyadmin.user.user_edit',$data);
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
        $user = (object) $this->user;
        if ($user != null) {
            $validator = Validator::make($request->all(), [
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
                    "errors" => $validator->errors(),
                ]);
            }

            $data = $request->all();
            $data['id'] = $request->id;
            $data['name'] = base64_encode($request->name);
            $data['email'] = $request->email;
            $data['phoneNumber'] = $request->phoneNumber;
            $data['userType'] = $request->roleName;
            // $data['documents'] =[];

            $data['updatedBy'] = Session::get('loginid');
            //dd(json_encode($data));
            $response = User::updateUser($data);

            if ($response['status']) {
                $param_data = [
                    'userId' => $this->user['id'],
                    'roleName' => '',
                    'officeId' => $this->user['officeId'],
                ];
                $this->users = User::UserListByEmployeeId($param_data);

                session()->put('users', $this->users);
                return response()->json([
                    "status" => true,
                    "message" => $response['message'],
                ]);
            } else {
                //dd($response['status']);
                return response()->json([
                    "status" => false,
                    "message" => $response['message'],
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
        // $user=(object)ApiController::User(Session::get('loginid'));
        $deletedBy = Session::get('loginid');
        $response = ApiController::deleteUser($id, $deletedBy);
        //dd($response);
        if ($response['status']) {
            return redirect()->route('companyadmin.user.index')->with('success', 'User deleted successfully');

        } else {
            return redirect()->route('companyadmin.user.index')->with('error', 'User Not Deleted');

        }
    }

    //user profile
    public function profile($loginid)
    {

        $data['user'] = $this->user;
        $data['routeRole'] = $this->routeRole;
        $data['roleName'] = $this->roleName;
        foreach ($data['user']['documents'] as $document) {
            if ($document['documentTypeId'] == 2) {
                $data['user']['image'] = env('LIVE_SERVER') . '/upload/UserDoc/' . $document['path'];
                // $user['image']=env('LIVE_SERVER').'/upload/UserDoc/'.$document['path'];
            }
        }
        $data['user'] = (object) $data['user'];
        $data['title'] = "Profile";
        return view('module.user.profile', $data);

    }
}
