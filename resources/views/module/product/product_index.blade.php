@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('Product List') }}</h4>
                        <ol class="breadcrumb float-sm-left border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Product List') }}</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <a href="javascript:" data-param="" data-url="{{ $product_create_route }}"
                            title="{{ __('New Product') }}"
                            class="load-popup top-0 float-right btn btn-rounded animated-shine px-2 mb-2 ">
                            {{ __('New Product') }}</a>
                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>

        <section class="content">

            <div class="reportPanel mt-3 card border border-primary">

            </div>

        </section>
    </div>

    <script>
        /* function SwitchActivation(UserID, ActiveStatus) {
                                                                                                                                                                                                                                                                                                                               //onclick="SwitchActivation(1);"
                                                                                                                                                                                                                                                                                                                                    }*/

        $(document).ready(function() {

            function loading() {
                $('.reportPanel').html(
                    '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                );
                var officeId = '{{ $office[0]['officeId'] }}';
                $.ajax({
                    url: '{{ $product_search_route }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        officeId: officeId
                    },
                    success: function(response) {
                        //     console.log(response);
                        $('.reportPanel').html(response.html);
                    }
                });
            }


            setTimeout(() => {
                loading();
                // $('.search').click();
            }, 2000);






        });
    </script>
@endsection
