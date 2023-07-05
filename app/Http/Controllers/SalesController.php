<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Http;

class SalesController extends Controller
{
    public function sales_invoice($invoice_no)
    {
        if ($invoice_no != null) {
            $invoice_no = base64_encode($invoice_no);
        } else {
            $invoice_no = '000000';
        }
        $sales_invoice = ApiController::getSalesInvoice($invoice_no);
        $current_url = url()->current();
        $shorten_url = $this->shortenUrl($current_url);

        return view('module.sales.invoice_html', compact('sales_invoice', 'current_url'));
    }
    private function shortenUrl($invoice_link)
    {

        $headers = ["Authorization" => "Bearer gPmAReDOagqvHyIF", "Accept" => "*/*"];
        //dd($headers);
        $res = Http::withHeaders($headers)->post("https://sizl.ink/api/url/add", [
            "url" => $invoice_link,
        ])->json();
        // dd($res);
        return $res;

    }
}
