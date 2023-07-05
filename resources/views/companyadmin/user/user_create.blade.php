 <div class="modal-dialog modal-lg  modal-dialog-centered mt-0">
     {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
     <div class="modal-content bg-info">
         <div class="modal-header">
             <h4 class="modal-title text-light">{{ __('Add User') }} </h4>
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

                                             <div class="row">
                                                 <div class="col-md-12">
                                                     <div class="form-group">
                                                         <label for="name">{{ __('User Name') }}</label>
                                                         <input type="text" class="form-control" id="name"
                                                             name="name" value="{{ old('name') }}"
                                                             placeholder="{{ __('Enter User Name') }}">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="roleName">{{ __('Role') }}</label>
                                                         <select class="form-control " name="roleName" id="roleName">
                                                             {{-- <option value="" class="text-bold">Select Role
                                                            </option> --}}
                                                             @forelse ($roles as $tg)
                                                                 <option value="{{ $tg }}">
                                                                     {{ __($tg) }}
                                                                 </option>
                                                             @empty
                                                                 <option value="">{{ __('No record found') }}
                                                                 </option>
                                                             @endforelse
                                                         </select>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div id="officePanel"  class="form-group">
                                                         <label for="officeId">{{ __('Business Entity') }}</label>

                                                         <select class="form-control " name="officeId" id="officeId">
                                                             {{-- <option value="" class="text-bold">Select Office
                                                             </option> --}}
                                                             @forelse ($officeList as $tg)
                                                                 <option value="{{ $tg['officeId'] }}">
                                                                     {{ __($tg['officeName']) }}
                                                                 </option>
                                                             @empty
                                                                 <option value="">{{ __('No record found') }}
                                                                 </option>
                                                             @endforelse
                                                         </select>
                                                     </div>
                                                 </div>

                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="phoneNumber">{{ __('Mobile No') }}</label>
                                                         <input type="text" size="10" maxlength="10"
                                                             class="form-control" id="phoneNumber" name="phoneNumber"
                                                             value="{{ old('phoneNumber') }}"
                                                             placeholder="{{ __('Enter Mobile no') }}">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="name">Email</label>
                                                         <input type="email" class="form-control" id="email"
                                                             name="email" value="{{ old('email') }}"
                                                             placeholder="{{ __('Enter Email') }}">
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row text-center">
                                                 <div class="col-6 mx-auto">
                                                     <button type="submit"
                                                         class=" submit btn btn-rounded animated-shine px-4"><span
                                                             class="iconify" data-icon="mdi:content-save-all-outline"
                                                             data-width="15" data-height="15"></span>
                                                         {{ __('Save') }}</button>

                                                 </div>
                                                 <div class="col-6 mx-auto">
                                                     <button type="button"
                                                         class=" btn btn-rounded animated-shine-danger px-4"
                                                         data-dismiss="modal">{{ __('Cancel') }}</button>
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

         </form>

         <div class="office-collection sr-only">
            <label for="officeId">{{ __('Business Entity') }}</label>
            <select class="form-control " name="officeId" id="officeId">
                {{-- <option value="" class="text-bold">Select Office  </option> --}}
                @forelse ($officeList as $tg)
                    @if ($tg['officeTypeId'] != 1)
                        <option value="{{ $tg['officeId'] }}">
                            {{ $tg['officeName'] }}
                        </option>
                    @endif
                @empty
                    <option value="">{{ __('No record found') }}</option>
                @endforelse
            </select>
        </div>
        <div class="master-office-collection sr-only">
            <label for="officeId">{{ __('Business Entity') }}</label>
            <select class="form-control " name="officeId" id="officeId">
                {{-- <option value="" class="text-bold">Select Office  </option> --}}
                @forelse ($officeList as $tg)
                    @if ($tg['officeTypeId'] == 1)
                        <option value="{{ $tg['officeId'] }}">
                            {{ $tg['officeName'] }}
                        </option>
                    @endif
                @empty
                    <option value="">{{ __('No record found') }}</option>
                @endforelse
            </select>
        </div>
     </div>
     <script type="text/javascript">
        $(document).ready(function() {
            $('#roleName').change(function() {

                var roleName = $(this).val();

                if (roleName.toLowerCase() == 'companyadmin') {
                    $('#officePanel').html($('.master-office-collection').html());
                } else {
                    $('#officePanel').html($('.office-collection').html());
                }
            });
            //  $('#officePanel').html('<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
            $('#officeId').append(
                '<option class="spinner-border text-primary" role="status"> Loading...  </option>');
            setTimeout(() => {
                $('#roleName').change();
            }, 1000);
        });
    </script>
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
                 $('.submit').attr('disabled', 'disabled');
                 $('.submit').html(
                     '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                     );
                 const url = "{{ route('companyadmin.user.store') }}";
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
                         //  console.log(data.errors);

                         Swal.fire({
                             icon: 'error',
                             title: 'Oops...',
                             text: data.errors[0],
                             footer: ''
                         }).then((result) => {
                             $.each(data.errors, function(key, value) {
                                 $('#' + key).addClass('is-invalid');
                                 $('#' + key).next().text(value);
                                 toastr.error(value);
                                 $('.submit').removeAttr('disabled');
                                 $('.submit').html(
                                     '<span class="iconify" data-icon="mdi:content-save-all-outline" data-width="15" data-height="15"></span> {{ __('Save') }}'
                                     );

                             });

                         });

                     } else {
                         toastr.success(data.message);
                         location.reload();
                     }
                 }).fail(function(data) {
                     Swal.fire({
                         icon: 'error',
                         title: 'Oops...',
                         text: data.errors,
                         footer: ''
                     }).then((result) => {
                         $('.submit').attr('disabled', false);
                         $('.submit').html(
                             '<span class="iconify" data-icon="mdi:content-save-all-outline" data-width="15" data-height="15"></span> {{ __('Save') }}'
                             );

                         $.each(data.errors, function(key, value) {
                             $('#' + key).addClass('is-invalid');
                             $('#' + key).next().text(value);
                             toastr.error(value);
                         });

                     });


                     console.log(data);
                 });


             });
         });
     </script>

 </div>
