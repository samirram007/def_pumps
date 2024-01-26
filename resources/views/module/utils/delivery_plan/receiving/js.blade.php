<script>
    $(document).ready(() => {
        $('.receive').on('click', function(event) {
            var deliveryPlanDetailsId = event.target.getAttribute('data-delivery_plan_details_id');
            var orderedQuantity = event.target.getAttribute('data-ordered-quantity');
            var deliveredQuantity = event.target.getAttribute('data-delivered-quantity');
            var receivedQuantity = event.target.getAttribute('data-received-quantity');
            var actualReceivedQuantity = $('#receivedQuantity' + deliveryPlanDetailsId).val();
            //console.log("Ex", typeof(actualReceivedQuantity), typeof(deliveredQuantity));
            if (parseInt(deliveredQuantity) == 0 || deliveredQuantity == '') {
                toastr.error("Delivery pending");
                return false;
            }
            if (parseInt(actualReceivedQuantity) > parseInt(deliveredQuantity)) {
                // console.log("In", actualReceivedQuantity, deliveredQuantity);
                toastr.error("Receiving Quantity Overflow");
                return false;
            } else if (actualReceivedQuantity == '') {
                receivedQuantity = deliveredQuantity;
            } else {
                receivedQuantity = actualReceivedQuantity;
            }

            //console.log(deliveryPlanDetailsId, orderedQuantity, deliveredQuantity, receivedQuantity);

            $(this).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            var formData = new FormData($('#formApprove')[0])
            console.log(formData);
            formData.append('deliveryPlanDetailsId', deliveryPlanDetailsId);
            formData.append('orderedQuantity', orderedQuantity);
            formData.append('deliveredQuantity', deliveredQuantity);
            formData.append('receivedQuantity', receivedQuantity);
            formData.append('actualReceivedQuantity', actualReceivedQuantity);



            var submit_url = "{{ route('companyadmin.receive_delivery_from_multi') }}";
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
                    toastr.success(data.message);
                    setTimeout(() => {

                        // $('.submit').attr('disabled', false);
                        // $('.submit').html('Approve');
                        // $('#filter').click();
                        $("#modal-popup").html(data.html)

                        // window.location.reload();

                    }, 1000);
                    return;
                    // toggleRequestPanel();
                }
                $('.submit').attr('disabled', false);
                $('.submit').html('Confirm');
            }).fail(function(data) {

                $('.submit').attr('disabled', false);
                $('.submit').html('Confirm');
                toastr.error(data.message);

                // console.log(data);
            });
            return;

            // {{ $plan['deliveryPlanDetailsId'] }}
        });

        setTimeout(() => {
            $('#receivedQuantity').focus();
        }, 500);





        $("#formApprove").on("submit", function(event) {
            event.preventDefault();


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
                    toastr.success(data.message);
                    setTimeout(() => {

                        // $('.submit').attr('disabled', false);
                        // $('.submit').html('Approve');
                        if (document.getElementById('RequestPlan')) {
                            console.log('Available');
                            //init_loading();

                            $('#requestForm').submit();
                            //$('#RequestPlan').click();
                        } else if (document.getElementById('filter')) {
                            //console.log('Filter Ok');
                            $('#filter').click();
                        }



                        $("#modal-popup .close").click()
                        // window.location.reload();
                    }, 1000);
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
