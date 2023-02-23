@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center ">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('User List') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('superadmin.dashboard') }}"
                                    class="text-active">{{ __('Top Compoany') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('User List') }}</li>
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
                                <div class="row   border-bottom pb-2 mb-2">

                                    <div class="col-sm-12 text-right justify-content-center ">

                                        <a href="javascript:" data-url="{{ route('superadmin.user.filter') }}"
                                            class="load-popup p-0   badge  btn-rounded btn-outline-info mt-0 mx-2">
                                           <i class="fa fa-filter"></i>
                                        </a>


                                        <a href="javascript:" data-param=""
                                            data-url="{{ route('superadmin.user.create') }}" title="Edit Area"
                                            class="load-popup float-right btn btn-rounded animated-shine   px-2   ">
                                            <span class="iconify" data-icon="carbon:user-profile" data-width="15"
                                                data-height="15"></span> {{ __('Add User') }}</a>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="searchPanel" class="searchPanel">
                    <div id="data-grid" class="data-tab-custom rounded">


                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        {{-- <th>Image</th> --}}
                                        <th>Name</th>
                                        <th>Office</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>ContactNo</th>
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
                                            {{-- <td><img style="width: 50px; height:50px; border:1px solid #000000;"
                                                    src="{{ !empty($data->image) ? url('upload/user_images/' . $data->image) : url('upload/no_image.jpg') }}"
                                                    alt=""></td> --}}
                                            <td>{{ $data->firstName }} {{ $data->surName }}</td>
                                            <td>{{ __($data->office['officeName']) }}</td>
                                            <td>{{ $data->roleName }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td class="text-wrap text-truncate">{{ $data->phoneNumber }}</td>
                                            <td>
                                                {{-- <a href="{{ route('employee.associate.select', $data->id) }}"
                                                    class="btn btn-outline-info"> <span class="iconify" data-icon="mdi:view-dashboard" data-width="15" data-height="15" data-rotate="180deg"></span> Select</a> --}}

                                                {{-- <a href="{{ route('superadmin.user.edit', $data->id) }}"
                                                    class="btn btn-outline-info"><span class="iconify"
                                                        data-icon="mdi:circle-edit-outline" data-width="15"
                                                        data-height="15"></span> Edit</a> --}}
                                                <a href="javascript:" data-param=""
                                                    data-url="{{ route('superadmin.user.edit', $data->id) }}"
                                                    title="{{ __('Edit ') }}"
                                                    class="load-popup float-right btn btn-rounded btn-outline-info px-2 mb-2 ">
                                                    <i class="fa fa-edit"></i> </a>

                                                {{-- <a href="{{ route('superadmin.user.delete', $data->id) }}"
                                                    class="btn btn-outline-info delete"><span class="iconify" data-icon="mdi:delete-sweep-outline" data-width="15" data-height="15"></span> Delete</a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <script>
                            $(document).ready(function() {
                                var table = $('#table').DataTable({
                responsive: true,
                select: false,
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
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
