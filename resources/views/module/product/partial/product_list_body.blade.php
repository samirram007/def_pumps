<table class="table table-bordered  ">
    <thead>
        <tr style="border-bottom:2px solid #000!important;">
            <th>{{ __('Product') }} <span class="text-danger">*</span></th>
            <th>{{ __('Container') }} ? <span class="text-danger">*</span></th>
            <th class="text-right">{{ __('Quantity') }} ({{ __('in Ltr') }})</th>
            <th class="text-right">{{ __('RecorderPoint') }} </th>
            <th class="text-right">{{ __('MaxStockLevel') }} </th>
            <th class="text-center">#</th>
        </tr>
    </thead>
    <tbody>
        <tr id="TableRowAddProduct" class="addClass">
            <td class="text-center">
                <input type="text" class="form-control" id="productTypeName" name="productTypeName"
                    placeholder="{{ __('Product Name') }}">
            </td>
            <td>
                <select class="form-control" id="isContainer" name="isContainer">
                    <option value="1">YES</option>
                    <option value="0">NO</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control text-right" id="quantity" name="quantity"
                    placeholder="{{ __('Container Quantity') }}">
            </td>
            <td>
                <input type="text" class="form-control text-right" id="recorderPoint" name="recorderPoint"
                    onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    placeholder="{{ __('Recorder Point') }}">
            </td>
            <td>
                <input type="text" class="form-control text-right" id="maxStockLevel" name="maxStockLevel"
                    onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    placeholder="{{ __('Maximum Stock Level') }}">
            </td>
            <td class="text-center">
                <input type="text" class="sr-only " id="productTypeId" name="productTypeId" value="">
                <input type="text" class="sr-only" id="organizationId" name="organizationId"
                    value="{{ $office[0]['officeId'] }}">
                <button type="button" id="save" onclick="save_product();"
                    class="save btn btn-sm btn-success">{{ __('Save') }}</button>

            </td>
        </tr>
        @forelse ($products as $item)
            <tr id="TableRowProduct{{ $item['productTypeId'] }}">
                <td>
                    {{ $item['productTypeName'] }}


                </td>
                <td class="text-center">
                    {{ $item['isContainer'] ? 'YES' : 'NO' }}

                </td>
                <td style="border-bottom:2px dashed #000!important;">
                    @if ($item['isContainer'])
                        <input type="text" class="bg-white w-100 text-right border-0"
                            onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                            name="quantity[]" value="{{ number_format($item['quantity'], 2, '.', '') }}">
                        {{ __('Ltr') }}
                    @else
                        <input type="text" class="bg-white w-100 text-right border-0" disabled value="0">
                    @endif
                </td>
                <td>
                    <input type="text" class="bg-white w-100 text-right border-0" disabled
                        value="{{ number_format($item['recorderPoint'], 2, '.', '') }}">
                </td>
                <td>
                    <input type="text" class="bg-white w-100 text-right border-0" disabled
                        value="{{ number_format($item['maxStockLevel'], 2, '.', '') }}">
                </td>
                <td class="text-center">
                    <button class="edit_data btn btn-primary btn-sm " data-producttypeid="{{ $item['productTypeId'] }}"
                        data-producttypename="{{ $item['productTypeName'] }}"
                        data-iscontainer="{{ !$item['isContainer'] ? '0' : '1' }}"
                        data-quantity="{{ $item['quantity'] }}" data-organizationid="{{ $item['organizationId'] }}"
                        data-recorderpoint="{{ $item['recorderPoint'] }}"
                        data-maxstocklevel="{{ $item['maxStockLevel'] }}">
                        <i class="fa fa-edit"></i>
                    </button>

                </td>
            </tr>

        @empty
        @endforelse
    </tbody>
</table>
@php
    $roleName = Session::get('roleName');
@endphp

<script>
    $('.edit_data').click(function() {

        var productTypeId = $(this).data('producttypeid');
        var productTypeName = $(this).data('producttypename');
        var isContainer = $(this).data('iscontainer');
        var quantity = $(this).data('quantity');
        var organizationId = $(this).data('organizationid');
        var recorderPoint = $(this).data('recorderpoint');
        var maxStockLevel = $(this).data('maxstocklevel');
        // var item = $(this).data('item');
        // console.log(recorderPoint);
        var empty_content = $('#TableRowAddProduct').html();

        //spinner
        $('#TableRowProduct' + productTypeId).html(
            '<td colspan="4" class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></td>'
        );
        setTimeout(() => {
            var loaded_content = $('#TableRowAddProduct').html();
            //console.log(recorderPoint);
            $('#TableRowProduct' + productTypeId).html(loaded_content);
            $('#TableRowProduct' + productTypeId).addClass('activeClass');
            $('#TableRowAddProduct').html('');
            $('#productTypeId').val(productTypeId);
            $('#organizationId').val(organizationId);
            $('#productTypeName').val(productTypeName);
            $('#isContainer').val(isContainer);
            $('#recorderPoint').val(recorderPoint);
            $('#maxStockLevel').val(maxStockLevel);
            $('#quantity').val(quantity);
            ToggleQtyInput();
        }, 1000);


        $('.edit_data').attr('disabled', true);

    });
    $('#isContainer').change(function() {
        ToggleQtyInput();
    });


    function save_product() {
        // spinner
        $('#save').html('<div class="spinner-border text-light" role="status"><span class="sr-only"></span></div>');
        var productTypeId = $('#productTypeId').val();
        var productTypeName = $('#productTypeName').val();
        var isContainer = $('#isContainer').val();
        var quantity = $('#quantity').val();
        var organizationId = $('#organizationId').val();
        var recorderPoint = $('#recorderPoint').val();
        var maxStockLevel = $('#maxStockLevel').val();
        // console.log(productTypeId);
        //alert(productTypeId);

        var roleName = "{{ $roleName }}";

        var url = "{{ route('superadmin.save_product') }}";
        if (roleName == 'companyadmin') {
            url = "{{ route('companyadmin.save_product') }}";
        }

        $.ajax({
            url: url,
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                productTypeId: productTypeId,
                productTypeName: productTypeName,
                isContainer: isContainer,
                quantity: quantity,
                organizationId: organizationId,
                recorderPoint: recorderPoint,
                maxStockLevel: maxStockLevel,
            },
            success: function(response) {
                //  console.log(response);
                if (response.status == 'success') {
                    toastr.success(response.message);
                    $('#save').html('Save');
                    $("#ProductListBody").html(response.html);
                    // $('#TableRowProduct' + productTypeId).removeClass('activeClass');
                    // $('#TableRowProduct' + productTypeId).addClass('addClass');
                    // $('#TableRowProduct' + productTypeId).html('<td><input type="text" class="sr-only" name="productTypeId[]" value="' + productTypeId + '"><input type="text" class="sr-only" name="organizationId[]" value="' + organizationId + '">' + productTypeName + '</td><td>' + isContainer + '</td><td style="border-bottom:2px dashed #000!important;"><input type="text" class="bg-white w-100 text-right border-0" onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="quantity[]" value="' + quantity + '"></td><td class="text-center"><a href="javascript:" class="edit_data btn btn-primary btn-sm " data-producttypeid="' + productTypeId + '" data-producttypename="' + productTypeName + '" data-iscontainer="' + isContainer + '" data-quantity="' + quantity + '" data-organizationid="' + organizationId + '"><i class="fa fa-edit"></i></a></td>');
                    // $('#TableRowAddProduct').html('');
                    // $('.edit_data').attr('disabled', false);
                } else {
                    toastr.error(response.message);
                    $('#save').html('Save');
                }
            },
            error: function(response) {
                //  console.log(response);
                toastr.error('Something went wrong');
                $('#save').html('Save');
            }
        });
    }

    function ToggleQtyInput() {
        var isContainer = $('#isContainer').val();
        if (isContainer == 1) {
            $('#quantity').prop('readonly', false);
        } else {
            $('#quantity').prop('readonly', true);
        }
    }
</script>
