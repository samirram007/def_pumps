<div class="alert alert-danger sr-only"></div>
<form id="formSavePlan">
    <div class="row justify-content-center align-items-center mb-4">

        @csrf
        <div class="col-3 col-md-2 text-right">Plan : </div>
        <div class="col-9 col-md-6 ">
            <input id="planTitle" name="planTitle" class=" w-100 border-bottom border-primary p-2 rounded "
                class="form-control" value="{{ $planTitle }}" />

        </div>


        @if (isset($requestData))
            <input type="text" name="productId" class="sr-only" value="{{ $requestData['ProductTypeId'] }}">
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

            <a href="javascript:" onclick="toggleMapPanel();" title="{{ __('Map View') }}"
                class="   btn btn-rounded animated-shine px-2  ">
                <i class="fas fa-map"></i></a>

            <a href="javascript:" onclick="toggleRequestPanel();" title="{{ __('New Request') }}"
                class="   btn btn-rounded animated-shine px-2   ">
                <i class="fa fa-paper-plane"></i></a>


        </div>

    </div>
</form>
<div id="listWrapperPanel" class="d-flex flex-column">


    <div class="  card border border-primary">
        @if (isset($response))
            <div class="dragHeader"> {{ $response['Routes']['Algorithm_1']['Description'] }}</div>
        @else
            <div class="dragHeader"> {{ __(' Routing based on Nearest Branch') }}</div>
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
                        <td class="">{{ __('Action') }}</td>
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
            <div class="dragHeader"> {{ __('More Pums in the queue') }}</div>
        @else
            <div class="dragHeader"> {{ __('More Pums in the queue') }}</div>
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
                    <td class="">{{ __('Action') }}</td>
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

    .dragable {
        cursor: grabbing !important;
        box-shadow: 0 0 3px 2px #ddd;
        margin: 5px 0;
        border-radius: 3px;
    }

    .dragList .dragHeader {}

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

    #wrapperOne .not-active {
        pointer-events: none;
    }

    #wrapperOne .active {
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
        $(document).ready(function() {});
        let newList=[];




        $("#formSavePlan").on("submit", function(event) {

            event.preventDefault();
            //alert();
            // $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            var formData = new FormData($(this)[0]);
            // console.log(formData);

            let data = newList;
            formData.append('data', JSON.stringify(data));
            formData.append('extraData', JSON.stringify(extraList));

            // console.log(formData);
            //return;reportPanel

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
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });
                    $('.save_plan').attr('disabled', false);
                    $('.save_plan').html('Save Plan');
                } else {
                    setTimeout(() => {
                        //$('.search').click();
                        // $('.close').click();
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
        function addNow(index) {
            // console.log(typeof(newList));
            // console.log(typeof(extraList));
            newList.splice(newList.length - 1, 0, extraList[index]);
            // console.log(newList);

            //newList.push(extraList[index]);
            extraList.splice(index, 1);
            // console.log(extraList);
            reArrange(newList);
            reArrangeWrapperTwo(extraList);
        }

        function deleteNow(index) {
            extraList.push(newList[index]);
            // console.log(extraList);
            newList.splice(index, 1);
            // console.log(newList);
            newList = reindex_array_keys(newList);
            // console.log(newList);
                reArrange(newList);
                reArrangeWrapperTwo(extraList);


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






        function swapNow(index1, index2) {
            newList = swap(newList, index1, index2);
            // console.log(typeof(newList));
            console.log(newList);
            reArrange(newList);

            //console.log(extraList);
            // str += '</div>';


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
        console.log(newList);
        var idx=1;
       var dt_table1 = $('#table1').DataTable({
            responsive: true,
            select: false,
            paging: false,
            zeroRecords: true,
            searching: false,
            order: false,
            info: false,
            "oLanguage": langOpt,
            data:newList.slice(1, -1),
            columns:[
                {
                    "data": null, "render": function (data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {

                    "data": null, "render": function (data, type, full, meta) {
                        return data.officeName+(meta.row +1);
                    }
                },
                {
                    data:'currentStock',
                },
                {
                    data:'currentStock',
                },
                {
                    data:'currentStock',
                },
                {
                    data:'currentStock',
                    render:function(data,type,row){

return row.currentStock;
}
                },
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
            // data:extraList

        });
    </script>
@endif


<div id="mapWrapperPanel" class="d-none flex-column">
    @if (isset($response))
        @include('module.delivery_plan.delivery_plan_map')
    @endif
</div>

