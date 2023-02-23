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

class ChartOneExport implements FromCollection, WithHeadings,WithMapping, WithCustomStartCell, WithEvents,ShouldAutoSize, WithDrawings
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
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:C1');
                 $sheet->setCellValue('A1', __("Sales-Expense Summery"));
                $sheet->getStyle('A1')->getFont()->setSize(12);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->mergeCells('A2:C2');
                $sheet->setCellValue('A2', "Period: ".date('d-m-Y',strtotime($this->request->fromDate))." to  ".date('d-m-Y',strtotime($this->request->toDate)));
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

            $total_sales=0;
            $total_expense=0;
            for ($i = 0; $i < count( $data['labels'] ); $i++){
                $report[$i]['Date']=date('d-m-Y', strtotime( $data['labels'][$i]));

                $report[$i]['Sales']= number_format($data['data_sales'][$i],2,'.','');
                $report[$i]['Expense']= number_format($data['data_expense'][$i],2,'.','');
                $total_sales+=$data['data_sales'][$i];
                $total_expense+=$data['data_expense'][$i];
            }
            $report[count( $data['labels'] )]['Date']=__('Total');
            $report[count( $data['labels'] )]['Sales']=number_format($total_sales,2,'.','');
            $report[count( $data['labels'] )]['Expense']=number_format($total_expense,2,'.','');

        $report=collect($report);
        //dd($report);
         return  $report;
    }
    public function headings(): array
    {
        return [
            __('Date'),
            __('Sales'),
            __('Expense'),
         ];
        }


         /**
     * Formattage des données.
     */
    public function map($row): array
    {
       // dd($row);
        return [
            $row['Date'],
            $row['Sales'],
            $row['Expense'],
        ];

        // (new \DateTime($row->dt_creation))->format('d/m/Y'),
        // (new \DateTime($row->dt_fin))->format('d/m/Y'),
    }

}
