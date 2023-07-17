<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Order Approval') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <div class="modal-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    {{ __('Pump') }}: <span class="font-weight-bold">{{ $planDetails['officeName'] }}</span>
                </div>
                <div class="col-md-6">

                    {{ __('Hub') }}: <span class="font-weight-bold">{{ $planDetails['startPoint']['hubName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Plan Date') }}: <span class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['deliveryPlan']['planDate'])) }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Delivery Date') }}: <span class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['deliveryPlan']['planDate'])) }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Product') }}: <span class="font-weight-bold">{{  $planDetails['product']['productTypeName'] }}</span>
                </div>
                <div class="col-md-6">
                    @php
                        $status='<span class="font-weight-bold text-gray">Waiting for approval</span>';
                        if($planDetails['approveStatus']==-1){
                            $status='<span class="font-weight-bold text-danger">Rejected</span>';
                        }
                        if($planDetails['approveStatus']==2){
                            $status='<span class="font-weight-bold text-success">Order Placed</span>';
                        }

                    @endphp
                    {{ __('Status') }}:  {!!   $status !!}
                </div>


            </div>
        </div>
        <form id="formApprove" enctype="multipart/form-data">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">


                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            for="plannedQuantity">{{ __('Suggested Quantity') }}({{ __($planDetails['productUnit']['unitShortName']) }})
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" size="10" class="form-control"  disabled
                                                             value="{{ $planDetails['plannedQuantity'] }}">
                                                        <input type="text" size="10" class="sr-only"
                                                            id="plannedQuantity" name="plannedQuantity"
                                                           value="{{ $planDetails['plannedQuantity'] }}">
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            for="approvedQuantity">{{ __('Order Quantity') }}({{ __($planDetails['productUnit']['unitShortName']) }})
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" size="10" class="form-control"
                                                            id="approvedQuantity" name="approvedQuantity"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                            value="{{ $planDetails['approvedQuantity'] == null ? '' : $planDetails['approvedQuantity'] }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div style="font-size:0.8rem" class="mt-2 mb-4 panel panel-info w-100 bg-light rounded text-center text-info  " > Leave "{{ __('Order Quantity') }}"" empty to confirm "Suggested Quantity"</div>
                                                </div>

                                            </div>

                                            <div class="row text-center">
                                                <div class="col-6 mx-auto">
                                                    <button type="submit"
                                                        class="submit btn btn-rounded animated-shine px-4"><span
                                                            class="iconify" data-icon="mdi:content-save-all-outline"
                                                            data-width="15" data-height="15"></span>
                                                        {{ __('Approve') }}</button>

                                                </div>
                                                <div class="col-6 mx-auto">
                                                    <button type="button"
                                                        class="reject btn btn-rounded animated-shine-danger px-4" >
                                                        <i class="fa fa-ban"></i>
                                                        {{ __('Reject') }}</button>
                                                </div>
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
    <script>
        $(document).ready(() => {
            setTimeout(() => {
                $('#approvedQuantity').focus();
            }, 500);

        });
        $('.reject').on("click",function(){
            $('.reject').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            $('.reject').attr('disabled', true);
            var rejecturl = "{{ route($routeRole . '.delivery_plan_details.reject', ':id') }}";
            var deliveryPlanDetailsId = {{ $planDetails['deliveryPlanDetailsId'] }};
            // console.log(deliveryPlanDetailsId);
            rejecturl = rejecturl.replace(':id', deliveryPlanDetailsId);
            $.ajax({
                type: "GET",
                url: rejecturl,

            }).done(function(data) {
                if (!data.status) {

                    $('.reject').attr('disabled', false);
                    $('.reject').html('Request a plan');
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });

                } else {
                    // console.log(data.data);
                  //  $('#reportPanel').html(data.html);
                  toastr.warning(data.message);
                    setTimeout(() => {

                        // $('.submit').attr('disabled', false);
                        // $('.submit').html('Approve');
                        // filter()
                        $('#filter').click();
                        $("#modal-popup .close").click()
                        //window.location.reload();
                    }, 1000);
                    return;
                   // toggleRequestPanel();
                }
                $('.reject').attr('disabled', false);
                $('.reject').html('Reject');
            }).fail(function(data) {

                $('.reject').attr('disabled', false);
                $('.reject').html('Reject');
                toastr.error(data.message);

                // console.log(data);
            });
        });

        $("#formApprove").on("submit", function(event) {
            event.preventDefault();
            // console.log(parseFloat($('#approvedQuantity').val()) ,$('#plannedQuantity').val());
            if (parseFloat($('#approvedQuantity').val()) > parseFloat($('#plannedQuantity').val())) {
                toastr.error("Maximum Qunatity exceed...");
                $('#approvedQuantity').focus();
                return;
            }

            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            $('.submit').attr('disabled', true);
            var submit_url = "{{ route($routeRole . '.delivery_plan_details.confirm_requirement', ':id') }}";
            var deliveryPlanDetailsId = {{ $planDetails['deliveryPlanDetailsId'] }};
            // console.log(deliveryPlanDetailsId);
            submit_url = submit_url.replace(':id', deliveryPlanDetailsId);

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
                        $('#filter').click();
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

    </script>
</div>
