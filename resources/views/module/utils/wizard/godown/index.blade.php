<section class="content">
    <div class="  p-3 bg-transparent   min-h-100">

        <div class="row">

            <div class="col-md-4 sr-only">
                <div id="h-section_create_office" class="sr-only"></div>
                <div class=" d-flex justify-content-center ">
                    <img class="info-image" style="" src="{{ asset('images/wizard/img01.png') }}">
                </div>

            </div>
            <div class="offset-md-2 col-md-8  ">
                <div class="wizard-box scroll-box card card-primary ">
                    <div class="rounded card p-3 bg-white shadow min-h-100">
                        <div class="rounded card p-3 bg-white shadow min-h-100">
                            @include('module.wizard.godown.partials.header', ['active' => 'list'])
                        </div>

                    </div>

                    <div class="rounded card p-3 bg-white shadow min-h-100">
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                {{-- @dd($editData) --}}
                                <table class="table table-bordered  text-center">
                                    <tr>
                                        <td class="text-left">{{ __('Name') }}</td>
                                        <td>{{ __('Godown Type') }}</td>
                                        <td>{{ __('IsReserver') }} ?</td>
                                        <td>{{ __('Capacity') }}</td>


                                        <td class="d-none">{{ __('Status') }}</td>
                                        <td>{{ __('Action') }}</td>
                                    </tr>


                                    @foreach ($godowns as $key => $godown)
                                        <tr>
                                            <td class="text-left">{{ $godown['godownName'] }}</td>
                                            <td>{{ $godown['godownTypeName'] }}</td>
                                            <td>{{ $godown['isReserver'] == 1 ? 'yes' : 'no' }}</td>
                                            <td>{{ $godown['capacity'] . ' ltr' }} </td>

                                            <td class="d-none">{{ $godown['status'] == 1 ? 'active' : 'inactive' }}
                                            </td>
                                            <td>
                                                <a href="javascript:" onclick="editGodown({{ $godown['godownId'] }})"
                                                    class="  mx-2 text-info d-inline-flex"
                                                    data-id="{{ $godown['godownId'] }}"
                                                    title="{{ __('Edit Godown') }}">
                                                    <i class=" fa fa-edit fa-lg  "
                                                        data-id="{{ $godown['godownId'] }}"></i>
                                                </a>
                                                <a href="javascript:"
                                                    class=" godown-delete mx-2 text-info d-inline-flex sr-only"
                                                    data-id="{{ $godown['godownId'] }}"
                                                    title="{{ __('Remove Godown') }}">
                                                    <i class="fa fa-trash fa-lg  "
                                                        data-id="{{ $godown['godownId'] }}"></i>
                                                </a>
                                                <div class=" godown-stock
                                mx-2 text-info d-inline-flex sr-only"
                                                    title="{{ __('Stock Details') }}">
                                                    <i class="fa fa-archive fa-lg cursor-pointer "
                                                        data-id="{{ $godown['godownId'] }}"></i>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="row text-center  border-top  pt-2">
                            <div class="col-12  d-flex justify-content-end">
                                <button type="button" onclick="showOffice(wizardOfficeId)"
                                    class="  btn btn-rounded animated-shine px-4">
                                    {{ __('Office Info') }}</button>

                                <button type="button" onclick="loadWizardRate(wizardOfficeId)"
                                    class="  btn btn-rounded animated-shine px-4">
                                    {{ __('Set Product Rates') }}</button>



                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
