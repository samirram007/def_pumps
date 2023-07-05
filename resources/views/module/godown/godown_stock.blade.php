<div class="col-md-6">
    @include('module.godown.godown_office')

</div>

<div class="col-md-6 text-right d-flex flex-row justify-content-end">
    <div id="addGodown" class="   mb-2 text-info d-flex flex-column align-items-center btn bg-transparent cursor-none border-0 disabled ">
        <i class="fa fa-plus fa-lg mx-2 "></i> <small  class="small mt-2"> {{ __('Add Godown') }}</small>
    </div>
    <div id="backToList" onclick=" backToList();"
        class="    mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fas fa-warehouse fa-lg  "></i> <small class="small mt-2"> {{ __('Godowns') }}</small>
    </div>
    <div id="allStock" onclick="  getAllStock();"
        class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-cubes fa-lg  "></i> <small  class="small mt-2"> {{ __('All Stock') }}</small>

    </div>
</div>
<div class="col-12">
    <div class="d-flex flex-column medium mx-auto text-center justify-content-center">
        <div>
            {{ __('Godown') }} : {{ $godown['godownName'] }}
        </div>
        <div class="small">
            {{ __('Type') }} : {{ $godown['godownTypeName'] }}{{ $godown['isReserver'] == 1 ? '(reserver)' : '' }}
        </div>

    </div>
</div>

<form id="formCreate" class="w-100 mt-3 mx-3">
    @csrf
    <div class=" p-2">
        <div class="col-md-12">
            <div class="row">
                {{-- @dd($godown['stockDetails']) --}}
                {{-- @dd($productList) --}}
                <table class="table table-bordered  ">
                    <tr>
                        <td class="  align-item-center">{{ __('Product') }}</td>
                        <td class="w-25 text-center">{{ __('Available Quantity') }}</td>

                    </tr>

                    @foreach ($productList as $key => $product)
                        @php
                            $currentStock = 0;
                            foreach ($godown['stockDetails'] as $key => $stock) {
                                if ($stock['productId'] == $product['productTypeId']) {
                                    $currentStock = $stock['currentStock'];
                                }
                            }
                            // echo $currentStock;
                        @endphp

                        @if (count($godown['stockDetails']) > 0 && $currentStock != 0)
                            <tr>
                                <td>{{ $product['productTypeName'] }}</td>
                                <td>

                                    <input type="text" name="productTypeId[]" class="sr-only"
                                        value="{{ $product['productTypeId'] }}">
                                    <input type="text" name="godownId[]" class="sr-only"
                                        value="{{ $godown['godownId'] }}">
                                    <input type="text" name="officeId[]" class="sr-only"
                                        value="{{ $office['officeId'] }}">
                                    <input type="text" class="form-control" name="currentStock[]"
                                        onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        value="{{ $currentStock }}">
                                    <input type="text" class="form-control sr-only" name="stock[]"
                                        value="{{ $currentStock }}">
                                </td>

                            </tr>
                        @endif
                    @endforeach
                </table>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <button id="updateGodown" type="submit" class=" submit btn btn-info btn-sm">{{ __('Update Stock Details')}}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</form>
<script>
    $(document).ready(() => {
        $('#godownName').on('keyup', () => {
            $('#godownNameError').html('');
        });


        // const backToList = () => {
        //     $('#EntryPanel').addClass('d-none');
        //     $('#ListPanel').removeClass('d-none');
        //     $('#modalTitle').html("{{ __('Godowns') }}");
        // }

        // $('#backToList').click(() => {
        //     backToList();
        // });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#formCreate').on('submit', function(e) {
            e.preventDefault();
            $('.submit').attr('disabled', 'disabled');
            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
            );
            var data = $(this).serialize();
            //data._token = _token;
            //console.log(data);
            $.ajax({
                url: "{{ route('companyadmin.godown.stock.update') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        toastr.success(response.message);
                        backToList();
                    } else {
                        toastr.console.error(response.message);
                    }

                }
            });

        });

    });
</script>
