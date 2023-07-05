<div class="col-lg-4 col-md-6">
    <div class="form-group">
        <label for="deliveryPlanId">{{ __('Delivery Plan') }} :</label>
        <div>
            <select name="deliveryPlanId" id="deliveryPlanId" class="form-control">

                @if ($delivery_plans != null)




                    <option value="{{ $delivery_plans[0]['deliveryPlanId'] }}" data-isRetail="-1" data-isAdmin="1"
                        class="">{{ __('All Delivery Plan') }}</option>



                    @forelse ($delivery_plans as $key => $delivery_plan)

                            <option value="{{ $delivery_plan['deliveryPlanId'] }}" data-isRetail="0" data-isAdmin="0"
                                class="optionChild">
                                {{ __($delivery_plan['planTitle']) }}</option>

                    @empty
                        <option value="0" data-isRetail="-1" data-isAdmin="1" class="optionGroup">
                            {{ __('No Pump Found') }}</option>
                    @endforelse


                @endif

            </select>
        </div>




    </div>
</div>
<div class="col-lg-2 col-md-3">
    <div class="form-group">
        <label for="office">{{ __('Office') }} :</label>
        <div>
            <select name="office" id="office" class="form-control">
                @if ($officeList != null)




                    <option value="{{ $officeList[0]['masterOfficeId'] }}" data-isRetail="-1" data-isAdmin="1"
                        class="">{{ __('All Pumps') }}</option>


                    {{-- Retail --}}
                    @forelse ($officeList as $key => $office)
                        @if ($office['officeTypeId'] == 3 || $office['officeTypeId'] == 2)
                            <option value="{{ $office['officeId'] }}" data-isRetail="0" data-isAdmin="0"
                                class="optionChild">
                                {{ __($office['officeName']) }}</option>
                        @endif
                    @empty
                        <option value="0" data-isRetail="-1" data-isAdmin="1" class="optionGroup">
                            {{ __('No Pump Found') }}</option>
                    @endforelse


                @endif

            </select>
        </div>




    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="form-group">
        <label for="reportrange">{{ __('Period') }} : </label>
        <div id="reportrange" name="reportrange" class="pull-right form-control">
            <i class=" fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>

    </div>
</div>
<div class=" col-lg-3 col-md-3   d-flex align-items-center mt-4 ">
    <button class="btn btn-rounded animated-shine mt-2 " id="filter">{{ __('Filter') }}</button>
</div>
