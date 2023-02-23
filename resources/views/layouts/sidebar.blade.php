@php
//$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
$user_id=Session::get('loginid');
$roleName=Session::get('roleName');
$office_id=Session::get('officeId');
// dd(Session::get('userData'));
$prefix=$roleName;

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

{{-- @dd($prefix) --}}
    <ul class="nav">
        @if ($prefix == 'superadmin' || $prefix == '/superadmin')
           @include('layouts.partial._superadmin')

        @elseif($prefix == 'companyadmin' || $prefix == '/companyadmin')
           @include('layouts.partial._companyadmin')

        @elseif($prefix == 'pumpadmin' || $prefix == '/pumpadmin' )
           @include('layouts.partial._pumpadmin')

        @elseif($prefix == 'pumpuser' || $prefix == '/pumpuser')
           @include('layouts.partial._pumpuser')

        @endif

        <li class="nav-item">
            <a class="nav-link my-2 " href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt mr-3"></i>

                <span class="menu-title">{{ __('Log Out') }}</span>
            </a>
            {{-- onclick="event.preventDefault(); this.closest('form').submit();">
            <form class="p-0 text-left" method="POST" action="{{ route('companyadmin.logout') }}">
                @csrf
                  </form> --}}


        </li>
    </ul>

</nav>
