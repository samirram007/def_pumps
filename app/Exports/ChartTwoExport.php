<?php

namespace App\Exports;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ChartTwoExport implements FromCollection, WithHeadings,WithMapping, WithCustomStartCell, WithEvents,ShouldAutoSize, WithDrawings
{
    use Exportable;
    protected $request;
    protected $roles=[
        'Customer'=>'Customer',
        'User'=>'User',
        'Pump Admin'=>'Pump Admin',
    ];
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
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function registerEvents(): array {

        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $event->sheet->getColumnDimension('A')->setAutoSize(false);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(70);
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:C1');
                 $sheet->setCellValue('A1', __("Product-wise Summery"));
                $sheet->getStyle('A1')->getFont()->setSize(12);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->mergeCells('A2:C2');
                $sheet->setCellValue('A2', __("Period").": ".date('d-m-Y',strtotime($this->request->fromDate))." to  ".date('d-m-Y',strtotime($this->request->toDate)));
                $sheet->getStyle('A2')->getFont()->setSize(8);
                $sheet->getStyle('A2')->getFont()->setBold(true);


                $office=ApiController::GetOffice($this->request->officeId);
                $sheet->mergeCells('A3:C3');
                $sheet->setCellValue('A3', __("Business Entity").": ".$office['officeName']);
                $sheet->getStyle('A3')->getFont()->setSize(8);
                $sheet->getStyle('A3')->getFont()->setBold(true);


                // $sheet->mergeCells('C1:D1');
                // $sheet->setCellValue('C1', "Account 2");

                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                $styleArray2 = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                         'border_bottom', \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'font' => [
                            'bold' => true,]
                    ],
                ];
                        // $cellRange = 'A1:G1'; // All headers
                        // $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $cellRange = 'A1:C3'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray)
                ->getFont()->setName('Calibri')->setSize(14)->setBold(true);
                $cellRange = 'A4:C4'; // All headers

                $event->sheet->getDelegate()
                ->getStyle($cellRange)
                ->applyFromArray($styleArray2)
                ->getBorders()
                ->getBottom()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            },
        ];
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/theme/images/logo.png'));
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');
        return $drawing;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $userData=Session::has('loginid')? (object)ApiController::User(Session::get('loginid')):'';
        $userData->roleName=strtolower($userData->roleName);
        $fromDate= date('Y-m-d',strtotime($this->request->fromDate));
        $toDate= date('Y-m-d',strtotime($this->request->toDate));
        $officeId= $this->request->officeId;
        $data['office']=ApiController::getOffice($officeId);
        $isAdmin= $this->request->isAdmin;
        // $data['param']=$request->all();

        $param_str= $fromDate.'/'.$toDate.'/'.$officeId.'/'.$isAdmin;
       // dd($param_str);
        $DEFDashBoardGraphData=ApiController::DEFDashBoardGraphData($param_str);
       // dd($DEFDashBoardGraphData);
        $data['DEFDashBoardGraphData'] = $DEFDashBoardGraphData;
        $data['months'] = $this->months;
        $data['years'] = $this->years;

        foreach($DEFDashBoardGraphData['graph2'] as $key=>$graph_data){
            foreach($graph_data['lstproduct'] as $key=>$graph_data1){
                if(!isset($product_sales[$graph_data1['productName']])    ){
                    $product_sales[$graph_data1['productName']]=$graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['sale'] = $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['qty'] = $graph_data1['qty'];
                    $product_sales_with_qty[$graph_data1['productName']]['PrimaryUnit'] = $graph_data1['primaryUnit'];
                    }
                else{
                    $product_sales[$graph_data1['productName']] += (double)$graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['sale']+= (double) $graph_data1['totalSale'];
                    $product_sales_with_qty[$graph_data1['productName']]['qty'] += (double)$graph_data1['qty'];
                    }
            }

        }
        $data['graph2'] = collect($product_sales_with_qty);

        $data['product_sales'] = collect($product_sales)->values();

        $data['product_sales_labels'] = collect($product_sales)->keys();


$total_amount=0;
            // for ($i = 0; $i < count( $data['graph2'] ); $i++){
            //     dd($data['graph2'] );
            //     $report[$i]['ProductName']=  $data['graph2'][$i]['productName'];
            //     $report[$i]['Quantity']=  $data['graph2'][$i]['qty'];

            //     $report[$i]['Amount']= number_format($data['graph2'][$i]['totalSale'],2,'.','');
            //     $total_amount+=$data['graph2'][$i]['totalSale'];
            // }
            $index=0;
            foreach ($data['graph2']  as $product => $value){
             //   dd($value);
             if($value['sale']!=0){


$report[$index]['ProductName']=  $product;
$report[$index]['Quantity']= $value['qty']==0?'': ($value['qty'].' '. $value['PrimaryUnit']['unitShortName']);
$report[$index]['Amount']= $value['sale']==0?'':(number_format($value['sale'],2,'.',''));
            }
$total_amount+=$value['sale'];
$index++;
            }

$report[count( $data['product_sales_labels'] )]['ProductName']=__('Total');
$report[count( $data['product_sales_labels'] )]['Quantity']='';
$report[count( $data['product_sales_labels'] )]['Amount']=number_format($total_amount,2,'.','');
//dd($report);
        $report=collect($report);
        //dd($report);
         return  $report;
    }
    public function headings(): array
    {
        return [
            __('ProductName'),
            __('Quantity'),
            __('Amount'),
         ];
        }


         /**
     * Formattage des données.
     */
    public function map($row): array
    {
       // dd($row);
        return [
            $row['ProductName'],
            $row['Quantity'],
            $row['Amount'],
        ];

        // (new \DateTime($row->dt_creation))->format('d/m/Y'),
        // (new \DateTime($row->dt_fin))->format('d/m/Y'),
    }

}
