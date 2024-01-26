<section class="content">
    <div class="  p-3 bg-transparent   min-h-100">

        <div class="row">

            <div class="col-md-4 sr-only">
                <div id="h-section_create_office" class="sr-only"></div>
                <div class=" d-flex justify-content-center ">
                    <img class="info-image" style="" src="{{ asset('images/wizard/img01.png') }}">
                </div>

            </div>
            <div class="offset-md-2 col-md-8  ">
                <div class="wizard-box scroll-box card card-primary ">
                    <div class="rounded card p-3 bg-white shadow min-h-100">
                        <div class="rounded card p-3 bg-white shadow min-h-100">
                            @include('module.wizard.godown.partials.header', ['active' => 'stock'])
                        </div>
                    </div>
                    <input type="text" class="sr-only" id="godownList"
                        data-godowndata="{{ json_encode($godownList) }}">





                    <div class="rounded card p-3 bg-white shadow min-h-100">

                        <div class="rounded card p-3 bg-white shadow min-h-100">


                            <form id="formStockUpdate" class="w-100 ">
                                @csrf
                                <div class="row">

                                    {{-- @dd($godown['stockDetails']) --}}

                                    <div class="col-md-6">
                                        <div class=" form-group  align-item-center">
                                            <label for="productTypeId">{{ __('Product') }}</label>
                                            <select name="productTypeId[]" id="productTypeId" class="form-control">

                                                @foreach ($productList as $key => $product)
                                                    <option value="{{ $product['productTypeId'] }}"
                                                        data-iscontainer="{{ $product['isContainer'] ? '1' : '0' }}">
                                                        {{ $product['productTypeName'] }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group  align-item-center">
                                            <label for="godownId">{{ __('Godowns') }}</label>
                                            <select name="godownId[]" id="godownId" class="form-control">
                                                @foreach ($godownList as $key => $godown)
                                                    <option value="{{ $godown['godownId'] }}"
                                                        data-godowntype="{{ $godown['godownTypeId'] }}"
                                                        data-isreserver="{{ $godown['isReserver'] ? '1' : '0' }}">
                                                        {{ $godown['godownName'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="text" name="officeId[]" class="sr-only"
                                                value="{{ $office['officeId'] }}">
                                            <input type="text" class="form-control sr-only" name="stock[]"
                                                value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group text-center">
                                            <label for="currentStock">{{ __('Available Quantity') }}</label>
                                            <input type="text" class="form-control" name="currentStock[]"
                                                onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                value="0">
                                        </div>
                                    </div>
                                    <div class="offset-md-4 col-md-4">
                                        <div>
                                            <button id="updateGodown" type="submit"
                                                class=" submit w-100 btn btn-info btn-sm">{{ __('Update Stock') }}</button>
                                        </div>
                                    </div>

                                </div>


                            </form>
                        </div>


                        <div class="rounded card p-3 bg-white shadow min-h-100 mt-4">
                            <table id="stockTable" class="table table-bordered responsive ">
                                <tr>
                                    <td class="  align-item-center">{{ __('Godowns') }}</td>
                                    <td class="  align-item-center">{{ __('Product') }}</td>

                                    <td class="w-25 text-center">{{ __('Available Quantity') }}</td>
                                    <td class="w-25 text-center">{{ __('Action') }}</td>

                                </tr>
                                {{-- @dd($godowns) --}}
                                @foreach ($godowns as $key => $product)
                                    @php
                                        $totalStock = 0;
                                    @endphp
                                    @if ($product['godownProduct'] != null)
                                        @foreach ($product['godownProduct'] as $data)
                                            @if ($data['godownProductId'] != 0)
                                                <tr>
                                                    <td>{{ $data['godownName'] }}
                                                        {{ $data['isReserver'] ? '(reserver)' : '' }}
                                                    </td>
                                                    <td class="">{{ $product['productTypeName'] }}</td>

                                                    <td class="text-center">{{ $data['currentStock'] }} </td>
                                                    <td></td>
                                                </tr>
                                                @php
                                                    $totalStock += $data['currentStock'];
                                                @endphp
                                            @endif
                                        @endforeach
                                        <tr class="bg-info border-primary font-weight-bold text-light">
                                            <td>{{ __('Total') }}</td>
                                            <td class="border-primary "> {{ __('Stock of') }}
                                                {{ $product['productTypeName'] }} :</td>
                                            <td class="border-top border-danger text-center">
                                                {{ $product['currentStock'] }}</td>
                                            <td>{!! $totalStock != $product['currentStock'] ? '<span class="text-danger">Error </span>' : '' !!}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>

                        </div>

                        <div class="row text-center  border-top  pt-2">
                            <div class="col-12  d-flex justify-content-end">
                                <button type="button" onclick="showOffice(wizardOfficeId)"
                                    class="  btn btn-rounded animated-shine px-4">
                                    {{ __('Office Info') }}</button>

                                <button type="button" onclick="loadWizardRate(wizardOfficeId)"
                                    class="  btn btn-rounded animated-shine px-4">
                                    {{ __('Set Product Rates') }}</button>



                            </div>

                        </div>
                    </div>




                    <style>
                        .bg-info {
                            background-color: #17a2b8 !important;

                        }
                    </style>
                    <script>
                        $(document).ready(function() {
                            const godownList = @json($godownList);
                            // var listTable = $('#stockTable').DataTable({
                            //     responsive: true,
                            //     select: false,
                            //     paging: false,
                            //     zeroRecords: true,
                            //     searching: false,
                            //     order: false,
                            //     info: false,
                            //     "oLanguage": langOpt,
                            // });



                            $('#godownName').on('keyup', () => {
                                $('#godownNameError').html('');
                            });
                            $('#productTypeId').on('change', () => {

                                populateGodown();
                            });
                            populateGodown();

                            async function populateGodown() {
                                // const godownList = JSON.parse($('#godownList').attr('data-godowndata'));

                                const productTypeId = $('#productTypeId').val();
                                const isContainer = $('#productTypeId option:selected').attr('data-iscontainer');
                                const godownId = $('#godownId').val();
                                const godownTypeId = $('#godownId option:selected').attr('data-godowntype');
                                const isReserver = $('#godownId option:selected').attr('data-isreserver');
                                console.log(isContainer);
                                if (isContainer == 1) {
                                    // console.log(isContainer);
                                    $('#godownId').html('');
                                    godownList.forEach((godown) => {
                                        if (godown['godownTypeId'] == 1) {
                                            $('#godownId').append(
                                                `<option value="${godown['godownId']}" data-godowntype="${godown['godownTypeId']}" data-isreserver="${godown['isReserver']}">${godown['godownName']}</option>`
                                            );
                                        }
                                    });
                                } else {
                                    $('#godownId').html('');
                                    godownList.forEach((godown) => {
                                        if (godown['godownTypeId'] == 2) {
                                            $('#godownId').append(
                                                `<option value="${godown['godownId']}" data-godowntype="${godown['godownTypeId']}" data-isreserver="${godown['isReserver']}">${godown['godownName']}</option>`
                                            );
                                        }
                                    });
                                }


                            }







                        });

                        $('#formStockUpdate').on('submit', function(e) {
                            e.preventDefault();
                            $('.submit').attr('disabled', 'disabled');
                            $('.submit').html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                            );
                            var data = $(this).serialize();
                            //data._token = _token;
                            //console.log(data);
                            $.ajax({
                                url: "{{ route('companyadmin.godown.stock.update') }}",
                                type: "POST",
                                data: data,
                                success: function(response) {
                                    //console.log(response);
                                    if (response.status) {
                                        toastr.success(response.message);
                                        getAllStock(wizardOfficeId);
                                        //backToList();
                                    } else {
                                        toastr.error(response.message);
                                        $('.submit').removeAttr('disabled');
                                        $('.submit').html('{!! __('Update Stock') !!}');
                                    }

                                }
                            });

                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>
