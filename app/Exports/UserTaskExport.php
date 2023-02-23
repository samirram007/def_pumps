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

class UserTaskExport implements FromCollection, WithHeadings,WithMapping, WithCustomStartCell, WithEvents,ShouldAutoSize, WithDrawings
{
    use Exportable;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array {

        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:G1');
                 $sheet->setCellValue('A1', "Task-User Report");
                $sheet->getStyle('A1')->getFont()->setSize(12);
                $sheet->getStyle('A1')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->mergeCells('A2:G2');
                $sheet->setCellValue('A2', "Period: ".date('d-m-Y',strtotime($this->request->fromDate))." to  ".date('d-m-Y',strtotime($this->request->toDate)));
                $sheet->getStyle('A2')->getFont()->setSize(8);
                $sheet->getStyle('A2')->getFont()->setBold(true);



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

                $cellRange = 'A1:G2'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray)
                ->getFont()->setName('Calibri')->setSize(14)->setBold(true);
                $cellRange = 'A3:G3'; // All headers

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
        $report=  ApiController::GetTaskReport($param);
        foreach($report as $key=>$value){
           // unset( $report[$key]['userId']);
           $name=$report[$key]['userDetails']['firstName'].' '.$report[$key]['userDetails']['surName'];
          // $office=ApiController::GetOffice($report[$key]['userDetails']['officeId']);
           //dd($office);
           $report[$key]['slNo']=$key+1;
           $report[$key]['OfficeName']=$report[$key]['userDetails']['office']['officeName'];
           $report[$key]['User']=$name;
           $report[$key]['Duration']=number_format($report[$key]['workDuration']/60,2);
           $report[$key]['CompletedTask']=$report[$key]['completedTask'];
           $report[$key]['PendingTask']=$report[$key]['pendingTask'];
           $report[$key]['UnAttendTask']=$report[$key]['unAttendTask'];

           // unset($report[$key]['userDetails']);
        }
        $report=collect($report);
        //dd($report);
         return  $report;
    }
    public function headings(): array
    {
        return [
            'SL NO',
            'Office Name',
            'User',
            'Duration',
            'Completed Task',
            'Pending Task',
            'UnAttend Task',
         ];
        }


         /**
     * Formattage des données.
     */
    public function map($row): array
    {
       // dd($row);
        return [
            $row['slNo'],
            $row['OfficeName'],
            $row['User'],
            $row['Duration'],
            $row['CompletedTask'],
            $row['PendingTask'],
            $row['UnAttendTask'],
        ];

        // (new \DateTime($row->dt_creation))->format('d/m/Y'),
        // (new \DateTime($row->dt_fin))->format('d/m/Y'),
    }

}
