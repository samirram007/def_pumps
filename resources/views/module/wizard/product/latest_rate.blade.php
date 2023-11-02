
<script>
    var driverObj = driver({
        showProgress: true,
        popoverClass: 'driverjs-theme',
        showButtons: ['next', 'previous'],
        keyboardControl: true,
        side: "top",
        align: 'center',
        steps: [{
                element: "#h-section_create_office",
                side: "top",
                align: 'center',
                popover: {
                    title: "Pump creation wizard",
                    description: "Pump creation wizard",
                    showPrevBtn: false,
                    highlight: '',

                    nextBtnText: 'okay, Start!',

                    onNextClick: () => {
                        driverObj.moveNext()
                        document.querySelector('#officeName').focus()
                    }
                },

            },
            {
                element: "#h-officeName",
                side: "top",
                align: 'center',
                popover: {
                    title: "Pump Name",
                    description: "Pump Name is identification of pump<p><small class='text-danger'><i>Enter Pump Name to proceed next</i></small></p>",

                    onNextClick: () => {
                        if (document.querySelector('#officeName').value != '') {


                            driverObj.moveNext()
                            document.querySelector('#officeTypeId').focus()
                        }
                    }
                }
            },
            {
                element: "#h-officeType",
                side: "top",
                    align: 'center',
                popover: {
                    title: "Pump Type",
                    description: "Select Pump Type",

                    onNextClick: () => {
                        if (document.querySelector('#officeTypeId').value != '') {


                            driverObj.moveNext()
                            document.querySelector('#officeEmail').focus()
                        }
                    }
                }
            },
            {
                element: "#h-officeEmail",
                side: "top",
                    align: 'center',
                popover: {
                    title: "Email",
                    description: "Receives mail, notification, order-copy, invoice etc "
                }
            },
            {
                element: "#h-officeContactNo",
                popover: {
                    title: "Contact Number",
                    description: "Receives sms, notification, order-copy, invoice etc ",
                    onNextClick: () => {
                        driverObj.moveTo(5)
                        document.querySelector('#gstTypeId').focus()
                    }

                }
            },
            {
                element: "#h-officeGstType",
                popover: {
                    title: "Gst Type",
                    description: "If your business is under taxation exempt, then you can skip it",
                    onNextClick: () => {
                        if (document.querySelector('#gstTypeId').value == '0') {
                            driverObj.moveTo(7)
                            document.querySelector('#registeredAddress').focus()
                        } else {
                            driverObj.moveNext()
                            document.querySelector('#gstNumber').focus()
                        }

                    }
                }
            },
            {
                element: "#h-gstNumber",
                popover: {
                    title: "GST Number",
                    description: "15 digits GST Number",
                    onHighlightStarted: (Element) => {
                        if (document.querySelector('#gstTypeId').attr('readonly')) {
                            driverObj.moveNext();
                        }
                        console.log('true');


                    }
                }
            },
            {
                element: "#h-officeRegisterAddress",
                popover: {
                    title: "Register Address",
                    description: "Your Business Registered Address",
                    onPrevClick: () => {
                        if (document.querySelector('#gstTypeId').value == '0') {
                            driverObj.moveTo(5)
                            document.querySelector('#gstTypeId').focus()
                        } else {
                            driverObj.movePrevious()
                            document.querySelector('#gstNumber').focus()
                        }

                    }
                }
            },
            {
                element: "#h-officeSave",
                showButtons:['previous'],
                popover: {
                    title: "Confirm",
                    description: "Confirm as new Pump"
                }
            },
        ]
    });
    driverObj.drive(0);
</script>
<form id="formLatestRate">
    @csrf
    <div class="modal-body bg-light p-0">
        <div class=" w-100  ">


            <section class="content">
                <div class="rounded card p-3 bg-white shadow min-h-100">
                    <div class="rounded card p-3 bg-white shadow min-h-100 ">
                        <div class="d-flex flex-row justify-content-between flex-nowrap  ">

                            <div class="card-title m-0 pl-2 "> {{ __('Fuel Rates for') }} {{ $office['officeName'] }} as
                                on
                                {{ date('d-m-Y') }}</div>

                            <div class=" d-flex justify-content-end align-items-center  ">
                                <button type="submit" class="  submit btn btn-rounded btn-sm animated-shine px-4  "
                                    style="right:0">

                                    <span class="iconify" data-icon="mdi:content-save-all-outline" data-width="15"
                                        data-height="15"></span>
                                    {{ __('Update') }}</button>
                            </div>


                        </div>

                    </div>
                    <div class="rounded card p-3 bg-white shadow min-h-100 ">
                        <div class="row">

                            <div class="card-body">
                                <table class="table table-bordered  ">
                                    <thead>
                                        <tr style="border-bottom:2px solid #000!important;">
                                            <th>{{ __('Product') }} </th>
                                            <th style="width:20%" class="text-right">{{ __('Rate') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($latest_rate as $item)
                                            <tr>
                                                <td>
                                                    {{ $item['productName'] }}
                                                    <input type="text" class="sr-only" name="productTypeId[]"
                                                        value="{{ $item['productTypeId'] }}">
                                                    <input type="text" class="sr-only" name="currentRate[]"
                                                        value="{{ $item['fuelRate'] }}">

                                                </td>
                                                <td class="px-0" style="border-bottom:2px dashed #034870!important;">

                                                    <input type="text" class="bg-white w-100 text-right border-0"
                                                        onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        name="rate[]"
                                                        value="{{ number_format($item['fuelRate'], 2, '.', '') }}">
                                                </td>
                                            </tr>

                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                                <input type="text" class="sr-only" name="officeId" value="{{ $item['officeId'] }}">
                            </div>

                        </div>
                        {{-- <div class="row text-center  border-top  pt-2 ">

                            <div class="col-12  d-flex justify-content-end">
                                <button type="button" onclick="showOffice(wizardOfficeId)"
                                    class="  btn btn-rounded animated-shine px-4">
                                    {{ __('Office Info') }}</button>

                                <button type="button" onclick="loadWizardGodown(wizardOfficeId)"
                                    class="  btn btn-rounded animated-shine px-4">
                                    {{ __('Godown') }}</button>
                                <button type="button" onclick="loadWizardInvoiceNo(wizardOfficeId)"
                                    class="  btn btn-rounded animated-shine px-4">
                                    {{ __('Set Invoice No') }}</button>



                            </div>


                        </div> --}}

                    </div>



                </div>
            </section>
        </div>
    </div>

</form>

<script>
    $(document).ready(function() {
        $('#formLatestRate').on('submit', function(e) {
            e.preventDefault();
            $('.submit').attr('disabled', 'disabled');
            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
            );
            var data = $(this).serialize();
            var roleName = "{{ $roleName }}";

            var url = "{{ route($routeRole . '.store_latest_rate') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function(data) {
                    if (data.status == true) {
                        toastr.success(data.message);
                        $('.submit').removeAttr('disabled');
                        $('.submit').html(`<span class="iconify"
                                        data-icon="mdi:content-save-all-outline" data-width="15"
                                        data-height="15"></span>
                                    {{ __('Update') }}`);

                    } else {
                        toastr.error(data.message);
                        $('.submit').removeAttr('disabled');
                        $('.submit').html(`<span class="iconify"
                                        data-icon="mdi:content-save-all-outline" data-width="15"
                                        data-height="15"></span>
                                    {{ __('Update') }}`);
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('.submit').removeAttr('disabled');
                    $('.submit').html(`<span class="iconify"
                                        data-icon="mdi:content-save-all-outline" data-width="15"
                                        data-height="15"></span>
                                    {{ __('Update') }}`);
                }
            });
        });
    });
</script>
