<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Sales Summary') }}</title>
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
                        <div class=" ">{{ __('Product-wise Summary Data') }}</div>
                        <div class="text-sm text-truncate">{{ __('Period') }}:
                            {{ date('d-m-Y', strtotime($param['fromDate'])) }} -
                            {{ date('d-m-Y', strtotime($param['toDate'])) }} </div>

                        <div class="text-sm">{{ __('Business Entity') }}: {{ $office[0]['officeName'] }}</div>
                    </td>
                    <td class="text-center-lg" style="width: 25%"></td>
                </tr>
            </table>

    </div>
        <table id="pdf-table" class="pdf-table">
            {{-- <table id="chartOneDataTable" class="table-striped  display nowrap stattab"  style="width:100%" > --}}
            {{-- <caption>{{__('Sales-Expense')}}</caption> --}}


            <thead>
                <tr style="background:rgb(124, 238, 213); font-weight:bold">
                    <td scope="col" style="width:40%;" class="text-left">{{ __('Product Name') }}</td>
                    <td scope="col" style="width:30%;" class="text-center">{{ __('Quantity') }}</td>
                    <td scope="col" style="width:30%;" class="text-right">{{ __('Amount') }}</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_amount = 0;
                @endphp
                @foreach ($graph2 as $product => $value)

                    @php
                        $total_amount += $value['sale'];
                    @endphp
                    @if($value['sale']!=0)
                    <tr style=" ">

                        <td scope="col" style="width: 40%;padding:5px" class="text-left">{{ __($product) }}</td>
                        <td scope="col" style="width: 30%;padding:5px" class="text-center">{{$value['qty']==0?'':  __(number_format($value['qty'], 2, '.', '')) .' ' .__($value['PrimaryUnit']['unitShortName']) }}</td>
                        <td scope="col" style="width: 30%;padding:5px" class="text-right">
                            {{ __(number_format($value['sale'], 2, '.', 0)) }}</td>
                    </tr>
                    @endif
                @endforeach
                <tr style="border-top:2px solid #fff;background:rgb(230, 233, 232); font-weight:bold">
                    {{-- <th scope="col" style="width: 50%;padding:5px" class="text-right"></th> --}}
                    <td scope="col" colspan="3" style="width: 100%;padding:5px" class="text-right">
                        {{ __('Total') }} : {{ __(number_format($total_amount, 2, '.', 0)) }}</td>
                </tr>
            </tbody>



        </table>

</body>

</html>
