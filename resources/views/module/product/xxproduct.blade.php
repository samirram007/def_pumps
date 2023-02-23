<div class="modal-dialog modal-lg  modal-dialog-centered mt-0">

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="modal-content bg-info">
        <div class="modal-header">
            {{-- <h4 class="modal-title text-light">{{ __('Product List') }} </h4> --}}
            <h4 class="modal-title text-light"> {{ __('Products List') }} :: {{ $office[0]['officeName'] }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form id="formCreate">
            @csrf


            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">


                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">
                            <div class="row mx-auto">


                            </div>
                            <div class="row">

                                <div class="card-body table-responsive" id="ProductListBody">
                                    @include('module.product.partial.product_list_body')
                                </div>



                            </div>

                        </div>
                    </section>
                    {{-- @dd($products) --}}
                </div>
            </div>
        </form>
    </div>
    <style>
        .activeClass {
            border: 2px solid #09969d;

            background: #c0c0c0;
            transition: all 1s ease-in;
        }

        .addClass {
            border: 2px solid #4694b3;

            background: #c0c0c0;
            transition: all 1s ease-in;
        }

        .activeClass .form-control {
            border: 2px solid #2c1481;
            transition: all 1s ease-in;
        }

        .addClass .form-control {
            border: 2px solid #2480a5;
            transition: all 1s ease-in;
        }
    </style>
    @php
        $roleName = Session::get('roleName');

    @endphp



</div>
