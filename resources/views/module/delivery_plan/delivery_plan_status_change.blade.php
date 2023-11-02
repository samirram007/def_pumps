<div class="modal-dialog modal-lg modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Change Status') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <div class="modal-body bg-light">
            <div class="row">

                <div class="col-md-6">

                    {{ __('Hub') }}: <span
                        class="font-weight-bold">{{ $planDetails['startPoint']['hubName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Plan Date') }}: <span
                        class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['planDate'])) }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Product') }}: <span
                        class="font-weight-bold">{{ $planDetails['product']['productTypeName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Delivery Date') }}: <span
                        class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['planDate'])) }}</span>
                </div>

                <div class="col-md-6">
                    {{ __('No Of Delivery Point') }}: <span
                        class="font-weight-bold">{{ count($planDetails['deliveryPlanDetailsList']) }}</span>
                </div>

                <div class="col-md-6">

                    {{ __('Status') }}: <span class="text-info">
                        {{ __($planDetails['deliveryPlanStatus']['deliveryPlanStatus']) }}</span>
                </div>
                {{-- @dd($planDetails['product']) --}}

            </div>
            {{-- {{ $planDetails['deliveryPlanStatusId'] }} --}}
            @if ($planDetails['deliveryPlanStatusId'] < 4)
                <form id="FormSetStatusCancel" enctype="multipart/form-data">
                    @csrf
                    <input type="text" class="sr-only" name="deliveryPlanId"
                        value="{{ $planDetails['deliveryPlanId'] }}">
                    <input type="text" class="sr-only" name="deliveryPlanStatusId" value="5">
                    <button type="submit"
                        class=" submit btn btn-rounded animated-shine-danger px-2  ">{{ __('Cancel this plan') }}</button>
                </form>
            @endif
        </div>
        <div>
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class=" card-primary">

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
                                                background-color: rgb(115, 175, 81);

                                                color: #e9f5ea;

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
                                        <div class="status_panel ">
                                            <ul class="list-group list-group-flush">

                                                <li class="li_block list-group-item text-secondary">

                                                    @php
                                                        $next = 0;
                                                    @endphp
                                                    @foreach ($deliveryPlanStatus as $key => $item)
                                                        @if ($item['deliveryPlanStatusId'] != 5)
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
                                                                    class="{{ !in_array($item['deliveryPlanStatusId'], [2, 4]) ? 'set_complete' : '' }} row row-block">
                                                                    <div class="text-center font-weight-bold   circle ">
                                                                        <i class="fa fa-check  current "></i>
                                                                    </div>
                                                                    <div class=" text-info text-left">
                                                                        <div class="">
                                                                            {{ __($item['deliveryPlanStatus']) }}</div>

                                                                        @if ($item['deliveryPlanStatusId'] == 2)
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
                                                            @elseif ($item['deliveryPlanStatusId'] == 5)
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
                                        </div>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </section>
            </div>
        </div>

        </form>
        {{-- @dd($planDetails) --}}
    </div>
    <style scoped>
        .list-group-item {
            border-bottom: 3px solid #bdb7b73d !important;
        }
    </style>
    <script>
        $(document).ready(() => {
            setTimeout(() => {
                // $('#receivedQuantity').focus();
            }, 500);

        });

        function setStatus(deliveryPlanId, deliveryPlanStatusId) {

        }
        // $('.reject').on("click",function(){
        //     $('.reject').html(
        //         '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
        //     );
        //     $('.reject').attr('disabled', true);
        //     var rejecturl = "{{ route($routeRole . '.delivery_plan_details.reject', ':id') }}";
        //     var deliveryPlanDetailsId = {{ $planDetails['deliveryPlanId'] }};
        //     // console.log(deliveryPlanDetailsId);
        //     rejecturl = rejecturl.replace(':id', deliveryPlanDetailsId);
        //     $.ajax({
        //         type: "GET",
        //         url: rejecturl,

        //     }).done(function(data) {
        //         if (!data.status) {

        //             $('.reject').attr('disabled', false);
        //             $('.reject').html('Request a plan');
        //             $.each(data.errors, function(key, value) {
        //                 $('#' + key).addClass('is-invalid');
        //                 $('#' + key).next().text(value);
        //                 toastr.error(value);
        //             });

        //         } else {
        //             // console.log(data.data);
        //           //  $('#reportPanel').html(data.html);
        //           toastr.warning(data.message);
        //             setTimeout(() => {

        //                 // $('.submit').attr('disabled', false);
        //                 // $('.submit').html('Approve');
        //                 // filter()
        //                 $('#filter').click();
        //                 $("#modal-popup .close").click()
        //                 //window.location.reload();
        //             }, 1000);
        //             return;
        //            // toggleRequestPanel();
        //         }
        //         $('.reject').attr('disabled', false);
        //         $('.reject').html('Reject');
        //     }).fail(function(data) {

        //         $('.reject').attr('disabled', false);
        //         $('.reject').html('Reject');
        //         toastr.error(data.message);

        //         // console.log(data);
        //     });
        // });
        $('.set_complete').on('click', function() {
            $('#FormSetStatus').submit();
        })
        $("#FormSetStatus").on("submit", function(event) {
            event.preventDefault();
            // console.log(parseFloat($('#approvedQuantity').val()) ,$('#plannedQuantity').val());


            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            $('.submit').attr('disabled', true);
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


            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            $('.submit').attr('disabled', true);
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
    </script>
</div>
