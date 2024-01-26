<div class="row mb-2 justify-content-between align-items-center">
    <div class="col-md-6">
        <h4 class="m-0 text-dark">{{ __('Pump') }}</h4>
        <ol class="breadcrumb  border-0 p-0 m-0">
            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                    class="text-active">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item "><a href="{{ route('companyadmin.office.index') }}"
                    class="text-active">{{ __('Business Entity') }}</a></li>
            <li class="breadcrumb-item active ">{{ __('New Pump') }}</li>
        </ol>

    </div>
    <div class="col-md-6  ">

        <div class=" d-flex  justify-content-end" style="right:0;top:0;">
            <a href="{{ route('companyadmin.wizard.index') }}" title="{{ __('New Pump') }}"
                class="sr-only d-none {{ env('APP_ENV') == 'local' ? 'load-wizard  btn btn-rounded animated-shine disabled px-2 mb-2 ' : 'sr-only' }} ">
                {{ __('New Pump') }}</a>
            {{-- <a href="javascript:" data-param="" data-size=""
                data-url="{{ route('companyadmin.wizard.modal', 'modal') }}"
                title="{{ __('New Pump') }}"
                class="{{ env('APP_ENV')=='local'?'load-wizard  btn btn-rounded animated-shine px-2 mb-2 ':'sr-only' }} ">
                {{ __('New Pump') }}</a> --}}
            <a href="{{ route('companyadmin.office.index') }}" title="{{ __('Business Entities') }}"
                class="  btn btn-rounded animated-shine px-2 mb-2 ">
                {{ __('Business Entities') }}</a>
        </div>
    </div>
</div>
