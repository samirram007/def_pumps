<div class="col-md-6">
    @include('module.godown.godown_office')

</div>

<div class="col-md-6 text-right d-flex flex-row justify-content-end">
    <div id="addGodown" onclick=" addGodown();"
        class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-plus fa-lg mx-2 "></i> <small class="small mt-2"> {{ __('Add Godown') }}</small>
    </div>
    <div id="backToList" onclick=" backToList();"
        class="    mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link bg-transparent cursor-none border-0  ">
        <i class="fas fa-warehouse fa-lg  "></i> <small class="small mt-2"> {{ __('Godowns') }}</small>
    </div>
    <div id="allStock" onclick="  getAllStock();"
        class="   mb-2 text-info d-flex flex-column align-items-center btn  bg-transparent cursor-none border-0 disabled ">
        <i class="fa fa-cubes fa-lg  "></i> <small class="small mt-2"> {{ __('All Stock') }}</small>

    </div>


    <input type="text" class="sr-only" id="godownList" data-godowndata="{{ json_encode($godownList) }}">
</div>




<div class="">
    <div class="col-md-12">
        <div class="card p-2 mb-4 box-shadow">


            <form id="formStockUpdate" class="w-100 ">
                @csrf
                <div class="row">

                    {{-- @dd($godown['stockDetails']) --}}

                    <div class="col-md-6">
                        <div class=" form-group  align-item-center">
                            <label for="productTypeId">{{ __('Product') }}</label>
                            <select name="productTypeId[]" id="productTypeId" class="form-control">

                                @foreach ($productList as $key => $product)
                                    <option value="{{ $product['productTypeId'] }}"
                                        data-iscontainer="{{ $product['isContainer'] ? '1' : '0' }}">
                                        {{ $product['productTypeName'] }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group  align-item-center">
                            <label for="godownId">{{ __('Godowns') }}</label>
                            <select name="godownId[]" id="godownId" class="form-control">
                                @foreach ($godownList as $key => $godown)
                                    <option value="{{ $godown['godownId'] }}"
                                        data-godowntype="{{ $godown['godownTypeId'] }}"
                                        data-isreserver="{{ $godown['isReserver'] ? '1' : '0' }}">
                                        {{ $godown['godownName'] }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" name="officeId[]" class="sr-only" value="{{ $office['officeId'] }}">
                            <input type="text" class="form-control sr-only" name="stock[]" value="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group text-center">
                            <label for="currentStock">{{ __('Available Quantity') }}</label>
                            <input type="text" class="form-control" name="currentStock[]"
                                onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <button id="updateGodown" type="submit"
                                class=" submit btn btn-info btn-sm">{{ __('Update Stock') }}</button>
                        </div>
                    </div>

                </div>


            </form>
        </div>

    </div>
    <table id="stockTable" class="table table-bordered responsive ">
        <tr>
            <td class="  align-item-center">{{ __('Product') }}</td>
            <td class="  align-item-center">{{ __('Godowns') }}</td>
            <td class="w-25 text-center">{{ __('Available Quantity') }}</td>
            <td class="w-25 text-center">{{ __('Action') }}</td>

        </tr>
        {{-- @dd($godowns) --}}
        @foreach ($godowns as $key => $product)
            @php
                $totalStock = 0;
            @endphp
            @if ($product['godownProduct'] != null)
                @foreach ($product['godownProduct'] as $data)
                    @if ($data['godownProductId'] != 0)
                        <tr>
                            <td>{{ $product['productTypeName'] }}</td>
                            <td>{{ $data['godownName'] }} {{ $data['isReserver'] ? '(reserver)' : '' }}
                            </td>
                            <td class="text-center">{{ $data['currentStock'] }} </td>
                            <td></td>
                        </tr>
                        @php
                            $totalStock += $data['currentStock'];
                        @endphp
                    @endif
                @endforeach
                <tr class="bg-info border-primary font-weight-bold text-light">
                    <td>Total</td>
                    <td class="border-primary "> Stock of
                        {{ $product['productTypeName'] }} :</td>
                    <td class="border-top border-danger text-center">{{ $product['currentStock'] }}</td>
                    <td>{!! $totalStock != $product['currentStock'] ? '<span class="text-danger">Error </span>' : '' !!}</td>
                </tr>
            @endif
        @endforeach
    </table>

</div>

</div>


<style>
    .bg-info {
        background-color: #17a2b8 !important;

    }
</style>
<script>
    $(function() {
        var listTable = $('#stockTable').DataTable({
            responsive: true,
            select: false,
            paging: false,
            zeroRecords: true,
            searching: false,
            order: false,
            info: false,
            "oLanguage": langOpt,
        });
    });
    $(document).ready(() => {

        $('#godownName').on('keyup', () => {
            $('#godownNameError').html('');
        });
        $('#productTypeId').on('change', () => {

            populateGodown();
        });
        populateGodown();

        function populateGodown() {
            const godownList = JSON.parse($('#godownList').attr('data-godowndata'));
            const productTypeId = $('#productTypeId').val();
            const isContainer = $('#productTypeId option:selected').attr('data-iscontainer');
            const godownId = $('#godownId').val();
            const godownTypeId = $('#godownId option:selected').attr('data-godowntype');
            const isReserver = $('#godownId option:selected').attr('data-isreserver');
            // console.log(isContainer);
            if (isContainer == 1) {
                // console.log(isContainer);
                $('#godownId').html('');
                godownList.forEach((godown) => {
                    if (godown['godownTypeId'] == 1) {
                        $('#godownId').append(
                            `<option value="${godown['godownId']}" data-godowntype="${godown['godownTypeId']}" data-isreserver="${godown['isReserver']}">${godown['godownName']}</option>`
                        );
                    }
                });
            } else {
                $('#godownId').html('');
                godownList.forEach((godown) => {
                    if (godown['godownTypeId'] == 2) {
                        $('#godownId').append(
                            `<option value="${godown['godownId']}" data-godowntype="${godown['godownTypeId']}" data-isreserver="${godown['isReserver']}">${godown['godownName']}</option>`
                        );
                    }
                });
            }


        }




    });

    // $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    $('#formStockUpdate').on('submit', function(e) {
        e.preventDefault();
        $('.submit').attr('disabled', 'disabled');
        $('.submit').html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
        );
        var data = $(this).serialize();
        //data._token = _token;
        //console.log(data);
        $.ajax({
            url: "{{ route('companyadmin.godown.stock.update') }}",
            type: "POST",
            data: data,
            success: function(response) {
                //console.log(response);
                if (response.status) {
                    toastr.success(response.message);
                    getAllStock();
                    //backToList();
                } else {
                    toastr.error(response.message);
                    $('.submit').removeAttr('disabled');
                    $('.submit').html('{!! __('Update Stock') !!}');
                }

            }
        });

    });
</script>
