<div class="modal-dialog modal-lg  modal-dialog-centered mt-0">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('View Business Entity') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="formCreate">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">


                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="hidden" name="masterOfficeId" id="masterOfficeId" value="{{$editData->masterOfficeId }}">
                                                        <label for="officeName">{{ __('Business Entity') }}</label>
                                                        <input type="text" class="form-control" id="officeName"
                                                            name="officeName" value="{{ $editData->officeName }}"
                                                            placeholder="{{__('Enter Business Entity')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="officeTypeId">{{ __('Business Entity Type') }}</label>
                                                        <select name="officeTypeId" id="officeTypeId" class="form-control">
                                                            @foreach ($officeTypes as $officeType)
                                                            <option value="{{$officeType['officeTypeId']}}" {{$editData->officeTypeId==$officeType['officeTypeId']?'selected':''}}>{{$officeType['officeTypeName']}}</option>

                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>



                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="officeEmail">{{ __('Email') }}</label>
                                                        <input type="email" class="form-control" id="officeEmail"
                                                            name="officeEmail" value="{{ $editData->officeEmail }}"
                                                            placeholder="{{__('Enter Email')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="officeContactNo">{{ __('Contact No') }}</label>
                                                        <input type="text" size="10" required
                                                            class="form-control" id="officeContactNo"
                                                            name="officeContactNo" value="{{ $editData->officeContactNo }}"
                                                            placeholder="{{__('Enter Contact no')}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="gstNumber">{{ __('GST No') }}</label>
                                                        <input type="text" size="15"
                                                            class="form-control" id="gstNumber"
                                                            name="gstNumber" value="{{ $editData->gstNumber }}"
                                                            placeholder="{{__('Enter GST no')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="gstTypeId">{{ __('GST Type') }}</label>
                                                        <select name="gstTypeId" id="gstTypeId" class="form-control">
                                                            @foreach ($gstTypes as $gstType)
                                                            <option value="{{$gstType['gstTypeId']}}" {{ $gstType['gstTypeId']==$editData->gstTypeId?'selected':''}}>{{$gstType['gstTypeName']}}</option>

                                                            @endforeach

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="officeAddress">{{ __('Address') }}</label>
                                                        <textarea class="form-control" rows="1" id="officeAddress" name="officeAddress" placeholder="{{__('Enter Address')}}">{{ $editData->officeAddress }}</textarea>

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="longitude">{{ __('Longitude') }}</label>
                                                        <input class="form-control" id="longitude" name="longitude" placeholder="{{__('Enter longitude')}}" value="{{$editData->longitude }} ">

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="latitude">{{ __('Latitude') }}</label>
                                                        <input class="form-control" id="latitude" name="latitude" placeholder="{{__('Enter latitude')}}" value="{{ $editData->latitude }} ">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row text-center">
                                                <div class="col-6 mx-auto">
                                                    <button type="submit" class="submit btn btn-rounded animated-shine px-4"><span class="iconify"
                                                            data-icon="mdi:content-save-all-outline" data-width="15" data-height="15"></span>
                                                        {{ __('Save') }}</button>

                                                </div>
                                                <div class="col-6 mx-auto">
                                                    <button type="button" class=" btn btn-rounded animated-shine-danger px-4"
                                                        data-dismiss="modal">{{__('Cancel')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </section>
                </div>
            </div>

        </form>
    </div>
    <script>
        $(document).ready(function() {
            // $('#formCreate').submit();
            $("#formCreate").on("submit", function(event) {

                event.preventDefault();
                //spinner
                $('.submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                const url = "{{ route('companyadmin.office.update', $editData->officeId) }}";
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
                        console.log(data.errors);
                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors.responseJSON,
                            footer: '<a href>Why do I have this issue?</a>'
                        });
                        $('.submit').html('Save');
                    } else {
                        location.reload();
                    }
                }).fail(function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                        footer: '<a href>Why do I have this issue?</a>'
                    })
                    console.log(data);
                    $('.submit').html('Save');
                });


            });
        });
    </script>
</div>
