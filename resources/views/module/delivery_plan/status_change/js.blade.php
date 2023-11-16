<script>
    $(document).ready(() => {
        setTimeout(() => {
            dataTableInit()
        }, 500);

    });

    var deliveryPlan = @json($planDetails);
    var deliveryPlanId = @json($deliveryPlanId);
    var deliveryPlanDetails = deliveryPlan.deliveryPlanDetailsList;
    var deliveryPlanStatusId = deliveryPlan.deliveryPlanStatusId;
    var deliveryPlanStatus = @json($deliveryPlanStatus);
    var isTopAdmin = @json($isTopAdmin);
    var officeId = @json($officeId);
    var adminId = @json($adminId);
    var userId = @json($userId);
    var newList = [];


    var XExpectedReturnTime = null;
    // newList[newList.length - 1].estimatedDeliveryTime;
    var JourneyStartTime = null; //datetimeLocal(newList[0].estimatedDeliveryTime);
    var ExpectedReturnTime = null; //datetimeLocal(XExpectedReturnTime);

    var TotalJourneyTime = st(JourneyStartTime, ExpectedReturnTime);
    // deliveryPlanDetails = deliveryPlanDetails.filter(item => item.deliveryPlanDetailsStatusId != 3);
    // let view_url = `{{ route($routeRole . '.delivery_plan.view', ':id') }}`;
    // let edit_url = `{{ route($routeRole . '.delivery_plan.edit', ':id') }}`;
    // let delete_url = `{{ route($routeRole . '.delivery_plan.delete', ':id') }}`;
    // let status_change_url = `{{ route($routeRole . '.delivery_plan.status_change', ':id') }}`;
    // let driver_url = `{{ route($routeRole . '.delivery_plan.driver', ':id') }}`;
    var start = moment().subtract(6, 'days');
    var end = moment();

    function setStatus(deliveryPlanId, deliveryPlanStatusId) {

    }




    function set_complete(e, paramDeliveryPlanStatusId) {

        var thisHTML = e.innerHTML;
        e.innerHTML =
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
        var formData = new FormData($('#FormSetStatus')[0])

        formData.append('deliveryPlanId', deliveryPlanId);
        formData.append('deliveryPlanStatusId', paramDeliveryPlanStatusId);
        var submit_url = "{{ route($routeRole . '.delivery_plan.update_status', ':id') }}";
        submit_url = submit_url.replace(':id', deliveryPlanId);
        $.ajax({
            type: "POST",
            url: submit_url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            if (!data.status) {
                toastr.error(data.message);

                e.target.innerHTML = thisHTML


            } else {

                e.innerHTML = thisHTML
                toastr.success(data.message);
                setTimeout(() => {
                    getData();

                    $('#filter').click();

                }, 100);
                return;

            }
            e.innerHTML = thisHTML
        }).fail(function(data) {
            toastr.error(data.message);
            e.innerHTML = thisHTML


        });
        return;
    }

    function set_receiving(e) {
        var receivingQuantity = document.querySelector("#receivingPanel #receivingQuantity").value;
        var planDetails = document.querySelector("#receivingPanel #planDetails").value;

        if (receivingQuantity == 'undefined' || isNaN(parseInt(receivingQuantity)) || parseInt(receivingQuantity) ==
            0) {
            toastr.info("Please enter the correct value")
            return
        }

        const thisHTML = e.innerHTML;
        e.innerHTML =
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
        var formData = new FormData($('#FormReceiving')[0])

        formData.append('receivingQuantity', receivingQuantity);
        formData.append('planDetails', planDetails);

        var submit_url = "{{ route('companyadmin.receive_delivery_from_multi') }}";;

        $.ajax({
            type: "POST",
            url: submit_url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            if (!data.status) {
                toastr.error(data.message);

                e.target.innerHTML = thisHTML


            } else {

                $("#modal-popup").html(data['html']);
                // $("#modal-popup").modal('show');
                //increase modal height 0 to 100 % animated
                var init_height = 0;

                var interval = setInterval(() => {
                    init_height = (init_height + 0.2);
                    $("#modal-popup").css('opacity', init_height);
                    $("#modal-popup").modal('show');

                    if (init_height >= 1) {
                        clearInterval(interval);

                    }

                }, 50);

            }
            e.innerHTML = thisHTML
        }).fail(function(data) {
            toastr.error(data.message);
            e.innerHTML = thisHTML


        });
        return;
    }

    $("#FormSetStatus").on("submit", function(event) {
        event.preventDefault();
        var thisHTML = $('.submit').html();
        alert()
        $('.submit').html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
        );
        $('.submit').attr('disabled', true);
        var submit_url = "{{ route($routeRole . '.delivery_plan.update_status', ':id') }}";
        var deliveryPlanId = {{ $planDetails['deliveryPlanId'] }};
        submit_url = submit_url.replace(':id', deliveryPlanId);

        var formData = new FormData($(this)[0]);


        $.ajax({
            type: "POST",
            url: submit_url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {

            if (!data.status) {
                toastr.error(data.message);
                $('.submit').attr('disabled', false);
                $('.submit').html(thisHTML);
                $.each(data.errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).next().text(value);
                    toastr.error(value);
                });

            } else {

                toastr.success(data.message);
                setTimeout(() => {
                    getData();

                    $('#filter').click();

                }, 100);
                return;

            }
            $('.submit').attr('disabled', false);
            $('.submit').html(thisHTML);
        }).fail(function(data) {

            $('.submit').attr('disabled', false);
            $('.submit').html(thisHTML);
            toastr.error(data.message);


        });
    });
    $("#FormSetStatusCancel").on("submit", function(event) {
        event.preventDefault();

        $('.cancel').html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
        );
        $('.cancel').attr('disabled', true);
        var submit_url = "{{ route($routeRole . '.delivery_plan.update_status', ':id') }}";
        var deliveryPlanId = {{ $planDetails['deliveryPlanId'] }};

        submit_url = submit_url.replace(':id', deliveryPlanId);


        var formData = new FormData($(this)[0]);


        $.ajax({
            type: "POST",
            url: submit_url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            if (!data.status) {

                $('.cancel').attr('disabled', false);
                $('.cancel').html('Set');
                $.each(data.errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).next().text(value);
                    toastr.error(value);
                });

            } else {

                toastr.success(data.message);
                setTimeout(() => {


                    $('#filter').click();
                    $("#modal-popup .close").click()

                }, 1000);
                return;

            }
            $('.cancel').attr('disabled', false);
            $('.cancel').html('Cancel this plan');
        }).fail(function(data) {

            $('.cancel').attr('disabled', false);
            $('.submit').html('Cancel this plan');
            toastr.error(data.message);


        });
    });

    function dataTableInit() {
        var approve_url = `{{ route($routeRole . '.delivery_plan.approve', ':id') }}`;
        var receive_url = `{{ route($routeRole . '.delivery_plan.receive', ':id') }}`;
        var status_change_url = `{{ route($routeRole . '.delivery_plan.status_change', ':id') }}`;
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
            searching: false,
            "oLanguage": langOpt,
            data: deliveryPlan.deliveryPlanDetailsList,
            columns: [{
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return data.sequenceNo
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {

                        return `<div class="overflow-hidden" title="${data.office['officeName']}">${data.office['officeName']}</div>`
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {

                        return `<div class="overflow-hidden" title="${data.admin['name']}">${data.admin['name']}</div>
                    <div ><a class="text-info" href="tel:${data.admin['phoneNumber']}"><i class="fa fa-phone" style="rotate:90deg; font-size:12px;"></i> ${data.admin['phoneNumber']}</a></div>`
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        const d = new Date(data.deliveredAt ?? data.expectedDeliveryTime);
                        return `<span class="sr-only">${ d}</span>` +
                            `${ moment(d).format('DD-MM-YYYY hh:mm a')}`;
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        if ([1, 2, 3].includes(deliveryPlan.deliveryPlanStatusId)) {
                            return data.plannedQuantity
                        } else if ([4, 5, 6].includes(deliveryPlan.deliveryPlanStatusId)) {
                            return data.approvedQuantity
                        }
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        if ([1, 2, 3].includes(deliveryPlan.deliveryPlanStatusId)) {
                            return data.approvedQuantity
                        } else if ([4, 5, 6].includes(deliveryPlan.deliveryPlanStatusId)) {
                            return data.deliveredQuantity
                        }

                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        if ([1, 2, 3].includes(deliveryPlan.deliveryPlanStatusId)) {
                            return data.deliveredQuantity
                        } else if ([4, 5, 6].includes(deliveryPlan.deliveryPlanStatusId)) {
                            if (data.receivedQuantity == 0) {
                                return ''
                            } else if (!isTopAdmin) {
                                return data.receivedQuantity
                            }
                            var this_receive_url = receive_url.replace(':id', data[
                                'deliveryPlanId']);
                            var rcv_this_str =
                                ` <a  href="javascript:" data-param="${btoa(JSON.stringify(data))}" data-delivered-quantity="${data.deliveredQuantity}"
                                                    data-received-quantity="${data.receivedQuantity}"
                                                    data-deliveryplandetailsid="${data.deliveryPlanDetailsId}"
                                                data-url="${this_receive_url}" title="Receive"
                                                class="receiving   px-2 font-weight-bold ">
                                                <i class="fa fa-pencil"></i>${data.receivedQuantity}</a>`;
                            return rcv_this_str
                        }

                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        if (data.deliveryPlanDetailsStatus.deliveryPlanDetailsStatusId == 1) {
                            return `Pending`
                        }
                        return data.deliveryPlanDetailsStatus.deliveryPlanDetailsStatus
                    }
                },
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        var this_id = deliveryPlanId;
                        var this_receive_url = receive_url.replace(':id', data[
                            'deliveryPlanId']);
                        var this_approve_url = approve_url.replace(':id', data[
                            'deliveryPlanId']);
                        var this_status = data;
                        // var this_status_change_url = status_change_url.replace(':id', data[
                        //     'deliveryPlanId']);
                        console.log('true1' +
                            deliveryPlan.deliveryPlanStatusId);
                        var this_str = ``;

                        if ([2].includes(deliveryPlan.deliveryPlanStatusId)) {

                            if (isTopAdmin && (adminId !== data.adminId) &&
                                (data.approvedQuantity == 0 || data.approvedQuantity == null)) {
                                console.log('true2');
                                this_str =
                                    `<div class="btn btn-sm btn-rounded animated-shine">send intimaion</div>`
                            }

                            if (adminId == data.adminId) {
                                this_str +=
                                    ` <a  href="javascript:" data-param=""
                                                data-url="${this_approve_url}" title="Approve"
                                                class="load-popup   btn btn-sm btn-rounded  animated-shine px-2  ">
                                                <i class="fa fa-pencil"></i>Approve</a>`;
                            }

                        } else if ([4, 5, 6].includes(deliveryPlan.deliveryPlanStatusId) &&
                            data.deliveredQuantity > 0 &&
                            adminId == data.adminId && data.receivedQuantity == 0) {
                            this_str +=
                                ` <a  href="javascript:" data-param="${btoa(JSON.stringify(data))}" data-delivered-quantity="${data.deliveredQuantity}"
                                                    data-received-quantity="${data.receivedQuantity}"
                                                    data-deliveryplandetailsid="${data.deliveryPlanDetailsId}"
                                                data-url="${this_receive_url}" title="Receive"
                                                class="receiving btn btn-sm btn-rounded  animated-shine px-2  ">
                                                <i class="fa fa-pencil"></i>Receive</a>`;
                            // this_str +=
                            //     ` <a  href="javascript:" data-param=""
                            //                     data-url="${this_receive_url}" title="Receive"
                            //                     class="load-popup   btn btn-sm btn-rounded  animated-shine px-2  ">
                            //                     <i class="fa fa-pencil"></i>Receive</a>`;
                            if (data.receivedQuantity !== 0 && !isTopAdmin) {
                                this_str = ``

                            }
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

    $(document).on("click", ".receiving", function(e) {
        const receivingPanel = document.querySelector('#receivingPanel');
        const thisPointHTML = e.target.innerHTML;
        console.log(thisPointHTML);
        var spinner =
            `<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> `;
        e.target.innerHTML = spinner;
        e.target.style = "pointer-events: none";

        let deliveredQuantity = $(this).data('delivered-quantity');
        let receivedQuantity = $(this).data('received-quantity');
        let deliveryPlanDetailsId = $(this).data('deliveryplandetailsid');
        let param = JSON.parse(atob($(this).data('param')));
        let size = '';
        e.target.innerHTML = thisPointHTML;
        e.target.style = "pointer-events: auto";
        document.querySelector('#receivingPanel #receivingQuantity').value = param.receivedQuantity == 0 ? param
            .deliveredQuantity : param.receivedQuantity;
        document.querySelector('#receivingPanel #planDetails').value = $(this).data('param');

        document.querySelector('#receivingPanel #officeName').innerHTML = param.office.officeName;
        document.querySelector('#receivingPanel #order').innerHTML = param.approvedQuantity;
        document.querySelector('#receivingPanel #delivery').innerHTML = param.deliveredQuantity;
        if (receivingPanel.classList.contains('d-none')) {
            receivingPanel.classList.remove('d-none')



        }
    });


    function getData(ev = {}, id = 0) {

        let defaultHtml = ``
        try {
            defaultHtml = ev.innerHTML;
            ev.innerHTML =
                `updating... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> `

        } catch (error) {

        }

        var url = "{{ route($routeRole . '.delivery_plan.get_data', ':id') }}";
        // var deliveryPlanId = {{ $planDetails['deliveryPlanId'] }};
        url = url.replace(':id', id == 0 ? deliveryPlanId : id);

        // deliveryPlanDetails = [];
        $.ajax({
            type: "GET",
            url: url,
        }).done(function(data) {
            if (!data.data) {
                ev.innerHTML = defaultHtml
                toastr.error("No data found")
            } else {

                toastr.info("record(s) reloaded")
                deliveryPlan = data.data
                setHeader()

                try {
                    ev.innerHTML = defaultHtml
                } catch (error) {

                }

            }
        }).fail(function(data) {
            try {
                ev.innerHTML = defaultHtml
            } catch (error) {

            }
            toastr.error("something went wrong");
        });
    }


    function setHeader(params = deliveryPlan) {

        let header_part = document.querySelector('#header_part');
        let planStatusHtml = `<div>`

        let driver_url = `{{ route($routeRole . '.delivery_plan.driver', ':id') }}`;
        let this_driver_url = driver_url.replace(':id', deliveryPlan.deliveryPlanId);
        if (deliveryPlan.deliveryPlanStatusId < 3 && isTopAdmin) {

            for (let i = 0; i < deliveryPlanStatus.length; i++) {

                if (deliveryPlanStatus[i].deliveryPlanStatusId > deliveryPlan.deliveryPlanStatusId) {
                    planStatusHtml +=
                        `
                            {{ __('Set status as') }}
                            <a href="javascript:" onclick="set_complete(this,${deliveryPlanStatus[i].deliveryPlanStatusId})"
                            class=" btn btn-sm animated-shine btn-rounded">${deliveryPlanStatus[i].deliveryPlanStatus}</a>
                 `;
                    break;
                }
            }
        } else if (deliveryPlan.deliveryPlanStatusId == 3 && isTopAdmin) {
            planStatusHtml += `
                                        <a href="javascript:"
                                        data-param="${deliveryPlan.deliveryPlanId}" data-url="${this_driver_url}"
                                         title="{{ __('Assign Driver') }}" class="load-popup   btn btn-sm animated-shine btn-rounded   ">{{ __('Assign Driver') }}</a>
                                   `
        }
        planStatusHtml += `<button class="btn btn-sm animated-shine  text-light" onclick="getData(this)" title="{{ __('reload') }}">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-sm animated-shine  text-light " onclick="getMap(this)" title="{{ __('map view') }}">
                        <i class="fas fa-map " aria-hidden="true"></i>
                    </button></div>`
        header_part.innerHTML = ``;
        var headerHtml = `<div class="col-md-6 left-col">
                <div>
                    {{ __('Hub') }}: <span class="font-weight-bold">${ params['startPoint']['hubName'] }</span>
                </div>
                <div>
                    {{ __('Product') }}: <span class="font-weight-bold">${ params['product']['productTypeName'] }</span>
                </div>
                <div>
                    {{ __('No Of Delivery Point') }}: <span
                        class="font-weight-bold">${ params['deliveryPlanDetailsList'].length }</span>
                </div>
                <div>

                </div>
            </div>
            <div class="col-md-6 right-col">
                <div>
                    {{ __('Plan Date') }}: <span
                        class="font-weight-bold">${ moment(params['planDate']).format('DD-MMM-YYYY') }</span>
                </div>
                <div>
                    {{ __('Delivery Date') }}: <span
                    class="font-weight-bold">${ moment(params['expectedDeliveryDate']).format('DD-MMM-YYYY')  }</span>
                </div>
                <div>
                    {{ __('Current Status') }}: <span class="text-info plan_status">
                        ${ params['deliveryPlanStatus']['deliveryPlanStatus'] }</span>
                </div>
                ${planStatusHtml}
                </div>
                `;

        header_part.innerHTML = headerHtml; // headerHtml
        setDataTable();
    }

    function setDataTable(params = deliveryPlan.deliveryPlanDetailsList) {
        const tablePanel = document.querySelector("#tablePanel")
        tablePanel.innerHTML = ``
        tablePanel.innerHTML = DataTableStructureHtml();
        dataTableInit();

    }

    function DataTableStructureHtml() {
        let tableHeads = `<div class="table-responsive">
                <table id="table" class="table table-striped table-bordered  table-hover dt-responsive display nowrap">
                    <thead>
                        <tr>
                            <th data-visible="${ isTopAdmin }">{{ __('SLNo') }}</th>
                            <th>{{ __('Pump Name') }}</th>
                            <th data-visible="${ isTopAdmin }">{{ __('Admin') }}</th>
                            <th title='{{ __('Delivery Date') }}'>{{ __('Del Date') }}</th>`
        if (deliveryPlan.deliveryPlanStatusId == 1) {
            tableHeads +=
                ` <th title='{{ __('Suggested Quantity') }}'>{{ __('Sugg Qty') }}</th>
                        <th title='{{ __('Suggested Quantity') }}' data-visible="false">{{ __('Ord Qty') }}</th>
                        <th title='{{ __('Delivery Quantity') }}' data-visible="false">{{ __('Del Qty') }}</th>`
        } else if (deliveryPlan.deliveryPlanStatusId == 2) {
            tableHeads +=
                `<th title='{{ __('Suggested Quantity') }}'>{{ __('Sugg Qty') }}</th>
                                <th title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>
                                <th title='{{ __('Delivery Quantity') }}' data-visible="false">{{ __('Del Qty') }}</th>`
        } else if (deliveryPlan.deliveryPlanStatusId == 3) {
            tableHeads +=
                `<th title='{{ __('Suggested Quantity') }}' data-visible="false">{{ __('Sugg Qty') }}</th>
                <th title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>
                                <th title='{{ __('Delivery Quantity') }}' data-visible="false">{{ __('Del Qty') }}</th>`
        } else if (deliveryPlan.deliveryPlanStatusId == 4) {
            tableHeads += ` <th title='{{ __('Order Quantity') }}'>{{ __('Ord Qty') }}</th>
                                <th title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                                <th title='{{ __('Received Quantity') }}'>{{ __('Rcvd Qty') }}</th>`
        } else if (deliveryPlan.deliveryPlanStatusId == 5) {
            tableHeads += `<th title='{{ __('Order Quantity') }}' data-visible="false">{{ __('Ord Qty') }}</th>
            <th title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                                <th title='{{ __('Received Quantity') }}'>{{ __('Rcvd Qty') }}</th>`
        } else if (deliveryPlan.deliveryPlanStatusId == 6) {
            tableHeads += ` <th title='{{ __('Order Quantity') }}' data-visible="false">{{ __('Ord Qty') }}</th>
            <th title='{{ __('Delivery Quantity') }}'>{{ __('Del Qty') }}</th>
                                <th title='{{ __('Received Quantity') }}'>{{ __('Rcvd Qty') }}</th>`
        }
        tableHeads += `<th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>

                    </thead>


                </table>
            </div>`
        return tableHeads;
    }



    function st(starttime, endtime) {

        //this is correct way to get time gap between two dates
        var duration = (new Date(endtime)).getTime() - (new Date(starttime)).getTime();
        // console.log(starttime, endtime, distance);

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(duration / (1000 * 60 * 60 * 24));
        var hours = Math.floor((duration % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((duration % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((duration % (1000 * 60)) / 1000);
        // Output the result in an element with id="demo"
        return days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        // var x = setInterval(function() {

        //     // Time calculations for days, hours, minutes and seconds
        //     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        //     var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        //     // Output the result in an element with id="demo"
        //     document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
        //         minutes + "m " + seconds + "s ";
        //     //This line is added to decrease distance by 1 second
        //     distance -= 1000
        //     // If the count down is over, write some text
        //     if (distance < 0) {
        //         clearInterval(x);
        //         document.getElementById("demo").innerHTML = "EXPIRED";
        //     }
        // }, 1000);
    }

    function datetimeLocal(datetime) {
        const dt = new Date(datetime);
        dt.setMinutes(dt.getMinutes() - dt.getTimezoneOffset());
        return dt.toISOString().slice(0, 16);
    }

    function replacer(key, value) {
        if (typeof value === 'string') {
            //to avoid ///"
            //add space to , and :
            return value.replace(/"/g, '').replace(/,/g, ', ').replace(/:/g, ': ')
        } else {
            return value
        }
    }

    function getMapData(e, paramDeliveryPlanStatusId) {
        var officeIds = deliveryPlan.deliveryPlanDetailsList.map(function(a) {
            return a.officeId
        });
        let newOfficeList = JSON.stringify(officeIds, replacer);
        //console.log(deliveryPlan);


        var formData = new FormData($('#FormSetStatus')[0])
        formData.append('OfficeIdList', newOfficeList);
        formData.append('deliveryPlanId', deliveryPlanId);
        formData.append('productTypeId', deliveryPlan.productId);
        formData.append('StartingPointId', deliveryPlan.startPointId);
        formData.append('MinimumMultiple', deliveryPlan.deliveryLimit);
        formData.append('TankCapacity', deliveryPlan.containerSize);
        formData.append('PlanDateTime', deliveryPlan.planDate);
        formData.append('expectedDeliveryDate', deliveryPlan.expectedDeliveryDate);
        //console.log(formData);
        //return;reportPanel

        //var url = "{{ route($routeRole . '.delivery_plan.store') }}";
        var url = "{{ route($routeRole . '.delivery_plan.modified_request') }}";
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            processData: false, // don't process the data
            contentType: false, // set content type to false as jQuery will tell the server its a query string request
        }).done(function(data) {
            // console.log(data);
            if (!data.status) {

                if (data.errors != 'undefined') {
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });
                } else {

                    toastr.error(data.message);
                }

            } else {
                setTimeout(() => {
                    //$('.search').click();
                    // $('.close').click();
                    newList = data.data.Routes.Algorithm_1.Route;
                    Total_distance = data.data.Routes.Algorithm_1.Total_distance;
                    XXExpectedReturnTime = newList[newList.length - 1]
                        .estimatedDeliveryTime;
                    JourneyStartTime = datetimeLocal(newList[0].estimatedDeliveryTime);
                    ExpectedReturnTime = datetimeLocal(XExpectedReturnTime);

                    TotalJourneyTime = st(JourneyStartTime, ExpectedReturnTime);
                    //console.log(TotalJourneyTime);
                    // $('#ExpectedReturnTime').val(ExpectedReturnTime);
                    // $('#ModifiedExpectedReturnTime').val(ExpectedReturnTime);

                    // dt_table1.clear().rows.add(newList.slice(1, -1)).draw();
                    // extraList = data.data.Not_selected;
                    // dt_table2.clear().rows.add(extraList).draw();
                    toastr.success("Route optimize");
                    if ($('#mapWrapperPanel').hasClass('d-flex')) {
                        console.log('abc');
                        initMap();

                    }
                }, 1000);
            }
        }).fail(function(data) {


            toastr.error(data.message);

            // console.log(data);
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
</script>
