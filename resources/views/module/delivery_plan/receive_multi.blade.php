<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Order Receiving') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <div class="modal-body bg-light">
            <div class="row">
                <div class="col-12 pb-2">
                    {{ __('Title') }}: <span
                        class="font-weight-bold">{{ $planDetails[0]['deliveryPlan']['planTitle'] }}</span>
                </div>
                <div class="col-md-6">

                    {{ __('Hub') }}: <span
                        class="font-weight-normal">{{ $planDetails[0]['startPoint']['hubName'] }}</span>
                </div>
                <div class="col-md-6 text-right-md">
                    {{ __('Plan Date') }}: <span
                        class="font-weight-normal">{{ date('d-M-Y', strtotime($planDetails[0]['deliveryPlan']['planDate'])) }}</span>
                </div>
                <div class="col-md-6 text-right-md">
                    {{ __('Product') }}: <span
                        class="font-weight-normal">{{ $planDetails[0]['product']['productTypeName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Delivery Date') }}: <span
                        class="font-weight-normal">{{ date('d-M-Y', strtotime($planDetails[0]['deliveryPlan']['expectedDeliveryDate'])) }}</span>
                </div>

                <div class="col-md-6">
                    @php
                        $status = '<span class="font-weight-bold text-gray">Waiting for approval</span>';
                        $status = '<span class="font-weight-bold text-gray">Waiting for approval</span>';
                        if ($planDetails[0]['deliveryPlan']['deliveryPlanStatusId'] == -1) {
                            $status = '<span class="font-weight-bold text-danger">Rejected</span>';
                        } elseif ($planDetails[0]['deliveryPlan']['deliveryPlanStatusId'] == 2) {
                            $status = '<span class="font-weight-bold text-success">Order Under Processing</span>';
                        } elseif ($planDetails[0]['deliveryPlan']['deliveryPlanStatusId'] == 3) {
                            $status = '<span class="font-weight-bold text-success">Delivery On The Way</span>';
                        } elseif ($planDetails[0]['deliveryPlan']['deliveryPlanStatusId'] == 4) {
                            $status = '<span class="font-weight-bold text-success">Complete</span>';
                        }
                    @endphp
                    {!! $status !!}
                </div>


            </div>
        </div>

        <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
            <div class=" w-100 ">

                <section class="content">

                    @foreach ($planDetails as $key => $plan)
                        <div class="rounded card bg-white shadow min-h-100 px-3 pt-2">


                            <div class="row">
                                <div class=" col-md-4  ">
                                    <div class="form-group">
                                        <label for="plannedQuantity">{{ __('Pump') }}
                                        </label>
                                        <input type="text" size="10" class="form-control border border-success"
                                            value="{{ $plan['officeName'] }}" readonly>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    {{-- {{ __('Quantity') }} ({{ __($plan['productUnit']['unitShortName']) }}) --}}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="approvedQuantity">{{ __('Order Qty') }}
                                                </label>
                                                <input type="text" size="10" class="form-control" disabled
                                                    value="{{ $plan['approvedQuantity'] }}">
                                                <input type="text" size="10" class="sr-only"
                                                    id="approvedQuantity" name="approvedQuantity[]"
                                                    value="{{ $plan['approvedQuantity'] }}">
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="deliveredQuantity{{ $plan['deliveryPlanDetailsId'] }}">{{ __('Delivered') }}
                                                </label>
                                                <input type="text" size="10" class="form-control" disabled
                                                    id="deliveredQuantity{{ $plan['deliveryPlanDetailsId'] }}"
                                                    name="deliveredQuantity[]"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                    value="{{ $plan['deliveredQuantity'] == null ? '' : $plan['deliveredQuantity'] }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="receivedQuantity{{ $plan['deliveryPlanDetailsId'] }}">{{ __('Receive') }}
                                                </label>
                                                <input type="text" size="10" class="form-control"
                                                    {{ $plan['deliveredQuantity'] == null ? 'disabled' : '' }}
                                                    id="receivedQuantity{{ $plan['deliveryPlanDetailsId'] }}"
                                                    name="receivedQuantity[]"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                    value="{{ $plan['receivedQuantity'] == null ? '' : $plan['receivedQuantity'] }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="sr-only" name="deliveryPlanDetailsId[]"
                                            value="{{ $plan['deliveryPlanDetailsId'] }}">

                                        <label for="approvedQuantity">{{ __('Status') }}
                                        </label>
                                        {{-- <button type="submit" class="submit btn btn-rounded animated-shine px-1">
                                                {{ __('Receive') }}</button> --}}
                                        <a href="javascript:"

                                            data-delivery_plan_details_id="{{ $plan['deliveryPlanDetailsId'] }}"
                                            data-ordered-quantity="{{ $plan['approvedQuantity'] }}"
                                            data-delivered-quantity="{{ $plan['deliveredQuantity'] }}"
                                            data-received-quantity="{{ $plan['receivedQuantity'] }}"
                                            data-token="{{ @csrf_token() }}"
                                            class=" receive btn btn-rounded animated-shine px-1   {{ $plan['deliveredQuantity'] == null ? 'disabled' : '' }}">
                                            {{ __('Receive') }}</a>
                                        {{-- <div class="switch-field">
                                                <input type="radio" class="approve"
                                                    id="radio-one{{ $plan['deliveryPlanDetailsId'] }}"
                                                    name="switch_one[][{{ $plan['deliveryPlanDetailsId'] }}]"
                                                    value="2" checked />
                                                <label
                                                    for="radio-one{{ $plan['deliveryPlanDetailsId'] }}">Approve</label>
                                                <input type="radio" class="reject"
                                                    id="radio-two{{ $plan['deliveryPlanDetailsId'] }}"
                                                    name="switch_one[][{{ $plan['deliveryPlanDetailsId'] }}]"
                                                    value="-1" />
                                                <label
                                                    for="radio-two{{ $plan['deliveryPlanDetailsId'] }}">Reject</label>
                                            </div> --}}
                                    </div>
                                </div>


                            </div>

                        </div>
                    @endforeach
                    <form id="formApprove" enctype="multipart/form-data"  >
                        @csrf
                    </form>
                    <div class="rounded card p-3 bg-white shadow min-h-100">

                        <div class="card card-primary">


                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <div style="font-size:0.8rem"
                                            class="mt-2 mb-4 panel panel-info w-100 bg-light rounded text-center text-info  ">
                                            Leave "{{ __('Receive Quantity') }}"" empty to confirm
                                            "Delivered Quantity"</div>
                                    </div>
                                    <div class="col-12 mx-auto sr-only">
                                        <button type="submit" class="submit btn btn-rounded animated-shine px-4"><span
                                                class="iconify" data-icon="mdi:content-save-all-outline"
                                                data-width="15" data-height="15"></span>
                                            {{ __('UPDATE APPROVE STATUS') }}</button>

                                    </div>

                                </div>

                            </div>
                        </div>

                </section>
            </div>
        </div>


        {{-- @dd($planDetails) --}}
    </div>
    <style>
        #formApprove .form-group>label {
            font-weight: normal !important;
        }
    </style>
    <script>
        $(document).ready(() => {
            $('.receive').on('click', function(event) {
                var deliveryPlanDetailsId = event.target.getAttribute('data-delivery_plan_details_id');
                var orderedQuantity = event.target.getAttribute('data-ordered-quantity');
                var deliveredQuantity = event.target.getAttribute('data-delivered-quantity');
                var receivedQuantity = event.target.getAttribute('data-received-quantity');
                var actualReceivedQuantity = $('#receivedQuantity'+deliveryPlanDetailsId).val();
console.log(actualReceivedQuantity,receivedQuantity);
                if(deliveredQuantity==0 || deliveredQuantity==''){
                    toastr.error("Delivery pending");
                    return false ;
                }
                if(actualReceivedQuantity>deliveredQuantity){
                    toastr.error("Receiving Quantity Overflow");
                    return false ;
                }
                else if(actualReceivedQuantity==''){
                    receivedQuantity=deliveredQuantity;
                }
                else{
                    receivedQuantity=actualReceivedQuantity;
                }

                //console.log(deliveryPlanDetailsId, orderedQuantity, deliveredQuantity, receivedQuantity);

                $(this).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
                );
                var formData  =new FormData($('#formApprove')[0])
                console.log(formData);
                formData.append('deliveryPlanDetailsId', deliveryPlanDetailsId);
                formData.append('orderedQuantity', orderedQuantity);
                formData.append('deliveredQuantity', deliveredQuantity) ;
                formData.append('receivedQuantity', receivedQuantity) ;
                formData.append('actualReceivedQuantity', actualReceivedQuantity) ;



                var submit_url = "{{ route('companyadmin.receive_delivery_from_multi') }}";
                $.ajax({
                    type: "POST",
                    url: submit_url,
                    data: formData,
                    processData: false, // don't process the data
                    contentType: false, // set content type to false as jQuery will tell the server its a query string request
                }).done(function(data) {
                    if (!data.status) {

                        $('.submit').attr('disabled', false);
                        $('.submit').html('Request a plan');
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
                            // $('#filter').click();
                            $("#modal-popup").html(data.html)

                            // window.location.reload();

                        }, 1000);
                        return;
                        // toggleRequestPanel();
                    }
                    $('.submit').attr('disabled', false);
                    $('.submit').html('Confirm');
                }).fail(function(data) {

                    $('.submit').attr('disabled', false);
                    $('.submit').html('Confirm');
                    toastr.error(data.message);

                    // console.log(data);
                });
                return;

                // {{ $plan['deliveryPlanDetailsId'] }}
            });
            // $('.submit').on('click', function(event) {


            //     $('.submit').html(
            //         '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            //     );
            //     $('.submit').attr('disabled', true);
            //     var submit_url =
            //         "{{ route($routeRole . '.delivery_plan_details.confirm_delivery', ':id') }}";
            //       var deliveryPlanDetailsId = {{ $planDetails[0]['deliveryPlanDetailsId'] }};
            //     // console.log(deliveryPlanDetailsId);
            //     submit_url = submit_url.replace(':id', deliveryPlanDetailsId);

            //     // console.log(submit_url);
            //     var formData = new FormData($(this)[0]);
            //     formData.append('deliveryGodownList', JSON.stringify(godownsArray));
            //     event.preventDefault();
            //     alert('l');
            //     console.log(formData);
            //     return;
            //     $.ajax({
            //         type: "POST",
            //         url: submit_url,
            //         data: formData,
            //         processData: false, // don't process the data
            //         contentType: false, // set content type to false as jQuery will tell the server its a query string request
            //     }).done(function(data) {
            //         if (!data.status) {

            //             $('.submit').attr('disabled', false);
            //             $('.submit').html('Request a plan');
            //             $.each(data.errors, function(key, value) {
            //                 $('#' + key).addClass('is-invalid');
            //                 $('#' + key).next().text(value);
            //                 toastr.error(value);
            //             });

            //         } else {
            //             // console.log(data.data);
            //             //  $('#reportPanel').html(data.html);
            //             toastr.success(data.message);
            //             setTimeout(() => {

            //                 // $('.submit').attr('disabled', false);
            //                 // $('.submit').html('Approve');
            //                 $('#filter').click();
            //                 $("#modal-popup .close").click()
            //                 // window.location.reload();

            //             }, 1000);
            //             return;
            //             // toggleRequestPanel();
            //         }
            //         $('.submit').attr('disabled', false);
            //         $('.submit').html('Confirm');
            //     }).fail(function(data) {

            //         $('.submit').attr('disabled', false);
            //         $('.submit').html('Confirm');
            //         toastr.error(data.message);

            //         // console.log(data);
            //     });
            // });
            setTimeout(() => {
                $('#receivedQuantity').focus();
            }, 500);





            $("#formApprove").on("submit", function(event) {
                event.preventDefault();


                $('.submit').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
                );
                $('.submit').attr('disabled', true);
                var submit_url =
                    "{{ route($routeRole . '.delivery_plan_details.confirm_requirement_multi', ':id') }}";

                // console.log(deliveryPlanDetailsId);


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
                        $('.submit').html('Request a plan');
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
                            if (document.getElementById('RequestPlan')) {
                                console.log('Available');
                                //init_loading();

                                $('#requestForm').submit();
                                //$('#RequestPlan').click();
                            } else if (document.getElementById('filter')) {
                                //console.log('Filter Ok');
                                $('#filter').click();
                            }



                            $("#modal-popup .close").click()
                            // window.location.reload();
                        }, 1000);
                        return;
                        // toggleRequestPanel();
                    }
                    $('.submit').attr('disabled', false);
                    $('.submit').html('Approve');
                }).fail(function(data) {

                    $('.submit').attr('disabled', false);
                    $('.submit').html('Approve');
                    toastr.error(data.message);

                    // console.log(data);
                });
            });

        });
    </script>
</div>
