<?php

namespace App\Http\Controllers\PumpAdmin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ExpenseExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ApiController;
Use PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class ExpenseController extends Controller
{
    protected $roles;
    protected $routeRole='pumpadmin';
    protected $roleName='pumpadmin';
    protected $user=null;
    public function __construct()
    {
        // $roles=ApiController::GetRoles();
        $roles = session()->has('roles')? json_decode(json_encode(session()->get('roles')), true): session()->put('roles',ApiController::GetRoles());

        $del_val=['SuperAdmin','CompanyAdmin','PumpAdmin'];
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

    public function index()
    {
        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $offices=ApiController::GetOfficeList($user->officeId);
        $data['MasterOffice'] =[ApiController::GetOffice($user->officeId)];
        if($data['MasterOffice'][0]['masterOfficeId'] == null){
        $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        }
        else{
            $data['officeList'] = $data['MasterOffice'];
        }


        foreach ($offices as $key => $value){

            if ($value['masterOfficeId'] != null){
                $offices[$key]['MasterOffice']=[ApiController::GetOffice($value['masterOfficeId'])];
            }
        }

          $data['offices'] =$offices;
          $expense=[];
          $data['collections']=$expense == null ? [] : $expense;

        return view('module.expense.expense_index',$data);
    }

    public function create()
    {
        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;


        $data['MasterOffice'] =[ApiController::GetOffice($user->officeId)];
        if($data['MasterOffice'][0]['masterOfficeId'] == null){
            $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        }
        else{
            $data['officeList'] = $data['MasterOffice'];
        }
        $data['masterOfficeId'] =$user->officeId;

        $data['roles'] = $this->roles;
        $info['title'] = "New Expense Voucher";
        $info['size'] = "modal-lg";
        $data['info'] = $info;
        //dd($data);
        $GetView = view('module.expense.expense_create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }

    public function expense_filter(Request $request)
    {
        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $offices=ApiController::GetOfficeList($user->officeId);



        $data['MasterOffice'] =[ApiController::GetOffice($user->officeId)];
        if($data['MasterOffice'][0]['masterOfficeId'] == null){
        $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        }
        else{
            $data['officeList'] = $data['MasterOffice'];
        }

        $param=[
            'officeId'=>$request->officeId,
            'fromDate'=>$request->fromDate,
            'toDate'=>$request->toDate,
        ];
        // $data['report']= (object) ApiController::GetTaskReport($param);
        $expense=ApiController::GetExpenseIndexByDateOffice($request->fromDate,$request->toDate,$request->officeId);
           //dd($expense);
          $data['collections']=$expense == null ? [] : $expense;
        //dd($data['report']);
        //dd(typeOf($data['report']));
        //dd($data['collections']);
        $view= view('module.expense.expense_index_body',$data)->render();
        return response()->json(
            [
                'success' => true,
                'view' => $view,
            ]
        );


    }
    public function expense_export(Request $request)
    {
        $file_name='expenseReport.xlsx';

        return Excel::download((new ExpenseExport($request)), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);

    }
    public function expense_pdf(Request $request)
    {
        // $user=(object)ApiController::User(Session::get('loginid'));
        // $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $param=[
            'officeId'=>$request->officeId,
            'fromDate'=>$request->fromDate,
            'toDate'=>$request->toDate,
        ];
        //dd($request->all());
        //$data['report']= (object) ApiController::GetTaskReport($param);
        $data['param']=$param;
        $expense=ApiController::GetExpenseIndexByDateOffice($request->fromDate,$request->toDate,$request->officeId);
        if(count($expense)==0){
            return response()->json(
                [
                    'status' => 'error',
                    'success' => false,
                    'message' => 'No Data Found',
                ]
            );
        }
        $field['title'] =  __('Expense Report') ;
        $field['Period'] =  __('Period') ;
         //dd($expense);
        $data['field']=$field;
         //dd($expense);
          $data['collections']=$expense == null ? [] : $expense;




          $mpdf=new \Mpdf\Mpdf(
            [
               'mode' => 'utf-8',
               'default_font' => 'freeserif',
                'format' => 'A4-L',
                'autoLangToFont' => true,
                'autoScriptToLang' => true, // this is the important part

            ]

        );
        // $mpdf->SetFont('Arial Unicode', '', 14);
        $mpdf->SetFont('freeserif', '', 14);
        // $mpdf->TTFont('Lohit Hindi', '', 14);
        // $mpdf->TTFont('Lohit Bengali', '', 14);
        $html=view('module.expense.expense_pdf',$data)->render();
        //dd($html);
        $mpdf->WriteHTML($html);
        $fileName=$expense[0]['officeName'].'_Expense_Report_'. date('d-m-Y',strtotime($request->fromDate)).'_'.date('d-m-Y',strtotime($request->fromDate)).'.pdf';
        return $mpdf->Output( $fileName,'I');
    }
    public function store(Request $request)
    {

        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;

        $validator = Validator::make($request->all(), [
            'voucherNo' => 'nullable|max:255',
            'voucherDate' => 'required',
            'amount' => 'required|numeric|min:1',
            'particulars' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // process the data
        $data['documentId']=null;
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        } else {
            $imageName = null;
            if ($request->hasFile('image')) {
                //$image = $request->file('image');
                // $imageData = $request->file('image');
                // $imageName = time() . '.' . $imageData->getClientOriginalExtension();
                $docRes=json_encode([
                    'CreatedBy'=>$user->id,
                    'ModuleId'=>'6'
                ]) ;
                    $lstFiles =  $request->file('image');
                    //$lstFiles->getClientOriginalName();
                    $saveDocumentResourc= ['saveDocumentResourc'=>$docRes];
                 $docId=ApiController::SaveDocumentResource($lstFiles,$saveDocumentResourc);
               //dd($docId);
                $data['documentId']=$docId;
            }
            //dd(Str::uuid());
            $data=[
                'voucherNo' => base64_encode($request->input('voucherNo')) ,
                'officeId' => $request->input('officeId'),
                'CreatedBy' =>  $user->id,
                'voucherDate' =>$request->input('voucherDate'),
                'amount' => $request->input('amount'),
                'particulars' => base64_encode($request->input('particulars')),

            ];
       //dd(json_encode($data));
            $response = ApiController::CreateExpense($data);
            if(!$response['status']==true){
                return response()->json([
                    "status" => false,
                    "message" => "Expense Added Failed"
                ]);
            }
           return response()->json([
                "status" => true,
                "message" => "Expense Added successfully"
            ]);

            //return redirect()->route('admin.office.index')->with('success', 'Office created successfully');
        }
    }
    public function edit($id)
    {
        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;


        $data['MasterOffice'] =[ApiController::GetOffice($user->officeId)];
        if($data['MasterOffice'][0]['masterOfficeId'] == null){
            $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        }
        else{
            $data['officeList'] = $data['MasterOffice'];
        }
        $data['masterOfficeId'] =$user->officeId;

        $data['roles'] = $this->roles;
        $info['title'] = "New Expense Voucher";
        $info['size'] = "modal-lg";
        $data['info'] = $info;
        $data['editData'] = ApiController::GetExpenseById($id)[0];
        // dd($data['editData']);
        $GetView = view('module.expense.expense_edit', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $validator = Validator::make($request->all(), [
            'expenseId' => 'required',
            'voucherNo' => 'nullable|max:255',
            'voucherDate' => 'required',
            'amount' => 'required|numeric|min:1',
            'particulars' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // process the data
        $data['documentId']=null;
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        } else {
            $imageName = null;
            if ($request->hasFile('image')) {
                //$image = $request->file('image');
                // $imageData = $request->file('image');
                // $imageName = time() . '.' . $imageData->getClientOriginalExtension();
                $docRes=json_encode([
                    'CreatedBy'=>$user->id,
                    'ModuleId'=>'6'
                ]) ;
                    $lstFiles =  $request->file('image');
                    //$lstFiles->getClientOriginalName();
                    $saveDocumentResourc= ['saveDocumentResourc'=>$docRes];
                 $docId=ApiController::SaveDocumentResource($lstFiles,$saveDocumentResourc);
               //dd($docId);
                $data['documentId']=$docId;
            }
            //dd(Str::uuid());
            $data=[
                'expenseId' => $request->input('expenseId'),
                'voucherNo' => base64_encode($request->input('voucherNo')) ,
                'officeId' => $request->input('officeId'),
                'UpdatedBy' =>  $user->id,
                'voucherDate' =>$request->input('voucherDate'),
                'amount' => $request->input('amount'),
                'particulars' => base64_encode($request->input('particulars')),

            ];
       //dd(json_encode($data));
            $response = ApiController::UpdateExpense($data);
            if(!$response['status']==true){
                return response()->json([
                    "status" => false,
                    "message" => "Expense Not Updated"
                ]);
            }
           return response()->json([
                "status" => true,
                "message" => "Expense Updated successfully"
            ]);

        }
    }
    public function destroy($id)
    {
        $user = $this->user!=null? $this->user: ApiController::User(Session::get('loginid'));

         $roleName=$this->roleName;
        $routeRole= $this->routeRole;
        $response = ApiController::DeleteExpense($id,$user->id);
        if(!$response['status']==true){
            return \redirect()->route($routeRole.'.expense.index')->with('error', $response['message']);
        }
        return \redirect()->route($routeRole.'.expense.index')->with('success', 'Expense deleted successfully');



    }
}
