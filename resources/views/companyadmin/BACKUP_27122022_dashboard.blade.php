@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center p-3">
            <div class="col-md-12 ">
                <div class="row mx-auto ">

                    <div class="col-xl-3 col-lg-6">
                        <a href="{{ route('admin.user.index') }}">
                            <div class="card-anim l-bg-cherry">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0"></h5>
                                    </div>
                                    <div class="row justify-content-between mb-2 d-flex">
                                        <div class="col-8">
                                            <h3 class="d-flex align-items-center mb-0">
                                                Users
                                            </h3>
                                        </div>
                                        <div class="col-4 text-right">

                                            <span class="">{{ $admin_dashboard_data->userCount }} <i
                                                    class="fa fa-arrow-up"></i></span>
                                        </div>
                                    </div>
                                    <div class="progress mt-1  d-none" data-height="8" style="height: 8px;">
                                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <a href="{{ route('admin.office.index') }}">
                            <div class="card-anim l-bg-orange-dark">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-building"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0"></h5>
                                    </div>
                                    <div class="row align-items-center mb-2 d-flex">
                                        <div class="col-8">
                                            <h3 class="d-flex align-items-center mb-0">
                                                Offices
                                            </h3>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="">{{ $admin_dashboard_data->officeCount }}<i
                                                    class="fa fa-arrow-up"></i></span>
                                        </div>
                                    </div>
                                    <div class="progress mt-1 d-none " data-height="8" style="height: 8px;">
                                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-6 ">
                        <div class="card-anim l-bg-green-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0"></h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h3 class="d-flex align-items-center mb-0 ">
                                            Sales
                                        </h3>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="">{{ $admin_dashboard_data->salesCount }} <i
                                                class="fa fa-arrow-up"></i></span>
                                    </div>
                                </div>
                                <div class="progress mt-1 d-none " data-height="8" style="height: 8px;">
                                    <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="row justify-content-center">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="office">Office :</label>
                            <div>
                                <select name="office" id="office" class="form-control">
                                    <option value="{{ $officeList[0]['masterOfficeId'] }}" data-isRetail="-1"
                                        data-isAdmin="1" class="optionGroup">All Pump Offices</option>


                                    @foreach ($officeList as $key => $office)
                                        @if ($key == 0)
                                            <option value="{{ $office['masterOfficeId'] }}" data-isRetail="0"
                                                data-isAdmin="1" class="optionGroup">WholeSale Pumps</option>
                                        @endif
                                        @if ($office['isRetail'] == 0)
                                            <option value="{{ $office['officeId'] }}" data-isRetail="0" data-isAdmin="0"
                                                class="optionChild">
                                                &nbsp;&nbsp;&nbsp;&nbsp; {{ $office['officeName'] }}</option>
                                        @endif
                                    @endforeach



                                    @foreach ($officeList as $key => $office)
                                        @if ($key == 0)
                                            <option value="{{ $office['officeId'] }}" data-isRetail="1" data-isAdmin="1"
                                                class="optionGroup">Retail Pumps</option>
                                        @endif
                                        @if ($office['isRetail'] != 0)
                                            <option value="{{ $office['officeId'] }}" data-isRetail="1" data-isAdmin="0"
                                                class="optionChild">
                                                &nbsp;&nbsp;&nbsp;&nbsp;{{ $office['officeName'] }}</option>
                                        @endif
                                    @endforeach


                                </select>
                            </div>




                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="form-group">
                            <label for="reportrange">Period : </label>
                            <div id="reportrange" name="reportrange" class="pull-right form-control"
                                style="background: #fff; cursor: pointer; padding: 5px 10px;  ; width: 100%">
                                <i class=" fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end ">
                        <button class="btn btn-primary btn-sm mb-10  w-100" id="filter">Filter</button>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Sales</h5>
                                    <div class="btn btn-link   p-0">
                                        <i class="fas fa-chart-bar fa-lg d-none"></i>
                                        <i class="fas fa-table fa-lg "></i>
                                    </div>
                                </div>


                            </div>


                            <div class="card-body overflow-hidden d-flex">
                                <canvas id="chartOne" height="200px" class="w-100"></canvas>
                                <div id="chartOneData" class="d-none">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-md w-100">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                            </tr>
                                            {{-- @foreach ($admin_dashboard_data->top5Products as $product)
                                                <tr>
                                                    <td>{{ $product->productName }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>{{ $product->amount }}</td>
                                                </tr>
                                            @endforeach --}}
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Top 5 Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                        </tr>
                                        {{-- @foreach ($admin_dashboard_data->top5Products as $product)
                                            <tr>
                                                <td>{{ $product->productName }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->amount }}</td>
                                            </tr>
                                        @endforeach --}}
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Top 5 Customers</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Quantity</th>
                                            <th>Amount</th>
                                        </tr>
                                        {{-- @foreach ($admin_dashboard_data->top5Customers as $customer)
                                            <tr>
                                                <td>{{ $customer->customerName }}</td>
                                                <td>{{ $customer->quantity }}</td>
                                                <td>{{ $customer->amount }}</td>
                                            </tr>
                                        @endforeach --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        var labels = {{ Js::from($labels) }};
        var sales = {{ Js::from($data) }};

        const data = {
            labels: labels,
            datasets: [{
                label: 'Sales',
                backgroundColor: '#1e5799',
                borderColor: 'rgb(255, 99, 132)',
                data: sales,


            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                'height': '200px',
                'zoom': {
                    'enabled': true,
                    'mode': 'x',
                    'sensitivity': 3,
                    'speed': 0.1
                },

            }
        };

        var chartOne= new Chart(
            document.getElementById('chartOne'),
            config
        );

                                $('.fa-chart-bar').click(function() {
                                    $('.fa-chart-bar').addClass('d-none');
                                    $('.fa-table').removeClass('d-none');
                                   $('#chartOne').removeClass('d-none');
                                   $('#chartOne').css('margin-left', "0");

                                    $('#chartOneData').addClass('d-none');
                                    $('#chartOneData').removeClass('d-block');
                                    // chartOne.destroy();
                                    //  chartOne= new Chart(
                                    //     document.getElementById('chartOne'),
                                    //     config
                                    // );
                                    // height of chart is set to 200px
                                    $('#chartOne').css('height', '200px');
                                    $('#chartOne').css('zoom', '1');

                                });
                                $('.fa-table').click(function() {
                                    $('.fa-table').addClass('d-none');
                                    $('.fa-chart-bar').removeClass('d-none');
                                    //chart with id 0 is destroyed
                                    // chartOne.destroy();
                                    var height = $('#chartOne').css('height');
                                    var width = $('#chartOne').css('width');
                                    $('#chartOneData').css('witdh', width);
                                    width=(parseInt(width) + 20)+"px";
                                    console.log(width);
                                    $('#chartOne').css('margin-left', "-" + width );
                                    // $('#chartOne').addClass('d-none');
                                    $('#chartOneData').removeClass('d-none');
                                    $('#chartOneData').addClass('d-block');
                                });

    </script>

    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
                // console.log(start);
                // $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    // 'Today': [moment(), moment()],
                    // 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);


            $('#filter').click(function() {
                cb(start, end);
                var office = $('#office').val();
                var fromDate = start.format('YYYY-MM-DD');
                // var fromDate =$('#fromDate').val();
                var toDate = end.format('YYYY-MM-DD');

                // console.log($('#reportrange').daterangepicker({}));


                //console.log(office);
                //   console.log(toDate);
                $.ajax({
                    url: "{{ route('admin.sales_filter') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        officeId: office,
                        fromDate: fromDate,
                        toDate: toDate
                    },
                    success: function(data) {
                        console.log(data);
                    }
                })
            })


        });
    </script>
    <style>
        .optionGroup {
            font-weight: bold;
            font-style: italic;
        }

        .optionChild {
            /* padding-left: 30px; */
            padding: 20px;
            font-size: 14px;
        }
        .form-group{
            padding: 0;
            margin: 10px;
        }
        .mb-10{
            margin-bottom: 10px;
        }
        .form-group label {
    font-size: 0.875rem;
    line-height: 1.4rem;
    vertical-align: bottom;
    margin-bottom: -10px;
    margin-left: 9px;
    background: #fff;
    background: radial-gradient(circle, rgba(255,255,255,1) 75%, rgb(255 255 255 / 0%) 100%);
    padding: 0 6px;
}

        input+label {
            position: relative;
            z-index: 999;
        }
        select.form-control, select.asColorPicker-input, .dataTables_wrapper select, .jsgrid .jsgrid-table .jsgrid-filter-row select, .select2-container--default select.select2-selection--single, .select2-container--default .select2-selection--single select.select2-search__field, select.typeahead, select.tt-query, select.tt-hint,
         .form-control {
    padding: .4375rem .75rem;
    /* border: 0; */
     outline: none;
    color: #979292;
    border: 1px solid #cbd3db;
    overflow: hidden;
}
    </style>
@endsection
