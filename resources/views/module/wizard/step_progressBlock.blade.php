<div id="progressbar" class="progressbar sr-only d-none">
    {{-- <div class="progress-step progress-step-active" id="step-office" data-title="{{ __('Pump Info') }}"></div>
    <div class="progress-step " id="step-godown" data-title="{{ __('Godown') }}"></div>
    <div class="progress-step" id="step-product" data-title="{{ __('Product') }}"></div>
    <div class="progress-step" id="step-invoice" data-title="{{ __('Invoice No') }}"></div>
    <div class="progress-step" id="step-user" data-title="{{ __('User') }}"></div> --}}

</div>
<div id="progressBlock">

    <div class="frame">
        <h1 class="h1 plus-jakarta-sans"><span id="stepCount"></span>{{ __('5 Steps Pump Creation Process') }}</h1>

        {{-- <p class="p card-text plus-jakarta-sans">
            {{ __("Here's a quick overview of the process, from start to finish.") }}</p> --}}

        <div class="cards   pt-5 pb-3">
            <!-- Bootstrap responsive card -->

            <div class="col progress-step  current-step" id="step-office" data-title="{{ __('Pump Info') }}">
                <div class="card   mx-auto  ">
                    <div class="circle plus-jakarta-sans">1</div>
                    <div class="card-body">
                        <!-- Replace this with your SVG file -->
                        <img src="{{ asset('wizard/fuel-pump.svg') }}" alt="Icon" class="svg-icon">
                        <h2 class="card-title plus-jakarta-sans">Pump Info</h2>

                    </div>
                </div>
            </div>

            <div class="col progress-step current-step" id="step-godown" data-title="{{ __('Godown') }}">
                <div class="card  mx-auto  ">
                    <div class="circle plus-jakarta-sans">2</div>
                    <div class="card-body">
                        <img src="{{ asset('wizard/warehouse.svg') }}" alt="Icon" class="svg-icon">
                        <h2 class="card-title plus-jakarta-sans">Godown</h2>

                    </div>
                </div>
            </div>

            <div class="col progress-step current-step" id="step-product" data-title="{{ __('Product') }}">
                <div class="card mx-auto ">
                    <div class="circle plus-jakarta-sans">3</div>
                    <div class="card-body">
                        <img src="{{ asset('wizard/product.svg') }}" alt="Icon" class="svg-icon">
                        <h2 class="card-title plus-jakarta-sans">Product</h2>

                    </div>
                </div>
            </div>


            <div class="col progress-step current-step" id="step-invoice" data-title="{{ __('Invoice No') }}">
                <div class="card mx-auto  ">
                    <div class="circle plus-jakarta-sans">4</div>
                    <div class="card-body">
                        <img src="{{ asset('wizard/bill-invoice.svg') }}" alt="Icon" class="svg-icon">
                        <h2 class="card-title plus-jakarta-sans">Invoice No</h2>

                    </div>
                </div>
            </div>

            <div class="col progress-step current-step" id="step-user" data-title="{{ __('User') }}">
                <div class="card  mx-auto ">
                    <div class="circle plus-jakarta-sans">5</div>
                    <div class="card-body">
                        <img src="{{ asset('wizard/user.svg') }}" alt="Icon" class="svg-icon">
                        <h2 class="card-title plus-jakarta-sans">User</h2>

                    </div>
                </div>
            </div>

            <!-- Add similar sections for other cards -->

        </div>

        {{-- <div class="fixed-box">
            <button class="get-started plus-jakarta-sans"
                onclick="window.location.href='replace with url of your next page'">Get Started</button>
        </div> --}}


    </div>

</div>
<script>
    //console.log(stepper);
</script>
@include('module.wizard.welcome.css')
<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }
</style>
