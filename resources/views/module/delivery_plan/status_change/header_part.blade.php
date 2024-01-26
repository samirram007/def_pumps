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
        {{ __('Current Status') }}: <span class="text-info plan_status">
            {{ __($planDetails['deliveryPlanStatus']['deliveryPlanStatus']) }}</span>
    </div>

    <div>

        @if ($isTopAdmin)
            @if ($planDetails['deliveryPlanStatusId'] < 3)
                @foreach ($deliveryPlanStatus as $key => $item)
                    @if ($item['deliveryPlanStatusId'] > $planDetails['deliveryPlanStatusId'])
                        {{ __('Set status as') }}
                        <a href="javascript:" onclick="set_complete(this,{{ $item['deliveryPlanStatusId'] }})"
                            class="  btn btn-sm animated-shine btn-rounded">{{ $item['deliveryPlanStatus'] }}</a>
                    @break
                @endif
            @endforeach
        @endif

        @if (in_array($planDetails['deliveryPlanStatusId'], [3, 4, 5, 6]))

            @if ($planDetails['driver'] == null)
                <a href="javascript:" data-param="{{ $planDetails['deliveryPlanId'] }}"
                    data-url="{{ route($routeRole . '.delivery_plan.driver', $planDetails['deliveryPlanId']) }}"
                    title="{{ __('Assign Driver') }}"
                    class="load-popup  d-none btn btn-sm animated-shine btn-rounded   ">{{ __('Assign Driver') }}</a>
            @else
                <a href="javascript:" data-param="{{ $planDetails['deliveryPlanId'] }}"
                    data-url="{{ route($routeRole . '.delivery_plan.driver', $planDetails['deliveryPlanId']) }}"
                    title="{{ __('Assigned Driver') }}"
                    class="load-popup  d-none btn btn-sm animated-shine btn-rounded   "><i
                        class="fas fa-truck"></i></a>
            @endif
        @endif
    @endif

    <button class="btn btn-sm animated-shine d-none  text-light" onclick="getData(this)"
        title="{{ __('reload') }}">
        <i class="fa fa-refresh" aria-hidden="true"></i>
    </button>
    <button class="btn btn-sm animated-shine d-none  text-light  " onclick="getMap(this)"
        title="{{ __('map view') }}">
        <i class="fas fa-map " aria-hidden="true"></i>
    </button>
</div>
</div>
