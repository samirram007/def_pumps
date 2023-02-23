<div class="col-xl-4 col-lg-4 col-md-4">
    {{-- @dd($admin_dashboard_data) --}}
    <a href="{{ route('pumpadmin.user.index') }}">
        <div class="card-anim l-bg-skyblue">

            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large w-100 d-flex justify-content-between"><i class="fas fa-users"></i><i
                        class="fas fa-building mr-5"></i></div>
                <div class="mb-4">
                    <h5 class="card-title mb-0"></h5>
                </div>
                <div class="row justify-content-between mb-2 d-flex">
                    <div class="col-6">

                        <h5 class="d-flex align-items-center mb-0">
                            {{ __('Users') }}
                        </h5>
                        <span class="d-block ">

                            @if ($admin_dashboard_data->userCount != null)
                                @foreach ($admin_dashboard_data->userCount as $user)
                                    <div> {{ $user['roleName'] }} : {{ $user['userCount'] }}</div>
                                @endforeach
                            @else
                                {{ 0 }}
                            @endif
                            {{-- <i class="fa fa-arrow-up"></i> --}}
                        </span>
                    </div>
                    <div class="col-6 d-none">
                        <div class="d-flex justify-content-end  flex-column align-items-end">
                            <h5 class="d-flex align-items-center mb-0">
                                {{ __('Business Entities') }}
                            </h5>
                            <span class="d-block ">
                                @if ($admin_dashboard_data->officeCount != null)
                                    @foreach ($admin_dashboard_data->officeCount as $office)
                                        <div>{{ $office['officeTypeName'] }} : {{ $office['officeCount'] }}</div>
                                    @endforeach
                                @else
                                    {{ 0 }}
                                @endif
                                {{-- <i  class="fa fa-arrow-up"></i> --}}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="progress mt-1  d-none" data-height="8" style="height: 8px;">
                    <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                    </div>
                </div>
            </div>

        </div>
    </a>
</div>
<div class="col-xl-4 col-lg-4 col-md-4">
    <a href="{{ route('pumpadmin.sales.index') }}">
        <div class="card-anim l-bg-grey-light">
            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart" aria-hidden="true"></i></div>
                <div class="mb-4">
                    <h6 class="card-title mb-0 text-right"><small>{{ __('last 7 day\'s update') }}</small> </h6>
                </div>
                <div class="row align-items-center mb-2 d-flex">
                    <div class="col-4 justify-content-start">
                        <h5 class="d-flex align-items-center mb-0 ">
                            {{ __('Sales') }}
                        </h5>
                    </div>
                    <div class="col-3 text-right">
                        <span class="">{{ $admin_dashboard_data->incomeDetails['count'] }} <i
                                class="fa fa-arrow-up"></i></span>
                    </div>
                    <div class="col-5 text-right">
                        <span
                            class="">{{ number_format($admin_dashboard_data->incomeDetails['total'], 2, '.', '') }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                </div>
                <div class="progress mt-1  d-none " data-height="8" style="height: 8px;">
                    <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100" style="width: 25%;">

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-4 col-lg-4 col-md-4 ">
    <a href="{{ route('pumpadmin.expense.index') }}">
        <div class="card-anim l-bg-grey-dark">
            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-battery-full" aria-hidden="true"></i></div>
                <div class="mb-4">
                    <h6 class="card-title mb-0 text-right"> <small> {{ __('last 7 days update') }}</small></h6>
                </div>
                <div class="row align-items-center mb-2 d-flex">
                    <div class="col-4 justify-content-start">
                        <h5 class="d-flex align-items-center mb-0 ">
                            {{ __('Expense') }}
                        </h5>
                    </div>
                    <div class="col-3 text-right">
                        <span class="">{{ $admin_dashboard_data->expenseDetails['count'] }} <i
                                class="fa fa-arrow-up"></i></span>
                    </div>
                    <div class="col-5 text-right">
                        <span
                            class="">{{ number_format($admin_dashboard_data->expenseDetails['total'], 2, '.', '') }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                </div>
                <div class="progress mt-1 d-none " data-height="8" style="height: 8px;">
                    <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
