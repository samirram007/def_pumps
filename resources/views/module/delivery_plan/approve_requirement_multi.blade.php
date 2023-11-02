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
                <div class="col-12 pb-2">
                    {{ __('Title') }}: <span
                        class="font-weight-bold">{{ $planDetails[0]['deliveryPlan']['planTitle'] }}</span>
                </div>
                <div class="col-md-6">

                    {{ __('Hub') }}: <span
                        class="font-weight-bold">{{ $planDetails[0]['startPoint']['hubName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Plan Date') }}: <span
                        class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails[0]['deliveryPlan']['planDate'])) }}</span>
                </div>

                <div class="col-md-6">
                    {{ __('Product') }}: <span
                        class="font-weight-bold">{{ $planDetails[0]['product']['productTypeName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Delivery Date') }}: <span
                        class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails[0]['deliveryPlan']['expectedDeliveryDate'])) }}</span>
                </div>
                <div class="col-md-6">
                    @php
                        $status = '<span class="font-weight-bold text-gray">Waiting for approval</span>';
                        if ($planDetails[0]['deliveryPlan']['deliveryPlanStatusId'] == -1) {
                            $status = '<span class="font-weight-bold text-danger">Rejected</span>';
                        }
                        if ($planDetails[0]['deliveryPlan']['deliveryPlanStatusId'] == 2) {
                            $status = '<span class="font-weight-bold text-success">Order Under Processing</span>';
                        }
                    @endphp {!! $status !!}
                </div>


            </div>
        </div>
        <form id="formApprove" enctype="multipart/form-data">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">

                    <section class="content">

                        @foreach ($planDetails as $key => $plan)
                            <div class="rounded card bg-white shadow min-h-100 px-3">


                                <div class="row">
                                    <div class=" col-md-4  ">
                                        <div class="form-group">
                                            <label for="plannedQuantity">{{ __('Pump') }}
                                            </label>
                                            <input type="text" size="10"
                                                class="form-control border border-success"
                                                value="{{ $plan['officeName'] }}">

                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        {{-- {{ __('Quantity') }} ({{ __($plan['productUnit']['unitShortName']) }}) --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="plannedQuantity">{{ __('Suggested') }}
                                                    </label>
                                                    <input type="text" size="10" class="form-control" readonly
                                                        value="{{ $plan['plannedQuantity'] }}">
                                                    <input type="text" size="10" class="sr-only"
                                                        id="plannedQuantity" name="plannedQuantity[]"
                                                        value="{{ $plan['plannedQuantity'] }}">
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="approvedQuantity">{{ __('Order Qty') }}
                                                    </label>
                                                    <input type="text" id="approvedQuantityOrigial" class="sr-only"
                                                        value="{{ $plan['approvedQuantity'] == null ? '' : $plan['approvedQuantity'] }}">
                                                    <input type="text" size="10"
                                                        class=" approvedQuantity form-control" id="approvedQuantity"
                                                        name="approvedQuantity[]"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                        value="{{ $plan['approvedQuantity'] == null ? '' : $plan['approvedQuantity'] }}"
                                                        {{ $plan['approveStatus'] == -1 ? 'readonly' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="sr-only" name="deliveryPlanDetailsId[]"
                                                value="{{ $plan['deliveryPlanDetailsId'] }}">

                                            <label for="approveStatus">{{ __('Status') }}
                                            </label>

                                            <div class="switch-field">

                                                <input type="radio" class="approve"
                                                    id="radio-one{{ $plan['deliveryPlanDetailsId'] }}"
                                                    name="switch_one[][{{ $plan['deliveryPlanDetailsId'] }}]"
                                                    value="2"
                                                    {{ $plan['approveStatus'] == 2 ? 'checked' : '' }} />
                                                <label
                                                    for="radio-one{{ $plan['deliveryPlanDetailsId'] }}">Approve</label>
                                                <input type="radio" class="reject"
                                                    id="radio-two{{ $plan['deliveryPlanDetailsId'] }}"
                                                    name="switch_one[][{{ $plan['deliveryPlanDetailsId'] }}]"
                                                    value="-1"
                                                    {{ $plan['approveStatus'] == -1 ? 'checked' : '' }} />
                                                <label
                                                    for="radio-two{{ $plan['deliveryPlanDetailsId'] }}">Reject</label>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        @endforeach

                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="card card-primary">


                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <div style="font-size:0.8rem"
                                                class="mt-2 mb-4 panel panel-info w-100 bg-light rounded text-center text-info  ">
                                                Leave "{{ __('Order Quantity') }}"" empty to confirm
                                                "Suggested Quantity"</div>
                                        </div>
                                        <div class="col-12 mx-auto">
                                            <button type="submit"
                                                class="submit btn btn-rounded animated-shine px-4"><span class="iconify"
                                                    data-icon="mdi:content-save-all-outline" data-width="15"
                                                    data-height="15"></span>
                                                {{ __('UPDATE APPROVE STATUS') }}</button>

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
    <style>
        .switch-field {
            display: flex;
            margin-bottom: 36px;
            overflow: hidden;
        }

        .switch-field input {
            position: absolute !important;
            clip: rect(0, 0, 0, 0);
            height: 1px;
            width: 1px;
            border: 0;
            overflow: hidden;
        }

        .switch-field label {
            background-color: #e4e4e4;
            color: rgba(0, 0, 0, 0.6);
            font-size: 14px;
            line-height: 1;
            text-align: center;
            padding: 8px 16px;
            margin-right: -1px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
            transition: all 0.1s ease-in-out;
        }

        .switch-field label:hover {
            cursor: pointer;
        }

        .switch-field .approve:checked+label {
            background-color: #a5dc86;
            box-shadow: none;
        }

        .switch-field .reject:checked+label {
            background-color: #fc7ea4;
            box-shadow: none;
        }

        .switch-field label:first-of-type {
            border-radius: 4px 0 0 4px;
        }

        .switch-field label:last-of-type {
            border-radius: 0 4px 4px 0;
        }

        #formApprove .form-group>label {
            font-weight: normal !important;
        }
    </style>
    <script>
        $(document).ready(() => {
            setTimeout(() => {
                $('#approvedQuantity').focus();
            }, 500);

            $('.switch-field').on('click', function(e) {
                var $this = $(this);
                //  console.log(e.target.getAttribute('value'));
                if ($this.find(".approve").is(":checked")) {
                    // console.log(2);
                    $this.parent().parent().parent().find('#approvedQuantity').prop("readonly", false)
                    var originalValue = $this.parent().parent().parent().find('#approvedQuantityOrigial')
                        .val()
                    $this.parent().parent().parent().find('#approvedQuantity').val(originalValue)
                } else {
                    //console.log(-1);
                    $this.parent().parent().parent().find('#approvedQuantity').prop("readonly", true)
                    $this.parent().parent().parent().find('#approvedQuantity').val('0')
                    //  console.log();
                    // console.log(e.target.parentNode.parentNode.parentNode.parentNode.find('#approvedQuantity'))
                }
            });




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
