<div class="col-md-6 left-col">

    <div>
        {{ __('Hub') }}: <span class="font-weight-bold">{{ $planDetails['startPoint']['hubName'] }}</span>
    </div>
    <div>
        {{ __('Product') }}: <span class="font-weight-bold">{{ $planDetails['product']['productTypeName'] }}</span>
    </div>
    <div>
        {{ __('No Of Delivery Point') }}: <span
            class="font-weight-bold">{{ count($planDetails['deliveryPlanDetailsList']) }}</span>
    </div>
    <div>

    </div>
</div>
<div class="col-md-6 right-col">
    <div>
        {{ __('Plan Date') }}: <span
            class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['planDate'])) }}</span>
    </div>
    <div>
        {{ __('Delivery Date') }}: <span
            class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['expectedDeliveryDate'])) }}</span>
    </div>
    <div>
        {{ __('Current Status') }}: <span class="text-info">
            {{ __($planDetails['deliveryPlanStatus']['deliveryPlanStatus']) }}</span>
    </div>


</div>
