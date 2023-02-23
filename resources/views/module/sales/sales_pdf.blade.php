<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Sales Report') }}</title>

    <style>
        /* * {
            font-family: DejaVu Sans;
        } */

        .pdf-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid rgb(219, 217, 217);
        }

        .pdf-table th {
            border: 1px solid rgb(202, 201, 201);
            padding: 5px;
            font-weight: bold;
            text-align: center;
        }

        .pdf-table td {
            border: 1px solid rgb(190, 187, 187);
            padding: 5px;
            text-align: center;
        }

        .pdf-table .text-left {
            text-align: left;
        }

        .pdf-table .text-right {
            text-align: right;
        }

        .pdf-table .text-center {
            text-align: center;
        }

        .pdf-table .text-center-lg {
            text-align: center;
            font-size: 20px;
        }

        .pdf-table .text-left-lg {
            text-align: left;
            font-size: 20px;
        }

        .pdf-table .text-right-lg {
            text-align: right;
            font-size: 20px;
        }

        .pdf-table .text-center-md {
            text-align: center;
            font-size: 12px;
        }

        .pdf-table .text-left-md {
            text-align: left;
            font-size: 12px;
        }

        .pdf-table .text-right-md {
            text-align: right;
            font-size: 12px;
        }

        .header {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            position: relative;
            height: 100px;
        }

        .header_logo {
            position: absolute;
            top: 0;
            left: 0;
        }

        .header_logo img {
            width: 60px;
        }

        .header .text-sm {
            font-size: 16px;
        }

        body {
            font-family: 'nikosh', 'freeserif';

        }
    </style>
</head>

<body>
    {{-- <htmlpageheader> --}}
    <div class="header">
        <table style="width:100%">
            <tr>
                <td class="text-center-lg" style="width: 25%; ">
                    <div class="header_logo">
                        <img style="width:100px" src="{{ public_path('theme/images/logo.png') }}" alt="">
                        {{-- <img src="http://115.124.120.251:5004/theme/images/logo.png" alt=""> --}}
                    </div>
                </td>

                <td class="text-center-lg" style="width: 50%; text-align:center;">
                    <div class=" ">{{ __('Sales Report') }}</div>
                    <div class="text-sm text-truncate">{{ __('Period') }}:
                        {{ date('d-m-Y', strtotime($param['fromDate'])) }} to
                        {{ date('d-m-Y', strtotime($param['toDate'])) }} </div>
                    @foreach ($collections as $key => $data)
                        @php
                            $data = collect($data);
                            // dd($data);
                            $office = $data['officeName'];
                            // dd($office);
                        @endphp
                    @break
                @endforeach
                <div class="text-sm">{{ __('Business Entity') }}: {{ $office }}</div>
            </td>
            <td class="text-center-lg" style="width: 25%"></td>
        </tr>
    </table>


</div>
{{-- </htmlpageheader> --}}


<table id="pdf-table" class="pdf-table">

    <thead>

        <tr style="background:rgb(124, 238, 213); font-weight:bold">
            <td class=" text-left">{{ __('InvoiceDate') }}</td>
            <td class=" text-left">{{ __('InvoiceNo') }}</td>
            <td class=" text-left">{{ __('Name') }}</td>
            <td class=" text-left"> {{ __('MobileNo') }}</td>
            <td class=" text-left"> {{ __('VehicleNo') }}</td>
            <td class=" text-left"> {{ __('Product') }}</td>
            <td class="text-center"> {{ __('Qty.') }}</td>
            <td class="text-center"> {{ __('Rate') }}</td>
            <td class="text-center"> {{ __('Disc.') }}</td>
            <td class="text-right"> {{ __('Total') }}</td>
            <td class="text-right"> {{ __('PaymentMode') }}</td>
            <td class="text-left"> {{ __('Comment') }}</td>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
            $discount = 0;
        @endphp
        @foreach ($collections as $key => $data)
            @php
                $data = collect($data);
                $total += $data['total'];
                $discount += $data['discount'];
            @endphp
            <tr>

                <td class=" text-left">{{ date('d-m-Y', strtotime($data['invoiceDate'])) }}</td>
                <td class=" text-left">{{ $data['invoiceNo'] }}</td>
                <td class="text-wrap text-truncate  text-left">{{ $data['customerName'] }}</td>
                <td class="text-wrap text-truncate  text-left">{{ $data['mobileNo'] }}</td>
                <td class="text-wrap text-truncate  text-left">{{ $data['vehicleNo'] }}</td>
                <td class="text-wrap text-truncate  text-left">{{ $data['productTypeName'] }}</td>
                <td class="text-wrap text-truncate text-center">{{ $data['quantity'] }}</td>
                <td class="text-wrap text-truncate text-center">{{ number_format($data['rate'], 2, '.', '') }}</td>
                <td class="text-wrap text-truncate text-center">{{ number_format($data['discount'], 2, '.', '') }}
                </td>
                <td class="text-wrap text-truncate  text-right">{{ number_format($data['total'], 2, '.', '') }}
                </td>
                <td class="text-wrap text-truncate  text-center">{{ $data['paymentModeName'] }}</td>
                <td class="text-wrap text-truncate  text-left">{{ $data['comment'] }}</td>
            </tr>
        @endforeach
    <tfoot>
        <tr style="border-top:2px solid #fff;background:rgb(230, 233, 232); font-weight:bold">
            <td colspan="8" style="text-align:right">{{ __('Total') }} : </td>
            <td style="text-align:right">{{ number_format($discount, 2, '.', '') }}</td>
            <td style="text-align:right">{{ number_format($total, 2, '.', '') }}</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>

    </tbody>
</table>

</body>

</html>
