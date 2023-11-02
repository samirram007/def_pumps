<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Driver Assigning') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>
        <style>
            .row-block {
                background-color: rgb(247, 248, 246);
                border: 2px solid rgb(115, 175, 81);
                color: rgb(175, 175, 175);
                padding: 5px 10px !important;
                border-radius: 20px;
                margin: 10px !important;
                box-shadow: 0 0 10px 5px #7777772d
            }

            .text-blue {
                color: #3759ee;
            }
        </style>
        <div class="modal-body bg-light">
            <div class="row h5 text-info border-bottom border-info sr-only  ">
                <div class="col-md-8">
                    Driver Details
                </div>
                <div class="col-md-4">
                    Action
                </div>

            </div>
            @foreach ($collection as $key => $item)
                <div class="row row-block my-2">
                    <div class="col-md-8">
                        <div class="text-info font-weight-bold"> <i class="fa fa-user"></i> {{ $item['driverName'] }}
                        </div>
                        <div class="small">
                            <span class="text-blue  "> <i class="fa fa-phone" aria-hidden="true"></i>
                                {{ $item['contactNumber'] }}
                            </span>

                            <span class="px-4"></span>
                            <span>
                                <i class="fas fa-address-card"></i> {{ $item['licenceNo'] }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end align-items-center ">
                        @if (!empty($item['assigned']) && $item['assigned'])
                            <a href="javascript:" class=" d-block    px-2  ">Assigned</a>
                        @else
                            @if (!in_array($deliveryPlan['deliveryPlanStatusId'], [3, 4]))
                                <a href="javascript:" onclick="AddDriver(this,'{{ $item['driverId'] }}')"
                                    class=" d-block   btn btn-rounded  animated-shine px-2  ">Assign</a>
                            @endif
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <form id="formDriverAssign"
        action="{{ route('companyadmin.delivery_plan.assign_driver', $deliveryPlan['deliveryPlanId']) }}"
        method="post">
        @csrf

    </form>
    <script>
        function AddDriver(e, driverId) {
            //console.log(e)
            e.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            $('#formDriverAssign').append(`<input type='hidden' name='driverId' id='driverId' value='${driverId}'>`);
            var submit_url = $('#formDriverAssign').attr('action')
            var method = $('#formDriverAssign').attr('method')
            console.log(submit_url);
            var formData = new FormData($('#formDriverAssign')[0]);
            // formData.append('deliveryGodownList', JSON.stringify(godownsArray));
            $.ajax({
                type: method,
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
                    $('#filter').click();
                    setTimeout(() => {
                        $('#modal-popup').html(data.html)


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

        }
    </script>
</div>
