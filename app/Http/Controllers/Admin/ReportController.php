<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Illuminate\Http\Request;
use App\Exports\UserTaskExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    protected $report_date_type=[
        'day'=>'day',
        'week'=>'week',
        'month'=>'month',
        'year'=>'year',
        'custom'=>'custom',
    ];
    protected $roles;
    protected $routeRole='companyadmin';
    protected $roleName='companyadmin';
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
    public function phpinfo()
    {
        return phpinfo();
    }
    public function index()
    {
        $user=(object)$this->user;
        $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $data['report_date_type']=$this->report_date_type;

       // dd($data['officeList']);
        return view('companyadmin.report.index',$data);
    }
    public function task_report(Request $request)
    {
        $user=(object)$this->user;
        $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $param=[
            'officeId'=>$request->officeId,
            'fromDate'=>$request->fromDate,
            'toDate'=>$request->toDate,
        ];
        $data['report']= (object) ApiController::GetTaskReport($param);
        //dd($data['report']);


        $view= view('companyadmin.report.task_report',$data)->render();
        return response()->json(
            [
                'success' => true,
                'view' => $view,
            ]
        );


    }
    public function user_task_export(Request $request)
    {
        $file_name='userTask.xlsx';

        return Excel::download((new UserTaskExport($request)), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);

    }
    //user_task_pdf
    public function user_task_pdf(Request $request)
    {
        // $user=(object)ApiController::User(Session::get('loginid'));
        // $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $param=[
            'officeId'=>$request->officeId,
            'fromDate'=>$request->fromDate,
            'toDate'=>$request->toDate,
        ];
        //dd($request->all());
        $data['report']= (object) ApiController::GetTaskReport($param);
        $data['param']=$param;
        //dd($data['report']);
        $pdf = PDF::loadView('companyadmin.report.task_report_pdf', $data);
        $fileName='userTask'.date('ymdHis').'.pdf';
        return $pdf->download($fileName);
        // return $pdf->download('userTask.pdf');
    }
}
