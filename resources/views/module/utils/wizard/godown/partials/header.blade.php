<div class="row">
    <div class="col-md-6">
        @include('module.godown.godown_office')
    </div>
    <div class="col-md-6 text-right d-flex flex-row justify-content-end">

        <div id="addGodown" onclick="addGodown(wizardOfficeId)"
            class="   mb-2 text-info d-flex flex-column align-items-center btn bg-transparent cursor-none border-0
             {{ $active=='create'?'disabled':'' }} ">
            <i class="fa fa-plus fa-lg mx-2 "></i> <small class="small mt-2"> {{ __('Godown') }}</small>
        </div>
        <div id="godownList" onclick="loadWizardGodown(wizardOfficeId)"
            class="    mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link
             {{ $active=='list'?'disabled':'' }} ">
            <i class="fas fa-warehouse fa-lg  "></i> <small class="small mt-2"> {{ __('Godowns') }}</small>
        </div>
        <div id="allStock" onclick="getAllStock(wizardOfficeId);"
            class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link
             {{ $active=='stock'?'disabled':'' }}">
            <i class="fa fa-cubes fa-lg  "></i> <small class="small mt-2"> {{ __('All Stock') }}</small>

        </div>
    </div>
</div>
<style>
    .disabled {
    background-color: #dadcdd00 !important;
    background: linear-gradient(90deg, #dadcdd00 0%, #28597400 100%) !important;
    border-color: #a1a0a011 !important;
    color: #2e292957 !important;
    border-radius: 5px!important;
}
</style>
