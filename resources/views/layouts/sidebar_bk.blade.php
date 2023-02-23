@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
$user_id=Session::get('loginid');

//$userType = Session::get('user_data')['user_type'];

// if (str_contains($prefix, 'employee')) {
//     $guard = 'employee';
// }
// $user = DB::table($guard . 's')
//     ->where('id', Auth::guard($guard)->user()->id)
//     ->first();
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">


    <ul class="nav">
        @if ($prefix == '/superadmin')
            <li class="nav-item {{ $route == 'superadmin.dashboard' ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">{{ __('Dashboard') }} </span>
                </a>
            </li>
            <li class="nav-item {{ $route == 'superadmin.master_office.index' ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('superadmin.master_office.index') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">{{ __('Organization') }} </span>
                </a>
            </li>
            <li class="nav-item {{ $route == 'superadmin.user.index' ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('superadmin.user.index') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">{{ __('User') }} </span>
                </a>
            </li>
            
        @elseif($prefix == '/admin')
            <li class="nav-item {{ $route == 'admin.dashboard' ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">{{ __('Dashboard') }} </span>
                </a>
            </li>
            <li class="nav-item {{ $route == 'admin.office.index' ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('admin.office.index') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">{{ __('Office') }} </span>
                </a>
            </li>
            <li class="nav-item {{ $route == 'admin.user.index' ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('admin.user.index') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">{{ __('User') }} </span>
                </a>
            </li>
            <li class="nav-item {{ $route == 'admin.report' ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('admin.report') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">{{ __('Report') }} </span>
                </a>
            </li>
        @endif
        <li class="border-top my-3"></li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">
                <i class="ti-power-off menu-icon"></i>

                <span class="menu-title">{{ __('Log Out') }}</span>
            </a>
            {{-- onclick="event.preventDefault(); this.closest('form').submit();">
            <form class="p-0 text-left" method="POST" action="{{ route('admin.logout') }}">
                @csrf
                  </form> --}}


        </li>
    </ul>

</nav>
