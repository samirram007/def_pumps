<div class="modal-header">
    <button type="button" class="back load-popup-back  " data-param="{{ $planDetails['deliveryPlanId'] }}"
        aria-label="Back to List">
        <i class="fas fa-arrow-circle-left" aria-hidden="true" style="font-size:24px; color:#fff"></i>
    </button>

    <h4 class="modal-title text-light">{{ __($title) }}{{ $planDetails['deliveryPlan']['planTitle'] ?? '' }} </h4>


    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
    </button>
</div>
