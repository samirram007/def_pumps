@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-12">
                        <h4 class="m-0 text-dark">{{ __('Business Entity') }}</h4>
                        <ol class="breadcrumb  border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Business Entity') }}</li>
                        </ol>
                        <!-- /.col -->
                        <div class=" position-absolute " style="right:0;top:0;">
                            <a href="javascript:" data-param="" data-url="{{ route('companyadmin.office.create') }}"
                                title="{{ __('Add Business Entity') }}"
                                class="load-popup  btn btn-rounded animated-shine px-2 mb-2 ">
                                {{ __('Add Business Entity') }}</a>
                        </div><!-- /.col -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="organization-chart">
                {{-- @dd($offices) --}}
                @include('module.office._partial.index_body', ['offices' => $offices])
            </div>
        </section>


    </div>


    <script>
        /* function SwitchActivation(UserID, ActiveStatus) {
                                   //onclick="SwitchActivation(1);"
                                        }*/

        $(document).ready(function() {
            $('.expand').on('click', function(event) {
            //   console.log('clicked'+ $(this).children('td:first-child').children('button').html().trim());
               if($(this).children('td:first-child').children('button').html().trim() == '+'){
                $(this).children('td:first-child').children('button').html('-') ;
               // $(this).css('border-bottom','2px solid #fff');

                }else{
                    $(this).children('td:first-child').children('button').html('+') ;
                    //$(this).css('border-bottom','1px solid #dee2e6');
                }
                // $('.collapse').toggle();

            });

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
