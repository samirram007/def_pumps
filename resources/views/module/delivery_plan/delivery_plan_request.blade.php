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
            <input type="text" name="No_of_days_for_delivery" class="sr-only"
                value="{{ $requestData['No_of_days_for_delivery'] }}">
            <input type="date" name="PlanDate" class="sr-only" value="{{ $requestData['planDate'] }}">
            <input type="date" name="ExpectedDeliveryDate" class="sr-only"
                value="{{ $requestData['expectedDeliveryDate'] }}">
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

            .btn-box>div {}

            .animated-shine {
                animation: shine 8s infinite linear alternate forwards running;
                transform-origin: center bottom !important;

            }

            /* Animation */
            /* @keyframes shine {
                        0%   {transform: rotate(0deg);}
                        100% {transform: rotate(-360deg);}
                        } */
        </style>
        <div class="col-12  gap-10  d-flex flex-row align-items-center justify-content-end mt-2 ">
            <div class="btn-box animated-shine " onclick="toggleRequestPanel(this);" title="{{ __('Request') }}">

                <i class="fa fa-paper-plane"></i>
                <div>{{ __('Request') }}</div>
            </div>

            <div class="btn-box btn-block animated-shine update-route  " onclick="updateRoute(this);"
                title="{{ __('Update route') }}">

                <i class="fa fa-bullseye"></i>
                <div>{{ __('Update Route') }}</div>
            </div>
            <div class="btn-box animated-shine " onclick="toggleMapPanel(this);" title="{{ __('Map View') }}">

                <i class="fas fa-map"></i>
                <div>{{ __('Map View') }}</div>


            </div>


        </div>
        {{-- <div class="col-12 col-md-4 d-flex flex-row align-items-center justify-content-center  ">
            <div class="btn-box">
                <a href="javascript:" onclick="updateRoute();" title="{{ __('Update route') }}"
                    class="update-route   btn btn-rounded animated-shine px-2  ">
                    <i class="fa fa-bullseye"></i></a>
                <div>{{ __('Update Route') }}</div>
            </div>
            <div class="btn-block">
                <a href="javascript:" onclick="toggleMapPanel();" title="{{ __('Map View') }}"
                    class="   btn btn-rounded animated-shine px-2  ">
                    <i class="fas fa-map"></i></a>
                <div>{{ __('Map View') }}</div>
            </div>
            <div class="btn-box">
                <a href="javascript:" onclick="toggleRequestPanel();" title="{{ __('Request') }}"
                    class="   btn btn-rounded animated-shine px-2   ">
                    <i class="fa fa-paper-plane"></i></a>
                <div>{{ __('Request') }}</div>
            </div>


        </div> --}}


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
        <input type="text" name="No_of_days_for_delivery" class="sr-only"
            value="{{ $requestData['No_of_days_for_delivery'] }}">
        <input type="date" name="PlanDate" class="sr-only" value="{{ $requestData['planDate'] }}">
        <input type="date" name="ExpectedDeliveryDate" class="sr-only"
            value="{{ $requestData['expectedDeliveryDate'] }}">
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
                        <td class="">{{ __('Sl') }}</td>
                        <td class="">{{ __('Pumps') }}</td>
                    <td class="">{{ __('Current') }}({{ __('in ltr') }})</td>
                    <td class="">{{ __('Availability') }}({{ __('in ltr') }})</td>
                    <td class="editable-column">{{ __('Suggested') }}({{ __('in ltr') }})</td>

                        <td class=""
                            data-visible="{{ (isset($requestData) && $requestData['DeliveryPlanId']) != 0 ? true : false }}">
                            {{ __('Order') }}</td>
                        <td class=""
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
                    <td class="">{{ __('Sl') }}</td>
                    <td class="">{{ __('Pumps') }}</td>
                    <td class="">{{ __('Current') }}({{ __('in ltr') }})</td>
                    <td class="">{{ __('Availability') }}({{ __('in ltr') }})</td>
                    <td class="">{{ __('Suggested') }}({{ __('in ltr') }})</td>
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
        gap: 20px;
        flex-direction: row;
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
        height: 24px;
        transition: all 0.3s ease-in-out;
    }

    .modified-cell {
        font-weight: bolder;
        background: #49dfc6d7;
    }

    .modified {
        background-color: #ffd9dd !important;
    }
</style>


@if (isset($response))
    <script>
        //let newList=[];




        $("#formSavePlan").on("submit", function(event) {

            event.preventDefault();
            //alert();
            // $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            var formData = new FormData($(this)[0]);
            // console.log(formData);

            let data = newList.slice(1, -1);
            formData.append('data', JSON.stringify(data));
            formData.append('extraList', JSON.stringify(extraList));

            // console.log(formData);
            //return;reportPanel
            let btnText = $('#save_plan').html();
            $('#save_plan').attr('disabled', true);
            $('#save_plan').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );

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
                        console.log(data);
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
                        console.log(data);
                        toastr.error(data.message);
                    }

                } else {
                    setTimeout(() => {
                        //$('.search').click();
                        // $('.close').click();
                        newList = data.data.Routes.Algorithm_1.Route;
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



        //  console.log(response.Routes.Algorithm_1.Route);
        var routeList = response.Routes.Algorithm_1.Route;
        //console.log(response.hasOwnProperty('DeliveryPlan_statusId'));
        var DeliveryPlanStatusId = response.hasOwnProperty('DeliveryPlan_statusId') ? response.DeliveryPlan_statusId : 0;
        //console.log("Plan Status: "+DeliveryPlanStatusId);
        newList = routeList;
        var extra_list = response.Not_selected;

        var extraList = extra_list;

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

            // console.log(newList);
            newList = reindex_array_keys(newList);
            dt_table1.clear().rows.add(newList.slice(1, -1)).draw();
            // console.log(newList);
            // reArrange(newList);
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
            // console.log(typeof(newList));
            // console.log( extraList[index]['officeId']);
            modifiedOffice.push(extraList[index]['officeId']);
            newList.splice(newList.length - 1, 0, extraList[index]);
            // console.log(newList);
            newList = reindex_array_keys(newList);
            dt_table1.clear().rows.add(newList.slice(1, -1)).draw();

            //newList.push(extraList[index]);
            extraList.splice(index, 1);
            extraList = reindex_array_keys(extraList);
            dt_table2.clear().rows.add(extraList).draw();
            calculateSummary();
        }

        function updateRoute(element) {

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
            $.each(newList, function(index, value) {
                if (value.atDeliveryRequirement > 0) {
                    // console.log(index-1);
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
            $.each(extraList, function(index, value) {
                if (value.atDeliveryRequirement > 0) {
                    // console.log(index-1);
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

        function calculateSummary() {


            var addOne = newList.reduce(function(previousValue, currentValue) {
                return {
                    officeId: previousValue.officeId + currentValue.officeId,
                    atDeliveryRequirement: previousValue.atDeliveryRequirement + parseFloat(currentValue
                        .atDeliveryRequirement),

                }
            });
            // let newListLength=newList.length - 2;
            var strOne = `<div class="rowHeader">` +
                `<div>Total requirements for  suggested ${(newList.length - 2)} pump(s) is ` +
                `: ${ parseFloat(addOne.atDeliveryRequirement).toFixed(0)} ltr</div>` +
                `</div>`;
            $('#SummaryOne').html(strOne);

            var addTwo = extraList.reduce(function(previousValue, currentValue) {
                return {
                    officeId: previousValue.officeId + currentValue.officeId,
                    atDeliveryRequirement: previousValue.atDeliveryRequirement + currentValue.atDeliveryRequirement,

                }
            });
            var strTwo = `<div class="rowHeader">` +
                `<div>Total requirements for  more  ${extraList.length}  Pump(s) is ` +
                ` : ${parseFloat(addTwo.atDeliveryRequirement).toFixed(0)} ltr</div>` +
                `</div>`;
            $('#SummaryTwo').html(strTwo);

        }


        function swapNow(index1, index2) {
            modifiedOffice.push(newList[index1]['officeId']);
            modifiedOffice.push(newList[index2]['officeId']);
            newList = swap(newList, index1, index2);
            dt_table1.clear().rows.add(newList.slice(1, -1)).draw();
        }

        function swap(items, index1, index2) {

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
                    console.log(row);
                }

            },
            columns: [{
                    "data": null,
                    "render": function(data, type, full, meta) {
                        let icon = "{{ asset('theme/images/drag.png') }}";
                        let dragArea = `${ meta.row + 1}`;
                        let xStr = `<span class="draggable-icon"><img src="${icon}"</span>`;
                        return `${ dragArea}`;
                    }
                },
                {

                    "data": null,
                    "render": function(data, type, full, meta) {

                        var check1 = (meta.row > 0) ? 'active' : 'not-active disabled ';
                        var check2 = (meta.row < (newList.slice(1, -1).length) - 1) ? 'active' :
                            'not-active disabled';

                        var btn = `<div class="` + check1 + `" ` + `onclick="swapNow(` + (meta.row + 1) +
                            `,` + meta.row + `)">` +
                            `<i class="fas fa-arrow-up"></i></div>` +
                            `<div class="` + check2 + `" ` + `onclick="swapNow(` + (meta.row + 1) + `,` + (
                                meta.row + 2) + `)">` +
                            `<i class="fas fa-arrow-down"></i></div>` +
                            `<div onclick="deleteNow(` + (meta.row + 1) + `);">` +
                            `    <i class="fas    fa-download"></i>` +
                            `</div>`;
                        return '<div class="d-flex justify-content-between"><div>' + data.officeName +
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
                        return `<div class="editable" data-rowindex="${(meta.row + 1)}" data-key="atDeliveryRequirement">${parseFloat(data.atDeliveryRequirement).toFixed(0)}</div>`;
                    }
                },
                {
                    data: null,
                    "render": function(data, type, full, meta) {
                        //console.log(data);
                        if (data.hasOwnProperty('DeliveryPlanId')) {
                            if (data.hasOwnProperty('ApprovedQuantity')) {
                                //return data.ApprovedQuantity.toFixed(0);
                                if (data.ApproveStatus == -1) {
                                    return ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<label style="color:red;">X</label>`;
                                    `</div>`;
                                }
                                if (data.ApprovedQuantity == 0 || data.ApprovedQuantity == null) {
                                    return ``;
                                }
                                return ` <div class="d-flex align-items-center justify-content-center">` +
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
                                if (data.ApproveStatus == -1) {
                                    return ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<label style="color:red;">X</label>`;
                                    `</div>`;
                                }
                                if (data.RreceivedQuantity == 0 || data.RreceivedQuantity == null) {
                                    return ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<label style="color:green;">-</label>`;
                                    `</div>`;
                                }
                                return ` <div class="d-flex align-items-center justify-content-center">` +
                                    `<div>${ data.RreceivedQuantity }</div>` +
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

                            if (data.hasOwnProperty('ApproveStatus')) {


                                //   return data.ApproveStatus;
                                let this_id = data.DeliveryPlanDetailsId;
                                var DeliveryPlanStatusId = response.hasOwnProperty(
                                    'DeliveryPlan_statusId') ? response.DeliveryPlan_statusId : 0;

                                let this_approval_url = approval_url.replace(':id', this_id);
                                let this_receive_url = receive_url.replace(':id', this_id);
                                var this_status =
                                    ` <div class="d-flex align-items-center justify-content-center">` +
                                    `<a href="javascript:" ` +
                                    `class="load-popup edit-quantity    text-secondary p-2 font-weight-bolder " ` +
                                    `style="color:gray;" data-param="${this_id}" data-url="${this_approval_url}">` +
                                    `<label >Waiting for approval</label>` +
                                    `</a>` +
                                    `<a href="javascript:" data-param="${this_id}" data-url="${this_approval_url}"` +
                                    `title="Approve Requirement"` +
                                    `class="load-popup edit-quantity    text-info p-2 ">` +
                                    `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                    `</div>`;

                                if (data.ApproveStatus == -1) {
                                    this_status =
                                        ` <div class="d-flex align-items-center justify-content-center">` +
                                        `<label style="color:red;">Rejected</label>`;
                                    `</div>`;
                                }
                                if (DeliveryPlanStatusId == 1) {
                                    if (data.ApproveStatus == -1) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center">` +
                                            `<a href="javascript:" ` +
                                            `class="load-popup edit-quantity    text-success p-2 font-weight-bolder " ` +
                                            `data-param="${this_id}" data-url="${this_approval_url}">` +
                                            `<label style="color:red;">Rejected</label>` +
                                            `</a>` + `</div>`;
                                    } else if (data.ApproveStatus == 2) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center">` +
                                            `<a href="javascript:" ` +
                                            `class="load-popup edit-quantity    text-success p-2 font-weight-bolder " ` +
                                            `style="color:green;" data-param="${this_id}" data-url="${this_approval_url}">` +
                                            `<label >${data.ApprovedQuantity}  Order Placed</label>` +
                                            `</a>` +
                                            `<a href="javascript:" data-param="${this_id}" data-url="${this_approval_url}"` +
                                            `title="Approve Requirement"` +
                                            `class="load-popup edit-quantity    text-info p-2 ">` +
                                            `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                            `</div>`;
                                    } else if (data.ApproveStatus == 3) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center">` +
                                            `<a href="javascript:" ` +
                                            `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                            `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                            `<label >${data.ReceivedQuantity}  Received</label>` +
                                            `</a>` + `</div>`;
                                    }
                                }
                                if (DeliveryPlanStatusId == 2) {
                                    if (data.ApproveStatus == 2) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center text-break text-success p-2 font-weight-bolder">` +
                                            `<lavel>${ data.ApprovedQuantity }  Order Under Processing</lavel>` +
                                            `</div>`;
                                    } else if (data.ApproveStatus == 3) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center">` +
                                            `<a href="javascript:" ` +
                                            `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                            `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                            `<label >${data.ReceivedQuantity}  Received</label>` +
                                            `</a>` +
                                            `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                            `title="Approve Requirement"` +
                                            `class="load-popup receive-quantity   text-info p-2 ">` +
                                            `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                            `</div>`;
                                    }
                                } else if (DeliveryPlanStatusId == 3) {
                                    if (data.ApproveStatus == 2) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center">` +
                                            `<a href="javascript:" ` +
                                            `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                            `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                            `<label >${data.ApprovedQuantity}  Delivery on the way</label>` +
                                            `</a>` +
                                            `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                            `title="Approve Requirement"` +
                                            `class="load-popup receive-quantity   text-info p-2 ">` +
                                            `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                            `</div>`;
                                    } else if (data.ApproveStatus == 3) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center">` +
                                            `<a href="javascript:" ` +
                                            `class="load-popup receive-quantity    text-success p-2 font-weight-bolder " ` +
                                            `style="color:green;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                            `<label >${data.ReceivedQuantity}  Received</label>` +
                                            `</a>` +
                                            `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                            `title="Approve Requirement"` +
                                            `class="load-popup receive-quantity  text-break  text-info p-2 ">` +
                                            `<i class="fas fa-pencil-alt m-0 "></i></a>` +
                                            `</div>`;
                                    }
                                } else if (DeliveryPlanStatusId == 4) {
                                    if (data.ApproveStatus == 2) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center">` +
                                            `<a href="javascript:" ` +
                                            `class="load-popup receive-quantity  text-break  text-info p-2 font-weight-bolder " ` +
                                            `style="color:orange;" data-param="${this_id}" data-url="${this_receive_url}">` +
                                            `<label >${data.ApprovedQuantity}  Receiving Confirmation Pending</label>` +
                                            `</a>` +
                                            `<a href="javascript:" data-param="${this_id}" data-url="${this_receive_url}"` +
                                            `title="Approve Requirement"` +
                                            `class="load-popup receive-quantity  text-break  text-info p-2 ">` +
                                            `<i class="fas fa-pencil-alt m-0 "></i></a>` +

                                            `</div>`;
                                    } else if (data.ApproveStatus == 3) {
                                        this_status =
                                            ` <div class="d-flex align-items-center justify-content-center text-break">` +
                                            `<label >${data.ReceivedQuantity}  Received</label>` +
                                            `</div>`;
                                    }

                                } else if (DeliveryPlanStatusId == 5) {
                                    this_status =
                                        `<label class="text-danger text-break">Order Cancelled By Admin</label> `;

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
                        var btn = `<div onclick="addNow(` + meta.row + `);">` +
                            `    <i class="fas    fa-upload"></i>` +
                            `</div>`;
                        return '<div class="d-flex justify-content-between"><div>' + data.officeName +
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
        // $('#table1 tr>').on('drop', (e) => {
        //     let dragging = document.querySelector('.dragging')
        //     dragging.classList.remove('dragging');
        //     if ($(dragging).attr('data-source') == 'table1') {
        //         let thisNode = e.target
        //         // console.log(thisNode);
        //         let a = 0;
        //         while (thisNode.tagName != 'TR') {
        //             thisNode = thisNode.parentNode;
        //             //console.log(thisNode);
        //             ++a;
        //             if (a > 4) return;
        //         }
        //         console.log($(dragging).attr('data-index'))
        //         swapNow(thisNode.getAttribute('data-index'), $(dragging).attr('data-index'));
        //         //console.log(e.target.getAttribute('data-index'));
        //         // if(thisNode.getAttribute('data-index')!=$(dragging).attr('data-index')){

        //         // }

        //     } else {
        //         console.log("Drop Others");
        //     }
        // })
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
