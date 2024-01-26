<script>
    $(document).ready(() => {
        setTimeout(() => {
            dataTableInit()
        }, 500);

    });
    var deliveryPlan = @json($deliveryPlan);
    var drivers = @json($drivers);
    var deliveryPlanId = deliveryPlan.deliveryPlanId

    function dataTableInit() {

        var listTable = $('#table').DataTable({
            responsive: true,
            select: false,
            paging: false,
            zeroRecords: true,
            processing: true,
            serverSide: false,
            fixedColumns: true,
            ordering: true,
            info: false,
            searching: true,
            "oLanguage": langOpt,
            data: drivers,
            columns: [

                {
                    "data": null,
                    "render": function(data, type, full, meta) {

                        return `<div class="overflow-hidden font-weight-bold" title="${data['driverName']}"> <i class="fa fa-driver fa-2x"></i> ${data['driverName']}</div>`
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {

                        return `<div ><a class="text-info" href="tel:${data['contactNumber']}"><i class="fa fa-phone" style="rotate:90deg; font-size:12px;"></i> ${data['contactNumber']}</a></div>`
                    }
                },

                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return data.licenceNo
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {

                        return `<a href = "javascript:"
                            onclick = "driverStat('${ data.driverId}')"
                            class = "    btn btn-rounded  animated-shine     " > <i class="fa fa-bar-chart"></i> </a>`

                    }
                },

                {
                    "data": null,
                    "render": function(data, type, full, meta) {

                        var this_str = ``;
                        if (data.assigned && data.deliveryPlanId == deliveryPlanId) {
                            this_str += `<a href = "javascript:"
                                class = " d-block   btn btn-info-outline text-info    px-2 pe-none "  > Assigned </a>`
                        } else if ([3].includes(deliveryPlan.deliveryPlanStatusId)) {
                            this_str += `<a href = "javascript:"
                            onclick = "AddDriver(this,'${ data.driverId}')"
                            class = "   btn btn-rounded  animated-shine    " > Assign </a>`

                        } else {
                            this_str += `...`
                        }
                        return `<div>${this_str}</div>`;
                    }
                },


            ],
            order: [
                [0, 'asc']
            ],

        });

        setTimeout(() => {
            listTable.draw();
            listTable.columns.adjust().responsive.recalc();

        }, 100);
    }


    function AddDriver(e, driverId) {
        var thisHTML = e.innerHTML
        e.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
        $('#formDriverAssign').append(`<input type='hidden' name='driverId' id='driverId' value='${driverId}'>`);
        var submit_url = $('#formDriverAssign').attr('action')
        var method = $('#formDriverAssign').attr('method')

        var formData = new FormData($('#formDriverAssign')[0]);
        // formData.append('deliveryGodownList', JSON.stringify(godownsArray));
        $.ajax({
            type: method,
            url: submit_url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            e.innerHTML = thisHTML
            if (!data.status) {


                $.each(data.errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).next().text(value);
                    toastr.error(value);
                });

            } else {

                drivers = data.data.drivers;
                deliveryPlan = data.data.deliveryPlan;
                $('#table').DataTable().destroy();
                // $('#table').empty();
                dataTableInit();
                toastr.success(data.message);

                setTimeout(() => {

                    //$('#modal-popup').html(data.html)
                    $('#filter').click();

                }, 100);
                return;

            }
            e.innerHTML = thisHTML
        }).fail(function(data) {

            e.innerHTML = thisHTML
            toastr.error(data.message);


        });

    }

    function getMap(e) {

        // initMap();
        if ($('#mapWrapperPanel').hasClass('d-none')) {
            $('#mapWrapperPanel').removeClass('d-none');
            $('#mapWrapperPanel').addClass('d-flex');
            if (newList.length == 0) {
                getMapData();
            } else {
                initMap();
            }


        } else if ($('#mapWrapperPanel').hasClass('d-flex')) {

            $('#mapWrapperPanel').addClass('d-none');
            $('#mapWrapperPanel').removeClass('d-flex');
            // initMap();

        }
    }

    function getMapForPanel(e) {


        if (newList.length == 0) {
            getMapData();
        } else {
            initMap();
        }

    }
</script>
