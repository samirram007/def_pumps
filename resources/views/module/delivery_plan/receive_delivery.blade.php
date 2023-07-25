<div class="modal-dialog modal-lg  modal-dialog-centered mt-0 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Order Receiving') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>

        <div class="modal-body bg-light">
            <div class="row">
                <div class="col-md-6">
                    {{ __('Pump') }}: <span class="font-weight-bold">{{ $planDetails['officeName'] }}</span>
                </div>
                <div class="col-md-6">

                    {{ __('Hub') }}: <span
                        class="font-weight-bold">{{ $planDetails['startPoint']['hubName'] }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Plan Date') }}: <span
                        class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['deliveryPlan']['planDate'])) }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Delivery Date') }}: <span
                        class="font-weight-bold">{{ date('d-M-Y', strtotime($planDetails['deliveryPlan']['planDate'])) }}</span>
                </div>
                <div class="col-md-6">
                    {{ __('Product') }}: <span
                        class="font-weight-bold">{{ $planDetails['product']['productTypeName'] }}</span>
                </div>
                <div class="col-md-6">
                    @php
                        $status = '<span class="font-weight-bold text-gray">Receive Confirmation Pending</span>';
                        if ($planDetails['approveStatus'] == -1) {
                            $status = '<span class="font-weight-bold text-danger">Rejected</span>';
                        } elseif ($planDetails['approveStatus'] == 2) {
                            if ($planDetails['deliveryPlan']['deliveryPlanStatusId'] == 2) {
                                $status = '<span class="font-weight-bold text-success">Order Placed</span>';
                            } elseif ($planDetails['deliveryPlan']['deliveryPlanStatusId'] == 3) {
                                $status = '<span class="font-weight-bold text-success">Delivery On The Way</span>';
                            }
                        } elseif ($planDetails['approveStatus'] == 3) {
                            $status = '<span class="font-weight-bold text-success">Received</span>';
                        }

                    @endphp
                    {{ __('Status') }}: {!! $status !!}
                </div>
                <div class="col-md-6">
                    @if ($planDetails['approveStatus'] == 3)
                        {{ __('Received Quantity') }}: <span class="font-weight-bold"
                            id="receivedQty">{{ $planDetails['receivedQuantity'] }}</span>
                    @else
                        {{ __('Receiving Quantity') }}: <span class="font-weight-bold"
                            id="receivedQty">{{ $planDetails['approvedQuantity'] }}</span>
                    @endif
                </div>
                <div class="col-md-6">
                    {{-- {{ $planDetails['approveStatus'] }} --}}
                    @if ($planDetails['approveStatus'] == 3)
                        {{ __('Remaining Quantity') }}: <span class="font-weight-bold" id="remainingQty">0</span>
                        <span class="sr-only"
                            id="distributedQty">{{ $planDetails['receivedQuantity'] }}</span>
                    @else
                        {{ __('Remaining Quantity') }}: <span class="font-weight-bold" id="remainingQty">{{ $planDetails['approvedQuantity'] }}</span>
                        <span class="sr-only" id="distributedQty">0</span>
                    @endif

                </div>


            </div>
        </div>
        <form id="formApprove" enctype="multipart/form-data">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">
                    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                    <section id="step1" class="content">
                        <div class=" p-3 bg-white shadow min-h-100">



                            <div class="card">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                for="plannedQuantity">{{ __('Suggested Quantity') }}({{ __($planDetails['productUnit']['unitShortName']) }})
                                                <span class="text-danger">*</span></label>
                                            <input type="text" size="10" class="form-control" disabled
                                                value="{{ $planDetails['plannedQuantity'] }}">
                                            <input type="text" size="10" class="sr-only" id="plannedQuantity"
                                                name="plannedQuantity" value="{{ $planDetails['plannedQuantity'] }}">
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                for="approvedQuantity">{{ __('Ordered Quantity') }}({{ __($planDetails['productUnit']['unitShortName']) }})
                                                <span class="text-danger">*</span></label>
                                            <input type="text" size="10" class="form-control" disabled
                                                value="{{ $planDetails['approvedQuantity'] == null ? '' : $planDetails['approvedQuantity'] }}">
                                            <input type="text" size="10" class="sr-only" id="approvedQuantity"
                                                name="approvedQuantity"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                value="{{ $planDetails['approvedQuantity'] == null ? '' : $planDetails['approvedQuantity'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label
                                                for="receivedQuantity">{{ __('Received Quantity') }}({{ __($planDetails['productUnit']['unitShortName']) }})
                                                <span class="text-danger">*</span></label>
                                            <input type="text" size="10" class="form-control"
                                                id="receivedQuantity" name="receivedQuantity"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^([0-9]*\.[0-9]{0,2}).*/,'$1');"
                                                value="{{ $planDetails['receivedQuantity'] == null ? '' : $planDetails['receivedQuantity'] }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div style="font-size:0.8rem"
                                            class="mt-2 mb-4 panel panel-info w-100 bg-light rounded text-center text-info  ">
                                            Leave "{{ __('Receive Quantity') }}" empty to confirm "Ordered Quantity"
                                        </div>
                                    </div>

                                </div>

                                <div class="row text-center mb-4">
                                    <div class="col-6 mx-auto">
                                        <button type="button" class="next btn btn-rounded animated-shine px-4"><span
                                                class="iconify" data-icon="mdi:content-save-all-outline" data-width="15"
                                                data-height="15"></span>
                                            {{ __('Next') }}</button>

                                    </div>
                                    <div class="col-6 mx-auto">
                                        {{-- <button type="button"
                                                        class="reject btn btn-rounded animated-shine-danger px-4" >
                                                        <i class="fa fa-ban"></i>
                                                        {{ __('Reject') }}</button> --}}
                                        <button type="button" class=" btn btn-rounded animated-shine-danger px-4"
                                            data-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </section>
                    <section id="step2" class="content sr-only">
                        <div class=" p-3 bg-white shadow min-h-100">
                            <div class="card">
                                <div id="godownList" class=" godownList">
                                    {{-- @dd($godowns[0]['godownProduct'] ) --}}
                                    {{-- @foreach ($godowns[0]['godownProduct'] as $key => $godown)
                                        <div id="godown{{ $godown['godownId'] }}"
                                            data-godownid="{{ $godown['godownId'] }}" class="godown">
                                            <div class="name">{{ $godown['godownName'] }}</div>
                                            <div class="capacity">{{ __('Capacity') }}: {{ $godown['capacity'] }}
                                            </div>
                                            <div class="isReserver">{{ __('Reserver') }}: {{ $godown['isReserver'] }}
                                            </div>
                                            <div class="currentStock">
                                                {{ __('Current') }}:{{ $godown['currentStock'] }}</div>


                                        </div>
                                    @endforeach --}}
                                </div>

                                <div class="row text-center mb-4 mt-4">
                                    <div class="col-6 mx-auto">
                                        <button type="submit"
                                            class="submit btn btn-rounded animated-shine px-4 disabled" disabled><span
                                                class="iconify" data-icon="mdi:content-save-all-outline"
                                                data-width="15" data-height="15"></span>
                                            {{ __('Confirm') }}</button>

                                    </div>
                                    <div class="col-6 mx-auto">
                                        {{-- <button type="button"
                                    class="reject btn btn-rounded animated-shine-danger px-4" >
                                    <i class="fa fa-ban"></i>
                                    {{ __('Reject') }}</button> --}}
                                        <button type="button" class=" btn btn-rounded animated-shine-danger px-4"
                                            data-dismiss="modal">{{ __('Cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <style scoped>
                        .godownList {
                            display: flex;
                            flex-flow: row nowrap;
                            width: 100%;
                            gap: 10px;
                            overflow-x: auto !important;
                            justify-content: start;
                            flex-wrap: nowrap;
                            flex-direction: row;
                            align-items: center;
                        }

                        .godownList::-webkit-scrollbar {
                            width: 20px;
                        }

                        .godownList>.godown {
                            border: 2px solid #083b3096;
                            padding: 5px;
                            border-radius: 5px;
                            min-width: 14rem;
                            position: relative;


                        }

                        .godownList>.godown>.name {
                            font-size: 1.2rem;
                        }

                        .godownList>.godown>.capacity,
                        .godownList>.godown>.isReserver,
                        .godownList>.godown>.currentStock {
                            font-size: 0.9rem;
                        }

                        .img-btn {
                            position: absolute;
                            width: 30px;
                            right: 0;
                            top: 0;
                            outline: none;
                            border: 0;
                            background: transparent;
                            font-size: 1.5rem;
                            z-index: 0;
                        }

                        .img-btn i {
                            color: #5a5757;
                        }

                        .img-btn>img {
                            width: 100%;
                        }

                        .panelInputStock {
                            position: absolute;
                            bottom: 0;
                            left: 0;

                            background: #ebe5e5;
                            height: 100%;
                            padding: 10px;
                            /* display: none; */
                        }

                        .panelInputStock>div {
                            display: flex;
                            flex-direction: row;
                            flex-wrap: nowrap;
                            height: 2.3rem;
                            margin: .3rem auto;
                            z-index: 1;
                        }
                        .panelInputStock>label {
                            white-space: nowrap;
                        }

                        .btn-fuel {
                            font-size: 1.5rem;
                            padding: 0 10px !important;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }

                        .panelInputStock>.form-control {}
                    </style>
                </div>
            </div>

        </form>
        {{-- @dd($planDetails) --}}
    </div>
    <script>
        var godownsArray = [];
        var godowns = @JSON($godowns[0]['godownProduct']);
        var deliveryGodownMapper = @JSON($planDetails['deliveryGodownMapper']);
        console.log(deliveryGodownMapper);
        $(document).ready(() => {
            setTimeout(() => {
                $('#receivedQuantity').focus();
            }, 500);
            godownFill();



        });
        var fuelTobeLoaded = 0;

        function showPanel(godownId, index) {
            let tankElement = document.getElementById('godown' + godownId);

            let current = tankElement.dataset.index;
            let tankArray = godowns[index];
            let target = tankArray.currentStock;
            let capacity=tankArray.capacity ;
            let remainingCapacity=parseFloat(document.getElementById('remainingQty').innerHTML);

            let fillableQty=(capacity-target)>remainingCapacity?remainingCapacity:(capacity-target);

            if (tankElement.querySelector('.panelInputStock').classList.contains('sr-only')) {
                tankElement.querySelector('.panelInputStock').classList.remove('sr-only')
                tankElement.querySelector('.inputBox').focus();
                tankElement.querySelector('.inputBox').value=parseInt(fillableQty)
            } else {
                tankElement.querySelector('.panelInputStock').classList.add('sr-only')
                tankElement.querySelector('.inputBox').value=''
            }

        }

        function fuelUpByEnter(e, godownId, index) {
            if (e.which == 13) {
                fuelUp(godownId, index)
            }
        }
        async function fuelUp(godownId, index) {

            // console.log(godownsArray.length);
            let tankElement = document.getElementById('godown' + godownId);
            var thisStock = tankElement.querySelector('.inputBox').value;
            var lastCalculated = $('#distributedQty').html();

            //console.log(thisStock);
            if (tankElement.querySelector('.inputBox').value > 0) {
                if (!canLoad(godownId, index, thisStock)) {
                    tankElement.querySelector('.inputBox').focus();
                    let errorStr = "Quantity overflow!<br>Please! check your input"
                    toastr.warning(errorStr)
                   // Swal.fire('', errorStr, 'warning');

                    return;
                }

                showPanel(godownId, index);
            } else {
                tankElement.querySelector('.inputBox').focus();
                let errorStr = "Enter value to be transfer"
                toastr.warning(errorStr)
                // Swal.fire('', errorStr, 'warning');

                return;
            }
            toastr.success("transfer accepted")
            let current = tankElement.dataset.index;
            let tankArray = godowns[index];
            let target = tankArray.currentStock;

            let fluidPercentage = tankArray.currentStock / tankArray.capacity * 100;
            fuelTobeLoaded = (parseInt(thisStock) + tankArray.currentStock) / tankArray.capacity * 100;
            //console.log((parseInt(thisStock)+tankArray.currentStock) );
            //let fluidPercentage=parseInt(fuel++)/parseInt(fuel++)*100;
            let styleText = '';
            // console.log(tankElement);
            // while (target > tankArray.currentStock) {
            let angle = 0;


            if (parseInt(fluidPercentage) > 100) {
                angle = 0;
                tankElement.querySelector('.addedStock').innerHTML =
                    ` + ${(parseInt(tankArray.capacity)-parseInt(tankArray.currentStock)).toFixed(0)}`;
                return

            }

            //console.log(parseInt(fuelTobeLoaded));
            // $('#distributedQty').html(' _ _ _ _ _ ')
            while (parseInt(fluidPercentage) <= parseInt(fuelTobeLoaded)) {
                // $('#distributedQty').html(' _ _ _ _ _ ')
                //console.log(parseInt(fluidPercentage));
                if (parseInt(fluidPercentage) == 100) {
                    angle = 0;
                    tankElement.querySelector('.addedStock').innerHTML =
                        ` + ${(parseInt(tankArray.capacity)-parseInt(tankArray.currentStock)).toFixed(0)}(added)`;
                    styleText =
                        `linear-gradient(${angle}deg, rgba(0,151,255,0.6) ${fluidPercentage}%, rgba(255,255,255,0) ${fluidPercentage+2}% )`;

                    tankElement.style.background = styleText;
                    tankElement.style.transitionStyle = "ease-out";
                    tankElement.style.transitionDuration = "0.5s";
                    let newObj = {
                        'godownId': godownId,
                        'quantity': (parseInt(tankArray.capacity) - parseInt(tankArray.currentStock)).toFixed(0)
                    }
                    updateArray(newObj)
                    CheckDistributedQuantity()
                    return

                } else if (parseInt(fluidPercentage) == parseInt(fuelTobeLoaded)) {
                    angle = 0;
                    tankElement.querySelector('.addedStock').innerHTML =
                        ` + ${ parseInt(thisStock) .toFixed(0)}(added)`;
                    styleText =
                        `linear-gradient(${angle}deg, rgba(0,151,255,0.6) ${fluidPercentage}%, rgba(255,255,255,0) ${fluidPercentage+2}% )`;

                    tankElement.style.background = styleText;
                    tankElement.style.transitionStyle = "ease-out";
                    tankElement.style.transitionDuration = "0.5s";
                    let newObj = {
                        'godownId': godownId,
                        'quantity': thisStock
                    }
                    updateArray(newObj)
                    //console.log(godownsArray);

                    CheckDistributedQuantity()

                    return

                } else if (angle > 0) {
                    angle = -0.2;
                } else {
                    angle = 0.2;
                }
                styleText =
                    `linear-gradient(${angle}deg, rgba(0,151,255,0.6) ${fluidPercentage}%, rgba(255,255,255,0) ${fluidPercentage+5}% )`;

                tankElement.style.background = styleText;
                tankElement.style.transitionStyle = "ease-in";
                tankElement.style.transitionDuration = "0.5s";
                //console.log(fuelTobeLoaded);
                fluidPercentage++;
                tankElement.querySelector('.addedStock').innerHTML =
                    ` + ${((fluidPercentage*tankArray.capacity/100).toFixed(0)-tankArray.currentStock).toFixed(0)}`;
                let newObj = {
                    'godownId': godownId,
                    'quantity': ((fluidPercentage * tankArray.capacity / 100).toFixed(0) - tankArray.currentStock)
                }
                updateArray(newObj)
                CheckDistributedQuantity()
                target--;
                // console.log(godownsArray);



                await sleep(50);


                //CheckDistributedQuantity()
                // $('#distributedQty').html(parseInt(lastCalculated)+parseInt((fluidPercentage*tankArray.capacity/100)-tankArray.currentStock))

            }



        }

        function updateArray(newObj) {

            let index = godownsArray.findIndex(item => item['godownId'] === newObj['godownId']);

            if (index !== -1) {
                // Object already exists, update it
                godownsArray[index] = newObj;
            } else {
                // Object doesn't exist, insert it
                godownsArray.push(newObj);
            }
        }

        function canLoad(godownId, index, thisStock) {
            var rcvdQty = document.getElementById("receivedQty").innerHTML;
            let newObj = {
                'godownId': godownId,
                'quantity': thisStock
            }
            let newArray = godownsArray.map(a => ({
                ...a
            }));
            index = newArray.findIndex(item => item['godownId'] === newObj['godownId']);

            if (index !== -1) {
                // Object already exists, update it
                newArray[index] = newObj;
            } else {
                // Object doesn't exist, insert it
                newArray.push(newObj);
            }
            const distributed = newArray.reduce((accumulator, object) => {
                return accumulator + parseInt(object.quantity);
            }, 0);
            if (distributed > parseInt(rcvdQty)) {
                toastr.warning("Quantity overflow")
                return false
            }
            return true
        }

        function CheckDistributedQuantity() {
            var rcvdQty = document.getElementById("receivedQty").innerHTML;

            const distributed = godownsArray.reduce((accumulator, object) => {
                return accumulator + parseInt(object.quantity);
            }, 0);
            $('#distributedQty').html(distributed)
            $('#remainingQty').html(rcvdQty-distributed)
            // console.log(distributed, rcvdQty);
            if (distributed >= parseInt(rcvdQty)) {
                // console.log(distributed);
                if ($('.submit').hasClass('disabled')) {
                    $('.submit').removeClass('disabled')
                    $('.submit').removeAttr("disabled")
                }
            } else if (distributed < parseInt(rcvdQty)) {

                $('.submit').addClass('disabled')
                $('.submit').attr("disabled")

            }

        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        function godownFill() {
            let receivedQty = $('#receivedQuantity').val();
            let distributedQty = $('#distributedQty').val();

            let strGodown = '';
            godowns.forEach((godown, index) => {

                let thisdeliveryGodownMapper = deliveryGodownMapper.filter(
                    function(currentValue, index, arr) {

                        return godown.godownId == currentValue.godownId
                    }
                );
                // console.log(thisdeliveryGodownMapper);
               let LoadedQuantity=thisdeliveryGodownMapper.length==0?0:thisdeliveryGodownMapper[0].quantity;
                    console.log(LoadedQuantity);
                    godown.currentStock-=LoadedQuantity;
                let fluidPercentage = parseInt(godown.currentStock) / parseInt(godown.capacity) * 100;

                let styleText = `background: ` +
                    `linear-gradient(0deg, rgba(0,201,210,0.3) ${fluidPercentage}%, rgba(255,255,255,0) ${fluidPercentage}% )`;
                    if(LoadedQuantity>0){
                        let LoadedPercentage=parseInt(LoadedQuantity) / parseInt(godown.capacity) * 100;
                        styleText = `background: ` +
                    `linear-gradient(0deg, rgba(00,201,200,0.6) ${fluidPercentage}%, rgba(151,151,151,0.6) ${fluidPercentage}%,rgba(151,151,155,0.2) ${LoadedPercentage+fluidPercentage}%,rgba(255,255,255,0) ${fluidPercentage}% )`;
                    }
                strGodown += `<div id="godown${ godown.godownId }" ` +
                    `style="${styleText}"` +
                    `data-index="${ index }"` +
                    `data-godownid="${ godown.godownId }" class="godown">` +
                    `<div class="position-absolute"></div>` +

                    `<button class="img-btn" type="button" onclick="showPanel(${ godown.godownId },${ index });">` +
                    `<i class="fa fa-plus"></i>` +
                    `</button>` +
                    `<div class="name">${ godown.godownName }</div>` +
                    `<div class="capacity">{{ __('Capacity') }}: ${ godown.capacity.toFixed(0) }` +
                    `</div>` +
                    `<div class="isReserver">{{ __('Reserver') }}: ${ godown.isReserver }` +
                    `</div>` +
                    `<div class="currentStock">` +
                    `{{ __('Current') }}:${ godown.currentStock.toFixed(0) } <span class="addedStock">`+
                        `+ ${LoadedQuantity>0? LoadedQuantity+'(added)':''}</span></div>` +
                    `<div class="panelInputStock sr-only"  >` +
                    `<button type="button" class="img-btn" onclick="showPanel(${ godown.godownId },${ index });">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>` +
                    `<label>${ godown.godownName } to be filled</label>` +
                    `<div>` +
                    `<input name="" type="number" max="${ godown.capacity.toFixed(0) }" step="1" ` +
                    ` onkeypress="fuelUpByEnter(event,${ godown.godownId },${ index })" class="form-control inputBox" placeholder="0" >` +
                    ` <button type="button" class="btn-fuel btn-sm btn-info" onclick="fuelUp(${ godown.godownId },${ index })"><i class="fa fa-plus"></i> </button>` +
                    `</div>` +
                    `</div>` +
                    `</div>`;

            });
            $('#godownList').html(strGodown)
        }

        $('.reject').on("click", function() {
            $('.reject').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            $('.reject').attr('disabled', true);
            var rejecturl = "{{ route($routeRole . '.delivery_plan_details.reject', ':id') }}";
            var deliveryPlanDetailsId = {{ $planDetails['deliveryPlanDetailsId'] }};
            // console.log(deliveryPlanDetailsId);
            rejecturl = rejecturl.replace(':id', deliveryPlanDetailsId);
            $.ajax({
                type: "GET",
                url: rejecturl,

            }).done(function(data) {
                if (!data.status) {

                    $('.reject').attr('disabled', false);
                    $('.reject').html('Request a plan');
                    $.each(data.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid');
                        $('#' + key).next().text(value);
                        toastr.error(value);
                    });

                } else {
                    // console.log(data.data);
                    //  $('#reportPanel').html(data.html);
                    toastr.warning(data.message);
                    setTimeout(() => {

                        // $('.submit').attr('disabled', false);
                        // $('.submit').html('Approve');
                        // filter()
                        $('#filter').click();
                        $("#modal-popup .close").click()
                        //window.location.reload();
                    }, 1000);
                    return;
                    // toggleRequestPanel();
                }
                $('.reject').attr('disabled', false);
                $('.reject').html('Reject');
            }).fail(function(data) {

                $('.reject').attr('disabled', false);
                $('.reject').html('Reject');
                toastr.error(data.message);

                // console.log(data);
            });
        });
        $('.next').on('click', () => {
            $('#step1').addClass('sr-only')
            $('#step2').removeClass('sr-only')
            var receivedQuantity = 0;
            if ($('#receivedQuantity').val() > 0) {
                $('#receivedQty').html($('#receivedQuantity').val())
                $('#remainingQty').html($('#receivedQuantity').val())

            } else {
                $('#receivedQty').html($('#approvedQuantity').val())
                $('#remainingQty').html($('#approvedQuantity').val())
            }

        });
        $("#formApprove").on("submit", function(event) {
            event.preventDefault();
            if (godownsArray.length == 0) {
                toastr.warning("Distribution pending")
                return;
            }
            // console.log(parseFloat($('#approvedQuantity').val()) ,$('#plannedQuantity').val());
            if (parseFloat($('#receivedQuantity').val()) > parseFloat($('#approvedQuantity').val())) {
                toastr.error("Maximum Qunatity exceed...");
                $('#receivedQuantity').focus();
                return;
            }

            $('.submit').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> '
            );
            $('.submit').attr('disabled', true);
            var submit_url = "{{ route($routeRole . '.delivery_plan_details.confirm_delivery', ':id') }}";
            var deliveryPlanDetailsId = {{ $planDetails['deliveryPlanDetailsId'] }};
            // console.log(deliveryPlanDetailsId);
            submit_url = submit_url.replace(':id', deliveryPlanDetailsId);

            // console.log(submit_url);
            var formData = new FormData($(this)[0]);
            formData.append('deliveryGodownList', JSON.stringify(godownsArray));


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
                        $('#filter').click();
                        $("#modal-popup .close").click()
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
        });
    </script>
</div>
