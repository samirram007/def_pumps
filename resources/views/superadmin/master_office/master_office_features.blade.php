<div class="modal-dialog modal-lg  modal-dialog-centered mt-0">
    <style>
        .example>.row {
            margin-top: 2rem;
            height: 5rem;
            vertical-align: middle;
            text-align: center;
            border: 1px solid rgba(189, 193, 200, 0.5);
        }

        .example>.row:first-of-type {
            border: none;
            height: auto;
            text-align: left;
        }

        .example h3 {
            font-weight: 400;
        }

        .example h3>small {
            font-weight: 200;
            font-size: 0.75em;
            color: #939aa5;
        }

        .example h6 {
            font-weight: 700;
            font-size: 0.65rem;
            letter-spacing: 3.32px;
            text-transform: uppercase;
            color: #bdc1c8;
            margin: 0;
            line-height: 5rem;
        }

        .example .btn-toggle {
            top: 50%;
            transform: translateY(-50%);
        }

        .btn-toggle {
            margin: 0 4rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
            color: #6b7381;
            background: #bdc1c8;
        }

        .btn-toggle:focus,
        .btn-toggle.focus,
        .btn-toggle:focus.active,
        .btn-toggle.focus.active {
            outline: none;
        }

        .btn-toggle:before,
        .btn-toggle:after {
            line-height: 1.5rem;
            width: 4rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }

        .btn-toggle:before {
            content: 'Off';
            left: -4rem;
        }

        .btn-toggle:after {
            content: 'On';
            right: -4rem;
            opacity: 0.5;
        }

        .btn-toggle>.handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }

        .btn-toggle.active {
            transition: background-color 0.25s;
        }

        .btn-toggle.active>.handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }

        .btn-toggle.active:before {
            opacity: 0.5;
        }

        .btn-toggle.active:after {
            opacity: 1;
        }

        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }

        .btn-toggle.btn-sm:before {
            text-align: right;
        }

        .btn-toggle.btn-sm:after {
            text-align: left;
            opacity: 0;
        }

        .btn-toggle.btn-sm.active:before {
            opacity: 0;
        }

        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }

        .btn-toggle.btn-xs:before,
        .btn-toggle.btn-xs:after {
            display: none;
        }

        .btn-toggle:before,
        .btn-toggle:after {
            color: #6b7381;
        }

        .btn-toggle.active {
            background-color: #29b5a8;
        }

        .btn-toggle.btn-lg {
            margin: 0 5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 2.5rem;
            width: 5rem;
            border-radius: 2.5rem;
        }

        .btn-toggle.btn-lg:focus,
        .btn-toggle.btn-lg.focus,
        .btn-toggle.btn-lg:focus.active,
        .btn-toggle.btn-lg.focus.active {
            outline: none;
        }

        .btn-toggle.btn-lg:before,
        .btn-toggle.btn-lg:after {
            line-height: 2.5rem;
            width: 5rem;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }

        .btn-toggle.btn-lg:before {
            content: 'Off';
            left: -5rem;
        }

        .btn-toggle.btn-lg:after {
            content: 'On';
            right: -5rem;
            opacity: 0.5;
        }

        .btn-toggle.btn-lg>.handle {
            position: absolute;
            top: 0.3125rem;
            left: 0.3125rem;
            width: 1.875rem;
            height: 1.875rem;
            border-radius: 1.875rem;
            background: #fff;
            transition: left 0.25s;
        }

        .btn-toggle.btn-lg.active {
            transition: background-color 0.25s;
        }

        .btn-toggle.btn-lg.active>.handle {
            left: 2.8125rem;
            transition: left 0.25s;
        }

        .btn-toggle.btn-lg.active:before {
            opacity: 0.5;
        }

        .btn-toggle.btn-lg.active:after {
            opacity: 1;
        }

        .btn-toggle.btn-lg.btn-sm:before,
        .btn-toggle.btn-lg.btn-sm:after {
            line-height: 0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.6875rem;
            width: 3.875rem;
        }

        .btn-toggle.btn-lg.btn-sm:before {
            text-align: right;
        }

        .btn-toggle.btn-lg.btn-sm:after {
            text-align: left;
            opacity: 0;
        }

        .btn-toggle.btn-lg.btn-sm.active:before {
            opacity: 0;
        }

        .btn-toggle.btn-lg.btn-sm.active:after {
            opacity: 1;
        }

        .btn-toggle.btn-lg.btn-xs:before,
        .btn-toggle.btn-lg.btn-xs:after {
            display: none;
        }

        .btn-toggle.btn-sm {
            margin: 0 0.5rem;
            padding: 0;
            position: relative;
            border: none;
            height: 1.5rem;
            width: 3rem;
            border-radius: 1.5rem;
        }

        .btn-toggle.btn-sm:focus,
        .btn-toggle.btn-sm.focus,
        .btn-toggle.btn-sm:focus.active,
        .btn-toggle.btn-sm.focus.active {
            outline: none;
        }

        .btn-toggle.btn-sm:before,
        .btn-toggle.btn-sm:after {
            line-height: 1.5rem;
            width: 0.5rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }

        .btn-toggle.btn-sm:before {
            content: 'Off';
            left: -0.5rem;
        }

        .btn-toggle.btn-sm:after {
            content: 'On';
            right: -0.5rem;
            opacity: 0.5;
        }

        .btn-toggle.btn-sm>.handle {
            position: absolute;
            top: 0.1875rem;
            left: 0.1875rem;
            width: 1.125rem;
            height: 1.125rem;
            border-radius: 1.125rem;
            background: #fff;
            transition: left 0.25s;
        }

        .btn-toggle.btn-sm.active {
            transition: background-color 0.25s;
        }

        .btn-toggle.btn-sm.active>.handle {
            left: 1.6875rem;
            transition: left 0.25s;
        }

        .btn-toggle.btn-sm.active:before {
            opacity: 0.5;
        }

        .btn-toggle.btn-sm.active:after {
            opacity: 1;
        }

        .btn-toggle.btn-sm.btn-sm:before,
        .btn-toggle.btn-sm.btn-sm:after {
            line-height: -0.5rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.4125rem;
            width: 2.325rem;
        }

        .btn-toggle.btn-sm.btn-sm:before {
            text-align: right;
        }

        .btn-toggle.btn-sm.btn-sm:after {
            text-align: left;
            opacity: 0;
        }

        .btn-toggle.btn-sm.btn-sm.active:before {
            opacity: 0;
        }

        .btn-toggle.btn-sm.btn-sm.active:after {
            opacity: 1;
        }

        .btn-toggle.btn-sm.btn-xs:before,
        .btn-toggle.btn-sm.btn-xs:after {
            display: none;
        }

        .btn-toggle.btn-xs {
            margin: 0 0;
            padding: 0;
            position: relative;
            border: none;
            height: 1rem;
            width: 2rem;
            border-radius: 1rem;
        }

        .btn-toggle.btn-xs:focus,
        .btn-toggle.btn-xs.focus,
        .btn-toggle.btn-xs:focus.active,
        .btn-toggle.btn-xs.focus.active {
            outline: none;
        }

        .btn-toggle.btn-xs:before,
        .btn-toggle.btn-xs:after {
            line-height: 1rem;
            width: 0;
            text-align: center;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: absolute;
            bottom: 0;
            transition: opacity 0.25s;
        }

        .btn-toggle.btn-xs:before {
            content: 'Off';
            left: 0;
        }

        .btn-toggle.btn-xs:after {
            content: 'On';
            right: 0;
            opacity: 0.5;
        }

        .btn-toggle.btn-xs>.handle {
            position: absolute;
            top: 0.125rem;
            left: 0.125rem;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 0.75rem;
            background: #fff;
            transition: left 0.25s;
        }

        .btn-toggle.btn-xs.active {
            transition: background-color 0.25s;
        }

        .btn-toggle.btn-xs.active>.handle {
            left: 1.125rem;
            transition: left 0.25s;
        }

        .btn-toggle.btn-xs.active:before {
            opacity: 0.5;
        }

        .btn-toggle.btn-xs.active:after {
            opacity: 1;
        }

        .btn-toggle.btn-xs.btn-sm:before,
        .btn-toggle.btn-xs.btn-sm:after {
            line-height: -1rem;
            color: #fff;
            letter-spacing: 0.75px;
            left: 0.275rem;
            width: 1.55rem;
        }

        .btn-toggle.btn-xs.btn-sm:before {
            text-align: right;
        }

        .btn-toggle.btn-xs.btn-sm:after {
            text-align: left;
            opacity: 0;
        }

        .btn-toggle.btn-xs.btn-sm.active:before {
            opacity: 0;
        }

        .btn-toggle.btn-xs.btn-sm.active:after {
            opacity: 1;
        }

        .btn-toggle.btn-xs.btn-xs:before,
        .btn-toggle.btn-xs.btn-xs:after {
            display: none;
        }

        .btn-toggle.btn-secondary {
            color: #6b7381;
            background: #bdc1c8;
        }

        .btn-toggle.btn-secondary:before,
        .btn-toggle.btn-secondary:after {
            color: #6b7381;
        }

        .btn-toggle.btn-secondary.active {
            background-color: #ff8300;
        }
    </style>
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Features') }} :: {{ $office['officeName']}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
            <div class=" w-100  ">
                {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                <section class="content h-100 m-0 ">
                    <div class="rounded card  bg-white shadow min-h-100 px-4 pb-4">

                        <div class="col-12 ">

                            {{-- @dd($FeatureTypeList) --}}
                            <div class="row p-2 border-bottom border-info font-weight-bold">
                                <div class="col-1">
                                    #
                                </div>
                                <div class="col-6">
                                    {{ __('Feature Name') }}
                                </div>
                                <div class="col-5 example text-center">
                                    {{ __('Status') }}
                                </div>
                            </div>

                            @foreach ($FeatureTypeList as $key => $data)


                                        <div class="row p-2">
                                            <div class="col-1">

                                                {{-- {{ $data['featureTypeId'] }} --}}
                                                {{ $key+1 }}

                                            </div>
                                            <div class="col-6">
                                                {{ $data['featureTypeName'] }}

                                            </div>
                                            <div class="col-5 example">

                                                <button type="button"
                                                    class="features-toggle btn  btn-toggle {{ $data['IsActive'] ? 'active' : '' }}"
                                                    data-toggle="button"
                                                    data-featuretypeid="{{ $data['featureTypeId'] }}"
                                                    data-officeId="{{ $data['officeId'] }}"
                                                    aria-pressed="{{ $data['IsActive'] ? 'true' : 'false' }}"
                                                    autocomplete="{{__('off')}}">
                                                    <div class="handle"></div>
                                                </button>
                                            </div>

                                        </div> <div class="row px-2 pb-2">
                                            <div class="col-1"> </div>
                                            <div class="col-11">

                                                <small>{{$data['description']}} </small>

                                            </div>

                                        </div>




                            @endforeach




                </section>
            </div>
        </div>


    </div>
    <script>
        $(document).ready(function() {
            // $('#formCreate').submit();
            $("#formCreate").on("submit", function(event) {
                event.preventDefault();
                const url = '';
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
                    } else {
                        console.log(data);
                        window.location.href = "{{ route('superadmin.master_office.index') }}";
                    }
                }).fail(function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                        footer: '<a href>Why do I have this issue?</a>'
                    })
                    console.log(data);
                });


            });

            $(".features-toggle").on("click", function() {
                var featureTypeId = $(this).data('featuretypeid');
                var officeId = $(this).data('officeid');
                var isActive = $(this).hasClass('active');
                var url = "{{ route('superadmin.master_office.feature_toggle') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}",
                        featureTypeId: featureTypeId,
                        officeId: officeId,
                        isActive: !isActive
                    },
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    if (!data.status) {
                        //console.log(data.errors);
                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                            toastr.error(value);
                        });

                    } else {
                        toastr.success(data.message);
                        // console.log(data);
                        //window.location.href = "{{ route('superadmin.master_office.index') }}";
                    }
                }).fail(function(data) {
toastr.error(data.error);
                    //  console.log(data);
                });
            });
        });
    </script>
</div>
