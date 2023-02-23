<div class="col-lg-3 col-md-3">
    <div class="form-group">
        <label for="office">{{__('Office')}} :</label>
        <div>
            <select name="office" id="office" class="form-control">
                @if($officeList!=null)
                <option value="{{ $officeList[0]['masterOfficeId'] }}" data-isRetail="-1"
                data-isAdmin="6" class="optionGroup">{{__('All Entities')}}</option>

                @foreach ($officeList as $key => $office)
                    @if ($key == 0)
                        <option value="{{ $officeList[0]['masterOfficeId']  }}" data-isRetail="0"
                            data-isAdmin="4" class="optionGroup">&nbsp;&nbsp;&nbsp;&nbsp;{{__('All Companies')}}</option>
                    @endif
                    @if ($office['officeTypeId'] == 1)
                        <option value="{{ $office['officeId'] }}" data-isRetail="0" data-isAdmin="5"
                            class="optionChild">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ __($office['officeName']) }}</option>
                    @endif
                @endforeach

                <option value="{{ $officeList[0]['masterOfficeId'] }}" data-isRetail="-1"
                    data-isAdmin="1" class="optionGroup">&nbsp;&nbsp;&nbsp;&nbsp;{{__('All Pumps')}}</option>

                    {{-- Wholesale --}}
                @foreach ($officeList as $key => $office)
                    @if ($key == 0)
                        <option value="{{ $office['masterOfficeId'] }}" data-isRetail="0"
                            data-isAdmin="3" class="optionGroup">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{__('WholeSale Pumps')}}</option>
                    @endif
                    @if ($office['officeTypeId'] == 3)
                        <option value="{{ $office['officeId'] }}" data-isRetail="0" data-isAdmin="0"
                            class="optionChild">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ __($office['officeName']) }}</option>
                    @endif
                @endforeach


                    {{-- Retail --}}
                @foreach ($officeList as $key => $office)
                    @if ($key == 0)
                        <option value="{{ $office['masterOfficeId'] }}" data-isRetail="1" data-isAdmin="2"
                            class="optionGroup">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{__('Retail Pumps')}}</option>
                    @endif
                    @if ($office['officeTypeId'] == 2)
                        <option value="{{ $office['officeId'] }}" data-isRetail="1" data-isAdmin="0"
                            class="optionChild">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $office['officeName'] }}</option>
                    @endif
                @endforeach
                @else
                <option value="0" data-isRetail="-1" data-isAdmin="1" class="optionGroup">{{__('No Office Found')}}</option>
@endif

            </select>
        </div>




    </div>
</div>
<div class="col-lg-4 col-md-6">
    <div class="form-group">
        <label for="reportrange">{{__('Period')}} : </label>
        <div id="reportrange" name="reportrange" class="pull-right form-control">
            <i class=" fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>

    </div>
</div>
<div class="col-md-3 mt-4">
    <button class="btn btn-rounded animated-shine mt-2" id="filter">{{__('Filter')}}</button>
</div>
