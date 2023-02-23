<div class="card-content">
    <div class="row">



        <div class="col-md-3 col-10  ">
            <div class="label-text pb-2" for="Map_filter">{{ __('View Options') }}</div>
            <select name="map_filter" id="map_filter" class="form-control">

                <option value="1">{{ __('My Pumps') }}</option>
                @if ($office['officeTypeId'] == 1)
                    <option value="-1">{{ __('Pumps Under My Chain') }}</option>
                @endif
                <option value="-2">{{ __('All Def Pumps') }}</option>


            </select>
        </div>

        <div class="col-2 d-flex align-items-center mt-4 icon-wrap sr-only ">
            <a href="javascript:" class="search btn-zoom badge align-self-end" title="{{ __('Search') }}">
                <span class="iconify" data-icon="fe:search" style="color: #05a;" data-width="30"
                    data-height="30"></span>
            </a>


        </div>



    </div>



</div>
