<li class="nav-item  {{ $route == 'pumpadmin.dashboard' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('pumpadmin.dashboard') }}">
        <i class="fas fa-tachometer-alt mr-3"></i>
        <span class="menu-title">{{ __('Dashboard') }} </span>
    </a>
</li>
<li class="nav-item  {{ $route == 'pumpadmin.sales.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('pumpadmin.sales.index') }}">
    <i class="fa fa-shopping-cart mr-3" aria-hidden="true"></i>
        <span class="menu-title">{{ __('Sales') }} </span>
    </a>
</li>
<li class="nav-item  {{ $route == 'pumpadmin.expense.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('pumpadmin.expense.index') }}">
        <i class="fas fa-battery-full mr-3" aria-hidden="true"></i>
        <span class="menu-title">{{ __('Expense') }} </span>
    </a>
</li>
<li class="nav-item  {{ $route == 'pumpadmin.latest_rate' ? 'active' : '' }} script_active"  >

    <a class="nav-link my-2 load-popup" href="javascript:" data-url="{{ route('pumpadmin.latest_rate', $office_id) }}">
        <i class="fa fa-plug mr-3" aria-hidden="true"></i>
        <span class="menu-title">{{ __('Product Rates') }} </span>
    </a>

</li>

<li class="nav-item  {{ $route == 'pumpadmin.user.index' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('pumpadmin.user.index') }}">
        <i class="fas fa-users mr-3"></i>
        <span class="menu-title">{{ __('User') }} </span>
    </a>
</li>
<li class="nav-item {{ $route == 'pumpadmin.support.list' ? 'active' : '' }} ">
    <a href="{{ route('pumpadmin.support.list') }}" class="nav-link my-2">
        <i class="fa fa-user-circle mr-3" ></i>
        <span class="menu-title">{{ __('Support') }} </span>

    </a>
</li>
<li class="nav-item sr-only  {{ $route == 'pumpadmin.map' ? 'active' : '' }} ">
    <a class="nav-link my-2" href="{{ route('pumpadmin.map') }}">
        <i class="fa fa-map-marker mr-3"  ></i>
        <span class="menu-title">{{ __('Locate Pump') }} </span>
    </a>
</li>


