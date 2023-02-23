<div class="col-lg-3 col-md-3">
    <div class="form-group">
        <label for="office">{{__('Office')}} :</label>
        <div>
            <select name="office" id="office" class="form-control">

                @foreach ($officeList as $key => $office)

                <option value="{{ $office['officeId'] }}" data-isRetail="0" data-isAdmin="0"
                class="optionChild">{{ $office['officeName'] }}</option>
                @endforeach
           </select>
        </div>

    </div>
</div>
<div class="col-lg-3 col-md-3">
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
