<section class="content">
    <div class="  p-3 bg-transparent   min-h-100">

        <div class="row">


            <div class=" col-12  ">
                <div class="wizard-box scroll-box card card-primary position-relative ">


                    <div class="rounded card p-3 bg-white shadow-none  min-h-100">
                        @include('module.wizard.office.info')
                        <div id="createGodown" class="w-100    " style="border-bottom: 1px solid #2222221a;">

                            <div class=" p-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label for="godownName">Godown Name<span
                                                        class="text-danger text-lg ml-2">*</span><i
                                                        class="fas fa-info-circle   fa-lg p-c info"
                                                        data-title="{{ __('Godown Name') }}"
                                                        data-desc="{{ __('desc.godown_name') }}"></i></label>
                                                <input type="text" class="form-control" name="godownName"
                                                    id="godownName">
                                                <span id="godownNameError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="godownTypeId">{{ __('Godown Type') }} <i
                                                        class="fas fa-info-circle   fa-lg p-c info"
                                                        data-title="{{ __('Godown Type') }}"
                                                        data-desc="{{ __('desc.godown_type') }}"></i></label>
                                                <select name="godownTypeId" id="godownTypeId" class="form-control">
                                                    @foreach ($godownTypes as $key => $godownType)
                                                        <option value="{{ $godownType['godownTypeId'] }}">
                                                            {{ $godownType['godownTypeName'] }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-3 secondary">
                                            <div class="form-group">
                                                <label for="isReserver">{{ __('Use as reserver') }} <i
                                                        class="fas fa-info-circle   fa-lg p-c info"
                                                        data-title="{{ __('Use as reserver') }}"
                                                        data-desc="{{ __('desc.is_reserver') }}"></i></label>
                                                <select name="isReserver" id="isReserver" class="form-control">
                                                    <option value="1">YES</option>
                                                    <option value="0">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- submit --}}

                                        <div class=" offset-md-1  col-md-1 d-flex align-items-middle">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <button id="saveGodown" onclick="saveGodown()"
                                                    class="w-100 btn btn-info   animated-shine py-2 btn-sm"><i
                                                        class="fa fa-plus"></i></button>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>

                        </div>
                        <div id="listGodown" class="w-100 mt-1">


                        </div>
                    </div>
                    <div class=" py-4 bg-white  position-absolute w-100 " style="bottom: 0">
                        <div class="row">
                            <div class="col-md-4 offset-md-4 px-4 fixed-box ">

                                <a href="javascript:" onclick="handleClickStoreGodown(this)"
                                    class="btn-godown-store  btn   btn-rounded animated-shine  w-100 px-4">
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
                        })
                        populateGodownList()
                        $('#godownName').on('keyup', () => {
                            $('#godownNameError').html('');
                        });
                        $('#godownTypeId').on('change', () => {
                            godownTypeToggle();
                        });
                        godownTypeToggle();

                        function godownTypeToggle() {
                            let godownTypeId = $('#godownTypeId').val();
                            if (godownTypeId == 1) {
                                $('#isReserver').val(0);
                                $('#isReserver').attr('disabled', true);
                                // $('.secondary').addClass('sr-only');
                            } else {
                                $('#isReserver').val(0);
                                $('#isReserver').attr('disabled', false);
                                // $('.secondary').removeClass('sr-only');
                            }
                        }




                    });

                    function removeGodown(removeItem) {
                        console.log(removeItem);
                        const godownInfoData = JSON.parse(localStorage.getItem('godownInfo'))
                        const filerData = godownInfoData.filter(godown => godown.godownName != removeItem)

                        localStorage.setItem("godownInfo", JSON.stringify(filerData))
                        populateGodownList()
                    }

                    function populateGodownList() {
                        const godownInfo = localStorage.getItem('godownInfo')
                        if (godownInfo == null) {
                            // document.querySelector("#listGodown").innerHTML = "Add Some Godown"
                        } else {
                            let dataInfo = JSON.parse(godownInfo);
                            var html = `   <table id="table1" class="table   table-striped table-bordered   ">
                                <thead>
                                    <tr>
                                        <th>{{ __('Godown Name') }}</th>
                                        <th>{{ __('Godown Type') }}</th>
                                        <th>{{ __('Use as reserver') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>



                            </table>`
                            document.querySelector("#listGodown").innerHTML = html
                            var listTable = $('#table1').DataTable({
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
                                            return data.godownName
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return data.godownTypeId == 1 ? 'General' : 'Tank'
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return data.isReserver == 1 ? "Yes" : "No"
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return `<div class="removeItem btn  py-1 "
                                            onclick="removeGodown('${data.godownName}')"
                                            data-item="${data.godownName}" style="padding:3px!important">
                                            <i class="fa fa-trash fa-md" data-item="${data.godownName}"></i>
                                            </div>`
                                        }
                                    }




                                ]

                            });
                        }
                    }

                    function saveGodown() {
                        storeGodown()
                        populateGodownList()
                        document.querySelector("#godownName").value = ''
                        document.querySelector("#godownName").focus()
                    }
                </script>
            </div>
        </div>
    </div>

</section>
