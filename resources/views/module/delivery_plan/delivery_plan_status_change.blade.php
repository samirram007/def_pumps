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
                        class="font-weight-bold">{{ $planDetails['startPoint']['cityName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Plan Date') }}: <span
                        class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['planDate'])) }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Delivery Date') }}: <span
                        class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['planDate'])) }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Product') }}: <span
                        class="font-weight-bold">{{ $planDetails['product']['productTypeName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('No Of Delivery Point') }}: <span
                        class="font-weight-bold">{{ count($planDetails['deliveryPlanDetailsList']) }}</span>
                </div>

                <div class="col-md-6">

                    {{ __('Status') }}: <span class="text-info">
                        {{ $planDetails['deliveryPlanStatus']['deliveryPlanStatus'] }}</span>
                </div>
                {{-- @dd($planDetails['product']) --}}

            </div>
        </div>
        <div>
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">


                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                @php
                                                    $next = 0;
                                                @endphp
                                                @foreach ($deliveryPlanStatus as $key => $item)
                                                    @if ($item['deliveryPlanStatusId'] < $planDetails['deliveryPlanStatusId'])
                                                        <li class="list-group-item text-secondary">
                                                            {{ $item['deliveryPlanStatus'] }}</li>
                                                    @elseif ($item['deliveryPlanStatusId'] == $planDetails['deliveryPlanStatusId'])
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-8  text-info">
                                                                    {{ $item['deliveryPlanStatus'] }} </div>
                                                                <div
                                                                    class=" col-4 text-info text-center font-weight-bold">
                                                                    Current Status</div>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li class="list-group-item alert-success">
                                                            <div class="row">
                                                                <div class="col-8 d-flex align-items-center  ">
                                                                    {{ $item['deliveryPlanStatus'] }}</div>
                                                                @if ($next == 0)
                                                                    <div class="col-4 ">
                                                                        <form id="FormSetStatus"
                                                                            enctype="multipart/form-data">
                                                                            @csrf
                                                                            <input type="text" class="sr-only"
                                                                                name="deliveryPlanId"
                                                                                value="{{ $planDetails['deliveryPlanId'] }}">
                                                                            <input type="text" class="sr-only"
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

                                                        </li>
                                                    @endif
                                                @endforeach
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
        </script>
    </div>
