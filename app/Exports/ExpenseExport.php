<?php

namespace App\Exports;

use App\Http\Controllers\ApiController;
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

class ExpenseExport implements FromCollection, WithHeadings,WithMapping, WithCustomStartCell, WithEvents,ShouldAutoSize, WithDrawings
{
    use Exportable;
    protected $request;

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
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:D1');
                 $sheet->setCellValue('A1', __("Expense Report"));
                $sheet->getStyle('A1')->getFont()->setSize(12);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->mergeCells('A2:D2');
                $sheet->setCellValue('A2', __("Period").": ".date('d-m-Y',strtotime($this->request->fromDate))." ".__("to")."  ".date('d-m-Y',strtotime($this->request->toDate)));
                $sheet->getStyle('A2')->getFont()->setSize(8);
                $sheet->getStyle('A2')->getFont()->setBold(true);

                $office=[ApiController::GetOffice($this->request->officeId)];
                $sheet->mergeCells('A3:D3');
                $sheet->setCellValue('A3', __("Business Entity").": ".$office[0]['officeName']);
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

                $cellRange = 'A1:D3'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray)
                ->getFont()->setName('Calibri')->setSize(14)->setBold(true);
                $cellRange = 'A4:D4'; // All headers

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
        $param=[
            'officeId'=>$this->request->officeId,
            'fromDate'=>$this->request->fromDate,
            'toDate'=>$this->request->toDate,
        ];
        $report=  ApiController::GetExpenseIndexByDateOffice($this->request->fromDate,$this->request->toDate,$this->request->officeId);
       // dd($report);
        foreach($report as $key=>$value){
           // unset( $report[$key]['userId']);
        //    $name=$report[$key]['userDetails']['firstName'].' '.$report[$key]['userDetails']['surName'];
          // $office=ApiController::GetOffice($report[$key]['userDetails']['officeId']);

           $report[$key]['VoucherDate']=date('d-m-Y', strtotime($report[$key]['voucherDate']));
           $report[$key]['VoucherNo']=$report[$key]['voucherNo'];
           $report[$key]['Particulars']=$report[$key]['particulars'];
           $report[$key]['Amount']= $report[$key]['amount'];


           // unset($report[$key]['userDetails']);
        }
        $report=collect($report);
        //dd($report);
         return  $report;
    }
    public function headings(): array
    {
        return [
            __('VoucherDate'),
            __('VoucherNo'),
            __('Particulars'),
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
            $row['VoucherDate'],
            $row['VoucherNo'],
            $row['Particulars'],
            $row['Amount'],
        ];

        // (new \DateTime($row->dt_creation))->format('d/m/Y'),
        // (new \DateTime($row->dt_fin))->format('d/m/Y'),
    }

}
