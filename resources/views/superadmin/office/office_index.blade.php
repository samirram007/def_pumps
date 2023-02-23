@extends('layouts.main')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center mx-3">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('Business Entities') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('superadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item "><a href="{{ route('superadmin.master_office.index') }}"
                                    class="text-active">{{ __('Company') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Business Entities') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="rounded card p-3  bg-white shadow ">
                <div class="row   ">
                    <div class="col-md-12">
                        <div class=" card-primary">
                            <div class="card-body">
                                <div class="row   border-bottom pb-2 mb-2">
                                    <div class="col-md-8 h3">
                                        <label class="label text-primary">{{ __($MasterOffice[0]['officeTypeName']) }} :
                                            <span>{{ $MasterOffice[0]['officeName'] }}</span>
                                        </label>
                                    </div>
                                    {{-- @dd($MasterOffice[0]['officeId']) --}}
                                    <div class="col-sm-4 text-right">
                                        {{-- <a href="{{ route('superadmin.office.create',$MasterOffice[0]['officeId']) }}"
                                            class="load-popup float-right btn btn-rounded btn-outline-info ">
                                            <span class="iconify" data-icon="ep:office-building" data-width="15" data-height="15">
                                            </span> {{ __('Add Office') }}</a> --}}

                                        <a href="javascript:" data-param=""
                                            data-url="{{ route('superadmin.office.create', $MasterOffice[0]['officeId']) }}"
                                            title="{{ __('Add Business Entity') }}"
                                            class="load-popup float-right btn btn-rounded animated-shine px-2  ">
                                            <span class="iconify" data-icon="ep:office-building" data-width="15"
                                                data-height="15"></span> {{ __('Add Business Entity') }}</a>

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
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th> {{ __('Address') }}</th>
                                        <th> {{ __('ContactNo') }}</th>
                                        <th> {{ __('Email') }}</th>
                                        <th> {{ __('Last Invoice No') }}</th>
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
                                            <td>{{ $data->officeTypeName }}</td>
                                            <td class="{{ strlen($data->officeAddress) > 20 ? 'pre-wrap' : '' }}">{{ $data->officeAddress }}</td>
                                            <td>{{ $data->officeContactNo }}</td>
                                            <td class="text-wrap text-truncate">{{ $data->officeEmail }}</td>
                                            <td class="text-wrap text-truncate text-center">
                                                @if ($data->lastInvoiceNo == null && $data->officeTypeId != 1)
                                                    <a href="javascript:" data-param=""
                                                        data-url="{{ route('superadmin.office.invoice_no', $data->officeId) }}"
                                                        title="{{ __('Invoice No') }}"
                                                        class="load-popup btn btn-rounded animated-shine">
                                                        {{ __('Invoice No') }}
                                                    </a>
                                                @else
                                                    {{ $data->lastInvoiceNo }}
                                                @endif
                                            </td>
                                            <td class="align-left">
                                                {{-- <a href="{{ route('employee.associate.select', $data->id) }}"
                                                    class="btn btn-outline-info"> <span class="iconify" data-icon="mdi:view-dashboard" data-width="15" data-height="15" data-rotate="180deg"></span> Select</a> --}}

                                                {{-- <a href="{{ route('superadmin.office.edit', $data->officeId) }}"
                                                    class="btn btn-outline-info"><span class="iconify"
                                                        data-icon="mdi:circle-edit-outline" data-width="15"
                                                        data-height="15"></span> {{ __('Edit') }}</a> --}}

                                                <a href="javascript:" data-param=""
                                                    data-url="{{ route('superadmin.office.edit', $data->officeId) }}"
                                                    title="{{ __('Edit') }}"
                                                    class="load-popup   btn btn-rounded animated-shine px-4 "> <i
                                                        class="fa fa-edit"></i> </a>
                                                @if ($data->officeTypeId != 1)
                                                    <a href="javascript:" data-param=""
                                                        data-url="{{ route('superadmin.office.latest_rate', $data->officeId) }}"
                                                        title="{{ __('Latest Rate') }}"
                                                        class="load-popup btn btn-rounded animated-shine mx-2 ">
                                                        {{ __('@') }}
                                                @endif
                                                </a>

                                                {{-- <a href="{{ route('superadmin.office.delete', $data->id) }}"
                                                    class="btn btn-outline-info delete"><span class="iconify" data-icon="mdi:delete-sweep-outline" data-width="15" data-height="15"></span> Delete</a> --}}
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
