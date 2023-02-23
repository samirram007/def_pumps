@extends('layouts.main')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('User List') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            @if (!empty($office))
                                <li class="breadcrumb-item "><a href="{{ route('companyadmin.office.index') }}"
                                        class="text-active">{{ __('Office') }}</a></li>
                            @endif
                            <li class="breadcrumb-item active">{{ __('User List') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="rounded card p-3  bg-white shadow ">
                <div class="row   ">
                    <div class="col-md-12">
                        <div class=" card-primary">
                            <div class="card-body">
                                <div class="row   border-bottom pb-2  ">
                                    <div class="col-sm-6">
                                        @if (!empty($office))
                                            {{-- @dd($office) --}}
                                            <div class="label text-primary">
                                                {{ __('Office') . ' :: ' . $office->officeName }}
                                            </div>
                                        @endif

                                    </div>
                                    <div class="col-sm-6 text-right justify-content-center ">
                                        @if (!empty($office))
                                            <a href="javascript:"
                                                data-url="{{ route('companyadmin.office_user.filter', $office->officeId) }}"
                                                class="load-popup p-0   btn  btn-rounded animated-shine mt-0 mx-2">
                                                <i class="fa fa-filter" aria-hidden="true"></i>
                                            </a>


                                            <a href="javascript:" data-param=""
                                                data-url="{{ route('companyadmin.office_user.create', $office->officeId) }}"
                                                title="{{ __('Add User') }}"
                                                class="load-popup float-right btn btn-rounded animated-shine px-2   ">
                                                <span class="iconify" data-icon="carbon:user-profile" data-width="15"
                                                    data-height="15"></span> {{ __('Add User') }}</a>
                                        @else
                                            <a href="javascript:" data-url="{{ route('companyadmin.user.filter') }}"
                                            title="{{ __('Filter') }}"
                                                class="load-popup p-0   btn  btn-rounded animated-shine mt-0 mx-2">
                                                <i class="fa fa-filter" aria-hidden="true"></i>
                                            </a>


                                            <a href="javascript:" data-param=""
                                                data-url="{{ route('companyadmin.user.create') }}" title="{{ __('Add User') }}"
                                                class="load-popup float-right btn btn-rounded animated-shine px-2   ">
                                                <span class="iconify" data-icon="carbon:user-profile" data-width="15"
                                                    data-height="15"></span> {{ __('Add User') }}</a>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="searchPanel" class="searchPanel">
                    @include('companyadmin.user.user_filter_result')

                </div>
            </div>
        </section>
    </div>
@endsection
