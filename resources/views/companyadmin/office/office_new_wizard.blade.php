<div class="modal-dialog modal-lg  modal-dialog-centered mt-0">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('New Business Entity') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>
        <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
            <div class=" w-100  ">

                @include('module.office._partial.wizard_header', ['disabled' => ''])

                @if (!isset($office))
                    @include('module.wizard.office.create')
                @else
                    @include('module.wizard.office.edit')
                @endif
            </div>
        </div>

    </div>

</div>
