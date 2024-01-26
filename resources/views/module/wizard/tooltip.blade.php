<div class="modal fade" id="modal-tooltip" style="z-index:1060" role="tooltip" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md  modal-dialog-center ">
        <div class="modal-content">
            <div class="modal-header bg-transparent    text-dark">
                <h4 class="modal-title " id="title">{{ __('Tooltip') }} </h4>
                <button type="button" class="close d-none" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times-circle " style="font-size:24px; color:#cac3c3"></i>
                </button>
            </div>

            <div class=" modal-body bg-transparent p-4">
                <div class="row">
                    <div class="col-3"> <i class="fas fa-info-circle   fa-lg fa-3x" style="color: #1662e3;"></i>
                    </div>
                    <div class="desc col-9"></div>
                </div>
            </div>
            <div class="modal-footer bg-transparent py-1">

                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">
                    {{ __('desc.close') }}</i>
                </button>
            </div>
        </div>
    </div>
</div>
<style>
    #modal-tooltip {
        background-color: #ffffff0e;
        background-image: linear-gradient(to right, #f7b9c813, #a7b5fb13);
    }

    /* #modal-tooltip .modal-dialog {
        background-color: #ffffffc9;
        background-image: linear-gradient(to right, #f7b9c8, #a7b5fb);
    } */
    #modal-tooltip .modal-dialog {
        background-color: #ffffffc9;
        /* background-image: linear-gradient(to right, #5badec, #5fdef8); */
        background-image: linear-gradient(-22deg, #5badec 21%, #1daeb3);
    }

    #modal-tooltip .modal-content {
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

    #modal-tooltip .modal-header {
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

    #modal-tooltip .btn-primary {
        color: #fff;
        background-color: #536ec94a;
        border-color: #c7c7d9a1;
    }

    #modal-tooltip .btn-primary:hover {
        color: #fff;
        background-color: rgb(93, 162, 235);
        border-color: #005cbf;
    }

    #modal-tooltip .btn-primary:not(:disabled):not(.disabled).active,
    #modal-tooltip .btn-primary:not(:disabled):not(.disabled):active,
    #modal-tooltip .show>.btn-primary.dropdown-toggle {
        color: #fff;
        background-color: rgb(61, 144, 233)a8;
        border-color: #005cbf;
    }
</style>
