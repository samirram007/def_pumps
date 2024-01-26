<div class="table-responsive">
    <table id="table" class="table table-striped table-bordered  table-hover dt-responsive display nowrap">
        <thead>
            <tr>
                <th data-visible="{{ $isTopAdmin }}">{{ __('SLNo') }}</th>
                <th>{{ __('Pump Name') }}</th>
                <th data-visible="{{ $isTopAdmin }}">{{ __('Admin') }}</th>
                <th title='{{ __('Delivery Date') }}'>{{ __('Del Date') }}</th>
                @if ($planDetails['deliveryPlanStatusId'] == 1)
                    <th title='{{ __('Suggested Quantity') }}'>{{ __('Sugg Qty') }}</th>
                    <th data-visible="false" title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>
                    <th data-visible="false" title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                @elseif($planDetails['deliveryPlanStatusId'] == 2)
                    <th title='{{ __('Suggested Quantity') }}'>{{ __('Sugg Qty') }}</th>
                    <th title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>
                    <th data-visible="false" title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                @elseif($planDetails['deliveryPlanStatusId'] == 3)
                    <th title='{{ __('Suggested Quantity') }}' data-visible="false">{{ __('Sugg Qty') }}</th>
                    <th title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>

                    <th data-visible="false" title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                @elseif($planDetails['deliveryPlanStatusId'] == 4)
                    <th title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>
                    <th title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                    <th title='{{ __('Received Quantity') }}'>{{ __('Rcvd Qty') }}</th>
                @elseif($planDetails['deliveryPlanStatusId'] == 5)
                    <th data-visible="false" title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>
                    <th title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                    <th title='{{ __('Received Quantity') }}'>{{ __('Rcvd Qty') }}</th>
                @elseif($planDetails['deliveryPlanStatusId'] == 6)
                    <th data-visible="false" title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>
                    <th title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                    <th title='{{ __('Received Quantity') }}'>{{ __('Rcvd Qty') }}</th>
                @endif
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>

        </thead>


    </table>
</div>
