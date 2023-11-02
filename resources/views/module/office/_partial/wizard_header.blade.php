@if (isset($office))
    <div class="text-sm small">
        <div> {{ __('Office') }} : {{ $office['officeName'] }}

            <a href="javascript:" data-param="" data-url="{{ route('companyadmin.office.edit', $office['officeId']) }}"
                title="{{ __('Edit') }}" class="load-popup   mx-2 text-info  ">
                <i class="fa fa-edit"></i>
            </a>
        </div>
        <div> {{ $office['officeAddress'] != '' ? 'Address' . ' : ' . $office['officeAddress'] : '' }}</div>
    </div>
@endif
<div class=" text-right d-flex flex-row justify-content-end bg-light">
    <div id="addGodown" class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-users fa-lg mx-2 "></i> <small class="small mt-2"> {{ __('Office') }}</small>
    </div>
    <div id="addGodown" class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-users fa-lg mx-2 "></i> <small class="small mt-2"> {{ __('User') }}</small>
    </div>
    {{-- <div id="addGodown" class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-plus fa-lg mx-2 "></i> <small class="small mt-2"> {{ __('Add Godown') }}</small>
    </div> --}}
    <div id="backToList" onclick=" backToList();"
        class="    mb-2 text-info d-flex flex-column align-items-center btn  bg-transparent cursor-none border-0 {{ $disabled }} ">
        <i class="fas fa-warehouse fa-lg  "></i> <small class="small mt-2"> {{ __('Godowns') }}</small>
    </div>
    <div id="allStock" onclick="  getAllStock();"
        class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-cubes fa-lg  "></i> <small class="small mt-2"> {{ __('Stock') }}</small>

    </div>
    <div id="allStock" onclick="  getAllStock();"
        class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-cubes fa-lg  "></i> <small class="small mt-2"> {{ __('Product Rate') }}</small>

    </div>
    <div id="allStock" onclick="  getAllStock();"
        class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-cubes fa-lg  "></i> <small class="small mt-2"> {{ __('Invoice No') }}</small>

    </div>

</div>

<style>
    .disabled {
    background-color: #dadcdd00 !important;
    background: linear-gradient(90deg, #dadcdd00 0%, #28597400 100%) !important;
    border-color: #a1a0a0 !important;
    color: #2e292957 !important;
    border-radius: 0 !important;
}
</style>
