@php
    //$prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
//dd($route);

    $user_id = Session::get('loginid');
    $roleName = Session::get('roleName');
    $office_id = Session::get('officeId');
    // dd(Session::get('userData'));
    $prefix = $roleName;

    //$userType = Session::get('user_data')['user_type'];

    // if (str_contains($prefix, 'employee')) {
    //     $guard = 'employee';
    // }
    // $user = DB::table($guard . 's')
    //     ->where('id', Auth::guard($guard)->user()->id)
    //     ->first();

@endphp
{{-- @dd($roleName) --}}
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    {{-- <div style="position:absolute; width:3.7rem; background:#fdfd22;min-height: calc(100vh - 60px);">

    </div> --}}

    {{-- @dd($prefix) --}}
    <ul class="nav">
        @if ($prefix == 'superadmin' || $prefix == '/superadmin')
            @include('layouts.partial._superadmin')
        @elseif($prefix == 'companyadmin' || $prefix == '/companyadmin')
            @include('layouts.partial._companyadmin')
        @elseif($prefix == 'pumpadmin' || $prefix == '/pumpadmin')
            @include('layouts.partial._pumpadmin')
        @elseif($prefix == 'pumpuser' || $prefix == '/pumpuser')
            @include('layouts.partial._pumpuser')
        @endif
        {{-- @dd(session()->get('sessionUserIds')) --}}

        {{-- @php
            print_r(session()->has('sessionUserIds') ? session()->get('sessionUserIds') : ['no ids']);
        @endphp --}}

        @if (session()->has('isSuperAdmin') && session()->get('isSuperAdmin') && session()->get('roleName') != 'superadmin')

            @if (session()->has('sessionUserIds') && session()->get('sessionUserIds') != null)
                <li class="nav-item   ">
                    <a href="{{ route('switchmode', 'none') }}" class="nav-link my-2">
                        <i class="fa fa-arrow-left mr-3" aria-hidden="true"></i>
                        <span class="menu-title">{{ __('Previous User') }} </span>

                    </a>
                </li>
                {{-- @dd(session()->get('sessionUserIds')) --}}
            @endif
            <li class="nav-item  ">
                <a href="{{ route('switchmode', session()->get('superAdminId')) }}" class="nav-link my-2">
                    <i class="fa fa-power-off mr-3"></i>
                    <span class="menu-title">{{ __('Exit User') }} </span>

                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link my-2 " href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt mr-3"></i>

                    <span class="menu-title">{{ __('Log Out') }}</span>
                </a>


            </li>
        @endif

    </ul>

</nav>
