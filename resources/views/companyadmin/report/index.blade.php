@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center mx-3">
                    <div class="col-xs-6">
                        <h4 class="m-0 text-dark">{{ __('Report') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-xs-6">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Report') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">

            <div class="card border border-primary p-3 py-0">
                <div class="card-title text-primary m-0">
                   User Task Report Filter
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="col-md-3 pt-3">
                            <div>Office</div>
                            <select name="officeId" id="officeId" class="form-control">
                                @foreach ($officeList as $office)
                                    <option value="{{ $office['officeId'] }}">{{ $office['officeName'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 pt-3">
                            <div class="text-center-lg text-left-md">From Date</div>
                            <div class="d-flex " style="gap:10px;">
                                <div class="w-100  ">
                                    <input type="date" class="form-control" name="fromDate" id="fromDate"
                                        value="{{ date('Y-m-d') }}">
                                </div>

                            </div>

                        </div>
                        <div class="col-md-3 pt-3">
                            <div class="text-center-lg text-left-md">
                                <div class="text-center-lg text-left-md">To Date</div>
                                <div class="d-flex " style="gap:10px;">

                                    <div class="w-100  ">
                                        <input type="date" class="form-control" name="toDate" id="toDate"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3 d-flex justify-content-start align-content-end align-items-center mt-2 ">
                            <a href="javascript:" class="search badge align-self-end">
                                <span class="iconify" data-icon="fe:search" style="color: #05a;" data-width="30"
                                    data-height="30"></span>
                            </a>
                            <a class="export badge align-self-end mx-2" href="javascript:">
                                <span class="iconify" data-icon="ri:file-excel-2-fill" style="color: #2a0;" data-width="30"
                                    data-height="30"></span>
                            </a>
                            <a class="pdf badge   align-self-end" href="javascript:">
                                <span class="iconify" data-icon="fluent:document-pdf-32-regular" style="color: #d20;"
                                    data-width="30" data-height="30"></span>
                            </a>
                        </div>

                    </div>

                </div>

            </div>
            <div class="reportPanel mt-3 card border border-primary p-3 py-0">

            </div>

        </section>
        <script>
            $(document).ready(function() {
                $('.search').click(function() {
                    $('.reportPanel').html(
                        '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                    );
                    var officeId = $('#officeId').val();
                    var fromDate = $('#fromDate').val();
                    var toDate = $('#toDate').val();
                    $.ajax({
                        url: '{{ route('companyadmin.report.task') }}',
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
                    var officeId = $('#officeId').val();
                    var fromDate = $('#fromDate').val();
                    var toDate = $('#toDate').val();
                    $.ajax({
                        url: '{{ route('companyadmin.user_task.export') }}',
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
                            var filename = (matches != null && matches[1] ? matches[1] :
                                'userTask.xlsx');

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
                $('.pdf').on('click',function(){
                    var officeId = $('#officeId').val();
                    var fromDate = $('#fromDate').val();
                    var toDate = $('#toDate').val();
                  //  alert(officeId);
                    $.ajax({
                        url: '{{ route('companyadmin.user_task.pdf') }}',
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
                                    var datetime =  'userTask'+currentdate.getFullYear()+currentdate.getDate()
                                                + (currentdate.getMonth()+1)
                                                + currentdate.getHours()
                                                + currentdate.getMinutes()
                                                + currentdate.getSeconds();

                                // document.write(datetime);
                            var filename = (matches != null && matches[1] ? matches[1] : datetime+'.pdf');

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
                        },
                        fail: function(data) {
                            alert('Not downloaded');
                            //console.log('fail',  data);
                        }
                    });
                });
                $('#officeId').select2();
            });
        </script>
    </div>
@endsection
