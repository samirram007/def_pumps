@extends('layouts.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h2 class="m-0 text-dark">{{ __('Support') }}</h2>
                        <ol class="breadcrumb float-sm-left border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active"> <a href="{{ route($routeRole . '.support.list') }}">
                                    {{ __('Support') }}</a></li>
                        </ol>
                        <div class=" position-absolute " style="right:0;top:0;">
                            <a href="javascript:" data-param="" data-real=" " data-param=" "
                                data-url="{{ route($routeRole . '.support.create') }}" data-size="md"
                                title="{{ __('New Ticket') }}"
                                class=" load-popup btn btn-rounded animated-shine px-2 {{ strtolower($roleName) == 'superadmin' ? 'd-none' : '' }}  ">
                                 {{ __('New Ticket') }}</a>
                            <div>
                                <small class="p-2  ml-2">
                                    <span class="badge badge-success rounded-circle  " style="color:#ffffff00">O</span> {{__('Read')}}
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span class="badge badge-warning rounded-circle"
                                        style="color:#ffffff00">O</span> {{__('Unread')}}
                                </small>
                            </div>

                        </div>
                    </div><!-- /.col -->
                    <!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid rounded card p-3">
                <div class="row">

                    <div class="col-sm-12 text-right mb-2">


                        {{-- <a href="javascript:" data-param="" data-url="{{ route('coupon.add') }}" title="Edit Area"
                                class="load-popup float-right btn btn-rounded btn-info mb-2  ">Start New Chat</a> --}}

                        {{-- <a href="javascript:"   data-param=""
                                  data-url="{{ route('trainer.registration.add') }}"  title="Edit Area" class="load-popup float-right btn btn-rounded btn-info mb-2">Add
                                  Trainer</a> --}}
                    </div>
                </div>

                <div id="searchPanel" class="searchPanel">
                    <div id="data-grid" class="data-tab-custom rounded">

                        <div class="table-responsive">
                            <table id="table" class="table table-borderd table-striped ">
                                <thead>
                                    <tr>
                                        <th class="text-center"> {{ __('#') }} </th>
                                        <th> {{ __('TicketNo') }}</th>
                                        <th> {{ __('Title') }}</th>
                                        <th> {{ __('Created By') }}</th>
                                        <th> {{ __('Created On') }}</th>
                                        <th> {{ __('LastModifiedOn') }}</th>

                                        {{-- <th> {{__('ChatCount')}}</th> --}}
                                        <th class="text-center"> {{ __('Action') }}</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($allData as $data)
                                        {{-- @dd($data) --}}
                                        <tr>
                                            <td class="text-wrap text-truncate text-center">{!! $data['readStatus'] != true
                                                ? '<span class="badge badge-success rounded-circle  " style="color:#ffffff00">O</span>'
                                                : '<span class="badge badge-warning rounded-circle" style="color:#ffffff00">O</span>' !!}</td>

                                            <td class="text-wrap text-truncate">{{ $data['supportId'] }}

                                            </td>
                                            <td class="text-wrap text-truncate">{{ $data['title'] }}<br>
                                                <small>{{__('chat count')}} : {{ $data['chatCount'] }}</small></td>
                                            <td class="text-wrap text-truncate">{{ $data['userDetails']['firstName'] }}
                                                {{ $data['userDetails']['firstName'] == $data['userDetails']['surName'] ? '' : $data['userDetails']['surName'] }}
                                            </td>
                                            <td class="text-wrap text-truncate"><span
                                                    class="sr-only">{{ $data['createdOn'] }}</span>
                                                {{ date('d-M-Y', strtotime($data['createdOn'])) }}<br>
                                                <small class="text-primary">
                                                    {{ date('H:i:s', strtotime($data['createdOn'])) }}</small>
                                            </td>
                                            <td class="text-wrap text-truncate"><span
                                                    class="sr-only">{{ $data['lastModifyOn'] }}</span>
                                                {{ date('d-M-Y', strtotime($data['lastModifyOn'])) }}<br>
                                                <small class="text-primary">
                                                    {{ date('H:i:s', strtotime($data['lastModifyOn'])) }}</small>
                                            </td>
                                            {{-- <td class="text-wrap text-truncate text-center">{{ $data['chatCount'] }}</td> --}}
                                            <td class="text-center">
                                                <a href="javascript:;" data-real="{{ $data['supportId'] }}"
                                                    data-param="{{ base64_encode(json_encode($data)) }}"
                                                    data-url="{{ route($routeRole . '.support.add') }}" data-size="md"
                                                    title="{{ __('View Support') }}"
                                                    class="load-support btn btn-rounded animated-shine px-2 m-0 ">
                                                    <i class="fa fa-eye small" aria-hidden="true"></i></a>
                                                {{-- {{$data['chatCount'] ==0? 'disabled':''}} --}}
                                            </td>
                                        </tr>

                                    @empty
                                    @endforelse

                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
                <div id="detailsPanel">

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
                    [5, "desc"]
                ]
            });
        });
        $(document).on('click', '.load-support', function() {
            // $(this).html('<i class="fa fa-spinner fa-spin mr-2 small" aria-hidden="true"></i> {{ __('Loading...') }}');
            $(this).html(
                '<span class="spinner-border spinner-border-sm" role="status" style="margin-bottom: 4px;" aria-hidden="true"></span>'
                );
            var param = $(this).data('param');
            var url = $(this).data('url');
            var size = $(this).data('size');
            var real = $(this).data('real');
            var title = $(this).attr('title');
            var data = {
                'param': param,
                'real': real
            };
            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                success: function(response) {
                    $('#searchPanel').hide();
                    $('#detailsPanel').html(response.html);
                    $('#detailsPanel').show();
                }
            });
        });
    </script>
@endsection
