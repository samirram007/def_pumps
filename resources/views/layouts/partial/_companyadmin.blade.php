<li class="nav-item   ">
    <a class="nav-link my-2" href="{{ route('companyadmin.dashboard') }}">
        <i class="fas fa-tachometer-alt mr-3"></i>
        <span class="menu-title">{{ __('Dashboard') }} </span>
    </a>
</li>
<li class="nav-item    ">
    <a class="nav-link my-2" href="{{ route('companyadmin.sales.index') }}">
    <i class="fa fa-shopping-cart mr-3" aria-hidden="true"></i>
        <span class="menu-title">{{ __('Sales') }} </span>
    </a>
</li>
<li class="nav-item    ">
    <a class="nav-link my-2" href="{{ route('companyadmin.expense.index') }}">
        <i class="fas fa-battery-full mr-3" aria-hidden="true"></i>
        <span class="menu-title">{{ __('Expense') }} </span>
    </a>
</li>
<li class="nav-item   ">
    <a class="nav-link my-2" href="{{ route('companyadmin.office.index') }}">
    <i class="fa fa-building mr-3" aria-hidden="true"></i>
        <span class="menu-title">{{ __('Business Entity') }} </span>
    </a>
</li>
<li class="nav-item    ">
    <a class="nav-link my-2" href="{{ route('companyadmin.user.index') }}">
        <i class="fas fa-users mr-3"></i>
        <span class="menu-title">{{ __('User') }} </span>
    </a>
</li>
{{-- @dd(session()->get('masterOfficeId')) --}}
@if(session()->get('masterOfficeId') == null)
{{-- <li class="nav-item  {{ $route == 'companyadmin.product' ? 'active' : '' }} script_active ">

    <a class="nav-link my-2 load-popup" href="javascript:" data-url="{{ route('companyadmin.product', $office_id) }}">
        <i class="fa fa-plug mr-3" aria-hidden="true"></i>
        <span class="menu-title">{{ __('Product') }} </span>
    </a>

</li> --}}
<li class="nav-item   script_active  ">

    <a class="nav-link my-2 " href="{{ route('companyadmin.product', $office_id) }}">
        <i class="fa fa-plug mr-3" aria-hidden="true"></i>
        <span class="menu-title">{{ __('Product') }} </span>
    </a>

</li>
@endif
<li class="nav-item   ">
    <a href="{{ route('companyadmin.support.list') }}" class="nav-link my-2">
        <i class="fa fa-user-circle mr-3" ></i>
        <span class="menu-title">{{ __('Support') }} </span>

    </a>
</li>
<li class="d-none nav-item    ">
    <a class="nav-link my-2" href="{{ route('companyadmin.project.index') }}">
        <i class="fas fa-users mr-3"></i>
        <span class="menu-title">{{ __('Project') }} </span>
    </a>
</li>
<li class="d-none nav-item    ">
    <a class="nav-link my-2" href="{{ route('companyadmin.report') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">{{ __('Report') }} </span>
    </a>
</li>
<li class="nav-item    ">
    <a class="nav-link my-2" href="{{ route('companyadmin.map') }}">
        <i class="fa fa-map-marker mr-3"  ></i>
        <span class="menu-title">{{ __('Locate Pump') }} </span>
    </a>
</li>
<li class="nav-item     ">
    <a class="nav-link my-2" href="{{ route('companyadmin.delivery_plan') }}">
        <i class="fa fa-map-marker mr-3"  ></i>
        <span class="menu-title">{{ __('Delivery Plan') }} </span>
    </a>
</li>
<li class="nav-item     ">
    <a class="nav-link my-2" href="{{ route('companyadmin.calculator') }}">
        <i class="fa fa-calculator mr-3"  ></i>
        <span class="menu-title">{{ __('ROI Calculator') }} </span>
    </a>
</li>
