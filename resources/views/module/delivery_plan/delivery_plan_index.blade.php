@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ $MasterOffice[0]['officeName'] }} : {{ __('Delivery Plan') }} </h4>
                        <ol class="breadcrumb float-sm-left border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Delivery plan') }}</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <a href="{{ route($routeRole . '.delivery_plan.create') }}" title="{{ __('New Delivery Plan') }}"
                            class=" float-right btn btn-rounded animated-shine px-2 mb-2 ">
                            {{ __('New Delivery Plan') }}</a>
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="card border border-primary p-3 py-0">


                <div class="card-content">
                    <div class="row">

                        @include('module.delivery_plan._partial.delivery_plan_section_filter')

                    </div>

                </div>

            </div>
            <div class="reportPanel mt-3  ">
                <table id="table" class="table   table-striped table-bordered   ">
                    <thead>
                        <tr>
                            <th>Plan Name</th>
                            <th>Planing Date</th>
                            <th>Hub</th>
                            <th>Product</th>
                            <th>TankerSize(ltr)</th>
                            <th class="text-center">Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    {{-- <tbody>

                        @foreach ($delivery_plans as $key => $plan)
                        <tr>
                            <td>{{ $plan['planTitle'] }}</td>
                             <td><span class="sr-only">{{  $plan['planDate']}}</span>{{  __(date('d-m-Y', strtotime($plan['planDate'])))}}</td>
                             <td>{{ $plan['startPoint']['cityName'] }}</td>
                             <td>{{ $plan['product']['productTypeName'] }}</td>
                             <td>{{ $plan['containerSize'] }}</td>
                            <td>

                                <a href="{{ route($routeRole.'.delivery_plan.view', $plan['deliveryPlanId']) }}"
                                title="{{ __('View Full Plan') }}" class="view_plan  btn btn-rounded animated-shine ">
                                <i class="fa fa-desktop m-0 "></i></a>

                                <a href="javascript:" data-param="" data-url="{{ route($routeRole.'.delivery_plan.edit', $plan['deliveryPlanId']) }}"
                                    title="{{ __('Edit Deliver Plan') }}" class="load-popup edit   btn btn-rounded animated-shine ">
                                    <i class="fa fa-edit m-0 "></i></a>
                                    <a href="{{ route($routeRole.'.delivery_plan.delete', $plan['deliveryPlanId']) }}" title="{{__('Delete')}}" class="delete  btn btn-rounded animated-shine-danger    "><i class="fa fa-trash m-0 "></i></a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody> --}}

                </table>
            </div>

        </section>
    </div>
    <style scoped>
        .dtr-details li {
            display: flex;
            padding: 0 !important;
        }

        .dtr-details li:last-child {
            margin-bottom: 10px;
        }

        .dtr-details li .dtr-title {
            align-self: center;
        }

        .dtr-details li .dtr-title::after {
            content: ':'
        }

        .dtr-details li .dtr-data {
            align-self: center;
            padding-inline-start: 5px;
        }

        .text-break {
            white-space: pre-wrap;
        }

        #table td:nth-child(6) {
            text-align: center;
        }
    </style>
    <script>
        $(document).ready(function() {

            $('.search').click(function() {
                $('.reportPanel').html(
                    '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                );
            });
            let delivery_plans = @json($delivery_plans);
            let view_url = `{{ route($routeRole . '.delivery_plan.view', ':id') }}`;
            let edit_url = `{{ route($routeRole . '.delivery_plan.edit', ':id') }}`;
            let delete_url = `{{ route($routeRole . '.delivery_plan.delete', ':id') }}`;
            let status_change_url = `{{ route($routeRole . '.delivery_plan.status_change', ':id') }}`;
            var start = moment().subtract(6, 'days');
            var end = moment();
            var listTable = $('#table').DataTable({
                responsive: true,
                select: false,
                paging: true,
                zeroRecords: true,
                "oLanguage": langOpt,
                data: delivery_plans,
                columns: [{
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return data.planTitle
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            const d = new Date(data['planDate']);
                            return `<span class="sr-only">${ d}</span>` +
                                `${ moment(d).format('DD-MM-YYYY')}`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return data.startPoint.cityName;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return data.product.productTypeName;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return data.containerSize;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            let this_id = data['deliveryPlanId'];
                            let this_status_change_url = status_change_url.replace(':id', data['deliveryPlanId']);
                            return `<div class=" text-break  text-info text-weight-bold">${data.deliveryPlanStatus.deliveryPlanStatus}` +
                                `<a href="javascript:" data-param="${this_id}" data-url="${this_status_change_url}"` +
                                `title="Change Status"` +
                                `class="load-popup status_change  text-break  text-info p-2 ">` +
                                `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                `</div>`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            let this_id = data['deliveryPlanId'];

                            let this_view_url = view_url.replace(':id', data['deliveryPlanId']);
                            let this_edit_url = edit_url.replace(':id', data['deliveryPlanId']);
                            let this_delete_url = delete_url.replace(':id', data['deliveryPlanId']);
                            let this_str =
                            ` <a href="${this_edit_url}"` +
                            ` title="{{ __('Map View') }}" `+
                                `class="   btn btn-rounded animated-shine px-2  ">` +
                                `<i class="fas fa-map"></i></a>` +
                                ` <a href="${this_view_url}"` +
                                `title="{{ __('View Full Plan') }}" class="view_plan  btn btn-rounded animated-shine ">` +
                                ` <i class="fa fa-desktop m-0 "></i></a>`;

                            this_str += ` <a href="${this_view_url}"` +
                                `title="{{ __('Delete') }}" class="delete  btn btn-rounded animated-shine-danger d-none   ">` +
                                `<i class="fa fa-trash m-0 "></i></a>`;

                            return this_str;
                        }
                    },


                ]

            });
            cb(start, end);

            function cb(start, end) {
                $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
                filter();

            }

            function filter() {
                $('#filter').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );

                // var office = $('#office').val();
                var isAdmin = $('#office').find(':selected').attr('data-isAdmin');

                var date = $('#reportrange').text();
                var dateArray = date.split(' - ');
                var startDate = dateArray[0];
                var endDate = dateArray[1];
                $.ajax({
                    url: "{{ route($routeRole . '.delivery_plan.delivery_filter') }}",
                    type: "POST",
                    data: {
                        fromDate: startDate,
                        toDate: endDate,
                        isAdmin: isAdmin,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (!response.starus) {
                            $('#filter').html("{{ __('Filter') }}");

                        }
                        //console.log(response);
                        delivery_plans = response.data.delivery_plans;
                        listTable.clear().rows.add(delivery_plans).draw();
                        setTimeout(() => {
                            $('#filter').html("{{ __('Filter') }}");
                        }, 500);

                    }
                });
                setTimeout(() => {
                    $('#filter').html("{{ __('Filter') }}");
                }, 500);
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    // 'Today': [moment(), moment()],
                    // 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Next 7 Days': [moment(), moment().add(6, 'days')],
                    'Next 30 Days': [moment(), moment().add(29, 'days')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);




            $('#filter').click(function() {
                // $('#section_graph1').html('');
                // $('#section_graph2').html('');
                filter()

            });
            // $('#reportrange').daterangechange(function() {
            //     filter()

            // });
            // $('#office').change(function() {

            //     filter()

            // });
            $('.search').click(function() {
                $('.reportPanel').html(
                    '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                );
            });

        });
    </script>
@endsection
