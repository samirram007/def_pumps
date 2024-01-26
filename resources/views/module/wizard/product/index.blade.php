<section class="content">
    @include('module.wizard.product.stock')
    <div class="  p-3 bg-transparent   min-h-100">

        <div class="row">


            <div class=" col-12  ">
                <div class="wizard-box scroll-box card card-primary position-relative ">


                    <div class="rounded card p-3 bg-white shadow-none  min-h-100">
                        @include('module.wizard.office.info')
                        <div id="formProduct" class="w-100    " style="border-bottom: 1px solid #2222221a;">

                            <div class=" p-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label for="productId">{{ __('Product') }} <span
                                                        class="text-danger text-lg ml-2">*</span><i
                                                        class="fas fa-info-circle   fa-lg p-c info info-select"
                                                        data-title="{{ __('Product Name') }}"
                                                        data-desc="{{ __('desc.product_name') }}"></i></label>
                                                <select name="productId" id="productId" class="form-control">
                                                    @foreach ($products as $key => $product)
                                                        <option value="{{ $product['productTypeId'] }}"
                                                            data-iscontainer="{{ $product['isContainer'] ? '1' : '0' }}">
                                                            {{ $product['productTypeName'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span id="productIdError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="productRate">{{ __('Product Rate') }} <span
                                                        class="text-danger text-lg ml-2">*</span><i
                                                        class="fas fa-info-circle   fa-lg p-c info"
                                                        data-title="{{ __('Product Rate') }}"
                                                        data-desc="{{ __('desc.product_rate') }}"></i></label>

                                                <input type="text" class="form-control" name="productRate"
                                                    id="productRate">
                                                <span id="productRateError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>
                                        <div class="offset-md-1  col-md-2 d-flex align-items-middle">
                                            <div class="form-group">
                                                <label for=""></label>
                                                {{-- onclick="saveProductInfo()" --}}
                                                <button id="saveProduct"
                                                    class="stock w-100 btn btn-info   animated-shine py-2 btn-sm"
                                                    data-title="{{ __('Godown Stock') }}"
                                                    data-desc="{{ __('desc.opening_stock') }}"><i
                                                        class="fa
                                                    fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group sr-only">
                                                <label for="openingStock">{{ __('Opening Stock') }} <span
                                                        class="text-danger text-lg ml-2">*</span><i
                                                        class="fas fa-info-circle   fa-lg p-c info info-select"
                                                        data-title="{{ __('Opening Stock') }}"
                                                        data-desc="{{ __('desc.opening_stock') }}"></i></label>

                                                <input type="text" class="form-control" name="openingStock"
                                                    id="openingStock">
                                                <span id="opening_stockError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>

                                        {{-- submit --}}




                                    </div>

                                </div>

                            </div>

                        </div>
                        <div id="listProduct" class="w-100 mt-1">


                        </div>
                    </div>
                    <div class=" py-4 bg-white  position-absolute w-100 " style="bottom: 0">
                        <div class="row">
                            <div class="col-md-4 offset-md-4 px-4 fixed-box ">

                                <a href="javascript:" onclick="handleClickStoreProduct(this)"
                                    class="btn-product-store btn   btn-rounded animated-shine  w-100 px-4">
                                    {{ __('Save & Next') }}</a>

                            </div>

                        </div>



                    </div>
                </div>
                <script>
                    $(document).ready(() => {
                        $('.info').on('click', function(e) {

                            const desc = $(this).attr('data-desc');
                            const title = $(this).attr('data-title');

                            $('#modal-tooltip').modal('show');
                            $('#modal-tooltip .desc').html(desc)
                            $('#modal-tooltip #title').html(title)

                        });
                        $('.stock').on('click', function(e) {

                            const productSelector = $('#formProduct #productId');
                            const productRate = $('#formProduct #productRate');
                            if (productRate.val() == '' || productRate.val() == 0) {
                                toastr.error(`Product Rate is not Given`);
                                productRate.focus()
                                return
                            }
                            //console.log(selectedProductName);
                            const desc = $(this).attr('data-desc');
                            const title = $(this).attr('data-title');
                            const productId = productSelector.val();
                            const ProductName = productSelector.find(":selected").text();
                            $('#modal-stock').modal('show');
                            // $('#modal-stock .desc').html(desc)
                            $('#modal-stock #title').html(`{{ __('Stock for') }} ${ProductName}`)
                            $('#modal-stock #productId').val(productId)
                            let godowns = JSON.parse(localStorage.getItem('godownInfo'))
                            let filteredGodown = godowns.filter(x => x.godownTypeId == (productSelector.find(
                                ":selected").attr("data-iscontainer") == 0 ? 2 : 1));
                            //console.log();
                            $("#modal-stock #selectGodown").html('')
                            filteredGodown.map((godown) => {
                                $("#modal-stock #selectGodown").append(
                                    `<option value="${godown['godownName']}">${godown['godownName']}</option>`
                                )
                            });
                            document.querySelector("#modal-stock #listStock").innerHTML = ''
                            populateStockList()
                        });
                        populateProductList()




                    });

                    function removeProduct(removeItem) {
                        //console.log(removeItem);
                        const productInfoData = JSON.parse(localStorage.getItem('productInfo'))
                        const filerData = productInfoData.filter(product => product.productId != removeItem)

                        localStorage.setItem("productInfo", JSON.stringify(filerData))
                        populateProductList()
                    }

                    function populateProductList() {
                        const productInfo = localStorage.getItem('productInfo')
                        const products = @json($products);

                        if (productInfo == null) {
                            // document.querySelector("#listGodown").innerHTML = "Add Some Godown"
                        } else {
                            let dataInfo = JSON.parse(productInfo);
                            var html = `   <table id="table2" class="table   table-striped table-bordered   ">
                                <thead>
                                    <tr>
                                        <th>{{ __('Product') }}</th>
                                        <th>{{ __('Rate') }}</th>
                                        <th>{{ __('Opening Stock') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>



                            </table>`
                            document.querySelector("#listProduct").innerHTML = html
                            var listTable = $('#table2').DataTable({
                                responsive: true,
                                select: false,
                                paging: false,
                                bInfo: false,
                                zeroRecords: true,
                                searching: false,
                                "oLanguage": langOpt,
                                data: dataInfo,
                                columns: [{
                                        "data": null,
                                        "render": function(data, type, full, meta) {

                                            return products.filter(product => product.productTypeId == data
                                                .productId)[
                                                0].productTypeName
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return data.productRate
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return data.openingStock
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return `<div class="removeItem btn  py-1 "
                                            onclick="removeProduct('${data.productId}')"
                                            data-item="${data.productId}" style="padding:3px!important">
                                            <i class="fa fa-trash fa-md" data-item="${data.productId}"></i>
                                            </div>`
                                        }
                                    }




                                ]

                            });
                        }
                    }

                    function saveProductInfo() {
                        storeProductInfo()
                        populateProductList()
                        // document.querySelector("#formProduct #productRate").value = ''
                        // document.querySelector("#formProduct #openingStock").value = ''
                        // document.querySelector("#formProduct #productId").focus()
                    }
                </script>
            </div>
        </div>
    </div>

</section>
