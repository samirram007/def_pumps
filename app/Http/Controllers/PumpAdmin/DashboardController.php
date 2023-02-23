<?php

namespace App\Http\Controllers\PumpAdmin;

use PDF;
use Illuminate\Http\Request;
use App\Exports\ChartOneExport;
use App\Exports\ChartTwoExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    protected $months=[
        '1'=>'January',
        '2'=>'February',
        '3'=>'March',
        '4'=>'April',
        '5'=>'May',
        '6'=>'June',
        '7'=>'July',
        '8'=>'August',
        '9'=>'September',
        '10'=>'October',
        '11'=>'November',
        '12'=>'December',
    ];
    protected $years=[
        '2022'=>'2022',
        '2023'=>'2023',
    ];
    protected $roles;
    protected $routeRole='pumpadmin';
    protected $roleName='pumpadmin';
    protected $user=null;
    public function __construct()
    {
        $roles=ApiController::GetRoles();
        $del_val=['SuperAdmin','CompanyAdmin','PumpAdmin'];
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
    public function dashboard_filter(Request $request)
    {

        $userData=Session::has('loginid')? (object)ApiController::User(Session::get('loginid')):'';
        $userData->roleName=strtolower($userData->roleName);
        $fromDate= date('Y-m-d',strtotime($request->fromDate));
        $toDate= date('Y-m-d',strtotime($request->toDate));
        $officeId= $request->officeId;
        $isAdmin= $request->isAdmin;
        $param_str= $fromDate.'/'.$toDate.'/'.$officeId.'/'.$isAdmin;
        $DEFDashBoardGraphData=ApiController::DEFDashBoardGraphData($param_str);
        $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
        $data['months'] = $this->months;
        $data['years'] = $this->years;

        $sales=[]   ;
        $expense=[]   ;
        $product_sales=[]   ;
        $data['labels'] = [];
        $data['data_sales'] =[];
        $data['data_expense'] = [];

        $data['graph2'] = [];

        $data['product_sales'] = [];

        $data['product_sales_labels'] = [];
        $data['average']=[];
        foreach($DEFDashBoardGraphData['graph1'] as $key=>$graph_data){
            $sales[$graph_data['requestedDate']]=$graph_data['totalIncome'];
            $expense[$graph_data['requestedDate']]=$graph_data['totalExpense'];
        }
        foreach($DEFDashBoardGraphData['graph2'] as $key=>$graph_data){
            foreach($graph_data['lstproduct'] as $key=>$graph_data1){
                if(!isset($product_sales[$graph_data1['productName']])    ){
                    $product_sales[$graph_data1['productName']]=$graph_data1['totalSale'];
                    }
                else{
                    $product_sales[$graph_data1['productName']] += (double)$graph_data1['totalSale'];
                    }
            }

        }


        $data['sales']=collect($sales);
        $data['expense']=collect($expense);

        // dd($sales);
        $data['labels'] = collect($sales)->keys();
        $data['data_sales'] = collect($sales)->values();
        $data['data_expense'] = collect($expense)->values();
        $average= collect($sales)->sum()/count($data['labels']) ;
        for($i=0;$i<count($data['labels']) ;$i++){
            $data['average'][$i]=number_format($average,2,'.','');
        }
        $data['graph2'] = collect($product_sales);
        //dd($product_sales );
        $data['product_sales'] = collect($product_sales)->values();

        $data['product_sales_labels'] = collect($product_sales)->keys();

        $graph1= view('pumpadmin._partial.section_graph1',$data)->render();
        $graph2= view('pumpadmin._partial.section_graph2',$data)->render();
        return response()->json(['status'=>true,'graph1'=>$graph1,'graph2'=>$graph2]);

    }

    public function chart1_export(Request $request)
    {
       // dd($request->all());
        $file_name='salesExpenseChartReport.xlsx';

        return Excel::download((new ChartOneExport($request)), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);

    }
    public function chart2_export(Request $request)
    {
        $file_name='productwiseSummaryReport.xlsx';

        return Excel::download((new ChartTwoExport($request)), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);
    }
    public function chart1_pdf(Request $request)
    {
        $userData=Session::has('loginid')? (object)ApiController::User(Session::get('loginid')):'';
        $userData->roleName=strtolower($userData->roleName);
        $fromDate= date('Y-m-d',strtotime($request->fromDate));
        $toDate= date('Y-m-d',strtotime($request->toDate));
        $officeId= $request->officeId;
        $data['office']=[ApiController::getOffice($officeId)];
        $isAdmin= $request->isAdmin;
        // dd($request->all());
        $data['param']=$request->all();

        $param_str= $fromDate.'/'.$toDate.'/'.$officeId.'/'.$isAdmin;
        $DEFDashBoardGraphData=ApiController::DEFDashBoardGraphData($param_str);
        $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
        $data['months'] = $this->months;
        $data['years'] = $this->years;

        $sales=[]   ;
        $expense=[]   ;
        foreach($DEFDashBoardGraphData['graph1'] as $key=>$graph_data){
            $sales[$graph_data['requestedDate']]=$graph_data['totalIncome'];
            $expense[$graph_data['requestedDate']]=$graph_data['totalExpense'];
        }
        $data['sales']=collect($sales);
        $data['expense']=collect($expense);
        // dd($sales);
        $data['labels'] = collect($sales)->keys();
        $data['data_sales'] = collect($sales)->values();
        $data['data_expense'] = collect($expense)->values();

        $mpdf=new \Mpdf\Mpdf(
            [
               'mode' => 'utf-8',
               'default_font' => 'freeserif',
                'format' => 'A4-L',
                'autoLangToFont' => true,
                'autoScriptToLang' => true, // this is the important part

            ]

        );
        $mpdf->SetFont('freeserif', '', 14);
        $html=view('pumpadmin._partial.chart1_pdf',$data)->render();
        $mpdf->WriteHTML($html);

        $fileName= $data['office'][0]['officeName'].'_Sales-Expense Summary_'.date('d-m-Y',strtotime($fromDate)).'_'.date('d-m-Y',strtotime($fromDate)).'.pdf';
        return $mpdf->Output( $fileName,'I');
    }
    public function chart2_pdf(Request $request)
    {
        $userData=Session::has('loginid')? (object)ApiController::User(Session::get('loginid')):'';
        $userData->roleName=strtolower($userData->roleName);
        $fromDate= date('Y-m-d',strtotime($request->fromDate));
        $toDate= date('Y-m-d',strtotime($request->toDate));
        $officeId= $request->officeId;
        $data['office']=[ApiController::getOffice($officeId)];
        $isAdmin= $request->isAdmin;
        $data['param']=$request->all();

        $param_str= $fromDate.'/'.$toDate.'/'.$officeId.'/'.$isAdmin;
        $DEFDashBoardGraphData=ApiController::DEFDashBoardGraphData($param_str);
        $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
        $data['months'] = $this->months;
        $data['years'] = $this->years;
        foreach($DEFDashBoardGraphData['graph2'] as $key=>$graph_data){
            foreach($graph_data['lstproduct'] as $key=>$graph_data1){
                if(!isset($product_sales[$graph_data1['productName']])    ){
                    $product_sales[$graph_data1['productName']]=$graph_data1['totalSale'];
                    }
                else{
                    $product_sales[$graph_data1['productName']] += (double)$graph_data1['totalSale'];
                    }
            }

        }
        $data['graph2'] = collect($product_sales);

        $data['product_sales'] = collect($product_sales)->values();

        $data['product_sales_labels'] = collect($product_sales)->keys();


        $mpdf=new \Mpdf\Mpdf(
            [
               'mode' => 'utf-8',
               'default_font' => 'freeserif',
                'format' => 'A4-L',
                'autoLangToFont' => true,
                'autoScriptToLang' => true, // this is the important part

            ]

        );
        $mpdf->SetFont('freeserif', '', 14);
        $html=view('pumpadmin._partial.chart2_pdf',$data)->render();
        $mpdf->WriteHTML($html);
        $fileName= $data['office'][0]['officeName'].'_Product-wise Summary_'.date('d-m-Y',strtotime($fromDate)).'_'.date('d-m-Y',strtotime($fromDate)).'.pdf';
          return $mpdf->Output( $fileName,'I');

    }
}
