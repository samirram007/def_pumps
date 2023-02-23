 <div class="modal-dialog modal-lg  modal-dialog-centered mt-0">
     <div class="modal-content bg-info">
         <div class="modal-header">
             <h4 class="modal-title text-light">{{ __('Add Top Company') }} </h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         @include('module.office.office_create')

     </div>
     <script>
         $(document).ready(function() {
             // $('#formCreate').submit();
             $("#formCreate").on("submit", function(event) {
                 event.preventDefault();
                 //spinner
                 $('.submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                 // $("#masterOfficeId").removeAttr('disabled');

                 const url = "{{ route('superadmin.master_office.store') }}";
                 var serializeData = $(this).serialize();
                 console.log(serializeData);


                 $.ajax({
                     type: "POST",
                     url: url,
                     _token: "{{ csrf_token() }}",
                     data: serializeData,
                     dataType: "json",
                     encode: true,
                 }).done(function(data) {
                    console.log(data);
                     if (!data.status) {
                         console.log(data.errors);
                         $.each(data.errors, function(key, value) {
                             $('#' + key).addClass('is-invalid');
                             $('#' + key).next().text(value);
                             toastr.error(value);
                         });

                         $('.submit').html('Save');
                     } else {
                        //  console.log(data);
                        toastr.success(data.message);
                         window.location.href = "{{ route('superadmin.master_office.index') }}";
                     }
                 }).fail(function(data) {
                    toastr.error(errors);
                    // console.log(data);
                     $('.submit').html('Save');
                 });


             });
         });
     </script>
 </div>
