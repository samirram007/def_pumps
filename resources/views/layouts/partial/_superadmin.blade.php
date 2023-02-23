<li class="nav-item border-bottom {{ $route == 'superadmin.dashboard' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('superadmin.dashboard') }}">
        <i class="fas fa-tachometer-alt mr-3"></i>
        <span class="menu-title">{{ __('Dashboard') }} </span>
    </a>
</li>
<li class="nav-item border-bottom {{ $route == 'superadmin.master_office.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('superadmin.master_office.index') }}">
        <i class="fas fa-briefcase mr-3"></i>
        <span class="menu-title">{{ __('Top Company') }} </span>
    </a>
</li>
<li class="nav-item {{ $route == 'superadmin.support.list' ? 'active' : '' }} ">
    <a href="{{ route('superadmin.support.list') }}" class="nav-link my-2">
        <i class="fa fa-user-circle mr-3" ></i>
        <span class="menu-title">{{ __('Support') }} </span>

    </a>
</li>
{{-- <li class="nav-item border-bottom {{ $route == 'superadmin.user.index' ? 'active' : '' }} ">
    <a class="nav-link my-2  " href="{{ route('superadmin.user.index') }}">
        <i class="fas fa-users mr-3"></i>
        <span class="menu-title">{{ __('User') }} </span>
    </a>
</li> --}}
