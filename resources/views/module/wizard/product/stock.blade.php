<div class="modal fade" id="modal-stock" role="tooltip" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md  modal-dialog-center ">
        <div class="modal-content" style="min-height: 30vh">
            <div class="modal-header bg-transparent    text-dark">
                <h4 class="modal-title " id="title">{{ __('Tooltip') }} </h4>
                <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times-circle " style="font-size:24px; color:#cac3c3"></i>
                </button>
            </div>

            <div class=" modal-body bg-transparent py-2 px-2">

                <div id="formStock" class="row m-0 border-bottom pb-3">
                    <input class="sr-only" type="text" name="productId" id="productId">
                    <div class="col-6 pl-0">
                        <label for ="selectGodown">{{ __('Godown') }} <i
                                class="fas fa-info-circle   fa-lg p-c info info-select"
                                style="right: 31px !important; top:43px!important;"
                                data-title="{{ __('Select Godown') }}"
                                data-desc="{{ __('desc.godown_name') }}"></i></label>
                        <select class="form-control" name="selectGodown" id="selectGodown"></select>
                    </div>
                    <div class="desc col-4">
                        <label for ="selectGodown">{{ __('Opening Stock') }} <i
                                class="fas fa-info-circle   fa-lg p-c info  "
                                style="right: 20px !important; top:43px!important;"
                                data-title="{{ __('Opening Stock') }}"
                                data-desc="{{ __('desc.opening_stock') }}"></i></label>
                        <input class="form-control" name="openingStock" id="openingStock" autofocus>
                    </div>
                    <div class="col-2 d-flex align-items-end p-0">
                        <a href="#" onclick="addStock()"
                            class=" btn animated-shine btn-sm w-100 justify-content-center text-center"><i
                                class="fa fa-plus-square"></i></a>
                    </div>
                </div>
                <div id="listStock" class="w-100 mt-2">


                </div>
            </div>
            <div class="modal-footer bg-transparent py-1 px-1">
                <div class="row w-100 mx-0">
                    <div class="col-6 d-flex justify-content-start font-weight-bold"> <span id="totalQuantity"></span>
                    </div>

                    <div class="col-6 d-flex justify-content-end  " style="gap:10px;">
                        {{-- <button type="button" class="btn btn-info animated-shine btn-sm">{{ __('Confirm') }}</button> --}}
                        <button type="button" class="btn btn-primary animated-shine btn-sm" data-dismiss="modal"
                            aria-label="Close">
                            {{ __('desc.close') }}</i>
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<script>
    function addStock() {
        var productId = $('#modal-stock #productId').val()
        var selectGodown = $('#modal-stock #selectGodown').val()
        var openingStock = $('#modal-stock #openingStock').val()
        // console.log(productId, selectGodown, openingStock);
        if (openingStock == '') {
            toastr.error("Please enter stock quantity")
            $('#modal-stock #openingStock').val(0)
            $('#modal-stock #openingStock').focus()
            return
        } else {
            var thisStockInfo = {
                'productId': productId,
                'godownName': selectGodown,
                'quantity': openingStock

            };
            var stockInfo = localStorage.getItem('stockInfo') == null ? [] : JSON.parse(localStorage.getItem(
                "stockInfo"))


            if (stockInfo == null || stockInfo.length == 0) {
                // console.log(stockInfo, thisStockInfo);
                // const stockInfo = []
                stockInfo.push(thisStockInfo)
                localStorage.setItem("stockInfo", JSON.stringify(stockInfo))
                saveProductInfo()
            } else {
                // console.log(stockInfo, thisStockInfo);
                // return
                // const stockInfo = JSON.parse(localStorage.getItem("stockInfo"))
                const existingStock = stockInfo.filter(stock => stock.productId == productId && stock
                    .godownName == selectGodown)

                if (existingStock.length > 0) {
                    const exceptionStocks = stockInfo.filter(x => x.productId != productId || x.godownName !=
                        selectGodown)
                    // console.log(exceptionStocks, existingStock, stockInfo);
                    // return
                    exceptionStocks.push(thisStockInfo)
                    localStorage.setItem("stockInfo", JSON.stringify(exceptionStocks))

                    populateStockList()
                    saveProductInfo()
                    return
                } else {
                    stockInfo.push(thisStockInfo)
                    localStorage.setItem("stockInfo", JSON.stringify(stockInfo))

                    populateStockList()
                    saveProductInfo()
                    return
                }
            }
            localStorage.setItem('stockInfo', JSON.stringify(stockInfo))
            populateStockList()
            saveProductInfo()
        }
    }

    function populateStockList() {
        var productId = document.querySelector('#formStock #productId').value;
        const stockInfo = localStorage.getItem('stockInfo')
        const godowns = localStorage.getItem('godownInfo') == null ? [] : JSON.parse(localStorage.getItem(
            "godownInfo"));

        if (stockInfo == null) {
            // document.querySelector("#listGodown").innerHTML = "Add Some Godown"
        } else {
            let dataInfo = JSON.parse(stockInfo).filter(x => x.productId == productId);
            let totalQuantity = dataInfo.reduce((total, item) => {
                return (total + parseFloat(item.quantity))
            }, 0);
            console.log(totalQuantity);
            document.querySelector("#modal-stock #totalQuantity").innerHTML =
                `{{ __('Total Opening Stock') }}: ${totalQuantity}`;
            document.querySelector("#formProduct #openingStock").value = totalQuantity
            var modHtml = `   <table id="table4" class="table   table-striped table-bordered   ">
                                <thead>
                                    <tr>
                                        <th>{{ __('Godown') }}</th>
                                        <th>{{ __('Opening Stock') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>



                            </table>`;

            document.querySelector("#modal-stock #listStock").innerHTML = modHtml
            var listTable = $('#table4').DataTable({
                responsive: true,
                select: false,
                paging: false,
                zeroRecords: true,
                bInfo: false,
                searching: false,
                "oLanguage": langOpt,
                data: dataInfo,
                columns: [{
                        "data": null,
                        "render": function(data, type, full, meta) {

                            return godowns.filter(godown => godown.godownName == data
                                .godownName)[
                                0].godownName
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return data.quantity
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return `<div class="removeItem btn  py-1 "
                                            onclick="removeStock('${data.godownName}')"
                                            data-item="${data.godownName}" style="padding:3px!important">
                                            <i class="fa fa-trash fa-md" data-item="${data.godownName}"></i>
                                            </div>`
                        }
                    }




                ]

            });
        }
    }

    function removeStock(removeItem) {
        //console.log(removeItem);
        var productId = $('#formStock #productId').val();
        const stockInfoData = JSON.parse(localStorage.getItem('stockInfo'))
        const filerData = stockInfoData.filter(x => x.productId != productId || x.godownName != removeItem)

        localStorage.setItem("stockInfo", JSON.stringify(filerData))
        populateStockList()
        saveProductInfo()
    }
</script>
<style>
    #modal-stock {
        background-color: #ffffff0e;
        background-image: linear-gradient(to right, #f7b9c813, #a7b5fb13);
    }

    /* #stock .modal-dialog {
        background-color: #ffffffc9;
        background-image: linear-gradient(to right, #f7b9c8, #a7b5fb);
    } */
    #modal-stock .modal-dialog {
        background-color: #fffffff6;
        /* background-image: linear-gradient(to right, #5badec, #5fdef8); */
        /* background-image: linear-gradient(-22deg, #5badec 21%, #1daeb3); */
        /* background-image: linear-gradient(-22deg, #5badec 21%, #1daeb3); */
    }

    #modal-stock .modal-content {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff0;
        background-clip: padding-box;
        border: 0px solid rgba(0, 0, 0, .2);
        border-radius: .3rem;
        outline: 0;
    }

    #modal-stock .modal-header {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #881ab37d;
        border-top-left-radius: .3rem;
        border-top-right-radius: .3rem;
        box-shadow: 1px 5px 9px 0px #574545;
    }

    #modal-stock .btn-primary {
        color: #fff;
        background-color: #536ec94a;
        border-color: #c7c7d9a1;
    }

    #modal-stock .btn-primary:hover {
        color: #fff;
        background-color: rgb(93, 162, 235);
        border-color: #005cbf;
    }

    #modal-stock .btn-primary:not(:disabled):not(.disabled).active,
    #modal-stock .btn-primary:not(:disabled):not(.disabled):active,
    #modal-stock .show>.btn-primary.dropdown-toggle {
        color: #fff;
        background-color: rgb(61, 144, 233)a8;
        border-color: #005cbf;
    }
</style>
