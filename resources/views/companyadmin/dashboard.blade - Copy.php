@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center p-3">
            <div class="col-md-12 ">
                <div class="row ">

                    <div class="col-xl-3 col-lg-6">
                        <a href="{{ route('admin.user.index') }}">
                            <div class="card-anim l-bg-cherry">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0"></h5>
                                    </div>
                                    <div class="row justify-content-between mb-2 d-flex">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                Users
                                            </h2>
                                        </div>
                                        <div class="col-4 text-right">

                                            <span class="">{{ $admin_dashboard_data->userCount }} <i class="fa fa-arrow-up"></i></span>
                                        </div>
                                    </div>
                                    <div class="progress mt-1  d-none" data-height="8" style="height: 8px;">
                                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <a href="{{ route('admin.office.index') }}">
                            <div class="card-anim l-bg-orange-dark">
                                <div class="card-statistic-3 p-4">
                                    <div class="card-icon card-icon-large"><i class="fas fa-building"></i></div>
                                    <div class="mb-4">
                                        <h5 class="card-title mb-0"></h5>
                                    </div>
                                    <div class="row align-items-center mb-2 d-flex">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                Offices
                                            </h2>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="">{{ $admin_dashboard_data->officeCount }}<i class="fa fa-arrow-up"></i></span>
                                        </div>
                                    </div>
                                    <div class="progress mt-1 d-none " data-height="8" style="height: 8px;">
                                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-lg-6 ">
                        <div class="card-anim l-bg-green-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0"></h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0 ">
                                            Sales
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        <span class="">{{ $admin_dashboard_data->salesCount }} <i class="fa fa-arrow-up"></i></span>
                                    </div>
                                </div>
                                <div class="progress mt-1 d-none " data-height="8" style="height: 8px;">
                                    <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 d-none">


                        <div class="card-anim l-bg-blue-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-calendar-check"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0"> </h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0 ">
                                            Tasks
                                        </h2>
                                    </div>
                                    <div class="col-4 text-right">
                                        {{-- <span class="">{{   }}<i  class="fa fa-arrow-up"></i></span> --}}
                                    </div>
                                </div>
                                <div class="progress mt-1 d-none" data-height="8" style="height: 8px;">
                                    <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
