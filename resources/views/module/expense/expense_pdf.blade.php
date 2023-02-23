<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('Expense Report')}}</title>
    <style>
        .pdf-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .pdf-table th {
            border: 1px solid #000;
            padding: 5px;
            font-weight: bold;
            text-align: center;
        }

        .pdf-table td {
            border: 1px solid #000;
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
            width: 150px;
            height: 60px;
        }

        .header .text-sm {
            font-size: 12px;
        }

        body {
            font-family: freesarif;
        }
    </style>
</head>

<body>

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
                    <div class=" ">{{ __('Expense Report') }}</div>
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
<table id="pdf-table" class="pdf-table">

    <thead>

        <tr style="background:rgb(252, 250, 176); font-weight:bold">
            <td class=" text-left">{{ __('VoucherDate') }}</td>
            <td class=" text-left">{{ __('VoucherNo') }}</td>
            <td class=" text-left">{{ __('Particulars') }}</td>
            <td class=" text-right"> {{ __('Amount') }}</td>
        </tr>
    </thead>
    <tbody>
        @php
            $amount = 0;
        @endphp
        @foreach ($collections as $key => $data)
            @php
                $data = collect($data);
                $amount += $data['amount'];
            @endphp
            <tr>
                <td class=" text-left">{{ date('d-m-Y', strtotime($data['voucherDate'])) }}</td>
                <td class=" text-left">{{ $data['voucherNo'] }}</td>
                <td class="text-wrap text-truncate  text-left">{{ $data['particulars'] }}</td>
                <td class="text-wrap text-truncate  text-right">{{ number_format($data['amount'], 2, '.', '') }}</td>

            </tr>
        @endforeach
        <tr style="border-top:2px solid #fff;background:rgb(230, 233, 232); font-weight:bold">
            <td colspan="3" class="text-right">{{ __('Total') }} : </td>
            <td class="text-right">{{ number_format($amount, 2, '.', '') }}</td>
    </tbody>
</table>

</body>

</html>
