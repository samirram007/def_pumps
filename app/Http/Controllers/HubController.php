<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;


class HubController extends Controller
{
    protected $roles;
    protected $routeRole='companyadmin';
    protected $roleName='companyadmin';
    protected $user=null;

    public function __construct(){
        $roles=ApiController::GetRoles();
        $del_val=['SuperAdmin','CompanyAdmin'];
        foreach ($roles as $key => $value){
               if (!in_array($value['name'],$del_val)){
                 $this->roles[$value['name']]=$value['name'];
               }

        }
        $user=   session()->has('userData')?json_decode(json_encode(session()->get('userData')),true):ApiController::user(session()->get('loginid'));
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
        //
    }
    public function list()
    {
        $response = Hub::GetHubList();
        return response()->json([
            "status" => true,
            "data"=>$response,
            "message" => "Hub fetched successfully",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;


        $data['roles'] = $this->roles;
        $info['title'] = "Search City";
        $info['size'] = "modal-md";
        $data['info'] = $info;
        $data['state_list'] = State::get_all();
        $GetView = view('module.hub.create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function address_search(Request $request)
    {
       // dd($request->all());
        $data['addressList'] = ApiController::GetAddressList($request->input('address'))->json();
       //  dd($data['addressList']);
        $GetView= view('module.hub.address_list',$data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView
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
        $user=$this->user;
        $validator = Validator::make($request->all(), [
            'hubName' => 'required|max:255',
            'hubAddress' => 'required|500',
            'stateId' => 'required|numeric',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        // dd($validator );
        // // process the data
        // if ($validator->fails()) {
        //     return response()->json([
        //         "status" => false,
        //         "errors" => $validator->errors(),
        //     ]);
        // }

        // store the user
        $data = [
            'hubName' => base64_encode($request->input('hubName')),
            'hubAddress' => base64_encode($request->input('hubAddredd')),
            'stateId' => $request->input('stateId'),
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
            'createdBy'=>$user['id']
        ];


        $response = Hub::StoreHub($data);
        return response()->json([
            "status" => true,
            "message" => "Hub created successfully",
        ]);

        //return redirect()->route('companyadmin.office.index')->with('success', 'Office created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hub  $hub
     * @return \Illuminate\Http\Response
     */
    public function show(Hub $hub)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hub  $hub
     * @return \Illuminate\Http\Response
     */
    public function edit(Hub $hub)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hub  $hub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hub $hub)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hub  $hub
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hub $hub)
    {
        //
    }
}
