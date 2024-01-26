<div class="col-lg-3 col-md-6">
    <div class="form-group">
        <label for="reportrange">{{ __('Period') }} : </label>
        <div id="reportrange" name="reportrange" class="pull-right form-control">
            <i class=" fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>

    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="form-group">
        <label for="productId">{{ __('Product') }} : </label>
        <select name="productId" id="productId" class="form-control">
            @foreach ($products as $product)
                <option value="{{ $product['productTypeId'] }}">
                    {{ __($product['productTypeName']) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="form-group">
        <label for="planStatusId">{{ __('Plan Status') }} : </label>
        <select name="planStatusId" id="planStatusId" class="form-control">
            <option value="">{{ __('all') }}</option>
            @foreach ($plan_statuses as $plan_status)
                <option value="{{ $plan_status['deliveryPlanStatusId'] }}">
                    {{ __($plan_status['deliveryPlanStatus']) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="col-md-3   d-flex align-items-center mt-2 ">
    <button class="btn btn-rounded animated-shine mt-2 " id="filter">{{ __('Filter') }}</button>
</div>
