<section class="content">
    <div class="  p-3 bg-transparent   min-h-100">

        <div class="row">


            <div class=" col-12  ">
                <div class="wizard-box scroll-box card card-primary position-relative ">


                    <div class="rounded card p-3 bg-white shadow-none  min-h-100">
                        @include('module.wizard.office.info')
                        <div id="formUser" class="w-100    " style="border-bottom: 1px solid #2222221a;">

                            <div class=" p-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label for="roleName">{{ __('Role') }} <span
                                                        class="text-danger text-lg ml-2">*</span><i
                                                        class="fas fa-info-circle   fa-lg p-c info info-select"
                                                        data-title="{{ __('Role') }}"
                                                        data-desc="{{ __('desc.role_name') }}"></i></label>
                                                <select name="roleName" id="roleName" class="form-control">
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{ $role }}">
                                                            {{ $role }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span id="roleNameError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }} <span
                                                        class="text-danger text-lg ml-2">*</span><i
                                                        class="fas fa-info-circle   fa-lg p-c info"
                                                        data-title="{{ __('Name') }}"
                                                        data-desc="{{ __('desc.name') }}"></i></label>

                                                <input type="text" class="form-control" name="name"
                                                    id="name">
                                                <span id="nameError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="phoneNumber">{{ __('Mobile No') }} <span
                                                        class="text-danger text-lg ml-2">*</span><span <i
                                                        class="fas fa-info-circle   fa-lg p-c info  "
                                                        data-title="{{ __('Mobile No') }}"
                                                        data-desc="{{ __('desc.phone_number') }}"></i></label>
                                                <small id="phoneNumber-count-char"
                                                    class="count-char  position-absolute right-0  ">0/10</small>
                                                <input type="text" class="form-control" name="phoneNumber"
                                                    id="phoneNumber" maxlength="10"
                                                    onkeyup="countchar(this,'phoneNumber',10);">
                                                <span id="phoneNumberError" class="text-danger text-sm"></span>
                                            </div>




                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="email">{{ __('Email') }} <span <i
                                                        class="fas fa-info-circle   fa-lg p-c info  "
                                                        data-title="{{ __('Email') }}"
                                                        data-desc="{{ __('desc.email') }}"></i></label>

                                                <input type="text" class="form-control" name="email"
                                                    id="email">
                                                <span id="emailError" class="text-danger text-sm"></span>
                                            </div>
                                        </div>

                                        {{-- submit --}}

                                        <div class="  col-md-1 d-flex align-items-middle">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <button id="saveUser" onclick="saveUserInfo()"
                                                    class="w-100 btn btn-info    animated-shine py-2 btn-sm"><i
                                                        class="fa fa-plus"></i></button>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>

                        </div>
                        <div id="listUser" class="w-100 mt-1">


                        </div>
                    </div>
                    <div class=" py-4 bg-white  position-absolute w-100  " style="bottom: 0">
                        <div class="row">
                            <div class="col-md-4 offset-md-4 px-4 fixed-box">

                                <a href="javascript:" onclick="storeUserIntoOffice(this)"
                                    class="btn-user-store  btn   btn-rounded animated-shine  w-100 px-4">
                                    {{ __('Complete') }}</a>

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
                        populateUserList()




                    });

                    function removeUser(removeItem) {
                        //console.log(removeItem);
                        const userInfoData = JSON.parse(localStorage.getItem('userInfo'))
                        const filerData = userInfoData.filter(user => user.phoneNumber != removeItem)

                        localStorage.setItem("userInfo", JSON.stringify(filerData))
                        populateUserList()
                    }

                    function populateUserList() {
                        const userInfo = localStorage.getItem('userInfo')
                        const roles = @json($roles);

                        if (userInfo == null) {
                            // document.querySelector("#listGodown").innerHTML = "Add Some Godown"
                        } else {
                            let dataInfo = JSON.parse(userInfo);
                            var html = `   <table id="table3" class="table   table-striped table-bordered   ">
                                <thead>
                                    <tr>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Mobile No') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>



                            </table>`
                            document.querySelector("#listUser").innerHTML = html
                            var listTable = $('#table3').DataTable({
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

                                            return data.roleName
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return data.name
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return data.phoneNumber
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return data.email
                                        }
                                    },
                                    {
                                        "data": null,
                                        "render": function(data, type, full, meta) {
                                            return `<div class="removeItem btn  py-1 "
                                            onclick="removeUser('${data.phoneNumber}')"
                                            data-item="${data.phoneNumber}" style="padding:3px!important">
                                            <i class="fa fa-trash fa-md" data-item="${data.phoneNumber}"></i>
                                            </div>`
                                        }
                                    }




                                ]

                            });
                        }
                    }

                    function saveUserInfo() {
                        storeUserInfo()
                        populateUserList()
                        document.querySelector("#name").value = ''
                        document.querySelector("#phoneNumber").value = ''
                        document.querySelector("#roleName").focus()
                    }
                </script>
            </div>
        </div>
    </div>

</section>
