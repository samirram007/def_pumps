@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('Office List') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Office List') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="rounded card p-3  bg-white shadow ">
                <div class="row   ">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row     ">
                                    <div class="col-md-8">
                                        <label class="label text-primary">{{ __('Organisation') }} :
                                            <span>{{ $MasterOffice[0]['officeName'] }}</span>
                                        </label>
                                    </div>
                                    {{-- @dd($MasterOffice[0]['officeId']) --}}
                                    <div class="col-sm-4 text-right">
                                        {{-- <a href="{{ route('companyadmin.office.create',$MasterOffice[0]['officeId']) }}"
                                            class="load-popup float-right btn btn-rounded btn-outline-info ">
                                            <span class="iconify" data-icon="ep:office-building" data-width="15" data-height="15">
                                            </span> {{ __('Add Office') }}</a> --}}

                                        <a href="javascript:" data-param="" data-url="{{ route('companyadmin.office.create') }}"
                                            title="Edit Area"
                                            class="load-popup float-right btn btn-rounded btn-outline-info px-2 mb-2 ">
                                            <span class="iconify" data-icon="ep:office-building" data-width="15"
                                                data-height="15"></span> {{ __('Add Office') }}</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="searchPanel" class="searchPanel">
                    <div id="data-grid" class="data-tab-custom rounded">


                        <div class="table-responsive">

                            <table id="table" class="table   table-bordered   ">
                                <thead>
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        <th>Name</th>
                                        <th> Address</th>
                                        <th> ContactNo</th>
                                        <th> Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($collections as $key => $data)
                                        @php
                                            $data = (object) $data;

                                        @endphp
                                        <tr>
                                            {{-- <td>{{ $key + 1 }} </td> --}}
                                            <td>{{ $data->officeName }}</td>
                                            <td class="{{ strlen($data->officeAddress) > 20 ? 'pre-wrap' : '' }}">{{ $data->officeAddress }}</td>
                                            <td>{{ $data->officeContactNo }}</td>
                                            <td class="text-wrap text-truncate">{{ $data->officeEmail }}</td>
                                            <td class="text-right " style="overflow: inherit;">
                                                <div class=" d-inline-flex">

                                                                <a href="{{ route('companyadmin.office.users', $data->officeId) }}" data-param=""
                                                                    data-url="{{ route('companyadmin.office.users', $data->officeId) }}"
                                                                    title="Edit" class="btn btn-rounded btn-info  px-2  "> USERS </a>

                                                               <a href="javascript:" data-param=""
                                                                    data-url="{{ route('companyadmin.office.edit', $data->officeId) }}"
                                                                    title="Edit" class="load-popup  btn btn-link  px-2  ">EDIT</a>

                                                </div>




                                            </td>
                                            {{-- <td class="text-right " style="overflow: inherit;">
                                                <div class="dropdown d-inline-flex">
                                                    <button class="btn btn-outline-link dropdown-toggle" type="button"
                                                        data-toggle="dropdown">SELECT
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu" style="z-index: 1000">

                                                            <li>
                                                                <a href="{{ route('companyadmin.office.users', $data->officeId) }}" data-param=""
                                                                    data-url="{{ route('companyadmin.office.users', $data->officeId) }}"
                                                                    title="Edit" class="btn btn-link  custom-btn"> USERS </a>

                                                            </li>
                                                            <li>
                                                               <a href="javascript:" data-param=""
                                                                    data-url="{{ route('companyadmin.office.edit', $data->officeId) }}"
                                                                    title="Edit" class="load-popup  btn btn-link  px-2  ">EDIT</a>
                                                            </li>

                                                    </ul>
                                                </div>




                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- <script>
        $(document).ready(function() {

            $('#table').DataTable({
                responsive: true,


                    language: {

                        searchPlaceholder: "Search...",
                        sSearch: "",
                        lengthMenu: "Showing  _MENU_ Records",
                        info: "Showing _START_ to _END_ of _TOTAL_ records",
                        infoEmpty: "No records found",
                        infoFiltered: "(filtered from _MAX_ total records)"
                    }


                }

            );
        });
    </script> --}}

    <script>
        /* function SwitchActivation(UserID, ActiveStatus) {
       //onclick="SwitchActivation(1);"
            }*/

        $(document).ready(function() {


            var table = $('#table').DataTable({
                responsive: true,
                select: true,
                "language": {
                    "lengthMenu": 'Show:<select>' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">All</option>' +
                        '</select>  records'
                },

                "order": [
                    [0, "asc"]
                ]
            });


        });
    </script>
@endsection
