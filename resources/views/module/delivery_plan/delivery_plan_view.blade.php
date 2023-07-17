@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark"> {{ __('Order Processing') }} </h4>
                        <ol class="breadcrumb float-sm-left border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.delivery_plan') }}"
                                    class="text-active">{{ __('Delivery plans ') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Order Processing') }}</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{-- <a href="{{ route($routeRole . '.delivery_plan.create') }}" title="{{ __('New Delivery Plan') }}"
                            class=" float-right btn btn-rounded animated-shine px-2 mb-2 ">
                            {{ __('New Delivery Plan') }}</a> --}}
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="card border border-primary p-3 py-0">


                <div class="card-content">
                    <div class="row">

                        @include('module.delivery_plan._partial.section_filter')

                    </div>

                </div>

            </div>
            <div class="reportPanel mt-3  ">
                <table id="tableDetails" class="table   table-striped table-bordered   ">
                    <thead>
                        <tr>
                            <th>Plan Title</th>
                            <th>Plan Date</th>
                            <th>Pump</th>
                            <th>Product</th>
                            <th class="text-center qty"> Suggested Qty.</th>
                            <th class="text-center qty"> Ordered Qty.</th>
                            <th class="text-center qty"> Received Qty.</th>
                            <th class="text-center">Status</th>
                        </tr>

                    </thead>

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

        #table td:first-child,
        #table th:first-child {
            text-align: center;
        }
        #tableDetails {
            width: 100% !important;
        }
        #table_wrapper.form-inline, #tableDetails_wrapper.form-inline, #table1_wrapper.form-inline, #table2_wrapper.form-inline {
    display: flex;
    flex-flow: column wrap;
    align-items: stretch;
}
        #tableDetails td:first-child {
            max-width: 30rem;
            font-weight:bold;
            font-size: 0.9rem;
            white-space: nowrap;
            text-overflow: ellipsis;
            word-break: break-all;
            overflow: hidden;
        }
        #tableDetails td:nth-child(2) {
            text-align: center;
        }
        @media screen and (max-width:480px){
            #tableDetails td:first-child {
            max-width: 20rem;
            font-size: 0.7rem;
            white-space: nowrap;
            text-overflow: ellipsis;
            word-break: break-all;
            overflow: hidden;
            padding-block: 0.5rem;
        }
        }
    </style>

    <script>
        let delivery_details = @json($delivery_details);
        //console.log(delivery_details);
        let approval_url = `{{ route($routeRole . '.delivery_plan_details.approve_requirement', ':id') }}`;
        let receive_url = `{{ route($routeRole . '.delivery_plan_details.receive_delivery', ':id') }}`;
        var start = moment().subtract(6, 'days');
        var end = moment();
        let isReady = false;
        let filterActive = false;
        $(function() {
            var listTable = $('#tableDetails').DataTable({
                responsive: true,
                select: false,
                paging: false,
                zeroRecords: true,
                searching: false,
                order: false,
                info: false,
                "oLanguage": langOpt,
                data: delivery_details,
                columns: [
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return data['deliveryPlan']['planTitle'];
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            const d = new Date(data['deliveryPlan']['planDate']);
                            return `<span class="sr-only">${ d}</span>` +
                                `${ moment(d).format('DD-MM-YYYY')}`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return `<span class="">${ data['office']['officeName']}</span>`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return `<span class="">${ data['product']['productTypeName']}</span>`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {

                            return ` <div class="d-flex align-items-center justify-content-center">` +
                                `<div>${ data['plannedQuantity'] } ${ data['productUnit']['unitShortName'] }</div>` +
                                `</div>`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            if (data['approveStatus'] == -1) {
                                return ` <div class="d-flex align-items-center justify-content-center">` +
                                    `<label style="color:red;">X</label>`;
                                `</div>`;
                            }
                            if (data['approvedQuantity'] == 0 || data['approvedQuantity'] == null) {
                                return ``;
                            }
                            return ` <div class="d-flex align-items-center justify-content-center">` +
                                `<div>${ data['approvedQuantity'] } ${ data['productUnit']['unitShortName'] }</div>` +
                                `</div>`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            if (data['approveStatus'] == -1) {
                                return ` <div class="d-flex align-items-center justify-content-center">` +
                                    `<label style="color:red;">X</label>`;
                                `</div>`;
                            }
                            if (data['receivedQuantity'] == 0 || data['receivedQuantity'] == null) {
                                return ` <div class="d-flex align-items-center justify-content-center">` +
                                    `<label style="color:green;">-</label>`;
                                `</div>`;
                            }
                            return ` <div class="d-flex align-items-center justify-content-center">` +
                                `<div>${ data['receivedQuantity'] } ${ data['productUnit']['unitShortName'] }</div>` +
                                `</div>`;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {

                            let this_id = data['deliveryPlanDetailsId'];
                            let this_approval_url = approval_url.replace(':id', this_id);
                            let this_receive_url = receive_url.replace(':id', this_id);
                            var this_status =
                            ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<a href="javascript:" ` +
                                        `class="load-popup edit-quantity    text-secondary p-2 font-weight-bolder " ` +
                                        `style="color:gray;" data-param="${this_id}" data-url="${this_approval_url}">` +
                                        `<label >Waiting for approval</label>` +
                                        `</a>` +
                                        `<a href="javascript:" data-param="${this_id}" data-url="${this_approval_url}"` +
                                        `title="Approve Requirement"` +
                                        `class="load-popup edit-quantity    text-info p-2 ">` +
                                        `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                        `</div>`;
                            if (data['approveStatus'] == -1) {
                                this_status =
                                    ` <div class="d-flex align-items-center justify-content-center">` +
                                    `<label style="color:red;">Rejected</label>`;
                                `</div>`;
                            }
                            if (data['deliveryPlan']['deliveryPlanStatusId'] == 1) {
                                if (data['approveStatus'] == -1) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<a href="javascript:" ` +
                                        `class="load-popup edit-quantity    text-success p-2 font-weight-bolder " ` +
                                        `data-param="${this_id}" data-url="${this_approval_url}">` +
                                        `<label style="color:red;">Rejected</label>` +
                                        `</a>`+`</div>`;
                                } else if (data['approveStatus'] == 2) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<a href="javascript:" ` +
                                        `class="load-popup edit-quantity    text-success p-2 font-weight-bolder " ` +
                                        `style="color:green;" data-param="${this_id}" data-url="${this_approval_url}">` +
                                        `<label >${data['approvedQuantity']} ${ data['productUnit']['unitShortName'] } Order Placed</label>` +
                                        `</a>` +
                                        `<a href="javascript:" data-param="${this_id}" data-url="${this_approval_url}"` +
                                        `title="Approve Requirement"` +
                                        `class="load-popup edit-quantity    text-info p-2 ">` +
                                        `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                        `</div>`;
                                } else if (data['approveStatus'] == 3) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<a href="javascript:" ` +
                                        `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                        `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                        `<label >${data['receivedQuantity']} ${ data['productUnit']['unitShortName'] } Received</label>` +
                                        `</a>` + `</div>`;
                                }
                            }
                            if (data['deliveryPlan']['deliveryPlanStatusId'] == 2) {
                                if (data['approveStatus'] == 2) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center text-break">` +
                                        `<lavel class="text-info font-weight-bold text-sm ">${ data['approvedQuantity'] } ${ data['productUnit']['unitShortName'] } Order Under Processing</lavel>` +
                                        `</div>`;
                                } else if (data['approveStatus'] == 3) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<a href="javascript:" ` +
                                        `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                        `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                        `<label >${data['receivedQuantity']} ${ data['productUnit']['unitShortName'] } Received</label>` +
                                        `</a>` +
                                        `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                        `title="Approve Requirement"` +
                                        `class="load-popup receive-quantity   text-info p-2 ">` +
                                        `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                        `</div>`;
                                }
                            } else if (data['deliveryPlan']['deliveryPlanStatusId'] == 3) {
                                if (data['approveStatus'] == 2) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<a href="javascript:" ` +
                                        `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                        `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                        `<label >${data['approvedQuantity']} ${ data['productUnit']['unitShortName'] } Delivery on the way</label>` +
                                        `</a>` +
                                        `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                        `title="Approve Requirement"` +
                                        `class="load-popup receive-quantity   text-info p-2 ">` +
                                        `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                        `</div>`;
                                } else if (data['approveStatus'] == 3) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<a href="javascript:" ` +
                                        `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                        `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                        `<label >${data['receivedQuantity']} ${ data['productUnit']['unitShortName'] } Received</label>` +
                                        `</a>` +
                                        `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                        `title="Approve Requirement"` +
                                        `class="load-popup receive-quantity  text-break  text-info p-2 ">` +
                                        `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                        `</div>`;
                                }
                            } else if (data['deliveryPlan']['deliveryPlanStatusId'] == 4) {
                                if (data['approveStatus'] == 2) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<a href="javascript:" ` +
                                        `class="load-popup receive-quantity  text-break  text-info p-2 font-weight-bolder " ` +
                                        `style="color:orange;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                        `<label >${data['approvedQuantity']} ${ data['productUnit']['unitShortName'] } Receiving Confirmation Pending</label>` +
                                        `</a>` +
                                        `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                        `title="Approve Requirement"` +
                                        `class="load-popup receive-quantity  text-break  text-info p-2 ">` +
                                        `<i class="fas fa-pencil-alt m-0 "></i></a>` +

                                        `</div>`;
                                } else if (data['approveStatus'] == 3) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center text-break">` +
                                        `<label >${data['receivedQuantity']} ${ data['productUnit']['unitShortName'] } Received</label>` +
                                        `</div>`;
                                }

                            } else if (data['deliveryPlan']['deliveryPlanStatusId'] == 5) {
                                this_status =
                                    `<label class="text-danger text-break">Order Cancelled By Admin</label> `;

                            }



                            return `${ this_status  }`;
                        }
                    }
                ]
            });
            cb(start, end);

            function cb(start, end) {
                $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
                filter();

            }

            function filter() {
                if (filterActive) {
                    toastr.warning("try after a moment");
                    return;
                }
                filterActive = true;

                $('#filter').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );

                var office = $('#office').val();
                var isAdmin = $('#office').find(':selected').attr('data-isAdmin');

                var date = $('#reportrange').text();
                var dateArray = date.split(' - ');
                var startDate = dateArray[0];
                var endDate = dateArray[1];
                // var deliveryPlanId=delivery_details[0].deliveryPlanId;
                //console.log(deliveryPlanId);
                $.ajax({
                    url: "{{ route($routeRole . '.delivery_plan_details.delivery_details_filter') }}",
                    type: "POST",
                    data: {
                        officeId: office,
                        fromDate: startDate,
                        toDate: endDate,
                        isAdmin: isAdmin,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (!response.starus) {
                            $('#filter').html("{{ __('Filter') }}");

                        }
                        delivery_details = response.data.delivery_details;
                        listTable.clear().rows.add(delivery_details).draw();
                        setTimeout(() => {
                            $('#filter').html("{{ __('Filter') }}");
                        }, 500);

                    }
                });
                setTimeout(() => {
                    $('#filter').html("{{ __('Filter') }}");
                    filterActive = false;
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
            $('#office').change(function() {

                filter()

            });
            $('.search').click(function() {
                $('.reportPanel').html(
                    '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                );
            });


            // `data-url="${approval_url}/${data['deliveryPlanDetailsId'] }"`+
            // console.log(approval_url);


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

        .form-group {
            padding: 0;
            margin: 10px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .form-group label {
            font-size: 0.875rem;
            line-height: 1.4rem;
            vertical-align: bottom;
            background: #fff;
            background: radial-gradient(circle, rgba(255, 255, 255, 1) 75%, rgb(255 255 255 / 0%) 100%);
            padding: 0 6px;
        }

        input+label {
            position: relative;
            z-index: 999;
        }

        select.form-control,
        select.asColorPicker-input,
        .dataTables_wrapper select,
        .jsgrid .jsgrid-table .jsgrid-filter-row select,
        .select2-container--default select.select2-selection--single,
        .select2-container--default .select2-selection--single select.select2-search__field,
        select.typeahead,
        select.tt-query,
        select.tt-hint,
        .form-control {
            padding: .4375rem .75rem;

            outline: none;
            color: #979292;
            border: 1px solid #cbd3db;
            overflow: hidden;
        }
    </style>
@endsection
