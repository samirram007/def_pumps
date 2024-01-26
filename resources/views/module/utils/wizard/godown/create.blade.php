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
                            @include('module.wizard.godown.partials.header', ['active' => 'create'])
                        </div>
                    </div>

                    <div class="rounded card p-3 bg-white shadow min-h-100">
                        <form id="createGodown" class="w-100 mt-3">
                            @csrf
                            <div class=" p-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="sr-only" name="officeId" id="officeId"
                                                    value="{{ $office['officeId'] }}">
                                                <label for="godownName">Godown Name<span
                                                        class="text-danger text-lg ml-2">*</span></label>
                                                <input type="text" class="form-control" name="godownName"
                                                    id="godownName">
                                                <span id="godownNameError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="godownTypeId">{{ __('Godown Type') }}</label>
                                                <select name="godownTypeId" id="godownTypeId" class="form-control">
                                                    @foreach ($godownTypes as $key => $godownType)
                                                        <option value="{{ $godownType['godownTypeId'] }}">
                                                            {{ $godownType['godownTypeName'] }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-3 secondary">
                                            <div class="form-group">
                                                <label for="isReserver">{{ __('Use as reserver') }}</label>
                                                <select name="isReserver" id="isReserver" class="form-control">
                                                    <option value="1">YES</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- submit --}}




                                    </div>
                                    <div class="row">
                                        <div class="offset-md-4 col-md-4">
                                            <div class="form-group">
                                                <button id="saveGodown" class="w-100 btn btn-info btn-sm">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                        <div class="row text-center  border-top  pt-2">
                            <div class="col-12  d-flex justify-content-end">
                                <button type="button" onclick="createOffice()"
                                    class="  btn btn-rounded animated-shine px-4">
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
                            godownTypeToggle();

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
                            $('#createGodown').on('submit', (e) => {
                                e.preventDefault();
                                $("#saveGodown").html(
                                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Save'
                                )
                                let officeId = $('#officeId').val();
                                let godownName = $('#godownName').val();
                                if (godownName === '') {
                                    $('#godownNameError').html('Godown Name is required');
                                    $("#saveGodown").html('Save')
                                    return;
                                }
                                let isReserver = $('#isReserver').val();
                                let godownTypeId = $('#godownTypeId').val();
                                let _token = $('input[name=_token]').val();
                                $.ajax({
                                    url: "{{ route('companyadmin.godown.store') }}",
                                    type: "POST",
                                    data: {
                                        officeId: officeId,
                                        godownName: godownName,
                                        isReserver: isReserver,
                                        godownTypeId: godownTypeId,
                                        _token: _token
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        if (response.status) {
                                            toastr.success(response.message);
                                            loadWizardGodown(loadWizardGodown)


                                        } else {
                                            toastr.error(response.message);
                                            $('#godownNameError').html(response.message);
                                            $("#saveGodown").html('Save')
                                        }

                                    }
                                });

                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>
