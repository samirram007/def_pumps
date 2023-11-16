<div class="alert alert-danger sr-only"></div>
<form id="formSavePlan">
    <div class="row justify-content-center align-items-center mb-4">

        @csrf
        <div class="col-12 col-md-2 text-md-right">{{ __('Plan Name') }} : </div>
        <div class="col-12 col-md-6 ">
            <input id="planTitle" name="planTitle" class=" w-100 border-bottom border-primary p-2 rounded-pill "
                class="form-control" value="{{ $planTitle }}" />

        </div>


        @if (isset($requestData))
            <input type="text" id="deliveryPlanId" name="deliveryPlanId" class="sr-only"
                value="{{ $requestData['DeliveryPlanId'] }}">
            <input type="text" name="productId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
            <input type="text" name="productTypeId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
            <input type="text" name="StartingPointId" class="sr-only" value="{{ $requestData['StartingPointId'] }}">
            <input type="text" name="manufactureingHub" class="sr-only"
                value="{{ $requestData['StartingPointId'] }}">
            <input type="text" name="MinimumMultiple" class="sr-only" value="{{ $requestData['MinimumMultiple'] }}">
            <input type="text" name="TankCapacity" class="sr-only" value="{{ $requestData['TankCapacity'] }}">

            <input type="datetime-local" name="planDate" class="sr-only" value="{{ $requestData['planDate'] }}">
            <input type="datetime-local" name="expectedDeliveryDate" class="sr-only"
                value="{{ $requestData['expectedDeliveryDate'] }}">
            <input type="datetime-local" id="ExpectedReturnTime" name="ExpectedReturnTime" class="sr-only"
                value="">
        @endif

        <div class="col-12 col-md-4 d-flex flex-row align-items-center justify-content-center  ">

            @if (isset($requestData) && $requestData['DeliveryPlanId'] > 0)
                <button id="save_plan" type="submit"
                    class="save_plan btn btn-rounded animated-shine px-2 mx-4 ">{{ __('Update Plan') }}</button>
            @else
                <button id="save_plan" type="submit"
                    class="save_plan btn btn-rounded animated-shine px-2 mx-4 ">{{ __('Save Plan') }}</button>
            @endif



        </div>
        <style>
            .btn-box {
                display: inline-block;
                white-space: nowrap;
                position: relative;
                padding: 1rem.75rem;
                font-size: 16px;
                line-height: 1.5;
                color: #fff;
                background-color: var(--info);
                border-radius: .3rem;
                cursor: pointer;
                transition: all ease-in-out.3s;
                width: 100%;
                min-width: fit-content;

            }

            .gap-10 {
                gap: 10px;
            }

            .fa-circle {
                border-radius: 50%;
                background-color: #9ca3a270;
                color: #0a705a;
                font-size: 100%;
            }

            .fa-circle:active {
                background-color: #464949d0;
                color: #d0ebe5;
                rotate: 45deg;
            }

            .fa-circle:hover {
                background-color: #3b6e6e91;
                color: #13332c;
                rotate: -135deg;
                transition: rotate 1s ease-in-out;
            }

            .btn-box>div {}

            .animated-shine {
                animation: shine 8s infinite linear alternate forwards running;
                transform-origin: center bottom !important;

            }

            .value_fit {
                max-width: 130px;
            }

            .sl_fit {
                max-width: 30px;
            }

            .desc_fit {
                max-width: 250px;
            }

            /* Animation */
            /* @keyframes shine {
                        0%   {transform: rotate(0deg);}
                        100% {transform: rotate(-360deg);}
                        } */
        </style>
        <div class="col-12  gap-5  d-flex flex-row align-items-center justify-content-end mt-2 overflow-hidden ">
            <div class="btn-box animated-shine d-none " onclick="toggleRequestPanel(this);"
                title="{{ __('Modify Request') }}">

                <i class="fa fa-paper-plane"></i>
                <div>{{ __('Request') }}</div>
            </div>

            <div class="btn-box btn-block animated-shine update-route  " onclick="updateRoute(this);"
                title="{{ __('Set Optimize route') }}">

                <i class="fa fa-bullseye"></i>
                <div>{{ __('Set Optimize Route') }}</div>
            </div>
            <div class="btn-box animated-shine " onclick="toggleMapPanel(this);" title="{{ __('Map View') }}">

                <i class="fas fa-map"></i>
                <div>{{ __('Map View') }}</div>


            </div>


        </div>



    </div>
</form>
<form id="formRequestModifiedPlan">
    @csrf
    @if (isset($requestData))
        <input type="text" name="productId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
        <input type="text" name="productTypeId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
        <input type="text" name="StartingPointId" class="sr-only" value="{{ $requestData['StartingPointId'] }}">
        <input type="text" name="manufactureingHub" class="sr-only" value="{{ $requestData['StartingPointId'] }}">
        <input type="text" name="MinimumMultiple" class="sr-only" value="{{ $requestData['MinimumMultiple'] }}">
        <input type="text" name="TankCapacity" class="sr-only" value="{{ $requestData['TankCapacity'] }}">

        <input type="datetime-local" name="planDate" class="sr-only" value="{{ $requestData['planDate'] }}">
        <input type="datetime-local" name="expectedDeliveryDate" class="sr-only"
            value="{{ $requestData['expectedDeliveryDate'] }}">
        <input type="datetime-local" id="ModifiedExpectedReturnTime" name="ExpectedReturnTime" class="sr-only"
            value="">
        {{-- @dump($requestData) --}}
        <button id="modify_plan" type="submit" class="modify_plan  sr-only">{{ __('Update Plan') }}</button>
    @endif
</form>
<div id="listWrapperPanel" class="d-flex flex-column">


    <div class="  card border border-primary">
        @if (isset($response))
            <div class="dragHeader" id="SummaryOne"> {{ $response['Routes']['Algorithm_1']['Description'] }}</div>
        @else
            <div class="dragHeader" id="SummaryOne"> {{ __(' Routing based on Nearest Branch ') }}</div>
        @endif
        {{-- @dd(json_encode($response)) --}}
        <div class="table-responsive">
            <table id="table1" class="table   table-striped table-bordered  display" cellspacing="0"
                style="width:100%">
                <thead>
                    <tr>
                        <td class="sl_fit">{{ __('Sl') }}</td>
                        <td class="desc_fit">{{ __('Pumps') }}</td>
                        <td class="value_fit">{{ __('Current') }}({{ __('in ltr') }})</td>
                        <td class="value_fit">{{ __('Availability') }}({{ __('in ltr') }})</td>
                        <td class="editable-column value_fit">{{ __('Suggested') }}({{ __('in ltr') }})</td>

                        <td class="value_fit"
                            data-visible="{{ (isset($requestData) && $requestData['DeliveryPlanId']) != 0 ? true : false }}">
                            {{ __('Order') }}</td>
                        <td class="value_fit"
                            data-visible="{{ (isset($requestData) && $requestData['DeliveryPlanId']) != 0 ? true : false }}">
                            {{ __('Receive') }}</td>
                        <td class=""
                            data-visible="{{ (isset($requestData) && $requestData['DeliveryPlanId']) != 0 ? true : false }}">
                            {{ __('Status') }}</td>
                        {{-- @if (isset($requestData))
                            @if ($requestData['DeliveryPlanId'] != 0)
                                <td class="">{{ __('Status') }}</td>
                            @endif
                        @endif --}}

                    </tr>
                </thead>

            </table>
        </div>


        {{-- <div id="tableFooterOne" class="dragBlockFooter ">
        <div class="dragItem">{{ __('Total Pumps( as ready ) : ') }}{{ $sl_no }}</div>

        <div class="dragItem text-white">{{ $totalCurrentStock }}</div>
        <div class="dragItem text-white">{{ $totalAvailability }}</div>


        <div class="dragItem pl-4">{{ $totalRequirement }}</div>

        <div>- </div>
    </div> --}}




    </div>
    <div class="  mt-4 border-top border-info border-md">
        @if (isset($response))
            <div class="dragHeader" id="SummaryTwo">

            </div>
        @else
            <div class="dragHeader" id="SummaryTwo"> {{ __('More Pums in the queue') }}</div>
        @endif
        {{-- @dd(json_encode($response)) --}}
        {{-- @dd($response['Routes']['Algorithm_1']['Route']) --}}
        <table id="table2" class="table   table-striped table-bordered w-100  ">
            <thead>
                <tr>
                    <td class="sl_fit">{{ __('Sl') }}</td>
                    <td class="desc_fit">{{ __('Pumps') }}</td>
                    <td class="value_fit">{{ __('Current') }}({{ __('in ltr') }})</td>
                    <td class="value_fit">{{ __('Availability') }}({{ __('in ltr') }})</td>
                    <td class="value_fit">{{ __('Suggested') }}({{ __('in ltr') }})</td>
                </tr>
            </thead>
            {{-- <tbody id="wrapperTwo">

                @php
                    $Q_sl_no = 0;
                    $Q_TotalRequirement = 0;
                @endphp
                @if (isset($response))

                    @forelse ($response['Not_selected']  as $key => $item)
                        @if ($item['atDeliveryRequirement'] > 0)
                            <tr class="" draggable="true">
                                <td class="">{{ ++$sl_no }}</td>
                                <td class="">{{ $item['officeName'] }}</td>
                                <td class="">{{ number_format($item['currentStock'], 3, '.', '') }}</td>
                                <td class="">
                                    {{ number_format($item['totalCapacity'] - $item['currentStock'], 3, '.', '') }}
                                </td>
                                <td class="">{{ number_format($item['atDeliveryRequirement'], 3, '.', '') }}
                                </td>
                                <td class="">
                                    <div class="dragItem">
                                        <div onclick="addNow({{ $key }});">
                                            <i class="fas  fa-upload"></i>
                                        </div>
                                    </div>



                                </td>
                            </tr>
                            @php
                                $Q_sl_no++;
                                $totalRequirement = $totalRequirement + $item['atDeliveryRequirement'];
                                $Q_TotalRequirement = $Q_TotalRequirement + $item['atDeliveryRequirement'];
                            @endphp
                        @endif
                    @empty
                        <div class="dragBlock ">{{ __('No Data Found') }}</div>
                    @endforelse
                @else
                    <div class="dragBlock ">{{ __('No Data Found') }}</div>

                @endif

            </tbody>
            <tfoot id="tableFooterTwo">
                <tr class="">
                    <th colspan="2" class="">{{ __('Total Pumps :') }} {{ $Q_sl_no }}</th>
                    <th class="text-white">{{ number_format($Q_TotalRequirement, 3, '.', '') }}</th>
                    <th class="text-white">{{ number_format($Q_TotalRequirement, 3, '.', '') }}</th>
                    <th class="">{{ number_format($Q_TotalRequirement, 3, '.', '') }}</th>
                    <th class=""></th>
                </tr>


            </tfoot> --}}
        </table>

        {{-- <tfoot id="tableFooterTwo">
        <tr class="dragBlockFooter border-bottom border-top  border-info ">
            <th colspan="2" class="">{{ __('Total Pumps :') }} {{ $sl_no }}</th>
            <th class="text-white">{{ $totalRequirement }}</th>
            <th class="text-white">{{ $totalRequirement }}</th>
            <th class="">{{ $totalRequirement }}</th>
            <th class=""></th>
        </tr>


    </tfoot> --}}
    </div>
</div>

<style scoped>
    .set-transparent {
        animation: opec 1s ease-in 1;
    }

    table.dataTable>tbody>tr.child span.dtr-title {
        display: inline-block;
        min-width: 100px !important;
        font-weight: bold;
    }

    @keyframes opec {
        0% {
            opacity: 1
        }

        80% {
            0
        }
    }

    .dragList {
        display: flex;
        justify-content: space-between;
        flex-flow: column nowrap;
    }



    .draggable {
        cursor: grabbing !important;
        margin: 5px 0;
        border-radius: 3px;
    }

    .draggable-icon>img {
        opacity: 0.2;
        width: 20px !important;
        height: 20px !important;

    }

    .dragging {
        background-color: rgba(255, 0, 0, 0.521);
        opacity: 0.5;
    }

    .dragHeader>div>div {}

    .rowHeader {
        display: flex;
        margin-inline-start: 20px;
        padding-inline-start: 10px;
        gap: 5px;
        flex-direction: column;
    }

    .rowHeader::before {
        content: '';
    }

    .dragBlockHeader,
    .dragBlockFooter {
        /* border-bottom border-top border-info bg-light py-2 */
        display: flex;
        justify-content: space-between;
        flex-flow: row nowrap;
        font-weight: bold;
        padding: 0.2rem 0.5rem;
    }

    .dragList .dragBlock {
        display: flex;
        justify-content: space-between;
        flex-flow: row nowrap;
        font-size: small !important;
        color: #495057 !important;
        background-color: #fff !important;
        padding: .5rem .75rem !important;


    }


    .dragItem {
        display: flex;
        gap: 5px;
        justify-content: end;
        align-items: center;
    }

    .dragItem>div {
        border-radius: 50%;
        border: 1px dotted #999;
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all 0.2s ease-in-out;
    }

    .dragItem>div:hover {
        cursor: pointer;
        background: #aaaaaa62;
        border: 1px dotted #99999928;
        box-shadow: 0 0 2px 2px #9999995b;

    }

    .not-active {
        pointer-events: none;
    }

    .active {
        pointer-events: auto;
    }

    #map {
        height: 60vh;
        border: 6px solid #4d9784e1;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 0 10px 0 #0000001a;
    }

    /* Add CSS styles to highlight the cell in edit mode */
    .edit-mode {
        background-color: rgba(46, 186, 241, 0.185);
        color: #2c2d35;
        width: 100%;
        height: 30px;
        padding: 5px;
        text-align: right;
        outline: transparent;
        transition: all 0.7s ease-in-out;
        font-weight: bolder;

    }

    .editable {
        height: 40px;
        transition: all 0.3s ease-in-out;
        border: 2px dashed #0d5a4d7c;
        background: #30e4c62f;
        border-radius: 5px;
    }

    .editable:focus {
        height: 40px;
        transition: all 0.3s ease-in-out;
        border: 2px dashed #091a1742;
        background: #30e4c64f;
        border-radius: 1px;
    }

    .modified-cell {
        font-weight: bolder;
        background: #49dfc6d7;
    }

    .modified {
        background-color: #247bfd9c !important;
        background: linear-gradient(to left, #247bfd9c, #ffffff02) !important;
    }

    .start-box,
    .td_box {
        height: 40px;
    }
</style>


@if (isset($response))
    <script>
        //let newList=[];




        $("#formSavePlan").on("submit", function(event) {

            event.preventDefault();
            if (!isOptimize) {
                toastr.error("Route Optimization Required")
                return


            }
            //alert();
            // $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            let btnText = $('#save_plan').html();
            $('#save_plan').attr('disabled', true);
            $('#save_plan').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            var addOne = newList.reduce(function(previousValue, currentValue) {
                return {
                    officeId: previousValue.officeId + currentValue.officeId,
                    atDeliveryRequirement: previousValue.atDeliveryRequirement + parseFloat(currentValue
                        .atDeliveryRequirement),

                }
            });
            // let newListLength=newList.length - 2;
            var TankCapacity = {{ $requestData['TankCapacity'] }};
            var styleCheck = 'text-info cursor-pointer';
            var limitWarning = `Tank Capacity: ${TankCapacity} ltr`;
            //console.log(TankCapacity,addOne.atDeliveryRequirement);
            if (addOne.atDeliveryRequirement > TankCapacity) {

                styleCheck = 'text-danger cursor-pointer';
                limitWarning = `Exceed the Tank Capacity Limit : ${TankCapacity} ltr`;
                toastr.error(limitWarning);
                $('#save_plan').attr('disabled', false);
                $('#save_plan').html(btnText);
                return
            }

            var formData = new FormData($(this)[0]);
            // console.log(formData);

            let data = newList.slice(1, -1);
            formData.append('data', JSON.stringify(data));
            formData.append('extraList', JSON.stringify(extraList));

            console.log(data);
            //return;reportPanel


            var url = "{{ route($routeRole . '.delivery_plan.store') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                processData: false, // don't process the data
                contentType: false, // set content type to false as jQuery will tell the server its a query string request
            }).done(function(data) {
                if (!data.status) {

                    $('#save_plan').attr('disabled', false);
                    $('#save_plan').html(btnText);

                    if (data.errors != 'undefined') {
                        $.each(data.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next().text(value);
                            toastr.error(value);
                        });
                    } else {

                        toastr.error(data.message);
                    }

                    $('#save_plan').attr('disabled', false);
                    $('#save_plan').html(btnText);
                } else {
                    toastr.success(data.message);
                    $('#content-wrapper').addClass('set-transparent');

                    setTimeout(() => {
                        //$('.search').click();
                        // $('.close').click();
                        // $('#save_plan').attr('disabled', false);
                        // $('#save_plan').html(btnText);

                        window.location.href = `{{ route('companyadmin.delivery_plan') }}`;
                    }, 100);
                }
            }).fail(function(data) {

                $('#save_plan').attr('disabled', false);
                $('#save_plan').html(btnText);
                toastr.error(data.message);

                // console.log(data);
            });

        });

        //const jsonData = JSON.stringify(data, replacer)
        $("#formRequestModifiedPlan").on("submit", function(event) {

            event.preventDefault();


            var addOne = newList.reduce(function(previousValue, currentValue) {
                return {
                    officeId: previousValue.officeId + currentValue.officeId,
                    atDeliveryRequirement: previousValue.atDeliveryRequirement + parseFloat(currentValue
                        .atDeliveryRequirement),

                }
            });
            // let newListLength=newList.length - 2;
            var TankCapacity = {{ $requestData['TankCapacity'] }};
            var styleCheck = 'text-info cursor-pointer';
            var limitWarning = `Tank Capacity: ${TankCapacity} ltr`;
            //console.log(TankCapacity,addOne.atDeliveryRequirement);
            if (addOne.atDeliveryRequirement > TankCapacity) {

                styleCheck = 'text-danger cursor-pointer';
                limitWarning = `Exceed the Tank Capacity Limit : ${TankCapacity} ltr`;
                toastr.error(limitWarning);
                // $('#save_plan').attr('disabled', false);
                // $('#save_plan').html(btnText);
                //  return;
            }
            //alert();
            // $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            var formData = new FormData($(this)[0]);
            // console.log(formData);

            // let data = newList.slice(1, -1);
            var officeIds = newList.slice(1, -1).map(function(a) {
                return a.officeId
            });
            let newOfficeList = JSON.stringify(officeIds, replacer);
            //console.log(newOfficeList);
            formData.append('OfficeIdList', newOfficeList);

            // console.log(formData);
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
                console.log(data);
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
                        $('#ExpectedReturnTime').val(ExpectedReturnTime);
                        $('#ModifiedExpectedReturnTime').val(ExpectedReturnTime);

                        dt_table1.clear().rows.add(newList.slice(1, -1)).draw();
                        extraList = data.data.Not_selected;
                        dt_table2.clear().rows.add(extraList).draw();
                        toastr.success("Route optimize");
                        if ($('#mapWrapperPanel').hasClass('d-flex')) {

                            initMap();

                        }
                    }, 1000);
                }
            }).fail(function(data) {


                toastr.error(data.message);

                // console.log(data);
            });

        });

        var response = @json($response);


        isOptimize = true
        //  console.log(response.Routes.Algorithm_1.Route);
        var routeList = response.Routes.Algorithm_1.Route;
        var Total_distance = response.Routes.Algorithm_1.Total_distance;
        // console.log(Total_distance);
        //console.log(response.hasOwnProperty('DeliveryPlan_statusId'));
        var DeliveryPlanStatusId = response.hasOwnProperty('DeliveryPlan_statusId') ? response.DeliveryPlan_statusId : 0;
        //console.log("Plan Status: "+DeliveryPlanStatusId);
        newList = routeList;
        // console.log(Date.Parse(newList[newList.length - 1].estimatedDeliveryTime));
        var XExpectedReturnTime = newList[newList.length - 1].estimatedDeliveryTime;
        var JourneyStartTime = datetimeLocal(newList[0].estimatedDeliveryTime);
        var ExpectedReturnTime = datetimeLocal(XExpectedReturnTime);

        var TotalJourneyTime = st(JourneyStartTime, ExpectedReturnTime);
        //console.log(TotalJourneyTime);
        $('#ExpectedReturnTime').val(ExpectedReturnTime);
        $('#ModifiedExpectedReturnTime').val(ExpectedReturnTime);
        var extra_list = response.Not_selected;

        var extraList = extra_list;

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

        function deleteNow(index) {
            extraList.push(newList[index]);
            modifiedOffice.push(newList[index]['officeId']);
            newList.splice(index, 1);


            newList = reindex_array_keys(newList);
            dt_table1.clear().rows.add(newList.slice(1, -1)).draw();

            extraList = reindex_array_keys(extraList);
            dt_table2.clear().rows.add(extraList).draw();
            //    reArrangeWrapperTwo(extraList);
            calculateSummary()

        }

        function addNow(index) {

            //New Method
            // newList.splice(newList.length - 1, 0, extraList[index]);
            // reIndexList();

            //Old Method

            modifiedOffice.push(extraList[index]['officeId']);
            newList.splice(newList.length - 1, 0, extraList[index]);

            newList = reindex_array_keys(newList);
            dt_table1.clear().rows.add(newList.slice(1, -1)).draw();

            //newList.push(extraList[index]);
            extraList.splice(index, 1);
            extraList = reindex_array_keys(extraList);
            dt_table2.clear().rows.add(extraList).draw();
            calculateSummary();
        }

        function updateRoute(element) {
            isOptimize = true
            TotalDistance = 0;
            let i_element = '';
            Object.values(element.childNodes).forEach(val => {
                var tag = val.tagName;

                if (tag == 'I') {

                    //     // val.className='fas fa-check text-success mr-3 ';

                    if (val.classList.contains('fa-bullseye')) {

                        val.classList.remove('fa-bullseye');
                        val.classList.add('spinner-border');
                        val.classList.add('spinner-border-sm');
                        i_element = val;

                    }
                }

            });
            $('#formRequestModifiedPlan').submit();
            setTimeout(() => {
                if (i_element.classList.contains('spinner-border')) {
                    i_element.classList.add('fa-bullseye');
                    i_element.classList.remove('spinner-border');
                    i_element.classList.remove('spinner-border-sm');
                }
            }, 3000);

            return;

        }



        function reArrange(newList) {
            var str = '';
            var count = 0;
            var reqTotal = 0;
            TotalDistance = 0;
            $.each(newList, function(index, value) {
                if (value.atDeliveryRequirement > 0) {

                    var check1 = (index > 1 && index < newList.length - 1) ? 'active' :
                        'not-active disabled';
                    var check2 = (index > 0 && index < newList.length - 2) ? 'active' :
                        'not-active disabled';
                    str += '<tr>';
                    str += '<td>' + index + '</td>';
                    str += '<td>' + value.officeName + '</td>';
                    str += '<td>' + value.currentStock.toFixed(3) + '</td>';
                    str += '<td>' + (value.totalCapacity - value.currentStock).toFixed(3) + '</td>';
                    str += '<td>' + value.atDeliveryRequirement.toFixed(3) + '</td>';
                    str += '<td><div class="dragItem">' +
                        '<div class="' + check1 + '" onclick="swapNow(' + index + ',' + (index - 1) +
                        ');">' +
                        '<i class="fas fa-arrow-up"></i></div>' +
                        ' <div class="' + check2 + '" onclick="swapNow(' + index + ',' + (index + 1) +
                        ');">' +
                        ' <i class="fas fa-arrow-down"></i>' +
                        '</div>' +
                        '<div onclick="deleteNow(' + index + ');">' +
                        '    <i class="fas    fa-download"></i>' +
                        '</div>' +
                        '</div></td></tr>';
                    count++;
                    reqTotal += value.atDeliveryRequirement;
                }

            });
            let strFooter = '  <tr >' +
                '<th colspan="2">{{ __('Total Pumps( as ready) :') }} ' + count + '</th>' +
                '<th class="text-white">' + reqTotal.toFixed(3) + '</th>' +
                '<th  class="text-white">' + reqTotal.toFixed(3) + '</th>' +
                '<th>' + reqTotal.toFixed(3) + '</th>' +
                '<th> </th>' +
                '</tr> ';
            $('#wrapperOne').html(str);
            $('#tableFooterOne').html(strFooter);

        }

        function reArrangeWrapperTwo(extraList) {
            var str = '';
            var Qcount = 0;
            var QreqTotal = 0;
            TotalDistance = 0;
            $.each(extraList, function(index, value) {
                if (value.atDeliveryRequirement > 0) {

                    // var check1 = (index > 1 && index < extraList.length - 1) ? 'active' : 'not-active disabled';
                    // var check2 = (index > 0 && index < extraList.length - 2) ? 'active' : 'not-active disabled';
                    str += '<tr class="" draggable="true">';
                    str += '<td class="">' + (index + newList.length - 1) + '</td>';
                    str += '<td class="">' + value.officeName + '</td>';
                    str += '<td>' + value.currentStock.toFixed(3) + '</td>';
                    str += '<td>' + (value.totalCapacity - value.currentStock).toFixed(3) + '</td>';
                    str += '<td class="">' + value.atDeliveryRequirement.toFixed(3) + '</td>';
                    str += '<td class=""> <div class="dragItem">' +
                        '<div onclick="addNow(' + index + ');">' +
                        '    <i class="fas    fa-upload"></i>' +
                        '</div></div>' +
                        '</td></tr>';
                    Qcount++;

                    QreqTotal += value.atDeliveryRequirement;
                    //console.log(QreqTotal);

                }

            });
            let strFooter = '  <tr >' +
                '<th colspan="2"> {{ __('Total Pumps(in queue) :') }}' + Qcount + '</th>' +
                '<th class="text-white">' + QreqTotal.toFixed(3) + '</th>' +
                '<th  class="text-white">' + QreqTotal.toFixed(3) + '</th>' +
                '<th class="">' + QreqTotal.toFixed(3) + '</th>' +
                '<th class="">{{ __('-') }}</th>'
            '</tr>';
            $('#wrapperTwo').html(str);
            $('#tableFooterTwo').html(strFooter);
        }

        function reindex_array_keys(array, start) {
            var temp = [];
            start = typeof start == 'undefined' ? 0 : start;
            start = typeof start != 'number' ? 0 : start;
            for (var i in array) {
                temp[start++] = array[i];
            }
            return temp;
        }

        async function calculateSummary() {
            isOptimize = false;
            TotalDistance = 0;

            // console.log('isOptimize:' + isOptimize);
            var addOne = newList.reduce(function(previousValue, currentValue) {
                return {
                    officeId: previousValue.officeId + currentValue.officeId,
                    atDeliveryRequirement: previousValue.atDeliveryRequirement + parseFloat(currentValue
                        .atDeliveryRequirement),

                }
            });
            // let newListLength=newList.length - 2;
            var TankCapacity = {{ $requestData['TankCapacity'] }};
            var styleCheck = 'text-info cursor-pointer';
            var limitWarning = `Tank Capacity: ${TankCapacity} ltr`;
            //console.log(TankCapacity,addOne.atDeliveryRequirement);
            if (addOne.atDeliveryRequirement > TankCapacity) {

                styleCheck = 'text-danger cursor-pointer';
                limitWarning = `Exceed the Tank Capacity Limit : ${TankCapacity} ltr`;
                toastr.error(limitWarning);
            }

            var strOne = `<ul class="rowHeader">
                <li title="${limitWarning}">Total requirements for  suggested ${(newList.length - 2)} pump(s) is
                    :<span class="${styleCheck}"> ${ parseFloat(addOne.atDeliveryRequirement).toFixed(0)} ltr</span></li>
                    <li>Suggested Distance : <span>${Total_distance.toFixed(0)} km</span></li>
                    <li> Suggested Travel Time : ${TotalJourneyTime}</li>

                    </ul>`;
            $('#SummaryOne').html(strOne);

            var addTwo = extraList.reduce(function(previousValue, currentValue) {
                return {
                    officeId: previousValue.officeId + currentValue.officeId,
                    atDeliveryRequirement: previousValue.atDeliveryRequirement + currentValue
                        .atDeliveryRequirement,

                }
            });
            var strTwo = `<div class="rowHeader">` +
                `<div>Total requirements for  more  ${extraList.length}  Pump(s) is ` +
                ` : ${parseFloat(addTwo.atDeliveryRequirement).toFixed(0)} ltr</div>` +
                `</div>`;
            $('#SummaryTwo').html(strTwo);

        }


        function swapNow(index1, index2) {
            isOptimize = false;
            modifiedOffice.push(newList[index1]['officeId']);
            modifiedOffice.push(newList[index2]['officeId']);
            newList = swap(newList, index1, index2);
            dt_table1.clear().rows.add(newList.slice(1, -1)).draw();
        }

        function swap(items, index1, index2) {
            isOptimize = false;
            // index1 validity check
            if (index1 < 0 || index1 >= items.length)
                return items;

            // index2 validity check
            if (index2 < 0 || index2 >= items.length)
                return items;

            // indices are equal. no swapping
            if (index1 == index2)
                return items;

            // array of items
            // var items = $items.toArray();
            // var items = $items;
            // console.log(items.length);
            // return;
            // swap items
            items.splice(index2, 1, items.splice(index1, 1, items[index2])[0]);

            // wrap the new array with jQuery and return
            // $items = $(items);
            return items;
        }
    </script>
    <script>
        var approval_url = `{{ route($routeRole . '.delivery_plan_details.approve_requirement', ':id') }}`;
        var receive_url = `{{ route($routeRole . '.delivery_plan_details.receive_delivery', ':id') }}`;

        var idx = 1;
        var modifiedOffice = []
        var TotalDistance = 0;
        var dt_table1 = $('#table1').DataTable({
            responsive: true,
            select: false,
            paging: false,
            zeroRecords: true,
            searching: false,
            order: false,
            info: false,
            "oLanguage": langOpt,
            data: newList.slice(1, -1),
            "createdRow": function(row, data, index) {

                $(row).addClass('draggable');
                $(row).attr('draggable', true);
                $(row).attr('data-index', index + 1);
                $(row).attr('data-source', 'table1');
                $(row).attr('onDragStart', 'dragStart(event)');
                if (modifiedOffice.includes(data.officeId)) {
                    $(row).addClass('modified');

                }

            },
            columns: [{
                    "data": null,
                    "render": function(data, type, full, meta) {
                        let icon = "{{ asset('theme/images/drag.png') }}";
                        let dragArea = `${ meta.row + 1}`;
                        let xStr = `<span class="draggable-icon"><img src="${icon}"</span>`;
                        return `<div class="start-box d-flex justify-content-between align-items-center  ">${ dragArea}</div>`;
                    }
                },
                {

                    "data": null,
                    "render": function(data, type, full, meta) {

                        var check1 = (meta.row > 0) ? 'active' : 'not-active disabled ';
                        var check2 = (meta.row < (newList.slice(1, -1).length) - 1) ? 'active' :
                            'not-active disabled';

                        var btn = `<div class="td_box ` + check1 + `" ` + `onclick="swapNow(` + (meta.row +
                                1) +
                            `,` + meta.row + `)">` +
                            `<i class="fas fa-arrow-up"></i></div>` +
                            `<div class="` + check2 + `" ` + `onclick="swapNow(` + (meta.row + 1) + `,` + (
                                meta.row + 2) + `)">` +
                            `<i class="fas fa-arrow-down"></i></div>` +
                            `<div class="bg-danger text-white" onclick="deleteNow(` + (meta.row + 1) +
                            `);">` +
                            `    <i class="fas    fa-minus-circle"></i>` +
                            `</div>`;
                        var options = {
                            year: "2-digit",
                            month: "2-digit",
                            day: "2-digit",
                            hour: "2-digit",
                            minute: "2-digit",
                        };
                        var SubProp = ``;
                        if (data.hasOwnProperty('estimatedDeliveryTime')) {
                            TotalDistance += data.distance;
                            // console.log(TotalDistance, data.distance);
                            SubProp = `      <div class="pl-2 text-primary"><small>Delivery at: <abbr title="attribute">${new Intl.DateTimeFormat('en-GB',options).format(Date.parse(data.estimatedDeliveryTime))}</abbr></small></div>
                                    <div class="pl-2 text-primary"><small>Distance(km) : <abbr title="attribute">${TotalDistance.toFixed(0)}(${data.distance.toFixed(0)}) </abbr></small></div>
                              `;
                        }

                        return `<div class="d-flex justify-content-between align-items-center title="${data.officeName}" ">
                                <div class="overflow-hidden">
                                    <strong><em>${trimToMaxLength(data.officeName,20)}</em></strong>
                                    ${SubProp}
                                </div>
                            <div class="dragItem bg-transparent p-2 rounded" >${btn}</div>
                            </div>`;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        return `<div class="td_box d-flex justify-content-between align-items-center ">${parseFloat(data.currentStock).toFixed(0)}</div>`;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        return `<div class="td_box d-flex justify-content-between align-items-center ">${parseFloat(data.totalCapacity - data.currentStock).toFixed(0)}</div>`;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        return `<div class="editable td_box d-flex align-items-center justify-content-center" data-rowindex="${(meta.row + 1)}" data-key="atDeliveryRequirement">${parseFloat(data.atDeliveryRequirement).toFixed(0)}</div>`;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        //console.log(data);
                        if (data.hasOwnProperty('DeliveryPlanId')) {
                            if (data.hasOwnProperty('ApprovedQuantity')) {
                                //return data.ApprovedQuantity.toFixed(0);
                                if (data.DeliveryPlanDetailsStatusId == 3) {
                                    return ` <div class="td_box d-flex align-items-center justify-content-center">` +
                                        `<label style="color:red;">X</label>`;
                                    `</div>`;
                                }
                                if (data.ApprovedQuantity == 0 || data.ApprovedQuantity == null) {
                                    return ``;
                                }
                                return ` <div class="td_box d-flex align-items-center justify-content-center">` +
                                    `<div>${ data.ApprovedQuantity } </div>` +
                                    `</div>`;
                            }
                            return '';

                        }
                        return null;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        if (data.hasOwnProperty('DeliveryPlanId')) {
                            if (data.hasOwnProperty('ReceivedQuantity')) {
                                // return data.ReceivedQuantity.toFixed(0);
                                if (data.DeliveryPlanDetailsStatusId == 3) {
                                    return ` <div class="td_box d-flex align-items-center justify-content-center">` +
                                        `<label style="color:red;">X</label>`;
                                    `</div>`;
                                }
                                if (data.ReceivedQuantity == 0 || data.ReceivedQuantity == null) {
                                    return ` <div class="td_box d-flex align-items-center justify-content-center">` +
                                        `<label style="color:green;">-</label>`;
                                    `</div>`;
                                }
                                return ` <div class="td_box d-flex align-items-center justify-content-center">` +
                                    `<div>${ data.ReceivedQuantity }</div>` +
                                    `</div>`;
                            }
                            return '';

                        }
                        return null;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {

                        if (data.hasOwnProperty('DeliveryPlanId')) {

                            if (data.hasOwnProperty('DeliveryPlanDetailsStatusId')) {


                                //   return data.DeliveryPlanDetailsStatusId;
                                let this_id = data.DeliveryPlanDetailsId;
                                var DeliveryPlanStatusId = response.hasOwnProperty(
                                    'DeliveryPlan_statusId') ? response.DeliveryPlan_statusId : 0;

                                let this_approval_url = approval_url.replace(':id', this_id);
                                let this_receive_url = receive_url.replace(':id', this_id);
                                var this_status =
                                    ` <div class="td_box d-flex align-items-center justify-content-start">{{ __('Waiting for approval') }}</div>`;

                                if (data.DeliveryPlanDetailsStatusId == 3) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-start"> {{ __('Rejected') }} </div>`;
                                }
                                if (DeliveryPlanStatusId == 1) {
                                    if (data.DeliveryPlanDetailsStatusId == 3) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-start">{{ __('Rejected') }}</div>`;
                                    } else if (data.DeliveryPlanDetailsStatusId == 2) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-start">${data.ApprovedQuantity} ltr  Order Placed</div>`;
                                    } else if (data.DeliveryPlanDetailsStatusId == 4) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-start">${data.DeliveredQuantity} ltr  Delivered</div>`;
                                    } else if (data.DeliveryPlanDetailsStatusId == 5) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-start">${data.ReceivedQuantity} ltr  Received</div>`;
                                    }
                                } else if (DeliveryPlanStatusId == 2) {


                                    if (data.DeliveryPlanDetailsStatusId == 2) {
                                        this_status =
                                            `<div class="td_box d-flex align-items-center justify-content-start">${ data.ApprovedQuantity } ltr  Order Placed</div>`;
                                    } else if (data.DeliveryPlanDetailsStatusId == 3) {
                                        this_status =
                                            `<div class="td_box d-flex align-items-center justify-content-start">{{ __('Rejected') }}</div>`;
                                    } else {
                                        this_status = this_status;
                                    }


                                } else if (DeliveryPlanStatusId == 3) {
                                    if (data.DeliveryPlanDetailsStatusId == 2) {
                                        if (data.DeliveredQuantity > 0) {
                                            this_status =
                                                ` <div class="d-flex align-items-center justify-content-start">${data.DeliveredQuantity} ltr  Delivered</div>`;
                                        } else {
                                            this_status =
                                                ` <div class="d-flex align-items-center justify-content-start">${data.ApprovedQuantity} ltr  In Transit</div>`;
                                        }

                                    } else if (data.DeliveryPlanDetailsStatusId == 5) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-start">` +
                                            `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                            `title="Received"` +
                                            `class="load-popup receive-quantity  text-break  text-info p-2 ">` +
                                            `<i class="fas fa-pencil-alt fa-circle m-0 "></i></a>` +
                                            `<a href="javascript:" ` +
                                            `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                            `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                            `<label >${data.ReceivedQuantity} ltr  Received</label>` +
                                            `</a>` +

                                            `</div>`;
                                    }
                                } else if ([4, 5, 6].includes(DeliveryPlanStatusId)) {
                                    if (data.DeliveryPlanDetailsStatusId == 2) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-start badge badge-primary  ">${data.ApprovedQuantity} ltr  Receiving Pending</div>`;
                                    } else if (data.DeliveryPlanDetailsStatusId == 5) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-start text-break">${data.ReceivedQuantity} ltr  Received</div>`;
                                    }

                                } else if (DeliveryPlanStatusId == 7) {
                                    this_status =
                                        `<label class="text-danger text-break">Cancelled</label> `;

                                }



                                return `${ this_status  }`;
                            }
                            return 'Not Found';
                        }
                        return null;
                    }
                }
            ]

        });

        function setCaretPositionToEnd(el) {
            const range = document.createRange();
            const sel = window.getSelection();
            range.selectNodeContents(el);
            range.collapse(false);
            sel.removeAllRanges();
            sel.addRange(range);
            el.focus();
        }
        $('#table1').on('focus', 'td .editable', function() {
            // Set the caret position to the end of the editable div
            setCaretPositionToEnd(this);
        });
        $('#table1').on('click', 'td .editable', function() {
            // Toggle the contenteditable attribute for the clicked cell
            $(this).prop('contenteditable', true);

            // Highlight the cell to indicate it is in edit mode

            $(this).addClass('edit-mode');

            $(this).focus();
            // window.getSelection().collapseToEnd()
            //  console.log($(this).prop('data-key'));
        });
        $('#table1').on('keypress', 'td .editable', function(e) {
            //

            // Toggle the contenteditable attribute for the clicked cell
            // console.log($(this).parent().index());
            // console.log($(this).attr('data-key'));
            if (e.which == 13 && $(this).prop('contenteditable')) {
                e.preventDefault();
                //  console.log($(this).attr('data-key'));

                // const rowIndex = $(this).attr('data-rowindex')
                // const columnIndex = $(this).attr('data-key')
                // const newValue = $(this).text();
                // // console.log('rowindex '+ rowIndex + ' Happy\n');
                // newList[rowIndex][columnIndex] = newValue
                // dt_table1.clear().rows.add(newList.slice(1, -1)).draw();
                $(this).prop('contenteditable', false);
                $(this).removeClass('edit-mode');
                //  console.log('remove');
                // calculateSummary();
                // console.log('calculated');
            }

        });

        // Add blur event handler to the cells to save the edited content
        $('#table1').on('blur', 'td .editable', function() {
            // Remove the edit mode class and toggle the contenteditable attribute
            setTimeout(() => {
                if ($(this).prop('contenteditable')) {
                    const rowIndex = $(this).attr('data-rowindex')
                    const columnIndex = $(this).attr('data-key')
                    const newValue = $(this).text();
                    // console.log('rowindex '+ rowIndex + ' Happy\n');
                    newList[rowIndex][columnIndex] = newValue
                    dt_table1.clear().rows.add(newList.slice(1, -1)).draw();
                    $(this).prop('contenteditable', false);
                    $(this).removeClass('edit-mode');
                    $(this).addClass('modified-cell');
                    // console.log('remove');
                    calculateSummary();
                }
            }, 200);

        });

        var dt_table2 = $('#table2').DataTable({
            responsive: true,
            select: false,
            paging: false,
            zeroRecords: true,
            searching: false,
            order: false,
            info: false,
            "oLanguage": langOpt,
            data: extraList,
            "createdRow": function(row, data, index) {

                $(row).addClass('draggable');
                $(row).attr('draggable', true);
                $(row).attr('data-index', index);
                $(row).attr('data-source', 'table2');
                $(row).attr('onDragStart', 'dragStart(event)');
                if (modifiedOffice.includes(data.officeId)) {
                    $(row).addClass('modified');
                }
            },
            columns: [{
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {

                    "data": null,
                    "render": function(data, type, full, meta) {
                        var btn = `<div class="bg-primary text-white" onclick="addNow(` + meta.row +
                            `);">` +
                            `    <i class="fas    fa-plus-circle"></i>` +
                            `</div>`;
                        return '<div class="d-flex justify-content-between"><div class="overflow-hidden">' +
                            trimToMaxLength(data.officeName, 30) +
                            '</div>' + '<div class="dragItem">' + btn + '</div></div>';
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        return parseFloat(data.currentStock).toFixed(0);
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        return parseFloat(data.totalCapacity - data.currentStock).toFixed(0);
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        return parseFloat(data.atDeliveryRequirement).toFixed(0);
                    }
                }
            ]

        });

        function dragStart(e) {
            e.target.classList.add('dragging');
            // console.log('start drag ')
        }

        // $('.draggable').on('dragend',(e)=>{
        //     e.preventDefault()
        //      e.target.classList.remove('dragging');
        //     // deleteNow($(e.target).attr('data-index'));
        //    // $(e.target).removeClass('dragging');
        //     //console.log($(e.target).attr('data-index'));
        // })
        $('#table2').on('dragover', (e) => {
            e.preventDefault()

        })
        $('#table1').on('dragover', (e) => {
            e.preventDefault()

        })
        $('#table1 tr *').on('dragover', (e) => {
            e.preventDefault()

        })
        $('#table2').on('drop', (e) => {
            // e.preventDefault()

            let dragging = document.querySelector('.dragging')
            dragging.classList.remove('dragging');
            // console.log($(dragging).attr('data-index'));
            if ($(dragging).attr('data-source') == 'table1') {
                deleteNow($(dragging).attr('data-index'));
            }
            // $(e.target).removeClass('dragging');
            //console.log(e.target.id);

        })
        $('#table1').on('drop', (e) => {
            // e.preventDefault()

            let dragging = document.querySelector('.dragging')
            dragging.classList.remove('dragging');
            // console.log($(dragging).attr('data-index'));
            if ($(dragging).attr('data-source') == 'table2') {
                addNow($(dragging).attr('data-index'));
            } else if ($(dragging).attr('data-source') == 'table1') {
                if ($(dragging).attr('data-source') == 'table1') {
                    let thisNode = e.target
                    // console.log(thisNode);
                    let a = 0;
                    while (thisNode.tagName != 'TR') {
                        thisNode = thisNode.parentNode;
                        //  console.log(thisNode);
                        ++a;
                        if (a > 4) return;
                    }
                    // console.log($(dragging).attr('data-index'))
                    swapNow(thisNode.getAttribute('data-index'), $(dragging).attr('data-index'));
                    //console.log(e.target.getAttribute('data-index'));
                    // if(thisNode.getAttribute('data-index')!=$(dragging).attr('data-index')){

                    // }

                } else {
                    console.log("Drop Others");
                }
            }

        })

        $(document).ready(() => {
            calculateSummary();
        });
    </script>
@endif


<div id="mapWrapperPanel" class="d-none flex-column">
    @if (isset($response))
        @include('module.delivery_plan.delivery_plan_map')
    @endif
</div>
