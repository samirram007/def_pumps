<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SalesController extends Controller
{
    public function sales_invoice($invoice_no)
    {
        if($invoice_no!=null)
        {
            $invoice_no = base64_encode($invoice_no);
        }
        else
        {
            $invoice_no = '000000';
        }
         $sales_invoice=ApiController::getSalesInvoice($invoice_no);
         $current_url=url()->current();
//dd($sales_invoice);
        //   $sales_invoice=[
        //     'invoiceTitle' => 'Sales Invoice',
        //     'invoice_no' => '000000023',
        //     'invoice_date' => '2022-01-01',
        //     'invoice_time' => '2022-01-01 22:37:00',
        //     'officeName' => 'Head Office',
        //     'officeAddress' => 'Head Office Address',
        //     'gstNo' => 'fsdf1111313131',
        //     'officeContactNo' => '33333333333',
        //     'officeEmail' => 'office@gmail.com',
        //     'customerName' => 'ABC Customer',
        //     'customerAddress' => 'Abc Customer Address',
        //     'contactNo' => '44646446446',
        //     'vehicleNo' => 'ABC 123',
        //     'productName' => 'Def 500',
        //     'productQuantity' => '5',
        //     'productUnitPrice' => '100',
        //     'productTotalPrice' => '500',
        //     'discount' => '100.00',
        //     'invoice_sub_total' => '400.00',
        //     'inWords'=>'Four Hundred Rupees Only',
        //     'paymentType' => 'Cash',
        //     'summeryLine'=>'Thank you for your business',
        //     ];
           // dd(json_encode($sales_invoice));
        return view('module.sales.invoice_html', compact('sales_invoice','current_url'));
    }
}
