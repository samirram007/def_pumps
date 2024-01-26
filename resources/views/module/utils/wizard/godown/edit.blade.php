
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
        @include('module.wizard.godown.partials.header', ['active' => 'edit'])
    </div>
</div>

<div class="rounded card p-3 bg-white shadow min-h-100">
    <form id="editGodown" class="w-100 mt-3">
        @csrf
        <div class=" p-2">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <input type="text" class="sr-only" name="officeId" id="officeId"
                                value="{{ $godown['officeId'] }}">

                            <input type="text" class="sr-only" name="godownId" id="godownId"
                                value="{{ $godown['godownId'] }}">
                            <label for="godownName">{{ __('Godown Name') }}<span
                                    class="text-danger text-lg ml-2">*</span></label>
                            <input type="text" class="form-control" name="godownName" id="godownName"
                                value="{{ $godown['godownName'] }}">
                            <span id="godownNameError" class="text-danger text-sm"></span>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="godownTypeId">{{ __('Godown Type') }}</label>
                            <select name="godownTypeId" id="godownTypeId" class="form-control">
                                @foreach ($godownTypes as $key => $godownType)
                                    <option value="{{ $godownType['godownTypeId'] }}"
                                        {{ $godown['godownTypeId'] == $godownType['godownTypeId'] ? 'selected' : '' }}>
                                        {{ $godownType['godownTypeName'] }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-3 secondary {{ $godown['godownTypeId'] == 1 ? 'sr-only' : '' }}">
                        <div class="form-group">
                            <label for="isReserver">{{ __('Use as reserver') }}</label>
                            <select name="isReserver" id="isReserver" class="form-control">
                                <option value="1" {{ $godown['isReserver'] ? 'selected' : '' }}>YES</option>
                                <option value="0" {{ !$godown['isReserver'] ? 'selected' : '' }}>NO</option>
                            </select>
                        </div>
                    </div>
                    {{-- submit --}}



                </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 ">
                        <div class="form-group">
                            <button id="updateGodown" class="w-100 btn btn-info btn-sm">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
    <div class="row text-center  border-top  pt-2">
        <div class="col-12  d-flex justify-content-end">
            <button type="button" onclick="createOffice()" class="  btn btn-rounded animated-shine px-4">
                {{ __('Office Info') }}</button>

            <button type="button" onclick="loadWizardRate(wizardOfficeId)"
                class="  btn btn-rounded animated-shine px-4">
                {{ __('Set Product Rates') }}</button>



        </div>

    </div>
</div>
<script>
    $(document).ready(() => {
        $('#godownName').on('keyup', () => {
            $('#godownNameError').html('');
        });
        $('#godownTypeId').on('change', () => {
            godownTypeToggle();
        });


        function godownTypeToggle() {
            let godownTypeId = $('#godownTypeId').val();
            if (godownTypeId == 1) {
                $('#isReserver').val(0);
                $('#isReserver').attr('disabled', true);
                $('.secondary').addClass('sr-only');
            } else {
                $('#isReserver').val(0);
                $('#isReserver').attr('disabled', false);
                $('.secondary').removeClass('sr-only');
            }
        }
        $('#editGodown').on('submit', (e) => {
            e.preventDefault();
            $("#updateGodown").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Save'
            )
            let godownId = $('#godownId').val();
            let officeId = $('#officeId').val();
            let godownName = $('#godownName').val();
            let godownTypeId = $('#godownTypeId').val();
            if (godownName === '') {
                $('#godownNameError').html('Godown Name is required');
                $("#updateGodown").html('Save')
                return;
            }
            let isReserver = $('#isReserver').val();
            let _token = $('input[name=_token]').val();
            $.ajax({
                url: "{{ route('companyadmin.godown.update') }}",
                type: "POST",
                data: {
                    godownId: godownId,
                    officeId: officeId,
                    godownName: godownName,
                    isReserver: isReserver,
                    godownTypeId: godownTypeId,
                    _token: _token
                },
                success: function(response) {

                    if (response.status) {

                        toastr.success(response.message);
                        loadWizardGodown(wizardOfficeId)

                    } else {
                        toastr.error(response.message);
                        $('#godownNameError').html(response.message);
                        $("#updateGodown").html('Save')
                    }

                }
            });

        });
        setTimeout(() => {
            // godownTypeToggle();
        }, 500);



    });
</script>
</div>
</div>
</div>
</div>
</section>
