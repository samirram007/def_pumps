<?php

namespace App\Http\Controllers\Admin;

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
    protected $paymentMode = [];
    protected $roles;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user = null;

    public function __construct()
    {

        $this->paymentMode = ApiController::GetPaymentMode();
        $roles = ApiController::GetRoles();
        $del_val = ['SuperAdmin', 'CompanyAdmin'];
        foreach ($roles as $key => $value) {
            if (!in_array($value['name'], $del_val)) {
                $this->roles[$value['name']] = $value['name'];
            }
        }
        $user = session()->has('userData') ? json_decode(json_encode(session()->get('userData')), true) : ApiController::user(session()->get('loginid'));
        $roleName = session()->get('roleName');

        $this->user = json_decode(json_encode($user), true);
        $this->roleName = session()->get('roleName');
        $this->routeRole = str_replace(' ', '_', strtolower($this->roleName));
    }
    public function index()
    {

        // $user=(object)ApiController::User(Session::get('loginid'));
        $user = (object) $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $offices = ApiController::GetOfficeList($user->officeId);

        $data['MasterOffice'] = session()->has('officeData') ? session()->get('officeData') : ApiController::GetOffice($user->officeId);

        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $data['officeList'] = array_filter($data['officeList'], function ($var) {
            return ($var['officeTypeId'] != 1);
        });
        $data['officeList'] = (object) $data['officeList'];
        foreach ($offices as $key => $value) {

            if ($value['masterOfficeId'] != null) {
                $offices[$key]['MasterOffice'] = [ApiController::GetOffice($value['masterOfficeId'])];
            }
        }
        $data['offices'] = $offices;
       // $sales = ApiController::GetSalesIndex();

        $data['paymentMode'] = $this->paymentMode;

       // $data['collections'] = $sales == null ? [] : $sales;
       $data['collections'] =[] ;
       // dd($data['collections']);
        // load the view and pass the users
        return view('module.sales.sales_index', $data);

    }

    public function create(Request $request)
    {
        //dd($request->param);
        $user = (object) $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);

        $info['title'] = "New Invoice";
        $data['editData'] = null;
        $data['productTypeList'] = ApiController::GetProductTypeWithRate($data['officeList'][0]['officeId']);
        $data['godownList'] = ApiController::GetGodownsByOfficeId($data['officeList'][0]['officeId']);

        $data['businessTaxTypes'] = ApiController::GetBusinessTaxTypes();

        $data['productTypeList'] = $this->SetUnits($data['productTypeList']);
        // dd($data['productTypeList']);
        $data['officeList'] = array_filter($data['officeList'], function ($var) {
            return ($var['officeTypeId'] != 1);
        });
        $data['masterOfficeId'] = $user->officeId;
        $data['officeTypes'] = ApiController::GetOfficeTypeList();
        $data['paymentMode'] = $this->paymentMode;
        // dd($data);
        $data['roles'] = $this->roles;

        $info['size'] = "modal-lg";
        $data['info'] = $info;

        $GetView = view('module.sales.sales_create', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function edit(Request $request, $salesId)
    {

        $user = (object) $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['officeList'] = ApiController::GetOfficeByMasterOfficeId($user->officeId);

        $thisData = json_decode(base64_decode($request->param), true);
        if ($thisData != null) {
            $data['editData'] = $thisData;
        } else {
            $data['editData'] = ApiController::GetSalesById($salesId)[0];
        }
        $info['title'] = 'Invoice : ' . $thisData['invoiceNo'];
        $data['productTypeList'] = ApiController::GetProductTypeWithRate($data['editData']['officeId'], $data['editData']['invoiceDate']);
        // $productTypeId = $data['editData']['productTypeId'];
        $thisProduct = [];
        //dd($data['productTypeList']);
        foreach ($data['productTypeList'] as $key => $value) {

            if ($value['productTypeId'] == $data['editData']['productTypeId']) {
                $thisProduct = $value;
                break;
            }
        }

        // $data['godownList'] = ApiController::GetGodownsByOfficeId($data['editData']['officeId']);
        $godownList = ApiController::GetGodownsWithStockByOfficeId($data['editData']['officeId']);
        $filter_godownList = [];
        foreach ($godownList as $key => $value) {
            if ($value['productTypeId'] == $data['editData']['productTypeId']) {

                $filter_godownList = $value['godownProduct'];
                break;
            }
        }
        $data['godownList'] = $filter_godownList;

        foreach ($data['godownList'] as $key => $value) {

            if (!$thisProduct['isContainer'] && $value['godownTypeId'] == 1) {
                unset($data['godownList'][$key]);
            }
            if ($thisProduct['isContainer'] && $value['godownTypeId'] == 2) {
                unset($data['godownList'][$key]);
            }
        }

        $data['businessTaxTypes'] = ApiController::GetBusinessTaxTypes();

        $data['productTypeList'] = $this->SetUnits($data['productTypeList']);

        $data['officeList'] = array_filter($data['officeList'], function ($var) {
            return ($var['officeTypeId'] != 1);
        });
        $data['masterOfficeId'] = $user->officeId;
        $data['officeTypes'] = ApiController::GetOfficeTypeList();
        $data['paymentMode'] = $this->paymentMode;
        // dd($data);
        $data['roles'] = $this->roles;

        $info['size'] = "modal-lg";
        $data['info'] = $info;
        // dd($data['editData']);
        $GetView = view('module.sales.sales_edit', $data)->render();
        return response()->json([
            "status" => true,
            "html" => $GetView,
        ]);
    }
    public function SetUnits($products)
    {
        $units = ApiController::GetUnits();

        foreach ($products as $key => $product) {
            // $product['unitName'] = $this->Getvalues($units, $product['unitId'])['unitName'];

            foreach ($units as $unit) {
                if ($unit['unitId'] == $product['primaryUnitId']) {
                    $products[$key]['primaryUnitName'] = $unit['unitName'];
                    $products[$key]['primaryUnitShortName'] = $unit['unitShortName'];
                    $products[$key]['primaryUnitSingularShortName'] = $unit['singularShortName'];
                }
                if ($unit['unitId'] == $product['secondaryUnitId']) {
                    $products[$key]['secondaryUnitName'] = $unit['unitName'];
                    $products[$key]['secondaryUnitShortName'] = $unit['unitShortName'];
                    $products[$key]['secondaryUnitSingularShortName'] = $unit['singularShortName'];
                }
            }

        }
        return $products;
    }
    public function sales_filter(Request $request)
    {
        $user = (object) $this->user;

        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;
        $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $data['MasterOffice'] = ApiController::GetOffice($user->officeId);

        $param = [
            'officeId' => $request->officeId,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'status' => $request->status != '' ? $request->status : null,
        ];
        //dd($param);
        // $data['report']= (object) ApiController::GetTaskReport($param);
        $sales = ApiController::GetSalesIndexByDateOffice($request->fromDate, $request->toDate, $request->officeId, $request->status != '' ? $request->status : null);
        //  dd($sales);
        $data['collections'] = $sales == null ? [] : $sales;
        //dd($data['report']);
        //dd(typeOf($data['report']));
        // dd($data['collections']);
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
        $user = (object) $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        // $user=(object)ApiController::User(Session::get('loginid'));
        // $data['officeList'] = (object) ApiController::GetOfficeByMasterOfficeId($user->officeId);
        $param = [
            'officeId' => $request->officeId,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'status' => $request->status != '' ? $request->status : null,
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
        // dd($sales[0]['officeName']);
        $fileName = $sales[0]['officeName'] . '_Sales_Report_' . date('d-m-Y', strtotime($request->fromDate)) . '_' . date('d-m-Y', strtotime($request->toDate)) . '.pdf';
        // dd($fileName);
        // $fileName=str_replace(' ','_',$fileName);
        return $mpdf->Output($fileName, 'I');
    }

    public function getRate($id)
    {
        $date = date('Y-m-d');
        // $response = ApiController::GetCurrentFuelRate($date,$id);
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
        //dd($request->all());
        $user = $this->user;

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
            $FuelRate = ApiController::GetFuelRate($request->input('fuelRateId'));
            if ($FuelRate[0]['rate'] != (double) $request->input('rate')) {

                return response()->json(["status" => false, "errors" => ["Fuel Rate is not valid"]]);
            } else {
                $Total = (double) $FuelRate[0]['rate'] * (double) $request->input('quantity') - (double) $request->input('discount');
                $Total = number_format($Total, 2, '.', '');

                if ($Total != $request->input('total')) {
                    return response()->json([
                        "status" => false,
                        "errors" => ["Total is not valid"],
                    ]);
                }
            }

            $data = [
                'customerName' => base64_encode($request->input('customerName')),
                'invoiceDate' => $request->input('invoiceDate'),
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
                'godownId' => $request->input('godownId'),
                'businessTaxTypeId' => $request->input('businessTaxTypeId'),
                'submittedDocumentNo' => $request->input('submittedDocumentNo'),

            ];
            //dd(json_encode($data));
            $response = ApiController::CreateSales($data);
            if ($response['status'] == false) {

                return response()->json(["status" => false, "message" => $response['message']]);
            }
            return response()->json(["status" => true, "message" => "Sales Added successfully"]);

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
    public function update(Request $request)
    {
        // dd($request->input('quantity'));
        $user = $this->user;
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
                'godownId' => $request->input('godownId'),
                'businessTaxTypeId' => $request->input('businessTaxTypeId'),
                'submittedDocumentNo' => $request->input('submittedDocumentNo'),

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
    public function productType_by_office_id($id, $date)
    {
        // dd($id . " : " . $date);
        $product = ApiController::GetProductTypeWithRate($id, $date);
        $response = $this->SetUnits($product);
        // dd($response);
        return response()->json([
            "status" => true,
            "response" => collect($response),
        ]);
    }
}
