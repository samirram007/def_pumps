<div class="modal-dialog modal-md  modal-dialog-top mt-4 ">
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Enter City Name') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>
        <div class="modal-body bg-light">
            <div class="">
                <div class="row">

                    {{-- search bar --}}
                    <div class="form-group d-flex justify-content-center w-100">
                        <input type="search" id="searchBox" class="form-inline form-control "
                            placeholder="Enter City Name to search" autofocus>
                        <button class="form-inline btn-sm btn-info" id="searchBtn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="row" id="cityListPanel"></div>
            </div>
            <form id="cityForm">
                @csrf
                <input type="text" class="sr-only" id="cityId" name="cityId">
            </form>

        </div>

    </div>
    <style scoped>
        #cityListPanel {
            min-height: 100px;
            max-height: 70vh;
            overflow-y: scroll;
            margin-block: 10px;
            display: flex;
            flex-flow: column nowrap;
            align-items: flex-start;
            border-bottom: 1px solid #a5a3a3;
        }

        .cityList {
            display: flex;
            width: 100%;
            justify-content: space-between;
            margin-bottom: 10px;
            flex-direction: row;
            padding: 5px
        }

        .cityList .city {
            font-size: 16px;
            color: rgb(70, 68, 68);
        }

        .cityList .state {
            font-size: 12px;

            color: darkgray;
        }

        .cityList:first-child:nth-child(2) {}
    </style>

    <script>
        var routeRole = "{{ $routeRole }}";
        $(document).ready(function() {
            $('#searchBox').on('keyup', function(e) {

                search()


            });
            $('#searchBtn').on('click', function() {
                search()
            });

            function search() {
                let str = $('#searchBox').val();
                var search_url = "{{ route($routeRole . '.city.search', ':id') }}";
                search_url = search_url.replace(':id', str)
                console.log(search_url);
                $.ajax({
                    url: search_url,
                    method: 'GET',
                    dataType: 'json',
                    success: (data) => {
                        $("#cityListPanel").html("");
                        let htmlString = '';
                        for (let i = 0; i < Object.keys(data['cities']).length; i++) {
                            let cityName = Object.values(data["cities"])[i]["cityName"];
                            let stateName = Object.values(data["cities"])[i]["state"]["stateName"];
                            //const countryCode = Object.values(data["countries"])[j]['code'];
                            let cityId = Object.values(data["cities"])[i]["cityId"];
                            htmlString += `<div id="city${cityId}" class="cityList card">` +
                                `<div>` +
                                `<div class="city">${cityName}</div>` +
                                `<div class="state">State: ${stateName} </div>` +
                                `</div>` +
                                `<button class="btn-sm btn-info" onclick="selectCity(${cityId});"><i class="fa fa-plus"></i> </button>` +
                                `</div>`;

                        }
                        $("#cityListPanel").html(htmlString);
                    },
                    error: (err) => {
                        console.log(`Error ${JSON.stringify(err)}`)
                    }
                })

            }
            $('#cityForm').on('submit', function(e) {
                e.preventDefault()
                console.log('Happ');
                var url = "{{ route($routeRole . '.city.add') }}";

                var formData = new FormData($(this)[0]);
                $.ajax({
                    type: "POST",
                    url: url,
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
                        $('#reportPanel').html(data.html);
                        setTimeout(() => {
                            if ($('#requestProcessPanel').hasClass("sr-only")) {
                                $('#requestProcessPanel').removeClass("sr-only");
                                $('#requestPanel').removeClass("offset-md-4");

                            }
                            toastr.success(data.message);
                        }, 1000);
                        toggleRequestPanel();
                    }
                    $('.submit').attr('disabled', false);
                    $('.submit').html('Request a plan');
                }).fail(function(data) {

                    $('.submit').attr('disabled', false);
                    $('.submit').html('Request a plan');
                    toastr.error(data.message);

                    // console.log(data);
                });


            })


        });

        function selectCity(cityId) {
            $('#cityId').val(cityId);
            console.log(cityId);
            $("#city" + cityId).remove();
            // setTimeout(()=>{location.reload()},1500);
            $("#cityForm").submit();

        }
    </script>
</div>
