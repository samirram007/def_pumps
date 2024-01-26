<section class="content">
    <div class="rounded card p-3 bg-white shadow min-h-100">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">


                    <div class="card-body">
                        <div class="text-sm small">

                            <div> {{ __('Office') }} : {{ $office['officeName'] }}</div>
                            <div> {{ __('Type') }} : {{ $office['officeTypeName'] }}</div>
                            <div>
                                {{ $office['officeAddress'] != '' ? 'Address' . ' : ' . $office['officeAddress'] : $office['registeredAddress'] }}
                            </div>
                            <div> {{ __('Contact No.') }} : {{ $office['officeContactNo'] }}</div>

                            <div> {{ __('Email') }} : {{ $office['officeEmail'] }}</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center  border-top  pt-2 ">

            <div class="col-12  d-flex justify-content-end">
                {{-- <button type="button" onclick="showOffice(wizardOfficeId)"
                    class="  btn btn-rounded animated-shine px-4">
                    {{ __('Office Info') }}</button> --}}

                <button type="button" onclick="loadWizardGodown(wizardOfficeId)"
                    class="  btn btn-rounded animated-shine px-4">
                    {{ __('Godown') }}</button>
                    <button type="button" onclick="loadWizardRate(wizardOfficeId)"
                    class="  btn btn-rounded animated-shine px-4">
                    {{ __('Set Product Rates') }}</button>
                <button type="button" onclick="loadWizardInvoiceNo(wizardOfficeId)"
                    class="  btn btn-rounded animated-shine px-4">
                    {{ __('Set Invoice No') }}</button>



            </div>


        </div>
    </div>
