<div class="modal-dialog modal-md  modal-dialog-centered ">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
     <div class="modal-content bg-info">
         <div class="modal-header">
             <h4 class="modal-title text-light">{{ __('Edit User') }} </h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
             </button>
         </div>
         <form id="formCreate">
             @csrf
             <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear"
                 data-aos-duration="1000">
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
                                                <label for="name">User  Name</label>
                                                <input type="hidden" id="id" name="id" value="{{ $editData->id}}">
                                                <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $editData->firstName }} {{ $editData->surName }}" placeholder="Enter User Full Name">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="officeId">Office</label>
                                                {{-- @dd($editData) --}}
                                                <select class="form-control " name="officeId"
                                                    id="officeId" >
                                                    <option value="" class="text-bold"  >Select Office</option>
                                                    @forelse ($officeList as $tg)
                                                        <option readonly value="{{ $tg['officeId'] }}"  {{ $editData->officeId==$tg['officeId']?'selected':''}}>
                                                            {{ $tg['officeName'] }}
                                                        </option>
                                                    @empty
                                                        <option value="" >No record found </option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="roleName">Role</label>
                                                <select class="form-control " name="roleName"
                                                    id="roleName" >
                                                    <option value="" class="text-bold">Select Role</option>
                                                    @forelse ($roles as $tg)
                                                        <option value="{{ $tg}}" {{ $editData->roleName==$tg?'selected':''}}>
                                                            {{ $tg }}
                                                        </option>
                                                    @empty
                                                        <option value="" >No record found </option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="phoneNumber">Mobile no</label>
                                                <input type="text" size="10" maxlength="10" required  class="form-control" id="phoneNumber" name="phoneNumber"
                                                value="{{$editData->phoneNumber}}"
                                                    placeholder="Enter Mobile no">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{$editData->email}}"
                                                    placeholder="Enter Email">
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
    <div class="modal-footer bg-light ">

        <div class="col-12">
            <div class="row text-center">
                <div class="col-md-6 mx-auto">
                    <button type="submit" class="btn btn-outline-info px-4"><span class="iconify"
                            data-icon="mdi:content-save-all-outline" data-width="15" data-height="15"></span>
                        {{ __('Save') }}</button>

                </div>
                <div class="col-md-6 mx-auto">
                    <button type="button" class=" btn btn-outline-danger px-4"
                        data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>

        {{-- <input type="submit" class="btn btn-outline-white btn-info px-4" value="Save"> --}}



    </div>
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

        const url = "{{ route('superadmin.user.update',$editData->id) }}";
        var serializeData = $(this).serialize();


        $.ajax({
            type: "POST",
            url: url,
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
            } else {
                location.reload();
            }
        }).fail(function(data) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.error,
                footer: '<a href>Why do I have this issue?</a>'
            })
            console.log(data);
        });


    });
});
</script>

</div>
