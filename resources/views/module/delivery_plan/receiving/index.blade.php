<div class="modal-dialog modal-xl  modal-dialog-top mt-4 ">
    <div class="modal-content bg-info">
        @include('module.delivery_plan.receiving.top_header')

        <div class="modal-body bg-light py-2">
            <div id="header_part" class="header_part row">

                @include('module.delivery_plan.receiving.header_part')
            </div>

        </div>

        <div class="modal-body bg-light   p-0">
            <div class=" w-100 ">

                <section id="receiving" class="content">

                    @foreach ($deliveryPlan['deliveryPlanDetailsList'] as $key => $plan)
                        <div class="rounded card bg-white shadow min-h-100 px-3 pt-1">


                            <div class="row">
                                <div class=" col-md-4  ">
                                    <div class="form-group row">
                                        <label class="{{ $key > 0 ? 'sr-only-md ' : 'sr-md' }} col-3"
                                            for="plannedQuantity">{{ __('Pump') }}
                                        </label>
                                        <input type="text" size="10" class="form-control col-9  "
                                            value="{{ $plan['office']['officeName'] }}" readonly>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    {{-- {{ __('Quantity') }} ({{ __($plan['productUnit']['unitShortName']) }}) --}}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="{{ $key > 0 ? 'sr-only-md' : 'sr-md' }}"
                                                    for="approvedQuantity">{{ __('Order Qty') }}
                                                </label>
                                                <input type="text" size="10"
                                                    class="form-control border border-none  bg-transparent" disabled
                                                    value="{{ $plan['approvedQuantity'] }}">
                                                <input type="text" size="10" class="sr-only"
                                                    id="approvedQuantity" name="approvedQuantity[]"
                                                    value="{{ $plan['approvedQuantity'] }}">
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="{{ $key > 0 ? 'sr-only-md' : 'sr-md' }}"
                                                    for="deliveredQuantity{{ $plan['deliveryPlanDetailsId'] }}">{{ __('Delivered') }}
                                                </label>
                                                <input type="text" size="10"
                                                    class="form-control border border-none bg-transparent" disabled
                                                    id="deliveredQuantity{{ $plan['deliveryPlanDetailsId'] }}"
                                                    name="deliveredQuantity[]"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                    value="{{ $plan['deliveredQuantity'] == null ? '' : $plan['deliveredQuantity'] }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="{{ $key > 0 ? 'sr-only-md' : 'sr-md' }}"
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
                                        <label class="{{ $key > 0 ? 'sr-only-md' : 'sr-md' }}"
                                            for="approvedQuantity">{{ __('Status') }}
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

                </section>
            </div>
        </div>


        {{-- @dd($planDetails) --}}
    </div>
    <div class="rounded card p-3 bg-white min-h-100 fixed-bottom">

        <div class="card card-primary">


            <div class="card-body">


                <div class="row text-left">
                    <div class="col-12 d-flex">
                        <div>
                            <i class="fa fa-info-circle fa-3x text-info"></i>
                        </div>

                        <div style="font-size:1.0rem" class="mt-2 pl-2 mb-4 panel panel-info    text-info  ">
                            <div>Leave "{{ __('Receive Quantity') }}" empty to confirm
                                "Delivered Quantity"</div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('module.delivery_plan.receiving.css')
    @include('module.delivery_plan.receiving.js')
</div>
