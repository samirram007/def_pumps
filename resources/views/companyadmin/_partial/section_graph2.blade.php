<div class="card mb-3" id="Graph2">
    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">
            <h4>{{__('Product Wise')}}</h4>
            <div class="btn btn-link   p-0">

                <i id="graphTwopdf" class="fas fa-file-pdf btn-zoom  bg-danger text-light fa-lg d-none mx-2"></i>
                <i id="graphTwoexcel" class="fas fa-file-excel btn-zoom bg-success text-light fa-lg d-none "></i>
                <i id="graphTwoChart" class="fas fa-chart-bar btn-zoom  fa-lg d-none ml-2"></i>
                <i id="graphTwoData"class="fas fa-table btn-zoom fa-lg "></i>
            </div>
        </div>
    </div>
    <div class="card-body overflow-hidden d-flex  " style="justify-content: center!important;">
        <canvas id="chartTwo" height="200px" class="w-100"></canvas>

        {{-- <div id="series_chart_div"></div> --}}
        <div id="chartTwoData" class="d-none w-100" style="height: 200px; overflow:auto">

                <table id="chartTwoDataTable" class="  table-striped  display nowrap stattab" style="width:100%"   >
                    <thead>
                        <tr>
                            <th colspan="3" style="text-align:center; background: rgba(81, 173, 85,1); border-bottom:1px solid rgb(4, 27, 10)">
                                {{__('Product Wise Summary Data')}}
                            </th>
                        </tr>
                        <tr style="background: rgba(81, 173, 85,1); border-bottom:1px solid rgb(4, 27, 10)">

                            <th scope="col" style="width: 40%;padding:5px;" >{{__('Product Name')}}</th>
                            <th scope="col" style="width: 30%;padding:5px; text-align:center;" >{{__('Quantity')}}</th>
                            <th scope="col"  style="width: 30%; text-align:right;padding:5px;border-left:1px dashed #aaa">{{__('Amount')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $total = 0;
                            $total_qty=0;
                        @endphp
                        @foreach ($graph2 as $product => $value)
                       {{-- @dd($value) --}}
                        @php
                            $total += (float)$value['sale'];
                            $total_qty += (float)$value['qty'];

                        @endphp

                        @if($value['sale']!=0)
                            <tr    style=" ">

                                <td scope="col" style="width: 40%;padding:5px" >{{ __($product) }}</td>
                                <td scope="col" style="width: 30%;padding:5px;text-align:center;" >{{$value['qty']==0?'':  __(number_format($value['qty'], 2, '.', '')) .' ' .__($value['PrimaryUnit']['unitShortName']) }}</td>
                                <td scope="col" style="width: 30%;padding:5px;border-left:1px dashed #aaa"  class="text-right">{{ __(number_format($value['sale'], 2, '.', '')) }}</td>
                            </tr>
                            @endif
                        @endforeach
                        <tr style="">

                            <td scope="col" colspan="2" style="width: 50%;padding:5px" >{{__('Total')}}</td>
                            <td scope="col" style="width: 50%;padding:5px;border-left:1px dashed #aaa"  class="text-right">{{ __(number_format($total, 2, '.', '')) }}</td>
                        </tr>
                    </tbody>


                </table>

        </div>
    </div>
</div>

{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script> --}}

<script>
    var labelsChart2 = {{ Js::from($product_sales_labels) }};
    var product_sales = {{ Js::from($product_sales) }};
    // console.log(labels);
    var dataChart2 = {
        labels: labelsChart2,

        datasets: [{

            label: 'Total Sale ',
            backgroundColor: ['rgba(8, 169, 255,0.8)', 'rgb(240, 79, 12)', 'rgba(86, 19, 252,0.8)',
                'rgb(235, 199, 12)', 'rgba(168, 19, 252,0.8)', 'rgba(189, 189, 252,0.8)', 'rgba(16, 19, 252,0.8)',
                 'rgba(168, 19, 25,0.8)', 'rgba(16, 199, 25,0.8)', 'rgba(18, 79, 25,0.8)', 'rgba(253, 159, 232,0.8)'
            ],
            borderColor: ['rgba(8, 169, 255,0.8)', 'rgb(240, 79, 12)', 'rgba(86, 19, 252,0.8)',
                'rgb(235, 199, 12)', 'rgba(168, 19, 252,0.8)', 'rgba(189, 189, 252,0.8)', 'rgba(16, 19, 252,0.8)',
                 'rgba(168, 19, 25,0.8)', 'rgba(16, 199, 25,0.8)', 'rgba(18, 79, 25,0.8)', 'rgba(253, 159, 232,0.8)'
            ],
            data: product_sales
        }]
    };

    var configChart2 = {
        type: 'doughnut', // line , bar,bubble, horizontalBar, pie, line, doughnut, radar, polarArea
        data: dataChart2,
        options: {
            height: '200px',
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
                },
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
                },
        }
    };

    var chartTwo = new Chart(document.getElementById('chartTwo'), configChart2);
</script>
<script>
    $(document).ready(function() {
        $('#graphTwopdf').click(function(){
            var office = $('#office').val();
                var isAdmin = $('#office').find(':selected').attr('data-isAdmin');

                var date = $('#reportrange').text();
                var dateArray = date.split(' - ');
                var fromDate = dateArray[0];
                var toDate = dateArray[1];


                //  alert(officeId);
                $.ajax({
                    url: '{{ route('companyadmin.chart2_pdf') }}',
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
        $('#graphTwoexcel').click(function(){
            var isAdmin = $('#office').find(':selected').attr('data-isAdmin');
            var office = $('#office').val();
            var date = $('#reportrange').text();
                var dateArray = date.split(' - ');
                var fromDate = dateArray[0];
                var toDate = dateArray[1];
                var officeName = $('#office').find(':selected').text();
                var fileName = officeName+'_product-wise summary_'+fromDate+'_to_'+toDate+'.xlsx';


                //  alert(officeId);
                $.ajax({
                    url: '{{ route('companyadmin.chart2_excel') }}',
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
                        var filename = (matches != null && matches[1] ? matches[1] :fileName);

                        // The actual download
                        var blob = new Blob([result], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        fileName=fileName.replace(' ', '');
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

        $('#graphTwoChart').click(function() {
            $(this).addClass('d-none');
            $('#graphTwoData').removeClass('d-none');
            $('#chartTwo').removeClass('d-none');
            $('#chartTwo').css('margin-left', "0");
            // alert();
            $('#chartTwoData').addClass('d-none');
            $('#chartTwoData').removeClass('d-block');
            $('#graphTwopdf').addClass('d-none');
            // $('#graphtwopdf').removeClass('d-flex');
            $('#graphTwoexcel').addClass('d-none');
            // $('#graphTwoexcel').removeClass('d-flex');
            // $('#chartTwoDataTable').DataTable().destroy();

        });
        $('#graphTwoData').click(function() {
            $(this).addClass('d-none');
            $('#graphTwoChart').removeClass('d-none');

            var height = $('#chartTwo').css('height');
            var width = $('#chartTwo').css('width');
            $('#chartTwoData').css('witdh', width);
            width = (parseInt(width) + 20) + "px";

            $('#chartTwo').addClass('d-none');
            $('#chartTwoData').removeClass('d-none');
            $('#chartTwoData').addClass('d-block');

            $('#graphTwopdf').removeClass('d-none');
            $('#graphTwoexcel').removeClass('d-none');


        });


    });
</script>
