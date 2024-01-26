<div class="modal-content bg-white text-secondary">
    <form id="formApprove" enctype="multipart/form-data">
        @csrf
        <div class="modal-content bg-light d-none">


            <div class=" modal-body bg-light py-2">
                <div id="header_part" class="header_part row">

                    @include('module.delivery_plan.approval.header_part')
                </div>
            </div>
        </div>

        <div class="modal-body bg-light p-0">
            <div class="  min-h-100 w-100 p-4  ">

                <section class="content">

                    @foreach ($deliveryPlan['deliveryPlanDetailsList'] as $key => $plan)
                        <div class="row">
                            <div class=" col-md-4  ">
                                <div class="form-group">
                                    <label for="plannedQuantity">{{ __('Pump') }}
                                    </label>
                                    <input type="text" size="10"
                                        class="form-control border border-success readonly" readonly
                                        value="{{ $plan['office']['officeName'] }}">

                                </div>

                            </div>
                            <div class="col-md-4">
                                {{-- {{ __('Quantity') }} ({{ __($plan['productUnit']['unitShortName']) }}) --}}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="plannedQuantity">{{ __('Suggested') }}
                                            </label>
                                            <input type="text" size="10"
                                                class="form-control border border-success" readonly
                                                value="{{ $plan['plannedQuantity'] }}">
                                            <input type="text" size="10" class="sr-only" id="plannedQuantity"
                                                name="plannedQuantity[]" value="{{ $plan['plannedQuantity'] }}">
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="approvedQuantity">{{ __('Order Qty') }}
                                            </label>
                                            <input type="text" id="approvedQuantityOrigial" class="sr-only"
                                                value="{{ $plan['approvedQuantity'] == null ? '' : $plan['approvedQuantity'] }}">
                                            <input type="text" size="10" class=" approvedQuantity form-control"
                                                id="approvedQuantity" name="approvedQuantity[]"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                value="{{ $plan['approvedQuantity'] == null ? $plan['plannedQuantity'] : $plan['approvedQuantity'] }}"
                                                {{ $plan['deliveryPlanDetailsStatusId'] == 3 ? 'readonly' : '' }}>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="sr-only" name="deliveryPlanDetailsId[]"
                                        value="{{ $plan['deliveryPlanDetailsId'] }}">

                                    <label for="deliveryPlanDetailsStatusId">{{ __('Status') }}
                                    </label>

                                    <div class="switch-field">

                                        <input type="radio" class="approve"
                                            id="radio-one{{ $plan['deliveryPlanDetailsId'] }}"
                                            name="switch_one[][{{ $plan['deliveryPlanDetailsId'] }}]" value="2"
                                            {{ !in_array($plan['deliveryPlanDetailsStatusId'], [3]) ? 'checked' : '' }} />
                                        <label for="radio-one{{ $plan['deliveryPlanDetailsId'] }}">Approve</label>
                                        <input type="radio" class="reject"
                                            id="radio-two{{ $plan['deliveryPlanDetailsId'] }}"
                                            name="switch_one[][{{ $plan['deliveryPlanDetailsId'] }}]" value="3"
                                            {{ $plan['deliveryPlanDetailsStatusId'] == 3 ? 'checked' : '' }} />
                                        <label for="radio-two{{ $plan['deliveryPlanDetailsId'] }}">Reject</label>
                                    </div>
                                </div>
                            </div>


                        </div>
                    @endforeach
                    <div class="row">
                        <div class="offset-md-4 col-md-4 offset-xs-2 col-xs-8">
                            <button type="submit" class="submit btn btn-rounded animated-shine px-4 w-100"><span
                                    class="iconify" data-icon="mdi:content-save-all-outline" data-width="15"
                                    data-height="15"></span>
                                {{ __('CONFIRM') }}</button>
                        </div>

                    </div>



                </section>
            </div>
        </div>

    </form>
    <div class="rounded   p-3 bg-white shadow min-h-100 fixed-bottom">

        @include('module.delivery_plan.approval.info')
    </div>
</div>

@include('module.delivery_plan.approval.css')
@include('module.delivery_plan.approval.js')
