<style>

</style>
<div class="modal-dialog modal-xl modal-dialog-top mt-4 position-relative ">
    <div class="modal-content bg-light position-relative">

        @include('module.delivery_plan.status_change.top_header')
        <div class="modal-body bg-light py-2">
            <div id="header_part" class="header_part row">

                @include('module.delivery_plan.status_change.header_part')

            </div>

        </div>
        <div class="position-relative">
            <div class="modal-body bg-white p-0  ">
                <div class="d-flex flex-nowrap overflowY-scroll">
                    <button class="tablink" id="btnData" onclick="openPage('panelData', this, 'info')"><i
                            class="fas fa-database"></i> {{ __('Data') }}</button>
                    <button class="tablink" id="btnMap" onclick="openPage('panelMap', this, 'info')"><i
                            class="fas fa-map-marked"></i> {{ __('Map') }}</button>
                    @if ($isTopAdmin)
                        <button class="tablink" id="btnDriver" onclick="openPage('panelDriver', this, 'info')"><i
                                class="fas fa-truck"></i> {{ __('Driver') }}</button>
                    @endif
                    <button class="tablink d-none" id="btnOrder" onclick="openPage('panelOrder', this, 'info')"><i
                            class="fas fa-check-circle"></i> {{ __('Approval') }}</button>
                    <button class="tablink d-none pe-none" id="btnReceivingInit"
                        onclick="openPage('panelReceivingInit', this, 'info')"><i class="fab fa-ioxhost"></i>
                        {{ __('Receiving init..') }}</button>
                    <button class="tablink d-none pe-none" id="btnReceiving"
                        onclick="openPage('panelReceiving', this, 'info')"><i class="fab fa-opencart"></i>
                        {{ __('Receiving') }}</button>
                    <button class="tablink   pe-none" id="btnDot"
                        onclick="openPage('panelDot', this, 'info')">...</button>

                </div>


                <div id="panelData" class="tabcontent w-100  ">

                    <section class="content">
                        <div id="tablePanel" class=" p-3     min-h-100">
                            @include('module.delivery_plan.status_change.datatable')
                        </div>

                    </section>
                    <div class="rounded card p-3 bg-white shadow min-h-100 fixed-bottom">
                        @include('module.delivery_plan.status_change.info')

                    </div>
                </div>


                <div id="panelMap" class="tabcontent  ">

                    {{-- <div id="mapWrapperPanel" class="  w-100 flex-column  ">

                        @include('module.delivery_plan.map.index')

                    </div> --}}

                    <object id="mapObject" data="" type="" class="object "></object>
                    <script>
                        function deliveryPlanMap() {

                            var MAP_DASHBOARD_URL = "{{ env('DASHBOARD_URL') }}";

                            var str = `${MAP_DASHBOARD_URL}deliveryPlanMap/${deliveryPlanId}`;

                            document.getElementById('mapObject').data = str;
                        }
                    </script>
                </div>

                <div id="panelDriver" class="tabcontent">
                    @php
                        $token = session()->get('_token');
                        $userid = session()->get('loginid');
                        $lang = str_replace('_', '-', app()->getLocale());

                    @endphp

                    <style>
                        .object {
                            width: 100%;
                            height: 70vh;
                        }

                        ::-webkit-scrollbar {
                            width: .5em;
                        }

                        .theme-container {
                            background: rgb(26, 28, 45) !important;
                            border-radius: 20px;
                            padding: 1.2rem;
                        }
                    </style>
                    <object id="driverObject" data="" type="" class="object "></object>
                    <script>
                        function newDriver() {
                            var token = '{{ $token }}';
                            var userid = '{{ $userid }}';
                            var lang = '{{ $lang }}';
                            var theme = localStorage.getItem('lights') == 'on' ? 'light' : 'dark';
                            localStorage.setItem("webtoken", "101010")

                            var DASHBOARD_URL = "{{ env('DASHBOARD_URL') }}";
                            var thisDriverId = ``;
                            // var str = `http://115.124.120.251:5063/?theme=${theme}&lang=${lang}&userId=${ userid }&jwtToken=${ token }`;
                            var jsonData = {
                                driverId: thisDriverId,
                                deliveryPlanId: deliveryPlanId,
                                updatedBy: userid,
                            }

                            // jwtToken: token
                            var base64Token = JSON.stringify(jsonData);


                            var str = `${DASHBOARD_URL}driverassignment?theme=${theme}&lang=${lang}&token=${btoa(base64Token)}`;


                            document.getElementById('driverObject').data = str;
                        }
                    </script>
                </div>

                <div id="panelOrder" class="tabcontent">
                    <h3>Order</h3>
                    <p>Who we are and what we do.</p>
                </div>
                <div id="panelReceivingInit" class="tabcontent border-0">

                    <script>
                        function newReceivingInit() {


                        }

                        function receivingPanelOpen(e) {
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

                                    $("#panelReceiving").html(data['html']);
                                    $("#panelReceivingInit").addClass('d-none');
                                    $("#btnReceivingInit").addClass('d-none');
                                    $("#panelReceiving").removeClass('d-none');
                                    $("#btnReceiving").removeClass('d-none');
                                    $("#btnDriver").addClass('d-none');
                                    $("#btnMap").addClass('d-none');
                                    // $("#modal-popup").modal('show');
                                    //increase modal height 0 to 100 % animated
                                    document.getElementById("btnReceiving").click();
                                }
                                e.innerHTML = thisHTML
                            }).fail(function(data) {
                                toastr.error(data.message);
                                e.innerHTML = thisHTML


                            });
                            return;
                        }

                        function orderPanelOpen(e) {

                            let thisHTML = e.innerHTML;

                            e.innerHTML =
                                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`

                            var submit_url = e.getAttribute('data-url');

                            $.ajax({
                                type: "GET",
                                url: submit_url,
                            }).done(function(data) {

                                if (!data.status) {
                                    toastr.error(data.message);

                                    e.target.innerHTML = thisHTML


                                } else {

                                    $("#panelOrder").html(data['html']);
                                    $("#panelReceivingInit").addClass('d-none');
                                    $("#btnReceivingInit").addClass('d-none');
                                    $("#panelOrder").removeClass('d-none');
                                    $("#btnOrder").removeClass('d-none');
                                    $("#panelReceiving").addClass('d-none');
                                    $("#btnReceiving").addClass('d-none');
                                    $("#btnDriver").addClass('d-none');
                                    $("#btnMap").addClass('d-none');
                                    // $("#modal-popup").modal('show');
                                    //increase modal height 0 to 100 % animated
                                    document.getElementById("btnOrder").click();
                                }
                                e.innerHTML = thisHTML
                            }).fail(function(data) {
                                toastr.error(data.message);
                                e.innerHTML = thisHTML


                            });
                            return;
                        }
                    </script>
                    @include('module.delivery_plan.status_change.receiving')
                </div>
                <div id="panelReceiving" class="tabcontent">
                    @include('module.delivery_plan.status_change.receiving_confirm')
                </div>




            </div>


            <form id="FormSetStatus">
                @csrf
            </form>
            <form id="FormReceiving">
                @csrf
            </form>


            @include('module.delivery_plan.status_change.css')
            {{-- @include('module.delivery_plan.map.css') --}}
            @include('module.delivery_plan.js')
            @include('module.delivery_plan.status_change.js')


        </div>

    </div>

    <style>
        .tablink {
            background-color: white;
            background: linear-gradient(0deg, #0b264631 5%, transparent 85%) !important;
            border-bottom: 4px solid #0b264631 !important;
            border-left: 1px solid #22222223 !important;
            color: rgb(179, 174, 174);
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 17px;
            width: 40%;
        }

        #btnDot {
            width: 20%;
        }

        .info {
            border-bottom: 4px solid #0c8992 !important;
            background: linear-gradient(0deg, transparent 5%, transparent 31%) !important;
            border-left: none !important;
            font-weight: bold;
            color: #0c8992;
            transition: border-bottom, border-left, background 0.5s ease-out;
        }

        .tablink:hover {
            background-color: white;
        }

        /* Style the tab content (and add height:100% for full page content) */
        .tabcontent {
            color: white;
            display: none;
            padding: 0;
            height: 100%;
            max-height: 70vh !important;
            min-height: 70vh !important;
            /* overflow-y: auto; */
        }

        #panelData {
            background-color: white;
        }

        #News {
            background-color: white;
        }

        #panelDriver {
            background-color: white;
        }

        #About {
            background-color: white;
        }
    </style>
    <script>
        var clickCount = 0

        function openPage(pageName, elmnt, color) {
            // Hide all elements with class="tabcontent" by default */
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }


            // Show the specific tab content
            document.getElementById(pageName).style.display = "block";

            // Add the specific color to the button used to open the tab content
            // elmnt.style.backgroundColor = color;
            document.querySelectorAll('.tablink').forEach(element => {
                element.classList.remove(color)
            });
            elmnt.classList.add(color);

            if (pageName == 'panelData') {
                //    getMapForPanel()
                $("#panelReceivingInit").addClass('d-none');
                $("#btnReceivingInit").addClass('d-none');
                $("#panelReceiving").addClass('d-none');
                $("#btnReceiving").addClass('d-none');
                $("#btnDriver").removeClass('d-none');
                $("#btnMap").removeClass('d-none');
                if (clickCount !== 0) {
                    getData(elmnt)
                    clickCount++
                } else {
                    clickCount++
                }

            }
            if (pageName == 'panelMap') {
                //    getMapForPanel()
                deliveryPlanMap()
            }
            if (pageName == 'panelDriver') {
                newDriver()
            }
            if (pageName == 'panelReceivingInit') {
                $("#panelReceivingInit").removeClass('d-none');
                $("#btnReceivingInit").removeClass('d-none');
                $("#panelReceiving").addClass('d-none');
                $("#btnReceiving").addClass('d-none');
                $("#btnDriver").addClass('d-none');
                $("#btnMap").addClass('d-none');
                newReceivingInit()
            }
            if (pageName == 'panelReceiving') {
                //   receivingPanelOpen(elmnt)
            }
        }

        // Get the element with id="defaultOpen" and click on it
        var defualtPage = @json($page);

        if (defualtPage == '') {
            document.getElementById("btnData").click();
        } else if (defualtPage == 'driver') {
            document.getElementById("btnDriver").click();
        }
    </script>

</div>
