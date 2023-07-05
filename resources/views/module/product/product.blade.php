@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center">
                    <div class="col-12">
                        <h4 class="m-0 text-dark">{{ __('Product List') }} </h4>
                        <ol class="breadcrumb  border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route($routeRole . '.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Product List') }}</li>
                        </ol>





                    </div><!-- /.col -->
                    <div class="col-sm-6">

                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div><!-- /.container-fluid -->
        </div>
        {{-- @dd($products) --}}
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
        <div class="modal-content bg-info">


            <form id="formCreate">
                @csrf


                <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                    <div class=" w-100  ">


                        <section class="content">
                            <div class="rounded card p-3 bg-white shadow min-h-100">
                                <div class="row mx-auto">


                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-body table-responsive" id="ProductListBody">
                                                @include('module.product.partial.product_list_body')
                                            </div>
                                        </div>
                                    </div>





                                </div>

                            </div>
                        </section>
                        {{-- @dd($products) --}}
                    </div>
                </div>
            </form>
        </div>
        <style scoped>
            .activeClass {
                border: 2px solid #09969d;

                background: #c0c0c0;
                transition: all 1s ease-in;
            }

            .addClass {
                /*border: 2px solid #4694b3;

                            background: #c0c0c0;*/
                background: #dddddd;
                transition: all 1s ease-in;
                position: relative;
                -webkit-animation: linear;
                -webkit-animation-name: runleft;
                -webkit-animation-duration: .5s;
            }

            .addtop {

                position: relative;
                -webkit-animation: linear;
                -webkit-animation-name: runtop;
                -webkit-animation-duration: .5s;
            }

            .addright {

                position: relative;
                -webkit-animation: linear;
                -webkit-animation-name: runright;
                -webkit-animation-duration: .5s;
            }

            .activeClass .form-control {
                /*border: 2px solid #2c1481;*/
                transition: all 1s ease-in;
            }

            .addClass .form-control {
                /*border: 2px solid #2480a5;*/
                transition: all 1s ease-in;
            }

            .custom-new {
                line-height: 1;
                border-radius: 5px !important;
            }

            @-webkit-keyframes runleft {
                0% {
                    left: -500px;
                }

                50% {
                    right: 0;
                }

                100% {
                    left: 0;

                }
            }

            @-webkit-keyframes runtop {
                0% {
                    top: -500px;
                }

                100% {
                    top: 0;

                }
            }

            @-webkit-keyframes runright {
                0% {
                    right: -1000px;
                }

                100% {
                    right: 0;

                }
            }

            .btn-primary:disabled {
                background-color: #babfc5;
                border-color: #a5a5a5;
            }

            .btn-primary:disabled:hover {
                cursor: not-allowed;
            }

            /*********** For Dark Theme*************/
            .lights-off .addClass {
                background: #05050c;
            }

            .lights-off .activeClass {
                border: 2px solid #00a4ff;
                background: #05050c;
            }
        </style>
        @php
            $roleName = Session::get('roleName');
            
        @endphp



    </div>
@endsection
