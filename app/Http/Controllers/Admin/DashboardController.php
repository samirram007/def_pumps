<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ChartOneExport;
use App\Exports\ChartTwoExport;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{

    protected $months = [
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];
    protected $years = [
        '2022' => '2022',
        '2023' => '2023',
    ];
    protected $roles;
    protected $routeRole = 'companyadmin';
    protected $roleName = 'companyadmin';
    protected $user = null;
    public function __construct()
    {
        //$roles = ApiController::GetRoles();
        $roles = session()->has('roles')? json_decode(json_encode(session()->get('roles')), true): session()->put('roles',ApiController::GetRoles());

        $del_val = ['SuperAdmin', 'CompanyAdmin'];
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
        $this->routeRole = session()->get('routeRole');
    }
    public function dashboard_filter(Request $request)
    {
        //dd($request->all());
        $user = $this->user;
        $userData = $this->user;
        $data['roleName'] = $this->roleName;
        $data['routeRole'] = $this->routeRole;

        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
        $officeId = $request->officeId;
        $isAdmin = $request->isAdmin;
        $param_str = $fromDate . '/' . $toDate . '/' . $officeId . '/' . $isAdmin;
        $DEFDashBoardGraphData = ApiController::DEFDashBoardGraphData($param_str);

        $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
        $data['months'] = $this->months;
        $data['years'] = $this->years;

        $sales = [];
        $expense = [];
        $product_sales = [];
        $data['labels'] = [];
        $data['data_sales'] = [];
        $data['data_expense'] = [];

        $data['graph2'] = [];

        $data['product_sales'] = [];

        $data['product_sales_labels'] = [];
        $data['average'] = [];
        //dd(json_encode($DEFDashBoardGraphData));
        if($DEFDashBoardGraphData['graph1']==null ||   $DEFDashBoardGraphData['graph2']==null) {
            $graph1 = view('companyadmin._partial.section_graph1', $data)->render();
            $graph2 = view('companyadmin._partial.section_graph2', $data)->render();
            return response()->json(['status' => false, 'graph1' => $graph1, 'graph2' => $graph2]);
        }
            foreach ($DEFDashBoardGraphData['graph1'] as $key => $graph_data) {
                $sales[$graph_data['requestedDate']] = $graph_data['totalIncome'];
                $expense[$graph_data['requestedDate']] = $graph_data['totalExpense'];
            }


        foreach ($DEFDashBoardGraphData['graph2'] as $key => $graph_data) {
            foreach ($graph_data['lstproduct'] as $key => $graph_data1) {
                if (!isset($product_sales[$graph_data1['productName']])) {
                    if($graph_data1['totalSale']==0){
                        continue;
                    }
                    $product_sales[$graph_data1['productName']] = $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['sale'] = $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['qty'] = $graph_data1['qty'];
                    $product_sales_with_qty[$graph_data1['productName']]['PrimaryUnit'] = $graph_data1['primaryUnit'];
                    continue;
                }
                if($graph_data1['totalSale']==0){
                    continue;
                }
                    $product_sales[$graph_data1['productName']]+= (double) $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['sale']+= (double) $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['qty'] += (double)$graph_data1['qty'];

            }

        }


        $data['sales'] = collect($sales);
        $data['expense'] = collect($expense);

        // $average=(collect($sales)->max()>=collect($expense)->max())?collect($sales)->max()/2:collect($expense)->max()/2;
        // dd($sales);
        //stringify for count of array

        $data['labels'] = collect($sales)->keys();
        $data['data_sales'] = collect($sales)->values();
        $data['data_expense'] = collect($expense)->values();

        $average = collect($sales)->sum() / count($data['labels']);
        for ($i = 0; $i < count($data['labels']); $i++) {
            $data['average'][$i] = number_format($average, 2, '.', '');
        }

        // $data['graph2'] = collect($product_sales);
        $data['graph2'] = collect($product_sales_with_qty);
        $data['product_sales'] = collect($product_sales)->values();

        $data['product_sales_labels'] = collect($product_sales)->keys();

        $graph1 = view('companyadmin._partial.section_graph1', $data)->render();
        $graph2 = view('companyadmin._partial.section_graph2', $data)->render();


        return response()->json(['status' => true, 'graph1' => $graph1, 'graph2' => $graph2]);

    }

    public function chart1_export(Request $request)
    {
        // dd($request->all());
        $file_name = 'salesExpenseChartReport.xlsx';

        return Excel::download((new ChartOneExport($request)), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);

    }
    public function chart2_export(Request $request)
    {
        $file_name = 'productwiseSummaryReport.xlsx';

        return Excel::download((new ChartTwoExport($request)), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);
    }
    public function chart1_pdf(Request $request)
    {
        $userData = Session::has('loginid') ? (object) ApiController::User(Session::get('loginid')) : '';
        $userData->roleName = strtolower($userData->roleName);
        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));
        $officeId = $request->officeId;
        $data['office'] = [ApiController::getOffice($officeId)];
        $isAdmin = $request->isAdmin;
        // dd($request->all());
        $data['param'] = $request->all();

        $param_str = $fromDate . '/' . $toDate . '/' . $officeId . '/' . $isAdmin;
        $DEFDashBoardGraphData = ApiController::DEFDashBoardGraphData($param_str);
        $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
        $data['months'] = $this->months;
        $data['years'] = $this->years;

        $sales = [];
        $expense = [];
        foreach ($DEFDashBoardGraphData['graph1'] as $key => $graph_data) {
            $sales[$graph_data['requestedDate']] = $graph_data['totalIncome'];
            $expense[$graph_data['requestedDate']] = $graph_data['totalExpense'];
        }
        $data['sales'] = collect($sales);
        $data['expense'] = collect($expense);
        // dd($sales);
        $data['labels'] = collect($sales)->keys();
        $data['data_sales'] = collect($sales)->values();
        $data['data_expense'] = collect($expense)->values();

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
        $html = view('companyadmin._partial.chart1_pdf', $data)->render();
        $mpdf->WriteHTML($html);
        $fileName = $data['office'][0]['officeName'] . '_Sales-Expense Summary_' . date('d-m-Y', strtotime($fromDate)) . '_' . date('d-m-Y', strtotime($fromDate)) . '.pdf';
        return $mpdf->Output($fileName, 'I');
        
    }
    public function chart2_pdf(Request $request)
    {
        $userData = Session::has('loginid') ? (object) ApiController::User(Session::get('loginid')) : '';
        $userData->roleName = strtolower($userData->roleName);
        $fromDate = date('Y-m-d', strtotime($request->fromDate));
        $toDate = date('Y-m-d', strtotime($request->toDate));

        //dd($toDate);
        $officeId = $request->officeId;
        $data['office'] = [ApiController::getOffice($officeId)];
        $isAdmin = $request->isAdmin;
        $data['param'] = $request->all();

        $param_str = $fromDate . '/' . $toDate . '/' . $officeId . '/' . $isAdmin;
        $DEFDashBoardGraphData = ApiController::DEFDashBoardGraphData($param_str);
        $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
        $data['months'] = $this->months;
        $data['years'] = $this->years;
        foreach ($DEFDashBoardGraphData['graph2'] as $key => $graph_data) {
            foreach ($graph_data['lstproduct'] as $key => $graph_data1) {
                if (!isset($product_sales[$graph_data1['productName']])) {
                    if($graph_data1['totalSale']==0){
                        continue;
                    }
                    $product_sales[$graph_data1['productName']] = $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['sale'] = $graph_data1['totalSale'];
                        $product_sales_with_qty[$graph_data1['productName']]['qty'] = $graph_data1['qty'];
                        $product_sales_with_qty[$graph_data1['productName']]['PrimaryUnit'] = $graph_data1['primaryUnit'];
                        continue;
                }
                    $product_sales[$graph_data1['productName']] += (double) $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['sale']+= (double) $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['qty'] += (double)$graph_data1['qty'];

            }

        }
        $data['graph2'] = collect($product_sales_with_qty);

        $data['product_sales'] = collect($product_sales)->values();

        $data['product_sales_labels'] = collect($product_sales)->keys();

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
        $html = view('companyadmin._partial.chart2_pdf', $data)->render();
        $mpdf->WriteHTML($html);
        $fileName = $data['office'][0]['officeName'] . '_Product-wise Summary_' . date('d-m-Y', strtotime($fromDate)) . '_' . date('d-m-Y', strtotime($toDate)) . '.pdf';
        //  $fileName= $data['office'][0]['officeName'].'_Sales-Expense Summary_'.date('d-m-Y',strtotime($fromDate)).'_'.date('d-m-Y',strtotime($fromDate)).'.pdf';
        return $mpdf->Output($fileName, 'I');

    }
}
