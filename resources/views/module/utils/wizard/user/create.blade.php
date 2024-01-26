<div class="rounded card p-3 bg-white shadow min-h-100">
    <div class="rounded card p-3 bg-white shadow min-h-100">
        @include('module.wizard.user.partials.header', ['active' => 'create'])
    </div>
</div>

<div class="rounded card p-3 bg-white shadow min-h-100">
    <form id="formUserCreate">
        @csrf

        <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('User Name') }} <span
                                                class="text text-danger  ">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name') }}" placeholder="{{ __('Enter User Name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="roleName">{{ __('Role') }} <span
                                                class="text text-danger  ">*</span></label>
                                            <select class="form-control " name="roleName" id="roleName">
                                                {{-- <option value="" class="text-bold">Select Role
                                                   </option> --}}
                                                @forelse ($roles as $tg)
                                                    <option value="{{ $tg }}">
                                                        {{ __($tg) }}
                                                    </option>
                                                @empty
                                                    <option value="">{{ __('No record found') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 sr-only">
                                        <div id="officePanel" class="form-group">
                                            <label for="officeId">{{ __('Business Entity') }}</label>

                                            <select class="form-control " name="officeId" id="officeId">
                                                {{-- <option value="" class="text-bold">Select Office
                                                    </option> --}}
                                                @forelse ($officeList as $tg)
                                                    <option value="{{ $tg['officeId'] }}">
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
                                            <label for="phoneNumber">{{ __('Mobile No') }} <span
                                                class="text text-danger  ">*</span></label>
                                            <input type="text" size="10" maxlength="10" class="form-control"
                                                id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber') }}"
                                                placeholder="{{ __('Enter Mobile no') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email') }}" placeholder="{{ __('Enter Email') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center ">
                                    <div class="offset-md-4 col-md-4 ">
                                        <button type="submit" class="w-100  submit btn btn-rounded animated-shine px-4"><span
                                                class="iconify" data-icon="mdi:content-save-all-outline" data-width="15"
                                                data-height="15"></span>
                                            {{ __('Save') }}</button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>


    </form>
    @include('module.wizard.user.partials.links')
</div>



<script type="text/javascript">
    $(document).ready(function() {
        $('#roleName').change(function() {

            var roleName = $(this).val();

            if (roleName.toLowerCase() == 'companyadmin') {
                $('#officePanel').html($('.master-office-collection').html());
            } else {
                $('#officePanel').html($('.office-collection').html());
            }
        });
        //  $('#officePanel').html('<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
        $('#officeId').append(
            '<option class="spinner-border text-primary" role="status"> Loading...  </option>');
        setTimeout(() => {
            $('#roleName').change();
        }, 1000);
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
    $(document).ready(function() {

        $("#formUserCreate").on("submit", function(event) {

            event.preventDefault();
            $('.submit').attr('disabled', 'disabled');
            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
            );
            const url = "{{ route('companyadmin.user.store') }}";
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
                    //  console.log(data.errors);

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
                    loadListUser(wizardOfficeId);
                }
            }).fail(function(data) {
                $('.submit').attr('disabled', false);
                    $('.submit').html(
                        '<span class="iconify" data-icon="mdi:content-save-all-outline" data-width="15" data-height="15"></span> {{ __('Save') }}'
                    );

                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });

            });


        });
    });
</script>
