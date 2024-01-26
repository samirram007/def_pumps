<div class="row w-100">
    <div class="col-md-6 left-col">
        <div>
            {{ __('Pump') }}: <span class="font-weight-bold">{{ $planDetails['officeName'] }}</span>
        </div>
        <div class="d-none">

            {{ __('Hub') }}: <span class="font-weight-bold">{{ $planDetails['startPoint']['hubName'] }}</span>
        </div>
        <div class="d-none">
            {{ __('Product') }}: <span class="font-weight-bold">
                {{ $planDetails['product']['productTypeName'] }}</span>
        </div>
        <div>
            @if ($planDetails['deliveryPlanDetailsStatusId'] == 5)
                {{ __('Received Quantity') }}: <span class="font-weight-bold"
                    id="receivedQty">{{ $planDetails['receivedQuantity'] }}</span>
            @else
                @if ($planDetails['deliveredQuantity'] > 0)
                    {{ __('Receiving Quantity') }}: <span class="font-weight-bold"
                        id="receivedQty">{{ $planDetails['deliveredQuantity'] }}</span>
                @else
                    {{ __('Receiving Quantity') }}: <span class="font-weight-bold"
                        id="receivedQty">{{ $planDetails['approvedQuantity'] }}</span>
                @endif
            @endif
        </div>
        <div>
            {{-- {{ $planDetails['approveStatus'] }} --}}
            @if ($planDetails['deliveryPlanDetailsStatusId'] == 5)
                {{ __('Remaining Quantity') }}: <span class="font-weight-bold" id="remainingQty">0</span>
                <span class="sr-only" id="distributedQty">{{ $planDetails['receivedQuantity'] }}</span>
            @else
                @if ($planDetails['deliveredQuantity'] > 0)
                    {{ __('Remaining Quantity') }}: <span class="font-weight-bold"
                        id="remainingQty">{{ $planDetails['deliveredQuantity'] }}</span>
                @else
                    {{ __('Remaining Quantity') }}: <span class="font-weight-bold"
                        id="remainingQty">{{ $planDetails['approvedQuantity'] }}</span>
                @endif
                <span class="sr-only" id="distributedQty">0</span>
            @endif

        </div>
    </div>
    <div class="col-md-6 right-col pr-0">
        <div class="d-none">
            {{ __('Plan Date') }}: <span class="font-weight-bold">
                {{ date('d-M-Y', strtotime($planDetails['deliveryPlan']['planDate'])) }}</span>
        </div>


        <div class="d-none">
            @if ($planDetails['deliveredQuantity'] > 0)
                {{ __('Delivery Date') }}: <span class="font-weight-bold">
                    {{ date('d-M-Y H:i:s', strtotime($planDetails['deliveredAt'])) }}</span>
            @else
                {{ __('Delivery Date') }}: <span
                    class="font-weight-bold">{{ date('d-M-Y H:i:s', strtotime($planDetails['expectedDeliveryTime'])) }}</span>
            @endif
        </div>
        <div class="d-none">
            @php
                $status = '<span class="font-weight-bold text-gray plan_status">Receive Confirmation Pending</span>';
                if ($planDetails['deliveryPlanDetailsStatusId'] == 3) {
                    $status = '<span class="font-weight-bold text-danger plan_status">Rejected</span>';
                } elseif ($planDetails['deliveryPlanDetailsStatusId'] == 2) {
                    if ($planDetails['deliveryPlan']['deliveryPlanStatusId'] == 2) {
                        $status = '<span class="font-weight-bold text-success plan_status">Order Placed</span>';
                    } elseif ($planDetails['deliveryPlan']['deliveryPlanStatusId'] == 3) {
                        if ($planDetails['deliveredQuantity'] > 0) {
                            $status = '<span class="font-weight-bold text-success plan_status">Delivered</span>';
                        } else {
                            $status = '<span class="font-weight-bold text-success plan_status">Delivery On The Way</span>';
                        }
                    }
                } elseif ($planDetails['deliveryPlanDetailsStatusId'] == 5) {
                    $status = '<span class="font-weight-bold text-success plan_status">Received</span>';
                }

            @endphp
            {{ __('Status') }}: {!! $status !!}
        </div>
    </div>
</div>








</div>
