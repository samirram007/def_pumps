<div id="receivingPanel" class=" d-none modal-content   p-0 flex-column w-100">
    <div class=" p-4 border-0 w-100">


        <div class="row m-0 d-none">
            <div class="col-md-4   align-left">
                <div class="rcv_anim pl-4"></div>
            </div>
        </div>

        <div class="row m-0  ">
            <div class="col-md-8 offset-md-2 card card-primary text-secondary inner_panel mt-2 pb-2">


                <div class="form-group row mt-2 flex-row ">
                    <div class="form-group col-md-6 offset-md-3">
                        <div>{{ __('Pump') }}: <span class="font-weight-bold" id="officeName"></span></div>
                        <div>{{ __('Ordered Quantity') }}: <span class="font-weight-bold" id="order"></span> ltr
                        </div>
                        <div>{{ __('Delivered Quantity') }}: <span class="font-weight-bold" id="delivery"></span>
                            ltr
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-6 offset-md-3">
                        <label for="receivingQuantity">Actual Receiving Quantity</label>
                        <input type="text" name="receivingQuantity" id="receivingQuantity" class="form-control">
                        <input type="text" name="planDetails" id="planDetails" class="sr-only">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-4 d-flex justify-content-center">
                        <a href="javascript:" onClick="receivingPanelOpen(this)"
                            class="btnReceiving btn btn-primary ">Continue</a>
                        {{-- <a href="javascript:" onClick="set_receiving(this)" class="btnReceiving btn btn-primary "
                        onclick="submitForm()">Continue</a> --}}
                    </div>
                </div>


            </div>

        </div>





    </div>
    <div class="row m-0  fixed-bottom">
        <div class="col-md-8  mt-4 mb-2 offset-md-2 card card-primary position-relative ">
            <div class='icon_info'>
                <i class="fa fa-info-circle fa-2x text-info rounded-circle"></i>
            </div>

            <div class="card-body">

                <div class="row text-left">
                    <div class="col-12 d-flex">


                        <div style="font-size:1.0rem" class="mt-2 pl-2 mb-2 panel panel-info    text-info  ">
                            <div>If you have received different quantiry, please change it accordingly</div>
                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<style>
    #receivingPanel {
        top: 0;
        width: 100% !important;
        height: 100% !important;
        box-sizing: border-box;
        margin: 0 auto;
        justify-content: center;
        align-items: center;
        background-color: #ffffff !important;
        padding-bottom: 10px !important;
    }

    #receivingPanel>.inner_panel {

        width: 80% !important;
        height: 80% !important;
        border: 2px solid rgb(16, 94, 96);
        border-radius: 10px;
        display: flex;
        flex-flow: column nowrap;
        margin: 0 auto;

        justify-content: center;
        align-items: center;
        background-color: #ffffff !important;
    }

    #receivingPanel .row {
        width: 100%;
    }

    #receivingPanel .btnReceiving {
        width: 80%;
    }

    .rcv_anim::after {
        animation: changeText 1s linear infinite alternate;
        content: 'Receiving.';
        font-weight: bold;
    }

    @keyframes changeText {
        0% {
            content: 'Receiving.';
            font-weight: bold;
        }

        50% {
            content: 'Receiving..';
            font-weight: bolder;
        }

        75% {
            content: 'Receiving...';
            font-weight: normal;
        }

        100% {
            content: 'Receiving....';
            font-weight: bold;
        }
    }
</style>
