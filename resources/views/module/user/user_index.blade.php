@extends('layouts.main')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center mx-3">
                    <div class="col-sm-6 mx-n3">
                        <h4 class="m-0 text-dark">{{ __('User List') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-sm-6 mx-n3">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route( $routeRole.'.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            @if (!empty($office))
                            @if($office['masterOfficeId']==null)
                                <li class="breadcrumb-item "><a href="{{ route($routeRole.'.master_office.index' ) }}"
                                    class="text-active">{{ __('Top Company') }}</a></li>
                            @else
                            <li class="breadcrumb-item "><a href="{{ route($routeRole.'.office.index',$office['officeId']) }}"
                                        class="text-active">{{ __('Business Entity') }}</a></li>
                            @endif


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
                        <div class=" ">
                            <div class="card-body">
                                <div class="row   border-bottom pb-2  ">
                                    <div class="col-sm-6">
                                        @if (!empty($office))
                                            {{-- @dd($office) --}}
                                            <div class="label text-primary h3">
                                               {{$office['officeTypeName'] }}:: {{ $office['officeName'] }}
                                            </div>
                                        @endif

                                    </div>
                                    <div class="col-sm-6 text-right justify-content-center ">
                                        @if (!empty($office))
                                            <a href="javascript:"
                                                data-url="{{ route($routeRole.'.organization_user.filter', $office['officeId']) }}"
                                                title="{{ __('Filter') }}"
                                                class="load-popup p-0   btn  btn-rounded  animated-shine mt-0 mx-2">
                                                <i class="fa fa-filter"></i>
                                            </a>


                                            <a href="javascript:" data-param=""
                                                data-url="{{ route($routeRole.'.organization_user.create', $office['officeId']) }}"
                                                title="{{ __('Add User') }}"
                                                class="load-popup float-right btn btn-rounded animated-shine px-2   ">
                                                <span class="iconify" data-icon="carbon:user-profile" data-width="15"
                                                    data-height="15"></span> {{ __('Add User') }}</a>
                                        @else
                                            <a href="javascript:" data-url="{{ route($routeRole.'.user.filter' ) }}"
                                            title="{{ __('Filter') }}"
                                                class="load-popup p-0   btn  btn-rounded  animated-shine mt-0 mx-2">
                                                <i class="fa fa-filter"></i>
                                            </a>


                                            <a href="javascript:" data-param=""
                                                data-url="{{ route($routeRole.'.user.create') }}" title="{{ __('Add User') }}"
                                                class="load-popup float-right btn btn-rounded animated-shine px-2  ">
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
                    @include('module.user.user_filter_result')

                </div>
            </div>
        </section>
    </div>
@endsection
