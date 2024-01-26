<div class="dragList px-4 py-2">
    @if (isset($response))
        <div class="dragHeader"> {{ $response['Routes']['Algorithm_1']['Description'] }}</div>
    @else
        <div class="dragHeader"> {{ __(' Routing based on Nearest Branch') }}</div>
    @endif
    {{-- @dd(json_encode($response)) --}}

    <div class="dragBlockHeader ">
        <div class="dragItem">{{ __('Sl') }}</div>
        <div class="dragItem">{{ __('Pumps') }}</div>
        <div class="dragItem">{{ __('Requirement(in ltr)') }}</div>
        <div class="dragItem">{{ __('Action') }}</div>
    </div>
    @php
        $sl_no = 0;
        $totalRequirement = 0;
    @endphp
    <div id="wrapperOne">
        @if (isset($response))
          {{-- @dd($response['Routes']['Algorithm_1']['Route']) --}}
            @forelse ($response['Routes']['Algorithm_1']['Route'] as $key => $item)
                @if ($item['atDeliveryRequirement'] > 0)
                    <div class="dragBlock dragable" draggable="true">
                        <div class="dragItem">{{ ++$sl_no }}</div>
                        <div class="dragItem">{{ $item['officeName'] }}</div>
                        <div class="dragItem">{{ $item['atDeliveryRequirement'] }}</div>
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
                    </div>
                    @php
                        $totalRequirement = $totalRequirement + $item['atDeliveryRequirement'];
                    @endphp
                @endif
            @empty
                <div class="dragBlock ">{{ __('No Data Found') }}</div>
            @endforelse
            <div class="dragBlockFooter ">
                <div class="dragItem">{{ __('Total Pumps( as ready ) : ') }}{{ $sl_no }}</div>
                <div class="dragItem">{{ $totalRequirement }}</div>
                <div class="dragItem"> <button class="btn btn-rounded animated-shine px-2">{{ __('Save Plan') }}</button> </div>
                <div></div>
            </div>
        @else
            <div class="dragBlock ">{{ __('No Data Found') }}</div>
        @endif

    </div>

</div>
<div class="dragList px-4 py-2 mt-4 border-top border-info border-md">
    @if (isset($response))
        <div class="dragHeader"> {{ __('More Pums in the queue') }}</div>
    @else
        <div class="dragHeader"> {{ __('More Pums in the queue') }}</div>
    @endif
    {{-- @dd(json_encode($response)) --}}
    {{-- @dd($response['Routes']['Algorithm_1']['Route']) --}}
    <div class="dragBlockHeader ">
        <div class="dragItem">{{ __('Sl') }}</div>
        <div class="dragItem">{{ __('Pumps') }}</div>
        <div class="dragItem">{{ __('Requirement(in ltr)') }}</div>
        <div class="dragItem">{{ __('Action') }}</div>
    </div>
    @php
        $Q_sl_no = 0;
        $Q_TotalRequirement = 0;
    @endphp
    <div id="wrapperTwo">
        @if (isset($response))

            @forelse ($response['Not_selected']  as $key => $item)
                @if ($item['atDeliveryRequirement'] > 0)
                    <div class="dragBlock dragable" draggable="true">
                        <div class="dragItem">{{ ++$sl_no }}</div>
                        <div class="dragItem">{{ $item['officeName'] }}</div>
                        <div class="dragItem">{{ $item['atDeliveryRequirement'] }}</div>
                        <div class="dragItem">

                            <div onclick="addNow({{ $key }});">
                                <i class="fas  fa-upload"></i>
                            </div>

                        </div>
                    </div>
                    @php
                        $Q_sl_no++;
                        $totalRequirement = $totalRequirement + $item['atDeliveryRequirement'];
                        $Q_TotalRequirement = $Q_TotalRequirement + $item['atDeliveryRequirement'];
                    @endphp
                @endif
            @empty
                <div class="dragBlock ">{{ __('No Data Found') }}</div>
            @endforelse
            <div class="dragBlockFooter border-bottom border-info ">
                <div class="dragItem">{{ __('Total Pumps(in queue) : ') }}{{ $Q_sl_no }}</div>
                <div class="dragItem">{{ $Q_TotalRequirement }}</div>
                <div  class="dragItem">{{ __('-') }}</div>
            </div>
        @else
            <div class="dragBlock ">{{ __('No Data Found') }}</div>

        @endif

    </div>

    <div class="dragBlockFooter border-bottom border-top  border-info ">
        <div class="dragItem">{{ __('Total Pumps :') }} {{ $sl_no }}</div>
        <div class="dragItem">{{ $totalRequirement }}</div>
        <div class="dragItem">{{ __('-') }}</div>
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

    .dragBlockHeader,.dragBlockFooter {
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
    .dragBlockFooter .dragItem:nth-child(1) {
        width: 50%!important;
        text-align: left;
    }
    .dragBlockFooter .dragItem:nth-child(2) {
        width: 30%!important;
        text-align: center;
    }
    .dragBlockFooter .dragItem:nth-child(3) {
        width: 20%!important;

    }
    .dragList .dragItem {}

    .dragList .dragItem:nth-child(1) {
        width: 10%;
    }

    .dragList .dragItem:nth-child(2) {
        width: 40%;
    }

    .dragList .dragItem:nth-child(3) {
        width: 30%;
        text-align: center;
    }

    .dragList .dragItem:nth-child(4) {
        width: 20%;
        text-align: center;
        cursor: pointer;
        display: flex;
        flex-flow: row nowrap;
        justify-content: center;
        align-items: center;
        gap: 3px;
    }

    .dragList .dragItem:nth-child(4)>div {
        border-radius: 50%;
        border: 1px dotted #999;
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: all 0.2s ease-in-out;
    }

    .dragList .dragItem:nth-child(4)>div:hover {
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
</style>
@if (isset($response))
    <script>
            var response = @json($response);



        //  console.log(response.Routes.Algorithm_1.Route);
        var routeList = response.Routes.Algorithm_1.Route;
        var newList = routeList;
        var extra_list=response.Not_selected;
        var extraList=$(extra_list);
        console.log(extraList);
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
            console.log(newList);
            newList.splice(newList.length-1, 0, extraList[index]);
            console.log(newList);
            //newList.push(extraList[index]);
            extraList.splice(index,1);
            reArrange(newList);
            reArrangeWrapperTwo(extraList);
        }
        function deleteNow(index) {
            extraList.push(newList[index]);
            newList.splice(index,1);
            newList = reindex_array_keys(newList);
            reArrange(newList);
            reArrangeWrapperTwo(extraList);
        }
        function reArrangeWrapperTwo(extraList){
            var str = '';
            var Qcount=0;
            var QreqTotal=0;
            $.each(extraList, function(index, value) {
                if (value.atDeliveryRequirement > 0) {
                    // console.log(index-1);
                    // var check1 = (index > 1 && index < extraList.length - 1) ? 'active' : 'not-active disabled';
                    // var check2 = (index > 0 && index < extraList.length - 2) ? 'active' : 'not-active disabled';
                    str += '<div class="dragBlock dragable" draggable="true">';
                    str += '<div class="dragItem">' + (index+newList.length-1 )+ '</div>';
                    str += '<div class="dragItem">' + value.officeName + '</div>';
                    str += '<div class="dragItem">' + value.atDeliveryRequirement + '</div>';
                    str += '<div class="dragItem">' +
                        '<div onclick="addNow('+index+');">' +
                        '    <i class="fas    fa-upload"></i>' +
                        '</div>' +
                        '</div></div>';
                        Qcount++;

                        QreqTotal+=value.atDeliveryRequirement;
                        //console.log(QreqTotal);

                }

            });
            str+='<div class="dragBlockFooter border-bottom border-info ">'+
                    '<div class="dragItem">{{ __('Total Pumps(in queue) :') }}'+Qcount+'</div>' +
                    '<div class="dragItem">'+QreqTotal+'</div>' +
                    '<div class="dragItem">{{ __('-') }}</div>'
                '</div>';
            $('#wrapperTwo').html(str);
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
            newList = swap(routeList, index1, index2);
            reArrange(newList);
            // str += '</div>';


        }
        function reArrange(newList){
            var str = '';
            var count=0;
            var reqTotal=0;
            $.each(newList, function(index, value) {
                if (value.atDeliveryRequirement > 0) {
                    // console.log(index-1);
                    var check1 = (index > 1 && index < newList.length - 1) ? 'active' : 'not-active disabled';
                    var check2 = (index > 0 && index < newList.length - 2) ? 'active' : 'not-active disabled';
                    str += '<div class="dragBlock dragable" draggable="true">';
                    str += '<div class="dragItem">' + index + '</div>';
                    str += '<div class="dragItem">' + value.officeName + '</div>';
                    str += '<div class="dragItem">' + value.atDeliveryRequirement + '</div>';
                    str += '<div class="dragItem">' +
                        '<div class="' + check1 + '" onclick="swapNow(' + index + ',' + (index - 1) + ');">' +
                        '<i class="fas fa-arrow-up"></i></div>' +
                        ' <div class="' + check2 + '" onclick="swapNow(' + index + ',' + (index + 1) + ');">' +
                        ' <i class="fas fa-arrow-down"></i>' +
                        '</div>' +
                        '<div onclick="deleteNow('+index+');">' +
                        '    <i class="fas    fa-download"></i>' +
                        '</div>' +
                        '</div></div>';
                        count++;
                        reqTotal+=value.atDeliveryRequirement;


                }

            });
            str+=' <div class="dragBlockFooter ">' +
                '<div class="dragItem">{{ __('Total Pumps( as ready) :') }} '+count+'</div>' +
                '<div class="dragItem">'+reqTotal+'</div>' +
                '<div class="dragItem"> <button class="btn btn-rounded animated-shine px-2">{{ __('Save Plan') }}</button> </div>' +
               '</div>';
            $('#wrapperOne').html(str);
        }

        function swap($items, index1, index2) {

            // index1 validity check
            if (index1 < 0 || index1 >= $items.length)
                return $items;

            // index2 validity check
            if (index2 < 0 || index2 >= $items.length)
                return $items;

            // indices are equal. no swapping
            if (index1 == index2)
                return $items;

            // array of items
            // var items = $items.toArray();
            var items = $items;
            // console.log(items.length);
            // return;
            // swap items
            items.splice(index2, 1, items.splice(index1, 1, items[index2])[0]);

            // wrap the new array with jQuery and return
            $items = $(items);
            return $items;
        }
    </script>
@endif
