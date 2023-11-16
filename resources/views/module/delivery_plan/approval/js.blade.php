<script>
    $(document).ready(() => {
        setTimeout(() => {
            $('#approvedQuantity').focus();
        }, 500);

        $('.switch-field').on('click', function(e) {
            var $this = $(this);
            //  console.log(e.target.getAttribute('value'));
            if ($this.find(".approve").is(":checked")) {
                // console.log(2);
                $this.parent().parent().parent().find('#approvedQuantity').prop("readonly", false)
                var originalValue = $this.parent().parent().parent().find('#approvedQuantityOrigial')
                    .val()
                $this.parent().parent().parent().find('#approvedQuantity').val(originalValue)
            } else {
                //console.log(-1);
                $this.parent().parent().parent().find('#approvedQuantity').prop("readonly", true)
                $this.parent().parent().parent().find('#approvedQuantity').val('0')
                //  console.log();
                // console.log(e.target.parentNode.parentNode.parentNode.parentNode.find('#approvedQuantity'))
            }
        });




        $("#formApprove").on("submit", function(event) {
            event.preventDefault();

            var thisHTML = event.innerHTML;
            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            $('.submit').attr('disabled', true);
            var submit_url =
                "{{ route($routeRole . '.delivery_plan_details.confirm_requirement_multi', ':id') }}";

            // console.log(deliveryPlanDetailsId);


            // console.log(submit_url);
            var formData = new FormData($(this)[0]);


            $.ajax({
                type: "POST",
                url: submit_url,
                data: formData,
                processData: false, // don't process the data
                contentType: false, // set content type to false as jQuery will tell the server its a query string request
            }).done(function(data) {
                if (!data.status) {

                    $('.submit').attr('disabled', false);
                    $('.submit').html('Request a plan');
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });

                } else {
                    // console.log(data.data);
                    //  $('#reportPanel').html(data.html);
                    event.innerHTML = thisHTML
                    toastr.success(data.message);
                    setTimeout(() => {
                        $('.load-popup-back').click();
                        // // $('.submit').attr('disabled', false);
                        // // $('.submit').html('Approve');
                        // if (document.getElementById('RequestPlan')) {
                        //     // console.log('Available');
                        //     //init_loading();

                        //     $('#requestForm').submit();
                        //     //$('#RequestPlan').click();
                        // } else if (document.getElementById('filter')) {
                        //     //console.log('Filter Ok');

                        //     $('#filter').click();


                        // }



                        //  $("#modal-popup .close").click()
                        // window.location.reload();
                    }, 100);
                    return;
                    // toggleRequestPanel();
                }
                $('.submit').attr('disabled', false);
                $('.submit').html('Approve');
            }).fail(function(data) {

                $('.submit').attr('disabled', false);
                $('.submit').html('Approve');
                toastr.error(data.message);

                // console.log(data);
            });
        });

    });
</script>
