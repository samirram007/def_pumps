<?php

namespace App\Http\Controllers\Admin;

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

    public function index()
    {
        $user= $this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;

        $offices=ApiController::GetOfficeList($user['officeId']);
        //dd($offices);
        $data['MasterOffice'] =[ApiController::GetOffice($user['officeId'])];
        //dd($data['MasterOffice']);
        // $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user['officeId']);
        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user['officeId']);
        $data['officeList'] = array_filter($data['officeList'], function ($var) {
            return ($var['officeTypeId'] != 1);
        });
        $data['officeList']=array_merge($data['MasterOffice'],$data['officeList']);

        // $data['officeList'] = array_filter($data['officeList'], function ($var) {
        //     return ($var['officeTypeId'] != 1);
        // });
        $data['officeList'] = (object) $data['officeList'];
        foreach ($offices as $key => $value){

            if ($value['masterOfficeId'] != null){
                $offices[$key]['MasterOffice']=[ApiController::GetOffice($value['masterOfficeId'])];
            }
        }
        //dd($offices);
          $data['offices'] =$offices;
          $expense=ApiController::GetExpenseIndex();
          // dd($expense);
          $data['collections']=$expense == null ? [] : $expense;

        return view('module.expense.expense_index',$data);
    }

    public function create()
    {
        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;

        $data['MasterOffice'] =[ApiController::GetOffice($user->officeId)];
        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);
         $data['officeList'] = array_filter($data['officeList'], function ($var) {
            return ($var['officeTypeId'] != 1);
        });
        $data['officeList']=array_merge($data['MasterOffice'],$data['officeList']);

        $data['officeList'] = (object) $data['officeList'];
         $data['masterOfficeId'] =$user->officeId;
        //dd($data['masterOfficeId']);
        $data['officeTypes'] =  ApiController::GetOfficeTypeList();

        $data['roles'] = $this->roles;
        $info['title'] = "New Expense Voucher";
        $info['size'] = "modal-lg";
        $data['info'] = $info;
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

        $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $data['MasterOffice'] =ApiController::GetOffice($user->officeId);
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
     //  dd(count($expense));
        if(count($expense)===0){
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

         // dd(count($expense));


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
        //dd($mpdf);
        // return $mpdf->Stream();
        // $fileName=$sales[0]['officeName'].'_Sales_Report_'. date('d-m-Y',strtotime($request->fromDate)).'_'.date('d-m-Y',strtotime($request->fromDate)).'.pdf';

        $fileName=$expense[0]['officeName'].'_Expense_Report_'. date('d-m-Y',strtotime($request->fromDate)).'_'.date('d-m-Y',strtotime($request->fromDate)).'.pdf';
        return $mpdf->Output( $fileName,'I');



       //dd($data['collections']);
        // $pdf = PDF::loadView('companyadmin.expense.expense_pdf', $data)->setPaper('a4', 'landscape');
        // $fileName='Expense'.date('ymdHis').'.pdf';

        // return $pdf->download($fileName);
        // return $pdf->download('userTask.pdf');
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $validator = Validator::make($request->all(), [
            'voucherNo' => 'nullable|max:20',
            'voucherDate' => 'required',
            'amount' => 'required|numeric|min:1',
            'particulars' => 'required|max:100',
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

        }
    }
    public function edit($id)
    {
        //dd($request->all());
        $user=$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;


        $data['MasterOffice'] =[ApiController::GetOffice($user['officeId'])];
        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user['officeId']);
        $data['officeList'] = array_filter($data['officeList'], function ($var) {
            return ($var['officeTypeId'] != 1);
        });
        $data['officeList']=array_merge($data['MasterOffice'],$data['officeList']);
        // if($data['MasterOffice'][0]['masterOfficeId'] == null){

        //     $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user['officeId']);
        //     $data['officeList']=array_merge($data['MasterOffice'],$data['officeList']);
        //     // $data['officeList'] = array_filter($data['officeList'], function ($var) {
        //     //     return ($var['officeTypeId'] != 1);
        //     // });
        //     $data['officeList'] = (object) $data['officeList'];
        // }
        // else{
        //     $data['officeList'] = $data['MasterOffice'];
        // }
        $data['masterOfficeId'] =$user['officeId'];

        $data['roles'] = $this->roles;
        $info['title'] = "New Expense Voucher";
        $info['size'] = "modal-lg";
        $data['info'] = $info;
        $data['editData'] = ApiController::GetExpenseById($id)[0];
        //dd($data['editData']);
        $GetView = view('module.expense.expense_edit', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function update(Request $request)
    {
        //dd($request->all());
        $user=(object)$this->user;
        $data['roleName']=$this->roleName;
        $data['routeRole']= $this->routeRole;
        $validator = Validator::make($request->all(), [
            'expenseId' => 'required',
            'voucherNo' => 'nullable|max:20',
            'voucherDate' => 'required',
            'amount' => 'required|numeric|min:1',
            'particulars' => 'required|max:100',
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
