<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;

class ProjectController extends Controller
{

    protected $roles=[
        'Customer'=>'Customer',
        'User'=>'User',
        'PumpAdmin'=>'PumpAdmin',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userData = Session::has('loginid') ? (object) ApiController::User(Session::get('loginid')) : '';
        // dd($userData);
        $userData->roleName = strtolower($userData->roleName);
        // $data['collections'] =ApiController::GetProjectList($userData->id);
        $data['collections'] = ApiController::GetProjectList_Admin($userData->id);
        //  dd($data['collections']);
        return view('companyadmin.project.project_index', $data);

        //
        // return view('companyadmin.project.project_index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // load the create form (app/views/users/create.blade.php)
        $user = (object) ApiController::User(Session::get('loginid'));

        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);
//dd($data['officeList']);
        $data['roles'] = $this->roles;
        $info['title'] = "Create Project";
        $info['size'] = "modal-lg";
        $data['info'] = $info;
        $GetView = view('companyadmin.project.project_create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
        //return view('companyadmin.user.user_create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = (object) ApiController::User(Session::get('loginid'));
        dd($request->all());
       foreach ($request->file('files') as $docfile) {
        $doc['lstFiles']= $docfile;
        $doc['saveDocumentResourc']=json_encode([
            'CreatedBy'=>$user->id,
            'ModuleId'=>2,
        ]);
        $docs_res=ApiController::SaveDocumentResource($doc);


      }

        $data['officeId'] = $request->officeId;
        $data['startDate'] = $request->startDate;
        $data['endDate'] = $request->endDate;
        $data['projectStatus'] = 2;
        $data['projectDescription'] = base64_encode($request->projectDescription);
        $data['projectName'] = base64_encode($request->projectName);
        $data['documents'] = $request->documents==null?[]:$request->documents;
        $data['createdBy'] = $user->id;
        $response = ApiController::CreateProject($data);
        return response()->json([
             "status" => true,
             "message" => "Project created successfully"
         ]);
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
        // load the create form (app/views/users/create.blade.php)
        $user = (object) ApiController::User(Session::get('loginid'));

        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);

        $data['roles'] = $this->roles;
        $info['title'] = "Edit Project";
        $info['size'] = "modal-lg";
        $data['info'] = $info;
        $data['editCollection'] = (object)ApiController::GetProjectById($id);
        $GetView = view('companyadmin.project.project_edit', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
