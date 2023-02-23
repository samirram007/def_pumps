<li class="nav-item border-bottom {{ $route == 'admin.dashboard' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-tachometer-alt mr-3"></i>
        <span class="menu-title">{{ __('Dashboard') }} </span>
    </a>
</li>
<li class="nav-item border-bottom {{ $route == 'admin.sales.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('admin.sales.index') }}">
        <i class="fas fa-briefcase mr-3"></i>
        <span class="menu-title">{{ __('Sales') }} </span>
    </a>
</li>
<li class="nav-item border-bottom {{ $route == 'admin.expense.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('admin.expense.index') }}">
        <i class="fas fa-briefcase mr-3"></i>
        <span class="menu-title">{{ __('Expense') }} </span>
    </a>
</li>
<li class="nav-item border-bottom {{ $route == 'admin.office.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('admin.office.index') }}">
        <i class="fas fa-briefcase mr-3"></i>
        <span class="menu-title">{{ __('Office') }} </span>
    </a>
</li>
<li class="nav-item border-bottom {{ $route == 'admin.user.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('admin.user.index') }}">
        <i class="fas fa-users mr-3"></i>
        <span class="menu-title">{{ __('User') }} </span>
    </a>
</li>
<li class="d-none nav-item border-bottom {{ $route == 'admin.project.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('admin.project.index') }}">
        <i class="fas fa-users mr-3"></i>
        <span class="menu-title">{{ __('Project') }} </span>
    </a>
</li>
<li class="d-none nav-item border-bottom {{ $route == 'admin.report' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('admin.report') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">{{ __('Report') }} </span>
    </a>
</li>
