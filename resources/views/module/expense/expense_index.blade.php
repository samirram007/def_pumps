@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('Expense') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole.'.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Expense') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="card border border-primary p-3 py-0">
                <div class="card-title text-primary m-0">
                    <div class="row      ">
                        <div class="col-md-8">
                            <label class="label text-primary">
                                <span>{{ $MasterOffice[0]['officeName'] }} : {{ __('Expense Report') }} </span>
                            </label>
                        </div>
                        <div class="col-md-4 invoice-btn">

                            <a href="javascript:" data-param="" data-url="{{ route($routeRole.'.expense.create') }}"
                                title="{{ __('New Expense Voucher') }}" class="load-popup float-right btn btn-rounded animated-shine px-2 mb-2 ">
                                {{ __('New Expense Voucher') }}</a>

                        </div>
                    </div>

                </div>

                <div class="card-content">
                    <div class="row">
                        <div class="col-md-3 pt-3">
                            <div class="label-text">{{ __('Business Entity') }}</div>
                            <select name="officeId_filter" id="officeId_filter" class="form-control">
                                @foreach ($officeList as $office)
                                    <option value="{{ $office['officeId'] }}">{{ __($office['officeName']) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 col-6 pt-3">
                            <div class="text-center-lg text-left-md label-text">{{ __('From Date') }}</div>
                            <div class="d-flex " style="gap:10px;">
                                <div class="w-100  ">
                                    <input type="date" class="form-control" name="fromDate" id="fromDate"
                                        value="{{ __(date('Y-m-d')) }}">
                                </div>

                            </div>

                        </div>
                        <div class="col-md-2 col-6 pt-3">
                            <div class="text-center-lg text-left-md">
                                <div class="text-center-lg text-left-md label-text">{{ __('To Date') }}</div>
                                <div class="d-flex " style="gap:10px;">

                                    <div class="w-100  ">
                                        <input type="date" class="form-control" name="toDate" id="toDate"
                                            value="{{ __(date('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3 d-flex align-items-center mt-4 icon-wrap">
                            <a href="javascript:" class="search btn-zoom  badge align-self-end">
                                <span class="iconify" data-icon="fe:search" style="color: #05a;" data-width="30"
                                    data-height="30"></span>
                            </a>
                            <a class="export btn-zoom badge align-self-end mx-2" href="javascript:">
                                <span class="iconify" data-icon="ri:file-excel-2-fill" style="color: #2a0;" data-width="30"
                                    data-height="30"></span>
                            </a>
                            <a class="pdf btn-zoom badge   align-self-end" href="javascript:">
                                <span class="iconify" data-icon="fluent:document-pdf-32-regular" style="color: #d20;"
                                    data-width="30" data-height="30"></span>
                            </a>
                        </div>

                    </div>

                </div>

            </div>
            <div class="reportPanel mt-3 card border border-primary">

            </div>

        </section>
    </div>
    @php
        //$routeRole = Route::currentRouteName();
         $url_expense_filter=route($routeRole.".expense_filter");
         $url_expense_export=route($routeRole.".expense_export");
         $url_expense_pdf=route($routeRole.".expense_pdf");
         //dd($url_filter);

    @endphp
    <script>
        /* function SwitchActivation(UserID, ActiveStatus) {
                       //onclick="SwitchActivation(1);"
                            }*/

        $(document).ready(function() {

            $('.search').click(function() {
                $('.reportPanel').html(
                    '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                );
                var officeId = $('#officeId_filter').val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                $.ajax({
                    url: '{{ $url_expense_filter }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        officeId: officeId,
                        fromDate: fromDate,
                        toDate: toDate
                    },
                    success: function(response) {
                        //     console.log(response);
                        $('.reportPanel').html(response.view);
                    }
                });
            });
            $('.export').on('click', function() {
                var officeId = $('#officeId_filter').val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                var officeName = $('#officeId_filter option:selected').text();
                var fileName=officeName + '_Expense_Report_' + date_format(fromDate) + '_to_' + date_format(toDate)+'.xlsx';
                $.ajax({
                    url: '{{ $url_expense_export}}',
                    type: 'POST',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        officeId: officeId,
                        fromDate: fromDate,
                        toDate: toDate
                    },
                    success: function(result, status, xhr) {

                        var disposition = xhr.getResponseHeader('content-disposition');
                        var matches = /"([^"]*)"/.exec(disposition);
                        var filename = (matches != null && matches[1] ? matches[1] :fileName);

                        // The actual download
                        var blob = new Blob([result], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename;

                        document.body.appendChild(link);

                        link.click();
                        document.body.removeChild(link);
                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
            });
            $('.pdf').on('click', function() {
                var officeId = $('#officeId_filter').val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();

                $.ajax({
                    url: '{{ $url_expense_pdf }}',
                    type: 'POST',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        officeId: officeId,
                        fromDate: fromDate,
                        toDate: toDate
                    },
                    success: function(result, status, xhr) {
                        // console.log(result);

                        var disposition = xhr.getResponseHeader('content-disposition');
                        var matches = /"([^"]*)"/.exec(disposition);
                        var currentdate = new Date();
                        var datetime = 'userTask' + currentdate.getFullYear() + currentdate
                            .getDate() +
                            (currentdate.getMonth() + 1) +
                            currentdate.getHours() +
                            currentdate.getMinutes() +
                            currentdate.getSeconds();

                        // document.write(datetime);
                        var filename = (matches != null && matches[1] ? matches[1] : datetime +
                            '.pdf');

                        // The actual download
                        var blob = new Blob([result], {
                            type: 'application/pdf'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename;

                        document.body.appendChild(link);

                        link.click();
                        document.body.removeChild(link);
                    }
                }).done(function(data) {
                    toastr.success('Downloaded');
                    //console.log(data);
                })
                .fail(function(data) {
                    toastr.error('No data found');
                   // console.log(data);
                });
            });
            $('#officeId').select2();
            setTimeout(() => {
                $('.search').click();
            }, 2000);






        });
    </script>
@endsection
