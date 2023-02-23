<div class="card mb-3" id="Graph1">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5>{{__('Sales-Expense')}} </h5>
            <div class="btn btn-link   p-0">

                <i id="graphOnepdf" class="fas fa-file-pdf btn-zoom bg-danger text-light fa-lg d-none mx-2"></i>
                <i id="graphOneexcel" class="fas fa-file-excel btn-zoom bg-success text-light fa-lg d-none "></i>
                <i id="graphOneChart" class="fas fa-chart-bar btn-zoom  fa-lg d-none ml-2"></i>
                <i id="graphOneData"class="fas fa-table btn-zoom  fa-lg "></i>
            </div>
        </div>


    </div>


    <div class="card-body overflow-hidden d-flex " style="justify-content: center;">
        <canvas id="chartOne" height="200px" class="w-100" style="max-height: 200px;"></canvas>
        <div id="chartOneData" class="d-none w-100" style="height: 200px; overflow-y:auto">


            <table id="chartOneDataTable" class="table-striped  display nowrap stattab"  style="width:100%" >
                {{-- <caption>{{__('Sales-Expense')}}</caption> --}}


                <thead>
                    <tr >
                        <th colspan="3" style="text-align:center; background: rgba(81, 173, 85,1); border-bottom:1px solid rgb(4, 27, 10)">{{__('Sales-Expense Summary Data')}}</th>
                    </tr>
                    <tr style="text-align:center; background: rgba(81, 173, 85,1); border-bottom:1px solid rgb(4, 27, 10)">
                        <th scope="col" style="width:50%;" class="text-left">{{__('Date')}}</th>
                        <th scope="col" style="width:25%;border-left:1px dashed #aaa" class="text-right">{{__('Sales')}}</th>
                        <th scope="col" style="width:25%;border-left:1px dashed #aaa" class="text-right">{{__('Expense')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sales = 0;
                        $expense = 0;
                    @endphp
                    @for ($i = 0; $i < count($labels); $i++)
                        @php
                            $sales += $data_sales[$i];
                            $expense += $data_expense[$i];
                        @endphp
                        <tr>
                            <td scope="col" style="width:50%;">{{ __($labels[$i]) }}</td>
                            <td scope="col" style="width:25%;border-left:1px dashed #aaa" class="text-right">{{ __(number_format($data_sales[$i], 2, '.', '')) }}</td>
                            <td scope="col" valign='middle' style="width:25%;border-left:1px dashed #aaa" class="text-right">{{ __(number_format($data_expense[$i], 2, '.', '')) }}</td>
                        </tr>
                    @endfor
                    <tr style="background:  rgb(183, 185, 183); border-top:2px solid rgb(4, 27, 10)">
                        <td scope="col" style="width:50%; text-align:right; ">{{ __('Total') }}</td>
                        <td scope="col" style="width:25%;; text-align:right;border-left:1px dashed #aaa">{{ __(number_format($sales, 2, '.', '')) }}</td>
                        <td scope="col" valign='middle' style="width:25%;; text-align:right;border-left:1px dashed #aaa" class="text-right">{{ __(number_format($expense, 2, '.', '')) }}</td>
                    </tr>

                </tbody>



            </table>


        </div>
    </div>


</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.umd.js"></script> --}}
{{-- <script src="path/to/chartjs/dist/chart.umd.js"></script> --}}
<script>
    var labelsChart1 = {{ Js::from($labels) }};
    var sales = {{ Js::from($data_sales) }};
    var expense = {{ Js::from($data_expense) }};

    var average ={{ Js::from($average) }};
    var c_type = 'line';
    if (labelsChart1.length < 10) {
        c_type = 'bar';
    }

    var dataChart1 = {
        labels: labelsChart1,
        datasets: [{
                label: '{{__('Sales')}}',
                backgroundColor: c_type == 'bar' ? 'rgb(57, 161, 0)' : '#1e579900',
                borderColor: 'rgb(57, 161, 0)',
                data: sales
            },
            {
                label: '{{__('Expense')}}',
                backgroundColor: c_type == 'bar' ? 'rgb(255, 99, 82)' : '#1e579900',
                borderColor: 'rgb(255, 99, 82)',
                data: expense
            },
            {
                label: '{{__('Avg. Sales')}}',
                data: average,
                type: 'line',
                fill: false,
                backgroundColor: 'transparent',
                borderColor: 'rgb(10, 159,90)',
                borderWidth: 1,
                pointRadius: 1,
                pointStyle: 'dot',
                borderDash: [1, 1],
                borderDashOffset: 0,
            }
        ]
    };

    var configChart1 = {
        type: c_type, // bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data: dataChart1,
        options: {
            'height': '200px',
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                labels: {
                    render: 'product_sales',
                    fontColor: '#000',
                    precision: 2,
                    fontSize: 12,
                    fontStyle: 'bold',
                    fontFamily: 'Poppins',
                    position: 'outside',
                    arc: true,
                    overlap: true,
                    showZero: true,
                    outsidePadding: 4,
                    textMargin: 4
                },
            legend: {
                position: 'bottom',
                align: 'center',
                labels: {
                    boxWidth: 10,
                    boxHeight: 10,
                    padding: 10,
                    usePointStyle: true,

                    font: {
                        size: 12,
                        family: 'Poppins',
                        weight: 400,
                        lineHeight: 1.2
                    }
                },
            }
            },
            legend: {
                position: 'bottom',
                align: 'center',
                labels: {
                    boxWidth: 10,
                    boxHeight: 10,
                    padding: 10,
                    usePointStyle: true,

                    font: {
                        size: 12,
                        family: 'Poppins',
                        weight: 400,
                        lineHeight: 1.2
                    }
                },
            }

        },
    };

    var chartOne = new Chart(
        document.getElementById('chartOne'),
        configChart1
    );
    // var background_1 = chartOne.createLinearGradient(0, 0, 0, 600);
    //     background_1.addColorStop(0, 'rgb(57, 161, 0)');
    //     background_1.addColorStop(1, 'rgb(197, 161, 0)');
</script>
<script>
    $(document).ready(function() {


        // $('#chartOneDataTable').DataTable({
        //     responsive: true,
        //     paging: false,
        //     searching: false,
        //     buttons: ['copy', 'excel'],
        //     align: 'center',
        //     columns: [{
        //         'data': 'Date',
        //         width: '70%'
        //     }, {
        //         'data': 'Sales',
        //         width: '120px'
        //     }, {
        //         'data': 'Expense',
        //         width: '120px'
        //     }],
        //     paginate: false,
        //     info: false,
        //     width: '100%',


        //     order: [
        //         [0, "desc"]
        //     ],
        //     columnDefs: [{
        //         "targets": [1, 2],
        //         "className": "text-right"
        //     }],
        //     "autoWidth": false,
        //     caption: {
        //         display: true,
        //         text: 'Sales-Expense',
        //         align: 'center',
        //         padding: 10,
        //         font: {
        //             size: 12,
        //             family: 'Poppins',
        //             weight: 400,
        //             lineHeight: 1.2
        //         }
        //     },
        //     language: {
        //         "caption": "Sales-Expense",
        //         "lengthMenu": "Display _MENU_ records per page",
        //         "zeroRecords": "Nothing found - sorry",
        //         "info": "Showing page _PAGE_ of _PAGES_",
        //         "infoEmpty": "No records available",
        //         "infoFiltered": "(filtered from _MAX_ total records)",
        //         "search": "Search:",
        //         "paginate": {
        //             "first": "First",
        //             "last": "Last",
        //             "next": "Next",
        //             "previous": "Previous"
        //         },
        //     }

        // });
        $('#graphOnepdf').click(function(){
            var office = $('#office').val();
                var isAdmin = $('#office').find(':selected').attr('data-isAdmin');

                var date = $('#reportrange').text();
                var dateArray = date.split(' - ');
                var fromDate = dateArray[0];
                var toDate = dateArray[1];


                //  alert(officeId);
                $.ajax({
                    url: '{{ route('pumpadmin.chart1_pdf') }}',
                    type: 'POST',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        officeId: office,
                        fromDate: fromDate,
                        toDate: toDate,
                        isAdmin: isAdmin
                    },
                    success: function(result, status, xhr) {
                        // console.log(result);

                        var disposition = xhr.getResponseHeader('content-disposition');
                        var matches = /"([^"]*)"/.exec(disposition);
                        var currentdate = new Date();
                        var datetime = 'salesExpense' + currentdate.getFullYear() + currentdate
                            .getDate() +
                            (currentdate.getMonth() + 1) +
                            currentdate.getHours() +
                            currentdate.getMinutes() +
                            currentdate.getSeconds();

                        // document.write(datetime);
                        var filename = (matches != null && matches[1] ? matches[1] : datetime +
                            '.pdf');

                        // The actual download
                        var blob = new Blob([result], {
                            type: 'application/pdf'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename;

                        document.body.appendChild(link);

                        link.click();
                        document.body.removeChild(link);
                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
        });
        $('#graphOneexcel').click(function(){
            var isAdmin = $('#office').find(':selected').attr('data-isAdmin');
            var office = $('#office').val();
            var date = $('#reportrange').text();
                var dateArray = date.split(' - ');
                var fromDate = dateArray[0];
                var toDate = dateArray[1];


                //  alert(officeId);
                $.ajax({
                    url: '{{ route('pumpadmin.chart1_excel') }}',
                    type: 'POST',
                    xhrFields: {
                        responseType: 'blob'
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        officeId: office,
                        fromDate: fromDate,
                        toDate: toDate,
                        isAdmin: isAdmin
                    },
                    success: function(result, status, xhr) {
                        var disposition = xhr.getResponseHeader('content-disposition');
                        var matches = /"([^"]*)"/.exec(disposition);
                        var filename = (matches != null && matches[1] ? matches[1] :
                            'sales-expense summary.xlsx');

                        // The actual download
                        var blob = new Blob([result], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename;

                        document.body.appendChild(link);

                        link.click();
                        document.body.removeChild(link);


                    },
                    fail: function(data) {
                        alert('Not downloaded');
                        //console.log('fail',  data);
                    }
                });
        });

        $('#graphOneChart').click(function() {
            $(this).addClass('d-none');
            $('#graphOneData').removeClass('d-none');
            $('#chartOne').removeClass('d-none');
            $('#chartOne').css('margin-left', "0");
            // alert();
            $('#chartOneData').addClass('d-none');
            $('#chartOneData').removeClass('d-flex');
            $('#graphOnepdf').addClass('d-none');

            $('#graphOneexcel').addClass('d-none');


        });
        $('#graphOneData').click(function() {
            $(this).addClass('d-none');
            $('#graphOneChart').removeClass('d-none');

            var height = $('#chartOne').css('height');
            var width = $('#chartOne').css('width');
            $('#chartOneData').css('witdh', width);
            width = (parseInt(width) + 20) + "px";

            $('#chartOne').addClass('d-none');
            $('#chartOneData').removeClass('d-none');
            $('#chartOneData').addClass('d-flex');
            $('#graphOnepdf').removeClass('d-none');
            $('#graphOneexcel').removeClass('d-none');


        });


    });
</script>
