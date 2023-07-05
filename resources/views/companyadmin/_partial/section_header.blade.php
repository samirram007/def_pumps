<div class="col-xl-3 col-lg-3 col-md-3">
    <a href="{{ route('companyadmin.user.index') }}">
        <div class="card-anim l-bg-skyblue">
            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                <div class="mb-4 d-flex justify-content-start">
                    <h5>{{ __('Users') }}</h5>
                </div>
                <div class="row align-items-start mb-2 justify-content-between flex-column pl-3">


                    @if ($admin_dashboard_data['userCount'] != null)
                        @foreach ($admin_dashboard_data['userCount'] as $user)
                            <div><span class=" text-nowrap"><small>{{ $user['roleName'] }} :
                                        {{ $user['userCount'] }}</small></span></div>
                        @endforeach
                    @else
                        {{ 0 }}
                    @endif



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
<div class="col-xl-3 col-lg-3 col-md-3">
    <a href="{{ route('companyadmin.office.index') }}">
        <div class="card-anim l-bg-teal">
            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large d-flex justify-content-end"> <i class="fas fa-handshake"></i>
                </div>
                <div class="mb-4 d-flex justify-content-start">
                    <h5> {{ __('Business Entities') }}</h5>
                </div>
                <div class="row align-items-start mb-2 justify-content-between flex-column pl-3">


                    @if ($admin_dashboard_data['officeCount'] != null)
                        @foreach ($admin_dashboard_data['officeCount'] as $office)
                            <div><span class=" text-nowrap"><small>
                                        <span>{{ $office['officeTypeName'] }} </span>

                                        :
                                        {{ $office['officeCount'] }}</small></span></div>
                        @endforeach
                    @else
                        {{ 0 }}
                    @endif
                </div>
            </div>



            <div class="progress mt-1  d-none" data-height="8" style="height: 8px;">
                <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25"
                    aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-xl-3 col-lg-3 col-md-3 sales-tablet">
    <a href="{{ route('companyadmin.sales.index') }}">
        <div class="card-anim l-bg-grey-light">
            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart" aria-hidden="true"></i></div>
                <div class="mb-4 d-flex justify-content-start">
                    <h5 class="w-100">{{ __('Sales') }}
                        <div class="progress mt-1   " data-height="2" style="height: 2px; display:none;">
                            <div class="progress-bar l-bg-orange" role="progressbar" data-width="100%"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            </div>
                        </div>
                    </h5>
                </div>
                <div class="row align-items-start mb-2 justify-content-between px-3 day-7">
                    <div>
                        <h6 class="card-title mb-0 text-right "><small>{{ __('Last 7 day\'s update') }}</small> </h6>
                    </div>
                    <div>
                        {{-- @dd( $admin_dashboard_data['incomeDetails'] ) --}}
                        <span
                            class="">{{ $admin_dashboard_data == null ? 0 : $admin_dashboard_data['incomeDetails']['count'] }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                    <div>
                        <span
                            class="">{{ number_format($admin_dashboard_data == null ? 0 : $admin_dashboard_data['incomeDetails']['total'], 2, '.', '') }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                </div>

                <div class="row align-items-start mb-2 justify-content-between px-3   day-0">
                    <div>
                        <h6 class="card-title mb-0 text-right ">
                            <small>{{ __('Today\'s update') }}</small>
                        </h6>
                    </div>
                    <div>
                        {{-- @dd( $admin_dashboard_data['incomeDetails'] ) --}}
                        <span class="">
                            {{ $admin_dashboard_data == null ? 0 : $admin_dashboard_data['incomeDetailsCurrentDay']['count'] }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                    <div>
                        <span
                            class="">{{ number_format($admin_dashboard_data == null ? 0 : $admin_dashboard_data['incomeDetailsCurrentDay']['total'], 2, '.', '') }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                </div>

            </div>
        </div>
    </a>
</div>
<script>
    $(document).ready(function() {
        $('.day-7').show();
        $('.day-0').hide();
        $('.sales-tablet').on('mouseover', function() {
            //horizotal progress bar
            $('.sales-tablet .progress .progress-bar').css('width', '0');
            $('.sales-tablet .progress').show();
            let width = 0;
            const timer = setInterval(() => {
                $('.sales-tablet .progress .progress-bar').css('width', width + '%');
                width += 20;
                if (width > 100) {
                    width = 0;
                    clearInterval(timer);
                    const visible = setTimeout(() => {
                        $('.sales-tablet .progress').hide();
                        $('.sales-tablet .day-7').hide();
                        $('.sales-tablet .day-0').show();

                    }, 100);
                }
            }, 100);



        });
        $('.sales-tablet').on('mouseout', function() {
            //horizotal progress bar
            $('.sales-tablet .progress .progress-bar').css('width', '0');
            $('.sales-tablet .progress').show();
            let width = 0;
            const timer = setInterval(() => {
                $('.sales-tablet .progress .progress-bar').css('width', width + '%');
                width += 20;
                if (width > 100) {
                    width = 0;
                    clearInterval(timer);
                    const visible = setTimeout(() => {
                        $('.sales-tablet .progress').hide();
                        $('.sales-tablet .day-7').show();
                        $('.sales-tablet .day-0').hide();

                    }, 100);
                }
            }, 100);

        });

    });
</script>
<div class="col-xl-3 col-lg-3 col-md-3 expense-tablet">
    <a href="{{ route('companyadmin.expense.index') }}">
        <div class="card-anim l-bg-grey-dark">
            <div class="card-statistic-3 p-4">
                <div class="card-icon card-icon-large"><i class="fas fa-battery-full" aria-hidden="true"></i></div>
                <div class="mb-4 d-flex justify-content-start ">
                    <h5 class="w-100">{{ __('Expense') }}
                        <div class="progress mt-1   " data-height="2" style="height: 2px; display:none;">
                            <div class="progress-bar l-bg-orange" role="progressbar" data-width="100%"
                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            </div>
                        </div>
                    </h5>
                </div>
                <div class="row align-items-center mb-2 justify-content-between px-3 day-7">
                    <div>
                        <h6 class="card-title mb-0 text-right  "> <small>
                                {{ __('Last 7 day\'s update') }}</small></h6>
                    </div>
                    <div>
                        <span
                            class="">{{ $admin_dashboard_data == null ? 0 : $admin_dashboard_data['expenseDetails']['count'] }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                    <div>
                        <span
                            class="">{{ number_format($admin_dashboard_data == null ? 0 : $admin_dashboard_data['expenseDetails']['total'], 2, '.', '') }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                </div>
                <div class="row align-items-center mb-2 justify-content-between px-3 day-0">
                    <div>
                        <h6 class="card-title mb-0 text-right "> <small>
                                {{ __('Today\'s update') }}</small></h6>
                    </div>
                    <div>
                        <span
                            class="">{{ $admin_dashboard_data == null ? 0 : $admin_dashboard_data['expenseDetailsCurrentDay']['count'] }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                    <div>
                        <span
                            class="">{{ number_format($admin_dashboard_data == null ? 0 : $admin_dashboard_data['expenseDetailsCurrentDay']['total'], 2, '.', '') }}
                            <i class="fa fa-arrow-up"></i></span>
                    </div>
                </div>

            </div>
        </div>
    </a>
</div>

<script>
    $(document).ready(function() {
        $('.day-7').show();
        $('.day-0').hide();
        $('.expense-tablet').on('mouseover', function() {
            //horizotal progress bar
            $('.expense-tablet .progress .progress-bar').css('width', '0');
            $('.expense-tablet .progress').show();
            let width = 0;
            const timer = setInterval(() => {
                $('.expense-tablet .progress .progress-bar').css('width', width + '%');
                width += 20;
                if (width > 100) {
                    width = 0;
                    clearInterval(timer);
                    const visible = setTimeout(() => {
                        $('.expense-tablet .progress').hide();
                        $('.expense-tablet .day-7').hide();
                        $('.expense-tablet .day-0').show();

                    }, 100);
                }
            }, 100);



        });
        $('.expense-tablet').on('mouseout', function() {
            //horizotal progress bar
            $('.expense-tablet .progress .progress-bar').css('width', '0');
            $('.expense-tablet .progress').show();
            let width = 0;
            const timer = setInterval(() => {
                $('.expense-tablet .progress .progress-bar').css('width', width + '%');
                width += 20;
                if (width > 100) {
                    width = 0;
                    clearInterval(timer);
                    const visible = setTimeout(() => {
                        $('.expense-tablet .progress').hide();
                        $('.expense-tablet .day-7').show();
                        $('.expense-tablet .day-0').hide();

                    }, 100);
                }
            }, 100);

        });

    });
</script>
