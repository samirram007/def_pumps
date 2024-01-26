<div class="modal-dialog modal-xl modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __($title) }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <div class="modal-body bg-light py-2">
            <div class="row">

                <div class="col-md-6 left-col">
                    <div>
                        {{ __('Hub') }}: <span
                            class="font-weight-bold">{{ $planDetails['startPoint']['hubName'] }}</span>
                    </div>
                    <div>
                        {{ __('Product') }}: <span
                            class="font-weight-bold">{{ $planDetails['product']['productTypeName'] }}</span>
                    </div>
                    <div>
                        {{ __('No Of Delivery Point') }}: <span
                            class="font-weight-bold">{{ count($planDetails['deliveryPlanDetailsList']) }}</span>
                    </div>
                </div>
                <div class="col-md-6 right-col">
                    <div>
                        {{ __('Plan Date') }}: <span
                            class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['planDate'])) }}</span>
                    </div>
                    <div>
                        {{ __('Delivery Date') }}: <span
                            class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['planDate'])) }}</span>
                    </div>
                    <div>
                        {{ __('Current Status') }}: <span class="text-info">
                            {{ __($planDetails['deliveryPlanStatus']['deliveryPlanStatus']) }}</span>
                    </div>

                    <div>
                        @foreach ($deliveryPlanStatus as $key => $item)
                            @if ($item['deliveryPlanStatusId'] > $planDetails['deliveryPlanStatusId'])
                                @if ($planDetails['deliveryPlanStatusId'] < 3)
                                    Set status as <a href="#"
                                        class="set_complete btn btn-sm animated-shine btn-rounded">{{ $item['deliveryPlanStatus'] }}</a>
                                @endif
                            @break
                        @endif
                    @endforeach
                </div>
            </div>




        </div>

        @if ($planDetails['deliveryPlanStatusId'] < 3)
            <form id="FormSetStatusCancel" class="d-none" enctype="multipart/form-data">
                @csrf
                <input type="text" class="sr-only" name="deliveryPlanId"
                    value="{{ $planDetails['deliveryPlanId'] }}">
                <input type="text" class="sr-only" name="deliveryPlanStatusId" value="5">
                <button type="submit"
                    class=" submit cancel btn btn-rounded animated-shine-danger px-2  ">{{ __('Cancel this plan') }}</button>
            </form>
        @endif
    </div>
    <div>
        <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
            <div class=" w-100  ">

                <section class="content">
                    <div class="rounded card p-3 bg-white shadow min-h-100">
                        <div class="table-responsive">
                            <table id="table"
                                class="table table-striped table-bordered  table-hover dt-responsive display nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ __('SLNo') }}</th>
                                        <th>{{ __('Pump Name') }}</th>
                                        <th>{{ __('Admin') }}</th>
                                        <th>{{ __('Del Date') }}</th>
                                        @if ($planDetails['deliveryPlanStatusId'] == 1)
                                            <th>{{ __('Sugg Qty') }}</th>
                                            <th data-visible="false">{{ __('Ord Qty') }}</th>
                                        @elseif($planDetails['deliveryPlanStatusId'] == 2)
                                            <th>{{ __('Sugg Qty') }}</th>
                                            <th>{{ __('Ord Qty') }}</th>
                                        @elseif($planDetails['deliveryPlanStatusId'] == 3)
                                            <th>{{ __('Ord Qty') }}</th>
                                            <th data-visible="false">{{ __('Sugg Qty') }}</th>
                                        @elseif($planDetails['deliveryPlanStatusId'] == 4)
                                            <th>{{ __('Ord Qty') }}</th>
                                            <th>{{ __('Del Qty') }}</th>
                                        @elseif($planDetails['deliveryPlanStatusId'] == 5)
                                            <th>{{ __('Del Qty') }}</th>
                                            <th>{{ __('Rcvd Qty') }}</th>
                                        @elseif($planDetails['deliveryPlanStatusId'] == 6)
                                            <th>{{ __('Del Qty') }}</th>
                                            <th>{{ __('Rcvd Qty') }}</th>
                                        @endif
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>

                                </thead>


                            </table>
                        </div>
                        <div class="row p-0">
                            <div class="col-6 d-none">
                                <div class=" card-primary">
                                    <div class="status_panel ">
                                        <ul class="list-group list-group-flush">

                                            <li class="li_block list-group-item text-secondary">

                                                @php
                                                    $next = 0;
                                                @endphp
                                                {{-- @dump($planDetails) --}}
                                                @foreach ($deliveryPlanStatus as $key => $item)
                                                    @if ($item['deliveryPlanStatusId'] != 7)
                                                        @if ($item['deliveryPlanStatusId'] < $planDetails['deliveryPlanStatusId'])
                                                            <div class="row row-block">
                                                                <div class="text-center font-weight-bold   circle ">
                                                                    <i class="fa fa-check  done "></i>
                                                                </div>
                                                                <div class="  text-info ">
                                                                    <div> {{ __($item['deliveryPlanStatus']) }}
                                                                    </div>
                                                                    <attr class="small  text-gray "> completed
                                                                    </attr>
                                                                </div>
                                                            </div>
                                                        @elseif ($item['deliveryPlanStatusId'] == $planDetails['deliveryPlanStatusId'])
                                                            <div
                                                                class="{{ !in_array($item['deliveryPlanStatusId'], [3, 4]) ? 'set_complete' : '' }} row row-block">
                                                                <div class="text-center font-weight-bold   circle ">
                                                                    <i class="fa fa-check  current "></i>
                                                                </div>
                                                                <div class=" text-info text-left">
                                                                    <div class="">
                                                                        {{ __($item['deliveryPlanStatus']) }}</div>

                                                                    @if ($item['deliveryPlanStatusId'] == 3)
                                                                        <attr class="small  text-gray "> wait for
                                                                            driver to start the trip</attr>
                                                                    @elseif ($item['deliveryPlanStatusId'] == 4)
                                                                        <attr class="small  text-gray "> plan is
                                                                            close</attr>
                                                                    @else
                                                                        <attr class="small  text-gray "> tap here!
                                                                            to mark as completed</attr>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @elseif ($item['deliveryPlanStatusId'] == 7)
                                                            <div class="row row-block">
                                                                <div class="  d-flex align-items-center  ">
                                                                    {{ __($item['deliveryPlanStatus']) }}</div>

                                                                <div>
                                                                    <form id="FormSetStatusCancel"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="text" class="sr-only"
                                                                            name="deliveryPlanId"
                                                                            value="{{ $planDetails['deliveryPlanId'] }}">
                                                                        <input type="text" class="sr-only"
                                                                            name="deliveryPlanStatusId"
                                                                            value="{{ $item['deliveryPlanStatusId'] }}">
                                                                        <button type="submit"
                                                                            class=" submit w-100  btn btn-rounded animated-shine px-2  inline-block">{{ __('Set') }}</button>
                                                                    </form>
                                                                    @php
                                                                        $next++;
                                                                    @endphp
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="row row-block">
                                                                <div class="text-center font-weight-bold   circle ">
                                                                    <i class="fa fa-check  pending "></i>

                                                                </div>
                                                                <div class=" text-gray text-left  ">

                                                                    {{ __($item['deliveryPlanStatus']) }}
                                                                    @if ($next == 0)
                                                                        <div class="col-4 sr-only ">
                                                                            <form id="FormSetStatus"
                                                                                enctype="multipart/form-data">
                                                                                @csrf
                                                                                <input type="text"
                                                                                    class="sr-only"
                                                                                    name="deliveryPlanId"
                                                                                    value="{{ $planDetails['deliveryPlanId'] }}">
                                                                                <input type="text"
                                                                                    class="sr-only"
                                                                                    name="deliveryPlanStatusId"
                                                                                    value="{{ $item['deliveryPlanStatusId'] }}">
                                                                                <button type="submit"
                                                                                    class=" submit w-100  btn btn-rounded animated-shine px-2  inline-block">Set</button>
                                                                            </form>
                                                                            @php
                                                                                $next++;
                                                                            @endphp
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @endforeach

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 w-100">

                            </div>
                            <div class="col-12 d-none ">
                                <div class="item_header">List Of Pumps</div>
                                <div class="item_list ">

                                    @php
                                        $deliveryPlanDetails = $planDetails['deliveryPlanDetailsList'];
                                        // Custom comparison function to sort by "sequenceNo"
                                        function sortBySequenceNo($a, $b)
                                        {
                                            return $a['sequenceNo'] - $b['sequenceNo'];
                                        }
                                        // Sort the array by "sequenceNo"
                                        usort($deliveryPlanDetails, 'sortBySequenceNo');
                                    @endphp
                                    {{-- @dump($deliveryPlanDetails) --}}

                                    @foreach ($deliveryPlanDetails as $key => $item)
                                        <div class="row  ">
                                            <div class="text-center font-weight-bold   circle ">
                                                {{ __($item['sequenceNo']) }}
                                            </div>
                                            <div class="  text-info ">
                                                <div> {{ __($item['office']['officeName']) }}
                                                </div>
                                                <attr class="small  text-gray ">
                                                    {{ __('Delivery Date') . ': ' . date('d-m-Y h:i a', strtotime($item['expectedDeliveryTime'])) }}
                                                </attr>
                                                </attr>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    {{-- @dd($planDetails) --}}
</div>
<style>
    .status_panel * {
        margin: 0 !important;
        padding: 0 !important;
    }

    .set_complete {
        cursor: pointer;
    }

    .circle {
        height: 50px;
        width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #f4fcfa13;
        border-radius: 50%;
        font-size: 22px;
        margin-block: 5px;
        border: 2px solid #777;
        /* background-color: rgb(115, 175, 81); */

    }

    .row-block:has(.li_block) {
        display: flex;
        flex-flow: column nowrap;
        gap: 10px !important;
    }

    .row-block:has(.circle) {
        background-color: rgb(247, 248, 246);
        border: 2px solid rgb(115, 175, 81);
        color: rgb(115, 175, 81);
        padding: 5px 10px !important;
        border-radius: 20px;
        margin: 20px !important;
        box-shadow: 0 0 10px 5px #7777772d
    }

    .row-block:has(.pending) {
        background-color: rgb(247, 248, 246);
        border: 2px solid rgb(194, 194, 193);
        color: rgb(189, 190, 188);
        padding: 5px 10px !important;
        border-radius: 20px;
        margin: 20px !important;
        box-shadow: 0 0 10px 5px #7777772d
    }

    .row-block:has(.circle)::before {
        content: ' ';
    }


    .circle:has(.current) {
        background: linear-gradient(rgb(81, 124, 52), rgb(157, 207, 127));

        color: #e9f5ea;
        animation: bg_active 0.5s infinite ease-in-out;

    }

    @keyframes bg_active {
        0% {
            background: linear-gradient(rgb(98, 134, 75), rgb(177, 214, 155));
        }

        100% {
            background: linear-gradient(rgb(81, 124, 52), rgb(157, 207, 127));
        }
    }

    .circle:has(.done) {
        background-color: rgb(208, 238, 190);
        border: 2px solid rgb(115, 175, 81);
        color: rgb(115, 175, 81);
    }

    .circle:has(.pending) {
        background-color: rgb(231, 234, 236);
        border: 2px solid rgb(219, 219, 219);
        color: #aeafb1 !important;
    }

    .row-block>div:last-child {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        font-size: 18px;
        padding-left: 10px !important;

    }
</style>
<style scoped>
    .list-group-item {
        border-bottom: 3px solid #bdb7b73d !important;
    }

    .right-col {
        text-align: left;
    }

    @media (min-width: 992px) {
        .modal-xl {
            min-width: 1000px !important;

        }

        .right-col {
            text-align: right;
        }

    }



    .text-break {
        white-space: pre-wrap;
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
</style>
<script>
    $(document).ready(() => {
        setTimeout(() => {
            // $('#receivedQuantity').focus();
        }, 500);

    });

    function setStatus(deliveryPlanId, deliveryPlanStatusId) {

    }

    $('.set_complete').on('click', function() {
        $('#FormSetStatus').submit();
    })
    $("#FormSetStatus").on("submit", function(event) {
        event.preventDefault();


        $('.submit').html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
        );
        $('.submit').attr('disabled', true);
        var submit_url = "{{ route($routeRole . '.delivery_plan.update_status', ':id') }}";
        var deliveryPlanId = {{ $planDetails['deliveryPlanId'] }};
        submit_url = submit_url.replace(':id', deliveryPlanId);

        var formData = new FormData($(this)[0]);


        $.ajax({
            type: "POST",
            url: submit_url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            if (!data.status) {
                toastr.error(data.message);
                $('.submit').attr('disabled', false);
                $('.submit').html('Set');
                $.each(data.errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).next().text(value);
                    toastr.error(value);
                });

            } else {
                // console.log(data.data);
                //  $('#reportPanel').html(data.html);
                toastr.success(data.message);
                setTimeout(() => {

                    // $('.submit').attr('disabled', false);
                    // $('.submit').html('Approve');
                    $('#filter').click();
                    $("#modal-popup .close").click()
                    // window.location.reload();
                }, 1000);
                return;
                // toggleRequestPanel();
            }
            $('.submit').attr('disabled', false);
            $('.submit').html('Set');
        }).fail(function(data) {

            $('.submit').attr('disabled', false);
            $('.submit').html('Set');
            toastr.error(data.message);

            // console.log(data);
        });
    });
    $("#FormSetStatusCancel").on("submit", function(event) {
        event.preventDefault();
        // console.log(parseFloat($('#approvedQuantity').val()) ,$('#plannedQuantity').val());


        $('.cancel').html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
        );
        $('.cancel').attr('disabled', true);
        var submit_url = "{{ route($routeRole . '.delivery_plan.update_status', ':id') }}";
        var deliveryPlanId = {{ $planDetails['deliveryPlanId'] }};
        // console.log(deliveryPlanDetailsId);
        submit_url = submit_url.replace(':id', deliveryPlanId);

        // console.log(submit_url);
        var formData = new FormData($(this)[0]);


        $.ajax({
            type: "POST",
            url: submit_url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            if (!data.status) {

                $('.cancel').attr('disabled', false);
                $('.cancel').html('Set');
                $.each(data.errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).next().text(value);
                    toastr.error(value);
                });

            } else {
                // console.log(data.data);
                //  $('#reportPanel').html(data.html);
                toastr.success(data.message);
                setTimeout(() => {

                    // $('.submit').attr('disabled', false);
                    // $('.submit').html('Approve');
                    $('#filter').click();
                    $("#modal-popup .close").click()
                    // window.location.reload();
                }, 1000);
                return;
                // toggleRequestPanel();
            }
            $('.cancel').attr('disabled', false);
            $('.cancel').html('Cancel this plan');
        }).fail(function(data) {

            $('.cancel').attr('disabled', false);
            $('.submit').html('Cancel this plan');
            toastr.error(data.message);

            // console.log(data);
        });
    });

    var deliveryPlanDetails = @json($planDetails['deliveryPlanDetailsList']);
    var deliveryPlanStatusId = @json($planDetails['deliveryPlanStatusId']);
    // deliveryPlanDetails = deliveryPlanDetails.filter(item => item.deliveryPlanDetailsStatusId != 3);
    // let view_url = `{{ route($routeRole . '.delivery_plan.view', ':id') }}`;
    // let edit_url = `{{ route($routeRole . '.delivery_plan.edit', ':id') }}`;
    // let delete_url = `{{ route($routeRole . '.delivery_plan.delete', ':id') }}`;
    // let status_change_url = `{{ route($routeRole . '.delivery_plan.status_change', ':id') }}`;
    // let driver_url = `{{ route($routeRole . '.delivery_plan.driver', ':id') }}`;
    var start = moment().subtract(6, 'days');
    var end = moment();
    var listTable = $('#table').DataTable({
        responsive: true,
        select: false,
        paging: false,
        zeroRecords: true,
        processing: true,
        serverSide: false,
        fixedColumns: true,
        ordering: true,
        info: false,
        searching: false,
        "oLanguage": langOpt,
        data: deliveryPlanDetails,
        columns: [{
                "data": null,
                "render": function(data, type, full, meta) {
                    return data.sequenceNo
                }
            },
            {
                "data": null,
                "render": function(data, type, full, meta) {

                    return `<div class="overflow-hidden" title="${data.office['officeName']}">${data.office['officeName']}</div>`
                }
            },
            {
                "data": null,
                "render": function(data, type, full, meta) {

                    return `<div class="overflow-hidden" title="${data.admin['name']}">${data.admin['name']}</div>
                    <div class="text-info">${data.admin['phoneNumber']}</div>`
                }
            },
            {
                "data": null,
                "render": function(data, type, full, meta) {
                    const d = new Date(data.deliveredAt ?? data.expectedDeliveryTime);
                    return `<span class="sr-only">${ d}</span>` +
                        `${ moment(d).format('DD-MM-YYYY hh:mm a')}`;
                }
            },
            {
                "data": null,
                "render": function(data, type, full, meta) {
                    if (deliveryPlanStatusId == 1) {
                        return data.plannedQuantity
                    } else if (deliveryPlanStatusId == 2) {
                        return data.plannedQuantity
                    } else if (deliveryPlanStatusId == 3) {
                        return data.plannedQuantity
                    } else if (deliveryPlanStatusId == 4) {
                        return data.approvedQuantity
                    } else if (deliveryPlanStatusId == 5) {
                        return data.deliveredQuantity
                    } else if (deliveryPlanStatusId == 6) {
                        return data.deliveredQuantity
                    }
                }
            },
            {
                "data": null,
                "render": function(data, type, full, meta) {
                    if (deliveryPlanStatusId == 1) {
                        return data.approvedQuantity
                    } else if (deliveryPlanStatusId == 2) {
                        return data.approvedQuantity
                    } else if (deliveryPlanStatusId == 3) {
                        return data.approvedQuantity
                    } else if (deliveryPlanStatusId == 4) {
                        return data.deliveredQuantity
                    } else if (deliveryPlanStatusId == 5) {
                        return data.receivedQuantity
                    } else if (deliveryPlanStatusId == 6) {
                        return data.receivedQuantity
                    }

                }
            },
            {
                "data": null,
                "render": function(data, type, full, meta) {
                    return data.deliveryPlanDetailsStatus.deliveryPlanDetailsStatus
                }
            },
            {
                "data": null,
                "render": function(data, type, full, meta) {
                    var btn = ``
                    if (deliveryPlanStatusId == 2 && (data.approvedQuantity == 0 || data
                            .approvedQuantity == null)) {
                        btn = `<div class="btn btn-sm animated-shine">send intimaion</div>`
                    }
                    return `<div>${btn}</div>`;
                }
            },


        ],
        order: [
            [0, 'asc']
        ],

    });

    setTimeout(() => {
        listTable.draw();
        listTable.columns.adjust().responsive.recalc();

    }, 100);
</script>
</div>
