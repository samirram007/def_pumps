<div class="modal-dialog modal-xl  modal-dialog-top mt-4 ">
    <div class="modal-content bg-info">
        @include('module.delivery_plan.receiving.top_header')

        <div class="modal-body bg-light py-2">
            <div id="header_part" class="header_part row">

                @include('module.delivery_plan.receiving.header_part')
            </div>

        </div>

        <div class="modal-body bg-light mt-2 p-0">
            <div class=" w-100 ">

                <section class="content">

                    @foreach ($deliveryPlan['deliveryPlanDetailsList'] as $key => $plan)
                        <div class="rounded card bg-white shadow min-h-100 px-3 pt-2">


                            <div class="row">
                                <div class=" col-md-4  ">
                                    <div class="form-group">
                                        <label for="plannedQuantity">{{ __('Pump') }}
                                        </label>
                                        <input type="text" size="10" class="form-control border border-success"
                                            value="{{ $plan['office']['officeName'] }}" readonly>

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
                                        <label for="approvedQuantity">{{ __('Status') }}
                                        </label>
                                        <input type="text" class="sr-only" name="deliveryPlanDetailsId[]"
                                            value="{{ $plan['deliveryPlanDetailsId'] }}">


                                        {{-- <button type="submit" class="submit btn btn-rounded animated-shine px-1">
                                                {{ __('Receive') }}</button> --}}
                                        <div>
                                            <a href="javascript:"
                                                data-delivery_plan_details_id="{{ $plan['deliveryPlanDetailsId'] }}"
                                                data-ordered-quantity="{{ $plan['approvedQuantity'] }}"
                                                data-delivered-quantity="{{ $plan['deliveredQuantity'] }}"
                                                data-received-quantity="{{ $plan['receivedQuantity'] }}"
                                                data-token="{{ @csrf_token() }}"
                                                class=" receive btn btn-rounded animated-shine px-1   {{ $plan['deliveredQuantity'] == null ? 'disabled' : '' }}">
                                                {{ __('Receive') }}</a>
                                        </div>


                                    </div>
                                </div>


                            </div>

                        </div>
                    @endforeach
                    <form id="formApprove" enctype="multipart/form-data">
                        @csrf
                    </form>
                    <div class="rounded card p-3 bg-white shadow min-h-100">

                        <div class="card card-primary">


                            <div class="card-body">
                                {{-- <div class="row text-center">
                                    <div class="col-12">
                                        <div style="font-size:1.25rem"
                                            class="mt-2 mb-4 panel panel-info w-100 bg-light rounded text-center text-info  ">
                                            Leave "{{ __('Receive Quantity') }}" empty to confirm
                                            "Delivered Quantity"</div>
                                    </div>
                                    <div class="col-12 mx-auto sr-only">
                                        <button type="submit" class="submit btn btn-rounded animated-shine px-4"><span
                                                class="iconify" data-icon="mdi:content-save-all-outline" data-width="15"
                                                data-height="15"></span>
                                            {{ __('UPDATE APPROVE STATUS') }}</button>

                                    </div>

                                </div> --}}

                                <div class="row text-left">
                                    <div class="col-12 d-flex">
                                        <div>
                                            <i class="fa fa-info-circle fa-3x text-info"></i>
                                        </div>

                                        <div style="font-size:1.0rem"
                                            class="mt-2 pl-2 mb-4 panel panel-info    text-info  ">
                                            <div>Leave "{{ __('Receive Quantity') }}" empty to confirm
                                                "Delivered Quantity"</div>
                                        </div>


                                    </div>

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
    @include('module.delivery_plan.receiving.css')
    @include('module.delivery_plan.receiving.js')
</div>
