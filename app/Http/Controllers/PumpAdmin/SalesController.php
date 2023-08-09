<?php

namespace App\Http\Controllers\PumpAdmin;

use App\Exports\SalesExport;
//  use MPDF;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    protected $roles;
    protected $paymentMode = [];
    protected $routeRole = 'pumpadmin';
    protected $roleName = 'pumpadmin';
    protected $user = null;
    public function __construct()
    {
        // $roles = ApiController::GetRoles();
        $roles = session()->has('roles')? json_decode(json_encode(session()->get('roles')), true): session()->put('roles',ApiController::GetRoles());

        $del_val = ['SuperAdmin', 'CompanyAdmin', 'PumpAdmin'];
        if($roles){
            foreach ($roles as $key => $value) {
                if (!in_array($value['name'], $del_val)) {
                    $this->roles[$value['name']] = $value['name'];
                }
            }
        }
        $this->paymentMode = ApiController::GetPaymentMode();
        $user = session()->has('userData') ? json_decode(json_encode(session()->get('userData')), true) : ApiController::user(session()->get('loginid'));
        $roleName = session()->get('roleName');

        $this->user = json_decode(json_encode($user), true);
        $this->roleName = session()->get('roleName');
        $this->routeRole = str_replace(' ', '_', strtolower($this->roleName));
    }
    public function index()
    {

        $user = (object) ApiController::User(Session::get('loginid'));

        $offices = ApiController::GetOfficeList($user->officeId);
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $data['MasterOffice'] = [ApiController::GetOffice($user->officeId)];
        if ($data['MasterOffice'][0]['masterOfficeId'] == null) {
            $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        } else {
            $data['officeList'] = $data['MasterOffice'];
        }

        foreach ($offices as $key => $value) {

            if ($value['masterOfficeId'] != null) {
                $offices[$key]['MasterOffice'] = [ApiController::GetOffice($value['masterOfficeId'])];
            }
        }

        $data['offices'] = $offices;
        //   $sales=ApiController::GetSalesIndex();

        $data['paymentMode'] = $this->paymentMode;
        //   $data['collections']=$sales == null ? [] : $sales;
        $data['collections'] = []; //$sales == null ? [] : $sales;

        return view('module.sales.sales_index', $data);

    }
    public function init_data($data): array
    {
        $data['paymentMode'] = $this->paymentMode;
        $data['roles'] = $this->roles;
        $user = (object) ApiController::User(Session::get('loginid'));
        $roleName = $user->roleName;
        $offices = ApiController::GetOfficeList($user->officeId);
        $data['roleName'] = $roleName;
        $data['routeRole'] = str_replace(' ', '_', strtolower($roleName));

        return $data;
    }
    public function sales_filter(Request $request)
    {
        $user = (object) ApiController::User(Session::get('loginid'));
        $roleName = $user->roleName;
        $offices = ApiController::GetOfficeList($user->officeId);
        $data['roleName'] = $roleName;
        $data['routeRole'] = str_replace(' ', '_', strtolower($roleName));

        $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $data['MasterOffice'] = [ApiController::GetOffice($user->officeId)];

        $param = [
            'officeId' => $request->officeId,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'status' => $request->status != '' ? $request->status : null,
        ];
        // $data['report']= (object) ApiController::GetTaskReport($param);
        $sales = ApiController::GetSalesIndexByDateOffice($request->fromDate, $request->toDate, $request->officeId, $request->status != '' ? $request->status : null);
        //dd($sales);
        $data['collections'] = $sales == null ? [] : $sales;
        //dd($data['report']);
        //dd(typeOf($data['report']));
        //dd($data['collections']);
        $view = view('module.sales.sales_index_body', $data)->render();
        return response()->json(
            [
                'success' => true,
                'view' => $view,
            ]
        );

    }
    public function sales_export(Request $request)
    {
        $file_name = 'salesReport.xlsx';

        return Excel::download((new SalesExport($request)), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);

    }
    public function sales_pdf(Request $request)
    {
        // $user=(object)ApiController::User(Session::get('loginid'));
        // $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $param = [
            'officeId' => $request->officeId,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
        ];

        $data['param'] = $param;
        $sales = ApiController::GetSalesIndexByDateOffice($request->fromDate, $request->toDate, $request->officeId);

        if (count($sales) == 0) {
            //    return redirect()->back()->with('error','No Data Found');
            return response()->json(
                [
                    'status' => 'error',
                    'success' => false,
                    'message' => 'No Data Found',
                ]
            );
        }
        // dd($sales);
        $field['title'] = __('Sales Report');
        $field['Period'] = __('Period');
        // dd($field);
        $data['field'] = $field;
        $data['collections'] = $sales == null ? [] : $sales;

        $mpdf = new \Mpdf\Mpdf (
            [
                'mode' => 'utf-8',
                'default_font' => 'freeserif',
                'format' => 'A4-L',
                'autoLangToFont' => true,
                'autoScriptToLang' => true, // this is the important part

            ]

        );
        $mpdf->SetFont('freeserif', '', 14);
        $html = view('module.sales.sales_pdf', $data)->render();
        $mpdf->WriteHTML($html);
        //dd($sales[0]['officeName']);
        $fileName = $sales[0]['officeName'] . '_Sales_Report_' . date('d-m-Y', strtotime($request->fromDate)) . '_' . date('d-m-Y', strtotime($request->fromDate)) . '.pdf';
        return $mpdf->Output($fileName, 'I');
    }
    public function create()
    {
        $user = (object) ApiController::User(Session::get('loginid'));

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['godownList'] = ApiController::GetGodownsByOfficeId($user->officeId);

        // $data['salesTypes'] = ApiController::GetSalesTypes();

        $data['MasterOffice'] = [ApiController::GetOffice($user->officeId)];
        if ($data['MasterOffice'][0]['masterOfficeId'] == null) {
            $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        } else {
            $data['officeList'] = $data['MasterOffice'];
        }

        // $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);

        $data['productTypeList'] = ApiController::GetProductTypeWithRate($data['officeList'][0]['officeId']);
        //dd( $data['productTypeList']);
        $data['masterOfficeId'] = $user->officeId;
        //dd($data['masterOfficeId']);
        // $data['officeTypes'] =  ApiController::GetOfficeTypeList();
        // dd($data['officeTypes']);
        $data['paymentMode'] = $this->paymentMode;

        $data['roles'] = $this->roles;
        $info['title'] = "New Invoice";
        $info['size'] = "modal-lg";
        $data['info'] = $info;
        // dd($data);
        $GetView = view('module.sales.sales_create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function getRate($id)
    {
        $date = date('Y-m-d');
        $response = ApiController::GetFuelRate($id);
        //dd($response['rate']);
        return response()->json($response);
    }
    public function getEnv($id)
    {
        $date = date('Y-m-d');
        $response = ApiController::GetProductTypeById($id);
        //dd($response['rate']);
        return response()->json($response);
    }
    public function store(Request $request)
    {
        // dd($request->input('discount'));
        $user = $this->user != null ? $this->user : ApiController::User(Session::get('loginid'));
        $user = collect($user);
        // dd($this->user);
        $validator = Validator::make($request->all(), [
            'customerName' => 'nullable|max:255',
            'invoiceDate' => 'required',
            'officeId' => 'required',
            'fuelRateId' => 'required',
            'rate' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'vehicleNo' => 'nullable|max:255',
            'mobileNo' => 'nullable|numeric|digits:10',
            'quantity' => 'required|numeric',
            'total' => 'required|numeric|min:1',
            'paymentModeId' => 'required',
        ]);
        // process the data
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        } else {
            // store the user
            // $request->input('discount') == null ?  0:$request->input('discount');
            $FuelRate = ApiController::GetFuelRate($request->input('fuelRateId'));

            // $CheckRate=ApiController::GetProductTypeById($request->input('fuelRateId'));
            if ($FuelRate[0]['rate'] != (double) $request->input('rate')) {

                return response()->json([
                    "status" => false,
                    "message" => "Fuel Rate is not valid",
                ]);
            } else {
                $Total = (double) $FuelRate[0]['rate'] * (double) $request->input('quantity') - (double) $request->input('discount');
                $Total = number_format($Total, 2, '.', '');

                if ($Total != $request->input('total')) {
                    return response()->json([
                        "status" => false,
                        "message" => "Total is not valid",
                    ]);
                }
            }

            $data = [
                'customerName' => base64_encode($request->input('customerName')),
                'officeId' => $request->input('officeId'),
                'invoiceDate' => $request->input('invoiceDate'),
                'userId' => $user['id'],
                'comment' => base64_encode($request->input('comment')),
                'mobileNo' => base64_encode($request->input('mobileNo')),
                'vehicleNo' => base64_encode($request->input('vehicleNo')),
                'quantity' => $request->input('quantity'),
                'rate' => $request->input('rate'),
                'fuelRateId' => $request->input('fuelRateId'),
                'total' => $request->input('total'),
                'discount' => $request->input('discount') == null ? 0 : $request->input('discount'),
                'paymentModeId' => $request->input('paymentModeId'),

            ];
            //  dd(json_encode($data));
            $response = ApiController::CreateSales($data);

            if ($response['status'] == false) {
                return response()->json(["status" => false, "message" => $response['message']]);
            }
            return response()->json(["status" => true, "message" => "Sales Added successfully"]);

        }
    }
    public function edit($salesId)
    {

        $user = ApiController::User(Session::get('loginid'));

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $data['MasterOffice'] = [ApiController::GetOffice($user['officeId'])];
        if ($data['MasterOffice'][0]['masterOfficeId'] == null) {
            $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        } else {
            $data['officeList'] = $data['MasterOffice'];
        }
        $data['godownList'] = ApiController::GetGodownsByOfficeId($user->officeId);
        // $data['salesTypes'] = ApiController::GetSalesTypes();

        $data['editData'] = ApiController::GetSalesById($salesId)[0];
        $data['productTypeList'] = ApiController::GetProductTypeWithRate($data['editData']['officeId'], $data['editData']['invoiceDate']);
        $data['masterOfficeId'] = $user['officeId'];
        $data['officeTypes'] = ApiController::GetOfficeTypeList();
        $data['paymentMode'] = $this->paymentMode;

        $data['roles'] = $this->roles;
        $info['title'] = "Edit Invoice";
        $info['size'] = "modal-lg";
        $data['info'] = $info;

        // dd($data['editData']);
        $GetView = view('module.sales.sales_edit', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function update(Request $request)
    {
        // dd($request->input('discount'));
        $user = $this->user != null ? $this->user : ApiController::User(Session::get('loginid'));
        $user = collect($user);
        // dd($this->user);
        $validator = Validator::make($request->all(), [
            'salesId' => 'required',
            'invoiceDate' => 'required|date',
            'invoiceNo' => 'required',
            'customerName' => 'nullable|max:255',
            'officeId' => 'required',
            'fuelRateId' => 'required',
            'rate' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'vehicleNo' => 'nullable|max:255',
            'mobileNo' => 'nullable|numeric|digits:10',
            'quantity' => 'required|numeric',
            'total' => 'required|numeric|min:1',
            'paymentModeId' => 'required',
        ]);
        // process the data
        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        } else {

            $FuelRate = ApiController::GetFuelRate($request->input('fuelRateId'));

            if ($FuelRate[0]['rate'] != (double) $request->input('rate')) {

                return response()->json(["status" => false, "errors" => ["Fuel Rate is not valid"]]);
            } else {
                $Total = (double) $FuelRate[0]['rate'] * (double) $request->input('quantity') - (double) $request->input('discount');
                $Total = number_format($Total, 2, '.', '');

                if ($Total != $request->input('total')) {
                    return response()->json(["status" => false, "errors" => ["Total is not valid"]]);
                }
            }

            $data = [
                'salesId' => $request->input('salesId'),
                'invoiceDate' => $request->input('invoiceDate'),
                'invoiceNo' => $request->input('invoiceNo'),
                'customerName' => base64_encode($request->input('customerName')),
                'officeId' => $request->input('officeId'),
                'userId' => $user['id'],
                'comment' => base64_encode($request->input('comment')),
                'mobileNo' => base64_encode($request->input('mobileNo')),
                'vehicleNo' => base64_encode($request->input('vehicleNo')),
                'quantity' => $request->input('quantity'),
                'rate' => $request->input('rate'),
                'fuelRateId' => $request->input('fuelRateId'),
                'total' => $request->input('total'),
                'discount' => $request->input('discount') == null ? 0 : $request->input('discount'),
                'paymentModeId' => $request->input('paymentModeId'),

            ];
            //  dd(json_encode($data));
            $response = ApiController::UpdateSales($data);

            if (!$response['status'] == true) {
                return response()->json([
                    "status" => false,
                    "message" => $response['message'],
                ]);
            }
            return response()->json([
                "status" => true,
                "message" => "Sales Updated successfully",
            ]);

        }
    }
    public function show(Request $request, $salesId)
    {

        $user = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user['officeId']);

        $thisData = json_decode(base64_decode($request->param), true);
        // dd($thisData);
        if ($thisData != null) {
            $data['editData'] = $thisData;
        } else {
            $data['editData'] = ApiController::GetSalesById($salesId)[0];
        }

        $data['productTypeList'] = ApiController::GetProductTypeWithRate($data['editData']['officeId'], $data['editData']['invoiceDate']);
        $data['masterOfficeId'] = $user['officeId'];
        $data['officeTypes'] = ApiController::GetOfficeTypeList();
        $data['paymentMode'] = $this->paymentMode;

        $data['roles'] = $this->roles;
        $info['title'] = "Edit Invoice";
        $info['size'] = "modal-lg";
        $data['info'] = $info;

        // dd($data['editData']);
        $GetView = view('module.sales.sales_show', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function UpdateStatus(Request $request)
    {
        $user = $this->user;

        $roleName = $this->roleName;
        $routeRole = $this->routeRole;
        $postData = [
            'salesIds' => $request->input('salesIds'),
            'statusUpdatedBy' => $user['id'],
            'status' => $request->input('status'),
        ];

        $response = ApiController::UpdateSalesStatus($postData);
        if (!$response['status'] == true) {
            return response()->json([
                "status" => false,
                "message" => $response['message'],
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "Sales Status Updated successfully",
        ]);

    }
    public function destroy($id)
    {

        $user = $this->user;

        $roleName = $this->roleName;
        $routeRole = $this->routeRole;
        $response = ApiController::DeleteSales($id, $user['id']);

        if (!$response['status'] == true) {
            return \redirect ()->route($routeRole . '.sales.index')->with('error', $response['message']);
        }
        return \redirect ()->route($routeRole . '.sales.index')->with('success', 'Sales deleted successfully');

    }

    public function producttype_index(Request $request)
    {
        // dd($request->all());
        $data['title'] = "Fuel Rate";
        $data['size'] = "modal-lg";

        if (Session::has('productTypeList')) {
            $data['productTypeList'] = Session::get('productTypeList');
            //dd($data['productTypeList']);
            $html = view('module.sales.fuelrate_index', $data)->render();
            return response()->json([
                "status" => true,
                "html" => $html,
            ]);
        } else {
            $user = (object) ApiController::User(Session::get('loginid'));

            $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);

            $data['productTypeList'] = ApiController::GetProductTypeWithRate($user->officeId);
            $html = view('module.sales.producttype_index', $data)->render();
            return response()->json([
                "status" => true,
                "html" => $html,
            ]);

        }

    }
    public function productType_by_office_id($id)
    {
        // dd($id);
        $response = ApiController::GetProductTypeWithRate($id);
        //$html= view('module.sales.producttype_index', $data)->render();
        // dd($response);
        return response()->json([
            "status" => true,
            "response" => collect($response),
        ]);
    }
}
