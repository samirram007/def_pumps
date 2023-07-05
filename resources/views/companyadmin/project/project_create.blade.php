<div class="modal-dialog modal-md   ">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __($info['title']) }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>
        <form id="formCreate" enctype="multipart/form-data">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">


                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary">

                                        <div class="card-body">
                                            <div class="row   border-bottom pb-2 mb-2 d-none">
                                                <div class="col-md-3 col-sm-6">

                                                    <div class="form-group">
                                                        {{-- <h5>Profile Image <span class="text-danger"></span></h5> --}}
                                                        <div class="">
                                                            <input type="file" name="image" id="image"
                                                                class="form-control d-none">
                                                        </div>
                                                        <div class="controls ">
                                                            <img id="showImage" class=" rounded-circle"
                                                                style="cursor:pointer;width: 75px; height:75px; border:1px solid #000000;"
                                                                src="{{ url('upload/no_image.jpg') }}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-9 col-sm-6 text-right">
                                                    <button type="submit" class="btn btn-outline-info"><span
                                                            class="iconify" data-icon="mdi:content-save-all-outline"
                                                            data-width="15" data-height="15"></span> Save</button>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="projectName">Project Name</label>
                                                        <input type="text" class="form-control" id="projectName"
                                                            name="projectName" value="{{ old('projectName') }}"
                                                            placeholder="Enter project name">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="officeId">Office</label>
                                                        <select class="form-control " name="officeId" id="officeId">
                                                            <option value="" class="text-bold">Select Office
                                                            </option>
                                                            @forelse ($officeList as $tg)
                                                                <option value="{{ $tg['officeId'] }}">
                                                                    {{ $tg['officeName'] }}
                                                                </option>
                                                            @empty
                                                                <option value="">No record found </option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6 pr-1">
                                                    <div class="form-group">
                                                        <label for="startDate">Start Date</label>
                                                        <input type="date" required class="form-control"
                                                            id="startDate" name="startDate"
                                                            value="{{ old('startDate') == null ? date('Y-m-d') : old('startDate') }}"
                                                            placeholder="Enter Start Date">
                                                    </div>
                                                </div>
                                                <div class="col-6 pl-1">
                                                    <div class="form-group">
                                                        <label for="endDate">End Date</label>
                                                        <input type="date" required class="form-control"
                                                            id="endDate" name="endDate"
                                                            value="{{ old('endDate') == null ? date('Y-m-d') : old('endDate') }}"
                                                            placeholder="Enter End Date">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="projectDescription">Description</label>
                                                        <textarea  class="form-control" id="projectDescription" name="projectDescription"
                                                            placeholder="Enter Project Description">{{ old('projectDescription') }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div  class="form-group">
                                                        <label for="projectDescription">Documents<span class="more-file btn btn-link"> + add more</span></label>

                                                        <div id="files">
                                                            <input type="file" class="form-control pb-2" name="files[]" id="file1">
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row text-center">
                                                        <div class="col-6 mx-auto">
                                                            <button type="submit"
                                                                class="btn btn-outline-info px-4"><span class="iconify"
                                                                    data-icon="mdi:content-save-all-outline"
                                                                    data-width="15" data-height="15"></span>
                                                                {{ __('Save') }}</button>

                                                        </div>
                                                        <div class="col-6 mx-auto">
                                                            <button type="button" class=" btn btn-outline-danger px-4"
                                                                data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            {{-- <div class="modal-footer bg-light ">




             </div> --}}
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#showImage').click(function() {
                $('#image').click();
            });
            $('#showAadhaarImage').click(function() {
                $('#aadhaar_image').click();
            });
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);

            });
        });
    </script>
    <script>
        //  $(document).ready(function() {
        //      $('#roleName').select2({
        //          placeholder: "Select Role",
        //          allowClear: true
        //      });
        //      $('#officeId').select2({
        //          placeholder: "Select Office",
        //          allowClear: true
        //      });
        //  });
    </script>

    <script>
        $(document).ready(function() {
            // $('#formCreate').submit();
            $("#formCreate").on("submit", function(event) {

                event.preventDefault();
                var officeId = $('#officeId').val();
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();
                var projectDescription = $('#projectDescription').val();
                var projectName = $('#projectName').val();

                var errorStr = "";
                if (projectName == '') {
                    errorStr += "Project Name is required<br>";
                }
                if (officeId == '') {
                    errorStr += "Office is required<br>";
                }
                if (startDate == '') {
                    errorStr += "Start Date is required<br>";
                }
                if (endDate == '') {
                    errorStr += "End Date is required<br>";
                }
                if (projectDescription == '') {
                    errorStr += "Description is required<br>";
                }
                if (errorStr != '') {
                    Swal.fire({
                        backdrop:true,
                        icon: 'error',
                        title: 'Oops...',
                        text: "Please fill all the required fields",
                        html: errorStr,
                        ConfirmButtonText: 'Check Error(s)',
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            return false;
                        }
                    })
                    return false;
                }
                const url = "{{ route('companyadmin.project.store') }}";
                // var serializeData = $(this).serialize();
                // var serializeData =  new FormData(this);
                // let data = new FormData($("#formCreate")[0]);
                console.log(serializeData);


                $.ajax({
                    type: "POST",
                    url: url,
                    encrype: "multipart/form-data",
                    _token: "{{ csrf_token() }}",
                    data: serializeData,
                    dataType: "json",
                    encode: true,
                }).done(function(data) {
                    if (!data.status) {
                        console.log(data.errors);
                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors.responseJSON,
                            footer: '<a href>Why do I have this issue..1?</a>'
                        });
                    } else {
                        location.reload();
                    }
                }).fail(function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                        footer: '<a href>Why do I have this issue..2 ?</a>'
                    })
                    console.log(data);
                });


            });
        });
    </script>

</div>
