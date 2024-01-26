<div class="modal-dialog modal-xl  modal-dialog-top mt-4 ">
    <div class="modal-content bg-info position-relative">
        <div class="modal-header">
            <button type="button" class="back load-popup-back"
                data-param="{{ $deliveryPlanId ?? $deliveryPlan['deliveryPlanId'] }}" aria-label="Close">
                <i class="fas fa-arrow-circle-left" aria-hidden="true" style="font-size:24px; color:#fff"></i>
            </button>
            <h4 class="modal-title text-light">{{ __('Driver Assigning') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>
        <div class=" modal-body bg-light py-2">
            <div id="header_part" class="header_part row">

                @include('module.delivery_plan.driver_assigning.header_part')
            </div>
        </div>

        <div>
            <div class="modal-body bg-light p-0">
                <div id="dataTablePanel" class=" w-100  ">

                    <section class="content">
                        <div id="tablePanel" class="rounded card p-3 bg-white shadow min-h-100">
                            @include('module.delivery_plan.driver_assigning.datatable')
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div id="mapWrapperPanel" class=" d-none w-100 flex-column">

            @include('module.delivery_plan.map.index')

        </div>
        <div id="statWrapperPanel" class=" d-none w-100 flex-column">

            @include('module.delivery_plan.driver_assigning.stat')

        </div>
    </div>
    <div class="position-relative">
        <div class="modal-body bg-light d-none">
            <div class="row h5 text-info border-bottom border-info sr-only  ">
                <div class="col-md-8">
                    Driver Details
                </div>
                <div class="col-md-4">
                    Action
                </div>

            </div>

        </div>
    </div>

</div>
<style>
    .row-block {
        background-color: rgb(247, 248, 246);
        border: 2px solid rgb(115, 175, 81);
        color: rgb(175, 175, 175);
        padding: 5px 10px !important;
        border-radius: 20px;
        margin: 10px !important;
        box-shadow: 0 0 10px 5px #7777772d
    }

    .text-blue {
        color: #3759ee;
    }

    #statWrapperPanel {
        position: absolute;
        /* bottom: 0; */
        height: 100%;
        background: #ffffff;
        border-radius: 5px;
    }
</style>

</div>
<form id="formDriverAssign"
    action="{{ route('companyadmin.delivery_plan.assign_driver', $deliveryPlan['deliveryPlanId']) }}" method="post">
    @csrf

</form>
{{-- @include('module.delivery_plan.driver_assigning.css') --}}
@include('module.delivery_plan.driver_assigning.js')
{{-- @include('module.delivery_plan.status_change.js') --}}
@include('module.delivery_plan.map.css')

</div>
