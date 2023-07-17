<div class="alert alert-danger sr-only"></div>
<form id="formSavePlan">
    <div class="row justify-content-center align-items-center mb-4">

        @csrf
        <div class="col-3 col-md-2 text-right">Plan Name : </div>
        <div class="col-9 col-md-6 ">
            <input id="planTitle" name="planTitle" class=" w-100 border-bottom border-primary p-2 rounded "
                class="form-control" value="{{ $planTitle }}" />

        </div>


        @if (isset($requestData))
            <input type="text" id="deliveryPlanId" name="deliveryPlanId" class="sr-only"
                value="{{ $requestData['DeliveryPlanId'] }}">
            <input type="text" name="productId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
            <input type="text" name="productTypeId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
            <input type="text" name="StartingPointId" class="sr-only" value="{{ $requestData['StartingPointId'] }}">
            <input type="text" name="MinimumMultiple" class="sr-only" value="{{ $requestData['MinimumMultiple'] }}">
            <input type="text" name="TankCapacity" class="sr-only" value="{{ $requestData['TankCapacity'] }}">
            <input type="text" name="No_of_days_for_delivery" class="sr-only"
                value="{{ $requestData['No_of_days_for_delivery'] }}">
            <input type="date" name="PlanDate" class="sr-only" value="{{ $requestData['planningDate'] }}">
            <input type="date" name="ExpectedDeliveryDate" class="sr-only"
                value="{{ $requestData['expectedDeliveryDate'] }}">
        @endif

        <div class="col-12 col-md-4 d-flex flex-row align-items-center justify-content-center  ">

            <button id="save_plan" type="submit"
                class="save_plan btn btn-rounded animated-shine px-2 mx-4">{{ __('Save Plan') }}</button>

            <a href="javascript:" onclick="updateRoute();" title="{{ __('Update route') }}"
                class="update-route   btn btn-rounded animated-shine px-2  ">
                <i class="fa fa-bullseye"></i></a>
            <a href="javascript:" onclick="toggleMapPanel();" title="{{ __('Map View') }}"
                class="   btn btn-rounded animated-shine px-2  ">
                <i class="fas fa-map"></i></a>


            <a href="javascript:" onclick="toggleRequestPanel();" title="{{ __('New Request') }}"
                class="   btn btn-rounded animated-shine px-2   ">
                <i class="fa fa-paper-plane"></i></a>


        </div>

    </div>
</form>
<form id="formRequestModifiedPlan">
    @csrf
    @if (isset($requestData))
        <input type="text" name="productId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
        <input type="text" name="productTypeId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
        <input type="text" name="StartingPointId" class="sr-only" value="{{ $requestData['StartingPointId'] }}">
        <input type="text" name="MinimumMultiple" class="sr-only" value="{{ $requestData['MinimumMultiple'] }}">
        <input type="text" name="TankCapacity" class="sr-only" value="{{ $requestData['TankCapacity'] }}">
        <input type="text" name="No_of_days_for_delivery" class="sr-only"
            value="{{ $requestData['No_of_days_for_delivery'] }}">
        <input type="date" name="PlanDate" class="sr-only" value="{{ $requestData['planningDate'] }}">
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
                        <td class="">{{ __('Current(in ltr)') }}</td>
                        <td class="">{{ __('Availability(in ltr)') }}</td>
                        <td class="">{{ __('Suggested(in ltr)') }}</td>
                    </tr>
                </thead>
                {{-- <tbody id="wrapperOne">
                    @php
                        $sl_no = 0;
                        $totalRequirement = 0;
                        $totalCurrentStock = 0;
                        $totalAvailability = 0;
                    @endphp
                    @if (isset($response))
                        @forelse ($response['Routes']['Algorithm_1']['Route'] as $key => $item)
                            @if ($item['atDeliveryRequirement'] > 0)
                                <tr class="">
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
                                            <div class=" {{ $key > 1 && $key < count($response['Routes']['Algorithm_1']['Route']) - 1 ? 'active' : 'not-active disabled' }}"
                                                onclick="swapNow({{ $key }},{{ $key - 1 }});"><i
                                                    class="fas fa-arrow-up"></i></div>
                                            @php
                                                // echo count($response['Routes']['Algorithm_1']['Route']);
                                            @endphp
                                            <div class=" {{ $key > 0 && $key < count($response['Routes']['Algorithm_1']['Route']) - 2 ? 'active' : 'not-active disabled' }}"
                                                onclick="swapNow({{ $key }},{{ $key + 1 }});">
                                                <i class="fas fa-arrow-down"></i>
                                            </div>
                                            <div onclick="deleteNow({{ $key }});">
                                                <i class="fas    fa-download"></i>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                @php
                                    $totalRequirement = $totalRequirement + $item['atDeliveryRequirement'];
                                    $totalCurrentStock = $totalCurrentStock + $item['currentStock'];
                                    $totalAvailability = $totalAvailability + ($item['totalCapacity'] - $item['currentStock']);
                                @endphp
                            @endif
                        @empty
                            <div class="dragBlock ">{{ __('No Data Found') }}</div>
                        @endforelse
                    @else
                        <div class="dragBlock ">{{ __('No Data Found') }}</div>
                    @endif

                </tbody>
                <tfoot id="tableFooterOne">
                    <tr class=" ">
                        <th colspan="2" class="">{{ __('Total Pumps( as ready ) : ') }}{{ $sl_no }}
                        </th>

                        <th class=" text-white">{{ number_format($totalCurrentStock, 3, '.', '') }}</th>
                        <th class=" text-white">{{ number_format($totalAvailability, 3, '.', '') }}</th>


                        <th class="pl-0 ">{{ number_format($totalRequirement, 3, '.', '') }}</th>

                        <th></th>
                    </tr>
                </tfoot> --}}
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
                    <td class="">{{ __('Current(in ltr)') }}</td>
                    <td class="">{{ __('Availability(in ltr)') }}</td>
                    <td class="">{{ __('Suggested(in ltr)') }}</td>
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
    .dragList {
        display: flex;
        justify-content: space-between;
        flex-flow: column nowrap;
    }
    .modified{
         background-color:#ffd9dd!important;
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

  .dragHeader>div>div {

  }
  .rowHeader{
    display: flex;
    gap:20px;
    flex-direction: row;
  }
  .rowHeader::before{
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
            $('.save_plan').attr('disabled', true);
            $('.save_plan').html(
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

                    $('.save_plan').attr('disabled', false);
                    $('.save_plan').html('Save Plan');

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

                    $('.save_plan').attr('disabled', false);
                    $('.save_plan').html('Save Plan');
                } else {
                    setTimeout(() => {
                        //$('.search').click();
                        // $('.close').click();
                        $('.save_plan').attr('disabled', false);
                        $('.save_plan').html('Save Plan');
                        toastr.success(data.message);
                    }, 1000);
                }
            }).fail(function(data) {

                $('.save_plan').attr('disabled', false);
                $('.save_plan').html('Save Plan');
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
        newList = routeList;
        var extra_list = response.Not_selected;

        var extraList = extra_list;
        // console.log(newList);
        // console.log(extraList);
        // $.each(routeList, function(key, value) {
        //     console.log(key + ": " + value);
        //     if (key == 3) {
        //         let tmp = routeList[1];
        //         routeList[1] = value;
        //         routeList[key] = tmp;
        //         console.log(routeList);


        //     }

        // });
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

        function updateRoute() {
            //    let start = Date.now();
            //       var officeIds1 = _.map(newList.slice(1,-1),'officeId');
            //       let timeTaken = Date.now() - start;
            //     console.log("Total time taken : " + timeTaken + " milliseconds");
            // var officeIds = newList.slice(1, -1).map(function(a) {
            //     return a.officeId
            // });

            // let requestData = @JSON($requestData);
            // // // let strOfficeIds=JSON.stringify(officeIds);
            // requestData.OfficeIdList = officeIds;
            $('#formRequestModifiedPlan').submit();
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
                    atDeliveryRequirement: previousValue.atDeliveryRequirement + currentValue.atDeliveryRequirement,

                }
            });
            // let newListLength=newList.length - 2;
            var strOne = `<div class="rowHeader">`+
                `<div>Total requirements for  suggested ${(newList.length - 2)} pump(s) is `+
                    `: ${ parseFloat(addOne.atDeliveryRequirement).toFixed(0)} ltr</div>` +
                `</div>`;
            $('#SummaryOne').html(strOne);

            var addTwo = extraList.reduce(function(previousValue, currentValue) {
                return {
                    officeId: previousValue.officeId + currentValue.officeId,
                    atDeliveryRequirement: previousValue.atDeliveryRequirement + currentValue.atDeliveryRequirement,

                }
            });
            var strTwo = `<div class="rowHeader">`+
                `<div>Total requirements for  more  ${extraList.length}  Pump(s) is `+
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
        var idx = 1;
        var modifiedOffice=[]
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
                if(modifiedOffice.includes(data.officeId)){
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
                        return parseFloat(data.atDeliveryRequirement).toFixed(0);
                    }
                }
            ]

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
                if(modifiedOffice.includes(data.officeId)){
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
        $(document).ready(function() {
            // let draggable = document.querySelectorAll('.draggable')
            // let container = document.querySelectorAll('.table')
            // console.log(draggable, container);

            calculateSummary();
        });
    </script>
@endif


<div id="mapWrapperPanel" class="d-none flex-column">
    @if (isset($response))
        @include('module.delivery_plan.delivery_plan_map')
    @endif
</div>
