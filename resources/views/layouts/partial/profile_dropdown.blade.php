<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
    {{-- route exists --}}
    @if (Route::has(session()->get('routeRole') . '.user.profile'))
        <a class="dropdown-item"
            href="{{ route(session()->get('routeRole') . '.user.profile', session()->get('loginid')) }}">
            <i class=" fas fa-user text-primary"></i>
            {{ $user['firstName'] }} {{ $user['surName'] }} {{ __('\'s Profile') }}
        </a>
    @endif

    {{-- @if ($user['roleName'] == 'SuperAdmin')
        <a class="dropdown-item"
            href="{{ route('superadmin.user.profile', session()->get('loginid')) }}">
            <i class=" fas fa-user text-primary"></i>
            {{ $user['firstName'] }} {{ $user['surName'] }} {{__('\'s Profile')}}
        </a>
    @elseif ($user['roleName'] == 'CompanyAdmin' || $user['roleName'] == 'companyadmin')
        <a class="dropdown-item" href="{{ route('companyadmin.user.profile', session()->get('loginid')) }}">
            <i class="fas fa-user text-primary"></i>
            {{ $user['firstName'] }} {{ $user['surName'] }} {{__('\'s Profile')}}
        </a>
    @elseif ($user['roleName'] == 'PumpUser')
        <a class="dropdown-item" href="{{ route('user.profile', session()->get('loginid')) }}">
            <i class="ti-settings text-primary"></i>
            {{ $user['firstName'] }} {{ $user['surName'] }} {{__('\'s Profile')}}
        </a>
    @endif --}}
    <a class="dropdown-item" href="javascript:">
        <div class="lights-toggle">
            <input id="lights-toggle" type="checkbox" name="lights-toggle" class="switch" checked="checked">
            <label for="lights-toggle" class="text-xs"><span>Turn me <span class="label-text">dark</span></span></label>
        </div>
    </a>

    @if (session()->has('isSuperAdmin') && session()->get('isSuperAdmin') && session()->get('roleName') != 'superadmin')
        <a href="{{ route('switchmode', session()->get('superAdminId')) }}" class="dropdown-item">
            <i class="fa fa-user-circle mr-3"></i>
            <span class="menu-title">{{ __('Exit User') }} </span>

        </a>
    @else
        <a class="dropdown-item" href="{{ route('logout') }}">
            <i class="ti-power-off text-primary"></i>
            {{ __('Logout') }}
        </a>
    @endif
</div>
