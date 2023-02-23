<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task-User Report</title>
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
            font-size: 16px;
        }

        .pdf-table .text-left-md {
            text-align: left;
            font-size: 16px;
        }

        .pdf-table .text-right-md {
            text-align: right;
            font-size: 16px;
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
            width: 80px;
            height: 80px;
        }

        .header .text-sm {
            font-size: 16px;
        }

        body {
            font-family: Helvetica;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header_logo">
            <img src="{{ asset('theme/images/logo.png') }}" alt="">
            {{-- <img src="http://115.124.120.251:5004/theme/images/logo.png" alt=""> --}}
        </div>
        <div>User Task Report</div>
        <div class="text-sm">Period: {{ date('d-m-Y', strtotime($param['fromDate'])) }} to
            {{ date('d-m-Y', strtotime($param['toDate'])) }} </div>

        @foreach ($report as $key => $data)
            @php
                $data = collect($data);
$office=$data['userDetails']['office']['officeName']
            @endphp
        @break
    @endforeach
    <div class="text-sm">Office: {{ $office }}</div>
</div>
<table id="pdf-table" class="pdf-table">

    <thead>

        <tr>
            {{-- <th>ID</th> --}}
            {{-- <th>Image</th> --}}
            <th>Sl No</th>
            <th>User</th>
            <th>Duration</th>
            <th>Completed Task</th>
            <th>Pending Task</th>
            <th>UnAttend Task</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $key => $data)
            @php
                $data = collect($data);
                //   dd($data['userDetails']);
            @endphp
            <tr>
                {{-- <td>{{ $key + 1 }} </td> --}}
                {{-- <td><img style="width: 50px; height:50px; border:1px solid #000000;"
                                src="{{ !empty($data->image) ? url('upload/user_images/' . $data->image) : url('upload/no_image.jpg') }}"
                                alt=""></td> --}}
                <td>{{ ++$key }} </td>
                {{-- <td>{{ $data['userDetails']['office']['officeName'] }} </td> --}}
                <td>{{ $data['userDetails']['firstName'] }} {{ $data['userDetails']['surName'] }}</td>
                <td>{{ __(number_format($data['workDuration'] / 60, 2, '.', '') . ' hrs') }}</td>
                <td>{{ __($data['completedTask']) }}</td>
                <td>{{ __($data['pendingTask']) }}</td>
                <td>{{ __($data['unAttendTask']) }}</td>

            </tr>
        @endforeach
    </tbody>
</table>

</body>

</html>
