<div class="modal-dialog modal-md  modal-dialog-centered mt-0">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('FuelRate as on ') }} {{ date('d-m-y') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
            <div class=" w-100  ">


                <section class="content">
                    <div class="rounded card p-3 bg-white shadow min-h-100">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered  ">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Product Type') }}</th>
                                                <th>Rate<span class="ml-2">Rs/Ltr</span></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($productTypeList as $fuelRate)
                                                <tr>
                                                    <td>{{ $fuelRate['productTypeName'] }}</td>
                                                    <td>
                                                        <div id="rate{{ $fuelRate['productTypeId'] }}"
                                                            contenteditable="true" multiline="false" class="d-flex">
                                                            {{ $fuelRate['rate'] }}
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript;" class="badge badge-link">Update</a></td>
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
        </div>

    </div>


    <script>
        $(document).ready(function() {

        });
    </script>

</div>
