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
                            <th>{{ __('Plan Name') }}</th>
                            <th>{{ __('Planing Date') }}</th>
                            <th class="" data-visible="false">{{ __('Hub') }}</th>
                            <th class="" data-visible="false">{{ __('Product') }}</th>
                            <th class="text-center">{{ __('TankerSize') }}({{ __('ltr') }})</th>
                            <th>{{ __('Driver') }}</th>
                            <th>{{ __('NODP') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>

                    </thead>


                </table>
                <div class="row px-4">
                    <div>NODP: Number of Delivery Point</div>
                </div>
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

        #table td:nth-child(5),
        #table th:nth-child(5) {
            text-align: center;
        }

        #table td:nth-child(6),
        #table th:nth-child(6) {
            text-align: left;
        }

        .gap-10 {
            gap: 10px;
        }

        .fa-circle {
            border-radius: 50%;
            background-color: #9ca3a270;
            color: #0a705a;
            font-size: 100%;
        }

        .fa-circle:active {
            background-color: #464949d0;
            color: #d0ebe5;
            rotate: 45deg;
        }

        .fa-circle:hover {
            background-color: #3b6e6e91;
            color: #13332c;
            rotate: -135deg;
            transition: rotate 1s ease-in-out;
        }
    </style>
@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $('.search').click(function() {
                $('.reportPanel').html(
                    '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> {{ __('Please wait...') }}</div>'
                );
            });
            let delivery_plans = @json($delivery_plans);
            delivery_plans = delivery_plans.filter(item => item.deliveryPlanStatusId != 5);
            let view_url = `{{ route($routeRole . '.delivery_plan.view', ':id') }}`;
            let edit_url = `{{ route($routeRole . '.delivery_plan.edit', ':id') }}`;
            let delete_url = `{{ route($routeRole . '.delivery_plan.delete', ':id') }}`;
            let status_change_url = `{{ route($routeRole . '.delivery_plan.status_change', ':id') }}`;
            let driver_url = `{{ route($routeRole . '.delivery_plan.driver', ':id') }}`;
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
                            return data.planTitle.split("_").slice(-2).join('_')
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
                            return null;
                            // return data.startPoint.hubName;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return null;
                            // return data.product.productTypeName;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return `<div class=" text-break   text-secondary text-center text-weight-bold">${data.containerSize}</div>`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            // console.log(data.driver);
                            let this_id = data['deliveryPlanId'];
                            let this_driver_url = driver_url.replace(':id', data[
                                'deliveryPlanId']);
                            if (data.driver == null) {
                                return `<div class="  text-left   text-info text-weight-bold">
                                    <a href="javascript:"  data-param="${this_id}" data-url="${this_driver_url}"  title="{{ __('Assign Driver') }}" class="load-popup status_change    text-info p-2 ">Assign Driver</a>
                                </div>`;
                            } else {
                                return `<div class="   text-left   text-info text-weight-bold">
                                    <a href="javascript:"  data-param="${this_id}" data-url="${this_driver_url}"  title="{{ __('Chnage Driver') }}" class="load-popup status_change     text-info p-2 ">
                                        ${data.driver.driverName}<div class="pl-2 small text-gray">${data.driver.contactNumber}</div>
                                        </a>

                                </div>`;
                            }

                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            //console.log(data);
                            return `<div class="text-center">${data.deliveryPlanDetailsList.length}</div>`
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            let this_id = data['deliveryPlanId'];
                            let this_status_change_url = status_change_url.replace(':id', data[
                                'deliveryPlanId']);
                            let this_status = data.deliveryPlanStatus.deliveryPlanStatus;
                            // console.log(typeof(this_status));
                            // console.log(trans(this_status));
                            if (data['deliveryPlanStatusId'] == 5) {
                                var this_str = `<span class="text-danger">Cancelled</span><br/>`;
                                return this_str;
                            }
                            return `<div class="  text-info text-weight-bold text-left">
                                <a href="javascript:" data-param="${this_id}" data-url="${this_status_change_url}"
                                title="{{ __('Change Status') }}"
                                class="load-popup status_change     text-info p-2 ">
                                <i class="fas fa-pencil-alt fa-circle m-0 "></i>
                                ${this_status}</a>
                                </div>`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            let this_id = data['deliveryPlanId'];

                            let this_view_url = view_url.replace(':id', data['deliveryPlanId']);
                            let this_edit_url = edit_url.replace(':id', data['deliveryPlanId']);
                            let this_delete_url = delete_url.replace(':id', data['deliveryPlanId']);
                            let this_str = '';
                            if (data['deliveryPlanStatusId'] != 5) {
                                this_str += ` <a href="${this_edit_url}"` +
                                    ` title="{{ __('Edit Plan') }}" ` +
                                    `class="   btn btn-rounded  animated-shine px-2  ">` +
                                    `<i class="fas fa-pencil-alt"></i> {{ __('Edit') }} </a>`;
                            }

                            if (data['deliveryPlanStatusId'] < 4) {
                                this_str += ` <a href="${this_delete_url}"` +
                                    `title="{{ __('Delete') }}" class="delete  btn btn-rounded animated-shine-danger   ">` +
                                    `<i class="fa fa-trash m-0 "></i> {{ __('Cancel') }} </a>`;

                            }

                            return `<div class="d-flex justify-content-start gap-10">${this_str}</div>`;
                        }
                    },


                ],
                order: [
                    [2, 'desc']
                ],

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
                        delivery_plans = response.data.delivery_plans.filter(item => item
                            .deliveryPlanStatusId != 5);
                        // delivery_plans=delivery_plans.filter(item => item.deliveryPlanStatusId !=5);
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
@endpush
