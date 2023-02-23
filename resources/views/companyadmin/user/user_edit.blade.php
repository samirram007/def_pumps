<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Edit User(Admin Mode)') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formCreate">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">


                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">{{ __('User Name') }}</label>
                                                        <input type="hidden" id="id" name="id"
                                                            value="{{ $editData->id }}">
                                                        <input type="text" class="form-control" id="name"
                                                            name="name"
                                                            value="{{ __($editData->firstName) }} {{ $editData->firstName == $editData->surName ? '' : $editData->surName }}  "
                                                            placeholder="{{ __('Enter User Name') }}">
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-md-6 {{ strtolower($editData->roleName) == 'companyadmin' ? 'd-none' : '' }}">
                                                    <div class="form-group">
                                                        <label for="roleName">{{ __('Role') }}</label>
                                                        <select class="form-control " name="roleName" id="roleName">
                                                            {{-- <option value="" class="text-bold">Select Role
                                                            </option> --}}
                                                            @forelse ($roles as $tg)
                                                                <option value="{{ $tg }}"
                                                                    {{ $editData->roleName == $tg ? 'selected' : '' }}>
                                                                    {{ __($tg) }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-md-6 {{ strtolower($editData->roleName) == 'companyadmin' ? 'd-none' : '' }}">
                                                    <div id="officePanel" class="form-group">
                                                        <label for="officeId">{{ __('Business Entity') }}</label>
                                                        {{-- @dd($editData) --}}
                                                        <select class="form-control " name="officeId" id="officeId">
                                                            {{-- <option value="" class="text-bold">Select Office
                                                            </option> --}}
                                                            @forelse ($officeList as $tg)
                                                                <option value="{{ $tg['officeId'] }}"
                                                                    {{ $editData->officeId == $tg['officeId'] ? 'selected' : '' }}>
                                                                    {{ __($tg['officeName']) }}
                                                                </option>
                                                            @empty
                                                                <option value="">{{ __('No record found') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phoneNumber">{{ __('Mobile No') }}</label>
                                                        <input type="text" size="10" maxlength="10" required
                                                            class="form-control" id="phoneNumber" name="phoneNumber"
                                                            value="{{ $editData->phoneNumber }}"
                                                            placeholder="{{ __('Enter Mobile no') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">{{ __('Email') }}</label>
                                                        <input type="email" class="form-control" id="email"
                                                            name="email" value="{{ $editData->email }}"
                                                            placeholder="{{ __('Enter Email') }}">
                                                    </div>
                                                </div>






                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-3 ">
                                <div class="col-12  ">
                                    <div class="row text-center">
                                        <div class="col-6 mx-auto">
                                            <button type="submit"
                                                class="submit btn btn-rounded animated-shine px-4"><span class="iconify"
                                                    data-icon="mdi:content-save-all-outline" data-width="15"
                                                    data-height="15"></span>
                                                {{ __('Save') }}</button>

                                        </div>
                                        <div class="col-6 mx-auto">
                                            <button type="button" class=" btn btn-rounded animated-shine-danger px-4"
                                                data-dismiss="modal">{{ __('Cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </section>

                </div>
            </div>
            {{-- <div class="modal-footer bg-light ">


            </div> --}}
        </form>
        <div class="office-collection sr-only">
            <label for="officeId">{{ __('Business Entity') }}</label>
            {{-- @dd($officeList) --}}
            <select class="form-control " name="officeId" id="officeId">
                {{-- <option value="" class="text-bold">Select Office  </option> --}}
                @forelse ($officeList as $tg)
                    @if ($tg['officeTypeId'] != 1)
                        <option value="{{ $tg['officeId'] }}"
                            {{ $editData->officeId == $tg['officeId'] ? 'selected' : '' }}>
                            {{ $tg['officeName'] }}
                        </option>
                    @endif

                @empty
                    <option value="">{{ __('No record found') }} </option>
                @endforelse
            </select>
        </div>
        <div class="master-office-collection sr-only">
            <label for="officeId">{{ __('Business Entity') }}</label>
            <select class="form-control " name="officeId" id="officeId">
                {{-- <option value="" class="text-bold">Select Office  </option> --}}
                @forelse ($officeList as $tg)
                    @if ($tg['officeTypeId'] == 1)
                        <option value="{{ $tg['officeId'] }}"
                            {{ $editData->officeId == $tg['officeId'] ? 'selected' : '' }}>
                            {{ $tg['officeName'] }}
                        </option>
                    @endif
                @empty
                    <option value="">{{ __('No record found') }} </option>
                @endforelse
            </select>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#roleName').change(function() {
                //spinner

                var roleName = $(this).val();
                if (roleName.toLowerCase() == 'admin') {
                    $('#officePanel').html($('.master-office-collection').html());
                } else {
                    $('#officePanel').html($('.office-collection').html());
                }
            });
            // $('#officePanel').html('<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');

            $('#officeId').append(
                '<option class="spinner-border text-primary" role="status"> Loading...  </option>');
            setTimeout(() => {

                $('#roleName').change();
            }, 2000);
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#showImage').click(function() {
                $('#image').click();
            });
            $('#showAadhaarImage').click(function() {
                $('#aadhaar_image').click();
            });
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);

            });
        });
    </script>
    <script>
        //  $(document).ready(function() {
        //      $('#roleName').select2({
        //          placeholder: "Select Role",
        //          allowClear: true
        //      });
        //      $('#officeId').select2({
        //          placeholder: "Select Office",
        //          allowClear: true
        //      });
        //  });
    </script>

    <script>
        $(document).ready(function() {
            // $('#formCreate').submit();
            $("#formCreate").on("submit", function(event) {

                event.preventDefault();
                $('.submit').attr('disabled', 'disabled');
                $('.submit').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                );

                const url = "{{ route('companyadmin.user.update', $editData->id) }}";
                var serializeData = $(this).serialize();



                $.ajax({
                    type: "POST",
                    url: url,

                    _token: "{{ csrf_token() }}",
                    data: serializeData,
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    if (!data.status) {
                        //console.log(data.errors);
                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                            toastr.error(value);
                            $('.submit').removeAttr('disabled');
                            $('.submit').html(
                                '<span class="iconify" data-icon="mdi:content-save-all-outline" data-width="15" data-height="15"></span> {{ __('Save') }}'
                            );
                        });
                    } else {
                        toastr.success(data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 2000);



                    }
                }).fail(function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                        footer: ' '
                    }).done(function() {
                        toastr.error(data.message);
                        $('.submit').removeAttr('disabled');
                        $('.submit').html(
                            '<span class="iconify" data-icon="mdi:content-save-all-outline" data-width="15" data-height="15"></span> {{ __('Save') }}'
                        );
                    });
                    console.log(data);
                });


            });
        });
    </script>

</div>
