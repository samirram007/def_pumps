<div class="modal-dialog modal-lg  modal-dialog-centered mt-0">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Edit User') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
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
                                            <div class="row   border-bottom pb-2 mb-2 d-none">
                                                <div class="col-md-3 col-sm-6">

                                                    <div class="form-group">
                                                        {{-- <h5>Profile Image <span class="text-danger"></span></h5> --}}
                                                        <div class="">
                                                            <input type="file" name="image" id="image"
                                                                class="form-control d-none">
                                                        </div>
                                                        <div class="controls ">
                                                            <img id="showImage" class=" rounded-circle"
                                                                style="cursor:pointer;width: 75px; height:75px; border:1px solid #000000;"
                                                                src="{{ url('upload/no_image.jpg') }}" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">{{ __('User Name') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="hidden" id="id" name="id"
                                                            value="{{ $editData->id }}">
                                                        <input type="text" class="form-control" id="name"
                                                            name="name"
                                                            value="{{ $editData->firstName }} {{ $editData->firstName == $editData->surName ? '' : __($editData->surName) }} "
                                                            placeholder="{{ __('Enter User Name') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="roleName">{{ __('Role') }} <span
                                                                class="text-danger">*</span></label>
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

                                                <div class="col-md-6">
                                                    <div id="officePanel" class="form-group">
                                                        <label
                                                            for="officeId">{{__('Business Entity')}}
                                                            <span class="text-danger">*</span></label>
                                                        <select class="form-control " name="officeId" id="officeId">
                                                            {{-- <option value="" class="text-bold">Select Office  </option> --}}
                                                            {{-- @forelse ($officeList as $tg)
                                                               <option value="{{ $tg['officeId'] }}">
                                                                   {{ $tg['officeName'] }}
                                                               </option>
                                                           @empty
                                                               <option value="">No record found </option>
                                                           @endforelse --}}
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phoneNumber">{{ __('Mobile no') }} <span
                                                                class="text-danger">*</span> </label>
                                                        <input type="text" size="10" maxlength="10"
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
                                            <button type="submit" class="submit btn btn-rounded animated-shine px-4">
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
                if (roleName.toLowerCase() == 'companyadmin') {
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
            }, 100);
        });
    </script>


    <script>
        $(document).ready(function() {
            // $('#formCreate').submit();
            $("#formCreate").on("submit", function(event) {

                event.preventDefault();
                $('.submit').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                const url = "{{ route($routeRole . '.user.update', $editData->id) }}";
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
                        try
                        {
                            toastr.error(data.message);
                        }
                        catch(err)
                        {
                            toastr.error("something went wrong");
                            console.log(err.message);
                        }

                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                            toastr.error(value);
                        });
                        $('.submit').html("{{ __('Save') }}");

                    } else {
                        toastr.success(data.message);
                        setTimeout(function() {
                            location.reload();

                        }, 1500);
                    }
                }).fail(function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                        footer: ' '
                    }).then((result) => {
                        //$('.submit').attr('disabled', false);
                        $('.submit').html("{{ __('Save') }}");

                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                            toastr.error(value);
                        });

                    });
                });


            });
        });
    </script>

</div>
