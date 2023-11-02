@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('Driver List') }}</h4>
                        <ol class="breadcrumb float-sm-left border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Driver List') }}</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <a href="javascript:" data-param="" data-url="{{ $driver_create_route }}"
                            title="{{ __('New Product') }}"
                            class="load-popup top-0 float-right btn btn-rounded animated-shine px-2 mb-2 ">
                            {{ __('New Driver') }}</a>
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>

        <section class="content">

            <div class="reportPanel mt-3 card border border-primary">
                <table id="table" class="table   table-striped table-bordered   ">
                    <thead>
                        <tr>
                            <th>{{ __('Driver Name') }}</th>
                            <th>{{ __('Contact No ') }}</th>
                            <th>{{ __('LicenceNo') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>

                    </thead>


                </table>
            </div>

        </section>
    </div>


@endsection
@push('script')
<script>
    /* function SwitchActivation(UserID, ActiveStatus) {
                                                                                                                                                                                                                                                                                                                               //onclick="SwitchActivation(1);"
                                                                                                                                                                                                                                                                                                                                    }*/

    $(document).ready(function() {
        var collection = @json($collection);

        let edit_url = `{{ route($routeRole . '.driver.edit', ':id') }}`;
        let delete_url = `{{ route($routeRole . '.driver.delete', ':id') }}`;
        var listTable = $('#table').DataTable({
            responsive: true,
            select: false,
            paging: true,
            zeroRecords: true,
            "oLanguage": langOpt,
            data: collection,
            columns: [{
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return data.driverName
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return data.contactNumber;
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return data.licenceNo;
                    }
                },

                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        let this_id = data['driverId'];


                        let this_edit_url = edit_url.replace(':id', data['driverId']);
                        let this_delete_url = delete_url.replace(':id', data['driverId']);
                        let this_str = '';
                            this_str += ` <a href="${this_edit_url}"` +
                                ` title="{{ __('Edit') }}" ` +
                                `class="load-popup    btn btn-rounded  animated-shine px-2  ">` +
                                `<i class="fas fa-pencil-alt"></i> {{ __('Edit') }} </a>`;

                            this_str += ` <a href="${this_delete_url}"` +
                                `title="{{ __('Delete') }}" class="delete  btn btn-rounded animated-shine-danger   ">` +
                                `<i class="fa fa-trash m-0 "></i> {{ __('Delete') }} </a>`;

                        return this_str;
                    }
                },


            ],
            order: [
                [2, 'desc']
            ],

        });

    });
</script>
@endpush
