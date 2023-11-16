<div class="modal-dialog modal-xl modal-dialog-top mt-4 position-relative ">
    <div class="modal-content bg-light">

        @include('module.delivery_plan.status_change.top_header')
        <div class=" modal-body bg-light py-2">
            <div id="header_part" class="header_part row">

                @include('module.delivery_plan.status_change.header_part')
            </div>
        </div>
    </div>

    <div class="position-relative">
        <div class="modal-body bg-light p-0">
            <div id="dataTablePanel" class=" w-100  ">

                <section class="content">
                    <div id="tablePanel" class="rounded card p-3 bg-white shadow min-h-100">
                        @include('module.delivery_plan.status_change.datatable')
                    </div>
                </section>
            </div>

            <div class="rounded card p-3 bg-white shadow min-h-100">
                @include('module.delivery_plan.status_change.info')

            </div>

        </div>
        @include('module.delivery_plan.status_change.receiving')
        <form id="FormSetStatus">
            @csrf
        </form>
        <form id="FormReceiving">
            @csrf
        </form>


        @include('module.delivery_plan.status_change.css')
        @include('module.delivery_plan.status_change.js')

    </div>
    <div id="mapWrapperPanel" class=" d-none w-100 flex-column">

        @include('module.delivery_plan.status_change.map')

    </div>
</div>
