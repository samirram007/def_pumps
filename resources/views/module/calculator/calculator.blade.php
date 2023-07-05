@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('ROI Calculator') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('ROI Calculator') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>
        <div class="container-fluid">
            <section id="roi_calculator">
                <div class="card">
                    <div class="card-body px-1">
                        <div class="col-12">
                            <div class="row pb-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="investment_amount">{{ __('Investment Amount') }} <span
                                                class="text-danger">*</span>
                                            <input type="text" class="form-control" name="investment_amount"
                                                id="investment_amount"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); $('#investment_amount-error').html('');"
                                                value="150000" onkeydown=" calc();">
                                            <span id="investment_amount-error" class="text-danger"></span> </label>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bank_fd_rate">{{ __('Bank FD Rate') }}</label>
                                        <div class="range-slider">
                                            <span class="pt-1 mr-1">4</span>
                                            <input type="range" class="form-range" id="bank_fd_rate" value="4"
                                                min="4" max="10" step="1">
                                            <span class="ml-2 pt-1 slider-max">10 </span>
                                            <span id="bank_fd_rate-bullet" class="rs-label">4</span>
                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="time_frame"> {{ __('Time Frame (months)') }}</label>
                                        <div class="range-slider">
                                            <span class="pt-1 mr-1">12</span>
                                            <input type="range" class="form-range" id="time_frame" value="12"
                                                min="12" max="60" step="6">
                                            <span class="ml-2 pt-1 slider-max">60</span>
                                            <span id="time_frame-bullet" class="rs-label">12</span>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="row py-4">
                                <div class="col-md-4">
                                    <div class="form-group-inline">
                                        <div for="interest_amount">{{ __('Interest Amtount (monthly)') }}</div>
                                        <div> <input type="text" class="d-inline-block  sp" id="interest_amount"
                                                readonly></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-inline">
                                        <div for="roi">{{ __('ROI(monthly)') }}</div>
                                        <div> <input type="text" class="d-inline-block sp" id="roi" readonly></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-inline">
                                        <div for="monthly_profit">{{ __('Monthly Profit') }}</div>
                                        <div> <input type="text" class="  d-inline-block sp" id="monthly_profit"
                                                readonly></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profit_rate">{{ __('Profit Rate per litre') }}</label>
                                        <div class="range-slider">
                                            <span class="pt-1 mr-1">2</span>
                                            <input type="range" class="form-range" id="profit_rate" value="2"
                                                min="2" max="15" step="1">
                                            <span class="ml-2 pt-1 slider-max">15</span>
                                            <span id="profit_rate-bullet" class="rs-label">2</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="profit_rate">{{ __('Rate of DEF') }}</label>
                                        <div class="range-slider">
                                            <span class="pt-1 mr-1">50</span>
                                            <input type="range" class="form-range" id="rate_def" value="50"
                                                min="50" max="70" step="1">
                                            <span class="ml-2 pt-1 slider-max">70</span>
                                            <span id="rate_def-bullet" class="rs-label">50</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-4">
                                <div class="col-md-4">
                                    <div class="form-group-inline">
                                        <div>{{ __('Sale(in Litre) need to achieve (monthly)') }} </div>

                                        <div> <input type="text" class=" sp" id="sale_qty_monthly" readonly> </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group-inline">
                                        <div> {{ __('Sale(in Litre) need to achieve (daily)') }}</div>
                                        <div> <input type="text" class=" sp" id="sale_qty_daily" readonly> </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group-inline">
                                        <div>{{ __('Sale(in Amt) need to achieve (daily)') }} </div>
                                        <div> <input type="text" class="  sp" id="sale_amount_daily" readonly></div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12  d-none justify-content-center calculate-btn">
                        <button class="btn btn-primary calculate  ">{{ __('Calculate') }}</button>
                    </div>
                    <div class="text-info">
                        ***ROI:- Return of Investment
                    </div>
                </div>
        </div>
    </div>


    </section>
    </div>
    <script>
        var bank_fd_rate_slider = document.getElementById("bank_fd_rate");
        bank_fd_rate_slider.addEventListener("input", show_bank_fd_rateValue, false);
        var range_bank_fd_rateBullet = document.getElementById("bank_fd_rate-bullet");


        function show_bank_fd_rateValue() {
            range_bank_fd_rateBullet.innerHTML = bank_fd_rate_slider.value;
            var bulletPosition = (bank_fd_rate_slider.value / bank_fd_rate_slider.max);
            var pixelPostion = bank_fd_rate_slider.clientWidth * bulletPosition;
            calc();
            //range_bank_fd_rateBullet.style.left = pixelPostion + "px";
            //ShowFilteredPumps();

        }

        var time_frame_slider = document.getElementById("time_frame");
        time_frame_slider.addEventListener("input", show_time_frameValue, false);
        var range_time_frameBullet = document.getElementById("time_frame-bullet");

        function show_time_frameValue() {
            range_time_frameBullet.innerHTML = time_frame_slider.value;
            var bulletPosition = (time_frame_slider.value / time_frame_slider.max);
            var pixelPostion = time_frame_slider.clientWidth * bulletPosition;
            calc();
            //  range_time_frameBullet.style.left = pixelPostion + "px";
            //ShowFilteredPumps();

        }

        var profit_rate_slider = document.getElementById("profit_rate");
        profit_rate_slider.addEventListener("input", show_profit_rateValue, false);
        var range_profit_rateBullet = document.getElementById("profit_rate-bullet");

        function show_profit_rateValue() {
            range_profit_rateBullet.innerHTML = profit_rate_slider.value;
            var bulletPosition = (profit_rate_slider.value / profit_rate_slider.max);
            var pixelPostion = profit_rate_slider.clientWidth * bulletPosition;
            calc();
            // range_profit_rateBullet.style.left = pixelPostion + "px";
            //ShowFilteredPumps();

        }

        var rate_def_slider = document.getElementById("rate_def");
        rate_def_slider.addEventListener("input", show_rate_defValue, false);
        var range_rate_defBullet = document.getElementById("rate_def-bullet");

        function show_rate_defValue() {
            range_rate_defBullet.innerHTML = rate_def_slider.value;
            var bulletPosition = (rate_def_slider.value / rate_def_slider.max);
            var pixelPostion = rate_def_slider.clientWidth * bulletPosition;

            calc();

            //  range_rate_defBullet.style.left = pixelPostion+ "px";
            //ShowFilteredPumps();

        }
    </script>
    <script>
        const investment_amount = $('#investment_amount');
        const bank_fd_rate = $('#bank_fd_rate');

        const time_frame = $('#time_frame');
        const interest_amount = $('#interest_amount');
        const roi = $('#roi');
        const monthly_profit = $('#monthly_profit');
        const profit_rate = $('#profit_rate');
        const rate_def = $('#rate_def');
        const sale_qty_monthly = $('#sale_qty_monthly');
        const sale_qty_daily = $('#sale_qty_daily');
        const sale_amount_daily = $('#sale_amount_daily');



        $(document).ready(function() {
            $('.calculate').on('click', function() {
                calc();

            });

        });
        let calc = () => {
            let investment_amount_val = investment_amount.val();
            if (investment_amount_val == '' || investment_amount_val < 1) {
                $('#investment_amount-error').html("Please enter valid amount");
            }
            let bank_fd_rate_val = bank_fd_rate.val();
            let time_frame_val = time_frame.val();
            let profit_rate_val = profit_rate.val();
            let rate_def_val = rate_def.val();

            let interest_amount_val = (investment_amount_val * bank_fd_rate_val * (time_frame_val /
                12) / 100) / time_frame_val;
            let roi_val = investment_amount_val / time_frame_val;
            let monthly_profit_val = roi_val + interest_amount_val;

            let sale_qty_monthly_val = monthly_profit_val / profit_rate_val;
            let sale_qty_daily_val = sale_qty_monthly_val / 30;
            let sale_amount_daily_val = sale_qty_daily_val * rate_def_val;
            interest_amount.val(interest_amount_val.toFixed(0));
            roi.val(roi_val.toFixed(0));
            monthly_profit.val(monthly_profit_val.toFixed(0));
            sale_qty_monthly.val(sale_qty_monthly_val.toFixed(0));
            sale_qty_daily.val(sale_qty_daily_val.toFixed(0));
            sale_amount_daily.val(sale_amount_daily_val.toFixed(0));
        }
        calc();
    </script>
    <style>
        #roi_calculator .form-control:disabled,
        #roi_calculator .form-control[readonly] {
            background-color: rgba(0, 0, 0, 0);
            opacity: 1;
            border: none;
            outline: none;
        }

        #roi_calculator .form-group-inline {
            display: flex;
            width: 100%;
        }

        #roi_calculator .form-group-inline div:first-child {
            width: 70%;
            font-size: 0.8rem;
        }

        #roi_calculator .form-group-inline div:last-child {
            width: 30%;
            font-size: 0.8rem;
        }

        .sp {
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            text-align: right;
            outline: none;
            border: none;
            align-self: flex-end;
        }

        #roi_calculator label {
            width: 100%;
        }

        .form-range {
            width: 80%;
            height: 1.5rem;
            padding: 0;
            border-radius: 10px;
            background-color: #56708a4b;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .range-slider {
            display: flex;
            justify-content: center;
            position: relative;
            margin-bottom: 20px;
        }

        .form-range::-webkit-slider-thumb {
            box-shadow: none;
            border: 0px solid #085750;
            box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.25);
            height: 42px;
            width: 22px;
            border-radius: 22px;
            background: #467f87;
            cursor: pointer;
            -webkit-appearance: none;
            z-index: 100;
            margin-top: -1px;
        }

        .rs-label {
            position: absolute;
            transform-origin: center center;
            display: block;
            width: 65px;
            height: 18px;
            background: transparent;
            border-radius: 50%;
            line-height: 30px;
            text-align: center;
            font-weight: bold;
            padding-top: 0px;
            box-sizing: border-box;
            border: 2px solid rgba(161, 138, 138, 0);
            margin-top: 34px;
            margin-left: 0px;
            left: attr(value);
            color: rgb(41, 38, 38);
            font-style: normal;
            font-weight: normal;
            line-height: normal;
            font-size: 0.85rem;
        }

        .rs-label::after {
            content: "";
            display: block;
            font-size: 12px;
            letter-spacing: 0.07em;
            margin-top: -2px;
        }
    </style>
    </div>
@endsection
