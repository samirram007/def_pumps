<div class="rounded card p-3  bg-white shadow ">


    <div id="searchPanel" class="searchPanel">
        <div id="data-grid" class="data-tab-custom rounded">


            <div class="table-responsive">

                <table id="table" class="table   table-striped table-bordered   ">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }} </th>
                            <th class="text-center">{{ __('Unit of Mesurement') }} </th>
                            <th class="text-center">{{ __('Container') }} ? </th>
                            <th class="text-center">{{ __('Quantity') }} ({{ __('in Ltr') }})</th>
                            <th class="text-center">{{ __('RecorderPoint') }} </th>
                            <th class="text-center">{{ __('MaxStockLevel') }} </th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $item)
                            <tr>

                                <td> {{ $item['productTypeName'] }} </td>
                                <td class="text-center">
                                    {{ $item['primaryUnitName'] }}
                                    {{ isset($item['secondaryUnitName']) ? ' (' . $item['secondaryUnitRatio'] . ' ' . $item['secondaryUnitName'] . ')' : '' }}
                                </td>
                                <td class="text-center">
                                    {{ $item['isContainer'] ? 'YES' : 'NO' }}

                                </td>
                                <td class="text-center">
                                    @if ($item['isContainer'])
                                        {{ number_format($item['quantity'], 2, '.', '') }}
                                        {{ __('ltr') }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ number_format($item['recorderPoint'], 2, '.', '') }}
                                </td>
                                <td class="text-center">
                                    {{ number_format($item['maxStockLevel'], 2, '.', '') }}
                                </td>
                                <td class="text-center">
                                    {{-- <a href="javascript:" class="edit_data mx-2 text-info px-2  "
                                        data-producttypeid="{{ $item['productTypeId'] }}">
                                        <i class="fa fa-edit"></i>

                                    </a> --}}
                                    <a href="javascript:" data-param="{{ $item['productTypeId'] }}"
                                        data-url="{{ $product_create_route }}" title="{{ __('Edit Product') }}"
                                        class="load-popup mx-2 text-info px-2  ">
                                        <i class="fa fa-edit"></i></a>
                                    {{-- <a href="javascript:" class="edit_data mx-2 text-info px-2  "
                                        data-producttypeid="{{ $item['productTypeId'] }}"
                                        data-producttypename="{{ $item['productTypeName'] }}"
                                        data-iscontainer="{{ !$item['isContainer'] ? '0' : '1' }}"
                                        data-quantity="{{ $item['quantity'] }}"
                                        data-organizationid="{{ $item['organizationId'] }}"
                                        data-recorderpoint="{{ $item['recorderPoint'] }}"
                                        data-maxstocklevel="{{ $item['maxStockLevel'] }}">
                                        <i class="fa fa-edit"></i>

                                    </a> --}}

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#table').DataTable({
            responsive: true,
            select: false,
            paging: true,
            zeroRecords: true,
            "oLanguage": langOpt,


            "order": [
                [0, "desc"],
                [1, "desc"]
            ]
        });
    });
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
</script>
