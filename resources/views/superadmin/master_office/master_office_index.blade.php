@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center ">
                    <div class="col-12">
                        <h4 class="m-0 text-dark">{{ __('Top Company') }}</h4>
                        <ol class="breadcrumb   border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('superadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Top Company') }}</li>
                        </ol>
                        <div class="position-absolute" style="top:0; right:0;">
                            <a href="javascript:" data-param="" data-url="{{ route('superadmin.master_office.create') }}"
                                title="{{ __('Add Top Company') }}" class="load-popup btn btn-rounded animated-shine   ">
                                <span class="iconify" data-icon="ep:office-building" data-width="15"
                                    data-height="15"></span> {{ __('Add Top Company') }}</a>
                        </div>
                    </div><!-- /.col -->
                    <!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="rounded card p-3  bg-white shadow ">


                <div id="searchPanel" class="searchPanel">
                    <div id="data-grid" class="data-tab-custom rounded">


                        <div class="table-responsive">
                            <table id="table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        <th>{{ __('Name') }}</th>
                                        <th> {{ __('Address') }}</th>
                                        <th> {{ __('ContactNo') }}</th>
                                        <th> {{ __('Email') }}</th>
                                        <th>{{ __('Action') }}</th>
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
                                            <td class="text-wrap text-truncate  ">{{ trim($data->officeAddress) }}</td>
                                            <td>{{ $data->officeContactNo }}</td>
                                            <td class="text-wrap text-truncate">{{ $data->officeEmail }}</td>
                                            <td class="w-50">
                                                <div>
                                                    <a href="javascript:" data-param=""
                                                        data-url="{{ route('superadmin.master_office.edit', $data->officeId) }}"
                                                        title="{{ __('Edit') }}"
                                                        class="load-popup btn btn-rounded animated-shine  ">
                                                        <i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('superadmin.organization.users', $data->officeId) }}"
                                                        data-param=""
                                                        data-url="{{ route('superadmin.organization.users', $data->officeId) }}"
                                                        title="{{ __('Users') }}"
                                                        class="btn btn-rounded animated-shine   "> <i
                                                            class="fa fa-users"></i> </a>

                                                    <a href="javascript:" data-param=""
                                                        data-url="{{ route('superadmin.organization.product', $data->officeId) }}"
                                                        title="{{ __('Product') }}"
                                                        class="load-popup  btn btn-rounded animated-shine   ">{{ __('Product') }}</a>

                                                    <a href="javascript:" data-param=""
                                                        data-url="{{ route('superadmin.master_office.features', $data->officeId) }}"
                                                        title="{{ __('Features') }}"
                                                        class="load-popup btn btn-rounded animated-shine  ">
                                                        <span class="iconify" data-icon="cil:featured-playlist"
                                                            style="color: #f68;" data-width="15" data-height="15"></span>
                                                        {{ __('Features') }}</a>
                                                    <a href="{{ route('superadmin.office.index', $data->officeId) }}"
                                                        class="btn btn-rounded animated-shine"><span class="iconify"
                                                            data-icon="ep:office-building" data-width="15"
                                                            data-height="15"></span></span> {{ __('Business Entity') }}</a>
                                                    {{-- <a href="{{ route('superadmin.office.delete', $data->id) }}"
                                                    class="btn btn-outline-info delete"><span class="iconify" data-icon="mdi:delete-sweep-outline" data-width="15" data-height="15"></span> Delete</a> --}}
                                                </div>
                                            </td>
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
    <script>
        $(document).ready(function() {

            var table = $('#table').DataTable({
                responsive: true,
                select: false,
                zeroRecords: true,
                "oLanguage": langOpt,

                "order": [
                    [0, "asc"]
                ]
            });
        });
    </script>
@endsection
