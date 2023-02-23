@extends('layouts.main')
@section('content')
    <style>
        @media(max-width: 575px) {
            .content-wrapper {
                padding: 1.375rem 1rem;
            }
        }

        @media (min-width: 576px) {
            .p-sm-3 {
                padding: 0.2rem !important;
            }

            .position-sm-static {
                position: static !important;
            }

            .position-sm-relative {
                position: relative !important;
            }

            .position-sm-absolute {
                position: absolute !important;
            }

            .position-sm-fixed {
                position: fixed !important;
            }

            .position-sm-sticky {
                position: sticky !important;
            }
        }

        @media (min-width: 768px) {
            .p-md-3 {
                padding: 0.4rem !important;
            }

            .position-md-static {
                position: static !important;
            }

            .position-md-relative {
                position: relative !important;
            }

            .position-md-absolute {
                position: absolute !important;
            }

            .position-md-fixed {
                position: fixed !important;
            }

            .position-md-sticky {
                position: sticky !important;
            }
        }

        @media (min-width: 992px) {
            .p-lg-3 {
                padding: 0.6rem !important;
            }

            .position-lg-static {
                position: static !important;
            }

            .position-lg-relative {
                position: relative !important;
            }

            .position-lg-absolute {
                position: absolute !important;
            }

            .position-lg-fixed {
                position: fixed !important;
            }

            .position-lg-sticky {
                position: sticky !important;
            }
        }

        @media (min-width: 1200px) {
            .p-xl-3 {
                padding: 0.8rem !important;
            }

            .position-xl-static {
                position: static !important;
            }

            .position-xl-relative {
                position: relative !important;
            }

            .position-xl-absolute {
                position: absolute !important;
            }

            .position-xl-fixed {
                position: fixed !important;
            }

            .position-xl-sticky {
                position: sticky !important;
            }
        }

        .cash {
            /* background-color: #3a81f1; */
            background: #73a2ee;
            /* background:  linear-gradient(to right, #73a2ee, #bad0f3); */
        }

        .upi {
            /* background-color: #2da94f; */
            background-color: #5fb476;
            /* background:  linear-gradient(to right, #5fb476, #9ccca9); */
        }

        .cr_card {
            /* background-color: #fdbd00; */
            background-color: #f0d070;
            /* background:  linear-gradient(to right, #f0d070, #f0dda5); */
        }

        .net_bank {
            /* background-color: #ea4335; */
            background-color: #e77267;
            /* background:  linear-gradient(to right, #e77267, #f1bbb6); */
        }
    </style>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-12">
                        <h4 class="m-0 text-dark">{{ __($MasterOffice[0]['officeName']) }} : {{ __('Sales') }} </h4>
                        <ol class="breadcrumb  border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Sales') }}</li>
                        </ol>

                        <div class="invoice-btn  position-md-absolute position-relative " style="right:0;top:0;">
                            @if(!in_array($routeRole,['pumpadmin','pumpuser']))
                            <a href="javascript:" id="btn-verify" data-status="1" data-param=""
                                data-url="{{ route($routeRole . '.sales.create') }}" title="{{ __('Mark Finalize') }}"
                                class="status_update btn btn-rounded animated-shine px-2 mb-2 {{in_array($routeRole,['pumpadmin','pumpuser']) ? 'd-none':'' }} ">
                                {{ __('Mark Finalize') }}</a>

                            <a href="javascript:" id="btn-verify" data-status="2" data-param=""
                                data-url="{{ route($routeRole . '.sales.create') }}" title="{{ __('Mark Disputed') }}"
                                class="status_update btn btn-rounded animated-shine px-2 mb-2 {{in_array($routeRole,['pumpadmin','pumpuser']) ? 'd-none':'' }} ">
                                {{ __('Mark Disputed') }}</a>
                             @endif

                            <a href="javascript:" data-param="" data-url="{{ route($routeRole . '.sales.create') }}"
                                title="{{ __('New Invoice') }}"
                                class="load-popup float-right btn btn-rounded animated-shine px-2 mb-2 ">
                                {{ __('New Invoice') }}</a>
                        </div>



                    </div><!-- /.col -->
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="card border border-primary  p-sm-3 p-md-3  p-lg-3  p-xl-3  py-0">


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
                                        value="{{ __(date('Y-m-d')) }}" max="{{ __(date('Y-m-d')) }}">
                                </div>

                            </div>

                        </div>
                        <div class="col-md-2 col-6 pt-3">
                            <div class="text-center-lg text-left-md">
                                <div class="text-center-lg text-left-md label-text">{{ __('To Date') }}</div>
                                <div class="d-flex " style="gap:10px;">

                                    <div class="w-100  ">
                                        <input type="date" class="form-control" name="toDate" id="toDate"
                                            value="{{ __(date('Y-m-d')) }}" max="{{ __(date('Y-m-d')) }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-2 pt-3">
                            <div class="label-text">{{ __('Status') }}</div>
                            <select name="status_filter" id="status_filter" class="form-control">

                                <option value="">{{ __('All') }}</option>
                                <option value="0">{{ __('Not Verified') }}</option>
                                <option value="1">{{ __('Verified') }}</option>
                                <option value="2">{{ __('Disputed') }}</option>


                            </select>
                        </div>

                        <div class="col-md-3 d-flex align-items-center mt-4 icon-wrap ">
                            <a href="javascript:" class="search btn-zoom badge align-self-end"  title="{{__('Search')}}">
                                <span class="iconify" data-icon="fe:search" style="color: #05a;" data-width="30"
                                    data-height="30"></span>
                            </a>
                            <a class="export btn-zoom badge align-self-end mx-2" href="javascript:"  title="{{__('Export to excel')}}">
                                <span class="iconify" data-icon="ri:file-excel-2-fill" style="color: #2a0;" data-width="30"
                                    data-height="30"></span>
                            </a>
                            <a class="pdf btn-zoom badge   align-self-end" href="javascript:"  title="{{__('Export to pdf')}}">
                                <span class="iconify" data-icon="fluent:document-pdf-32-regular" style="color: #d20;"
                                    data-width="30" data-height="30"></span>
                            </a>
                            <a class="toggle-legends btn-zoom badge   align-self-end" href="javascript:" title="{{__('Show/Hide Legend')}}">
                                <img src="{{ asset('images/code-block.png') }}" width="30" height="30"
                                    alt="">
                            </a>
                        </div>

                        <div class="col-md-3 ms-auto legends">

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="mx-2">
                                    <span class="badge badge-success rounded-circle cash d-block"
                                        style="color:#ffffff00!important;width:20px;height:20px;padding-bottom: 10px;margin: 5px auto 0;">O</span>
                                    <span
                                        style="padding: 10px 0 0 0; display: block; font-size: 12px;">{{ __('CASH') }}</span>
                                </div>
                                <div class="mx-2">
                                    <span class="badge badge-warning rounded-circle upi d-block"
                                        style="color:#ffffff00!important;width: 20px;height: 20px;padding: 10px 0 0 0;margin: 5px auto 0;">O</span>
                                    <span
                                        style="padding: 10px 0 0 0;display: block;font-size: 12px;">{{ __('UPI') }}</span>

                                </div>
                                <div class="mx-2">

                                    <span class="badge badge-warning rounded-circle cr_card d-block"
                                        style="color:#ffffff00!important;width: 20px;height: 20px;padding-bottom: 10px;margin: 5px auto 0;">O</span>
                                    <span
                                        style="padding: 10px 0 0 0;display: block;font-size: 12px;">{{ __('CARD') }}</span>

                                </div>
                                <div class="mx-2">
                                    <span class="badge badge-warning rounded-circle net_bank d-block"
                                        style="color:#ffffff00!important;width: 20px;height: 20px;padding-bottom: 10px;margin: 5px auto 0;">O</span>
                                    <span
                                        style="padding: 10px 0 0 0;display: block;font-size: 12px;">{{ __('NETBANKING') }}</span>

                                </div>




                            </div>

                        </div>
                        <div class="col-md-2 ms-auto legends">
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="mx-2 text-center sr-only">
                                    {{-- <span class="badge badge-success rounded-circle cash d-block"
                                        style="color:#ffffff00!important;width:20px;height:20px;padding-bottom: 10px;margin: 5px auto 0;">O</span> --}}
                                    <i class="fas fa-check-double text-gray"></i>
                                    <span
                                        style="padding: 10px 0 0 0; display: block; font-size: 12px;">{{ __('NOT VERIFIED') }}</span>
                                </div>
                                <div class="mx-2 text-center">
                                    {{-- <span class="badge badge-success rounded-circle cash d-block"
                                        style="color:#ffffff00!important;width:20px;height:20px;padding-bottom: 10px;margin: 5px auto 0;">O</span> --}}
                                    <i class="fas fa-check-double text-success"></i>
                                    <span
                                        style="padding: 10px 0 0 0; display: block; font-size: 12px;">{{ __('VERIFIED') }}</span>
                                </div>
                                <div class="mx-2 text-center sr-only">
                                    {{-- <span class="badge badge-success rounded-circle cash d-block"
                                        style="color:#ffffff00!important;width:20px;height:20px;padding-bottom: 10px;margin: 5px auto 0;">O</span> --}}
                                    <i class="fas fa-gavel text-secondary"></i>
                                    <span
                                        style="padding: 10px 0 0 0; display: block; font-size: 12px;">{{ __('DISPUTE') }}</span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="reportPanel mt-3 card border border-primary">

                </div>

        </section>
    </div>
    {{-- <script>
        $(document).ready(function() {

            $('#table').DataTable({
                responsive: true,


                    language: {

                        searchPlaceholder: "Search...",
                        sSearch: "",
                        lengthMenu: "Showing  _MENU_ Records",
                        info: "Showing _START_ to _END_ of _TOTAL_ records",
                        infoEmpty: "No records found",
                        infoFiltered: "(filtered from _MAX_ total records)"
                    }


                }

            );
        });
    </script> --}}
    @php
        //$routeRole = Route::currentRouteName();
        $url_sales_filter = route($routeRole . '.sales_filter');
        $url_sales_export = route($routeRole . '.sales_export');
        $url_sales_pdf = route($routeRole . '.sales_pdf');
        //dd($url_filter);
    @endphp
    <script>
        $(document).ready(function() {
            $('.toggle-legends').click(function() {
                $('.legends').toggle();
            });
        });
    </script>
    <script>
        var routeRole = "{{ $routeRole }}";
        $(document).ready(function() {

            $('.search').on('click', function() {
                $('.reportPanel').html(
                    '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                );
                var officeId = $('#officeId_filter').val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                var status = $('#status_filter').val();


                $.ajax({
                    url: '{{ $url_sales_filter }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        officeId: officeId,
                        fromDate: fromDate,
                        toDate: toDate,
                        status: status
                    },
                    success: function(response) {
                        //     console.log(response);
                        $('.reportPanel').html(response.view);
                    }
                });
            });
            // setTimeout(() => {
            //      $('.search').click();
            // }, 2000);
            $('#status_filter').on('change', function() {
                $('.search').click();
            });
            $('#officeId_filter').on('change', function() {
                $('.search').click();
            });
            $('#fromDate').on('change', function() {
                $('.search').click();
            });
            $('#toDate').on('change', function() {
                $('.search').click();
            });

            $('.export').on('click', function() {
                var officeId = $('#officeId_filter').val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                var officeName = $('#officeId_filter option:selected').text();
                var fileName = officeName + '_Sales_Report_' + date_format(fromDate) + '_to_' + date_format(
                    toDate) + '.xlsx';
                $.ajax({
                    url: '{{ $url_sales_export }}',
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
                        var filename = (matches != null && matches[1] ? matches[1] : fileName);

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
                var officeName = $('#officeId_filter option:selected').text();
                var officeName = $('#officeId_filter option:selected').text();
                var fileName = officeName + '_Sales_Report_' + date_format(fromDate) + '_to_' + date_format(
                    toDate) + '.pdf';

                // var fileName=officeName + '_Sales_Report_' + fromDate + '_to_' + toDate +'.pdf';
                $.ajax({
                        url: '{{ $url_sales_pdf }}',
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
                            //console.log(result);

                            var disposition = xhr.getResponseHeader('content-disposition');
                            var matches = /"([^"]*)"/.exec(disposition);
                            var currentdate = new Date();
                            var datetime = 'sales' + currentdate.getFullYear() + currentdate
                                .getDate() +
                                (currentdate.getMonth() + 1) +
                                currentdate.getHours() +
                                currentdate.getMinutes() +
                                currentdate.getSeconds();

                            // document.write(datetime);
                            //var filename = (matches != null && matches[1] ? matches[1] : datetime + '.pdf');
                            var filename = fileName;

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
                            //toastr.success('Downloaded');
                        },
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

            var updateCount = 0;
          $('.status_update').on('click', function() {
              if ($('#salesIds').val() == '') {
                  toastr.error("{{ __('Please select sales to update status') }}");
                  return false;
              }
              var status = $(this).attr('data-status');
              $.ajax({
                  url: "{{ route($routeRole . '.sales.verify') }}",
                  method: "POST",
                  data: {
                      _token: "{{ csrf_token() }}",
                      status: status,
                      salesIds: $('#salesIds').val()
                  },
                  success: function(data) {
                      if (data.status == 1) {
                        $('#salesIds').val('');
                          toastr.success(data.message);
                          console.log(updateCount++);
                          $('.search').click();
                          //  $('#table').DataTable().draw();
                      } else {
                          toastr.error(data.message);
                      }
                  }
              });

          });





        });
    </script>
@endsection
