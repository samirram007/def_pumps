<nav class=" bg-primary  navbar col-lg-12 col-12 p-0  fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start pl-md-4 pt-2">
        <a class="navbar-brand brand-logo " href="{{ route('superadmin.dashboard') }}">
            <img src="{{ asset('/css/bn/bn-images/logo.png') }}" class="p-1  img-fluid  shadow-md" alt="logo" />
            {{-- <span class="text-white text-uppercase display-5  ml-2">{{env('APP_NAME')}}</span> --}}
        </a>

        <a class="navbar-brand brand-logo-mini" href="{{ route('superadmin.dashboard') }}">
            <img src="{{ asset('/css/bn/bn-images/logo.png') }}" class=" p-1 img-fluid  shadow-md" alt="logo" />
            {{-- <span class="text-white text-uppercase display-5 ml-2 hidden-md">Karm</span> --}}
        </a>

    </div>
    {{-- <div class="bg-dark">

    </div> --}}
    {{-- {{ Session->get('productTypeList')}} --}}
    {{-- @if (!empty(Session::get('productTypeList')))

     @dd(Session::get('productTypeList')[0]['productTypeName'] )
    @endif --}}

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">



        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu text-light"></span>
        </button>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav navbar-nav-right text-light pt-2">
            <li class="nav-item nav-profile dropdown m-0">
                @php
                    $user = App\Http\Controllers\ApiController::user(session()->get('loginid'));
                    if ($user['documents'] != null) {
                        foreach ($user['documents'] as $key => $value) {
                            if ($value['documentTypeId'] == 2) {
                                $user['image'] = env('LIVE_SERVER') . '/upload/UserDoc/' . $value['path'];
                            }
                        }
                    }
                @endphp

                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    {{-- <i class="fas fa-user-circle"></i> --}}
                    {{-- alt text First Letter of Name --}}
                    {{-- @dd($user['image']) --}}

                    <img class="text-capitalize"
                        src="{{ !empty($user['image']) ? $user['image'] : url('upload/no_image.jpg') }}"
                        alt="{{ $user['firstName'][0] }}" />

                </a>

                @include('layouts.partial.profile_dropdown_lg')
            </li>


            <!-- Authentication Links -->
            @php $locale = session()->get('locale'); @endphp
            @php
                $Language = Session::get('Language');
            @endphp
            @if ($Language)
                <li class="nav-item nav-profile dropdown d-none">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @switch($locale)
                            @case('us')
                                <span class="iconify" data-icon="ri:english-input" style="color: #eee;" data-width="20"
                                    data-height="20"></span> {{ __('English') }}
                            @break

                            @case('bn')
                                <span class="iconify" data-icon="" data-width="20" data-height="20">অ<small>আ</small></span>
                            @break

                            @case('in')
                                <span class="iconify" data-icon="uil:letter-hindi-a" style="color: rgb(239, 239, 240);"
                                    data-width="20" data-height="20"></span>
                            @break

                            @default
                                <span class="iconify" data-icon="ri:english-input" style="color: #eee;" data-width="20"
                                    data-height="20"></span> <span class="ml-2"> </span>
                        @endswitch
                        <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown dropdown-menu-right"
                        aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('lang', 'en') }}"><span class="iconify mr-3"
                                data-icon="ri:english-input" style="color: rgb(51, 48, 48);" data-width="20"
                                data-height="20"></span>{{ __('English') }}</a>
                        <a class="dropdown-item  " href="{{ route('lang', 'bn') }}">
                            <span class="iconify mr-3" data-icon="" data-width="20"
                                data-height="20">অ<small>আ</small></span> {{ __('Bangla') }} </a>
                        <a class="dropdown-item" href="{{ route('lang', 'hi') }}"><span class="iconify mr-3"
                                data-icon="uil:letter-hindi-a" style="color: rgb(39, 39, 39);" data-width="20"
                                data-height="20"></span> {{ __('Hindi') }}</a>
                    </div>

                </li>
            @endif
        </ul>
        {{-- <a href="javascript:" class=" btn-sm btn btn-success" onclick="switchDashboard()">Toggle</a> --}}
    </div>


</nav>
