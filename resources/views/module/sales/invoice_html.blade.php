<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Invoice - {{ env('APP_NAME') }}</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <style>
        body {
            text-transform: uppercase;
            padding: 25px;
        }

        hr {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .hr-texta {
            line-height: 1em;
            position: relative;
            outline: 0;
            border: 0;
            color: grey;
            text-align: center;
            height: 1.5em;

        }

        .hr-texta:before {
            content: '';
            border-top: dashed 1px;
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
        }

        .hr-texta:after {
            content: attr(data-content);
            position: relative;
            display: inline-block;
            color: black;
            padding: 0 .5em;
            line-height: 1.5em;
            background-color: #fcfcfa;
        }

        .small_letter {
            text-transform: uppercase
        }

        .qr-svg>svg {
            position: relative;
            right: 70px;
        }
    </style>
</head>

<body>
    <div class="site-index">
        <div class="body-content">
            <div class="pull-right">
                <button class="btn btn-primary btn-xs" id="changeLanguage" data-lang='{{ str_replace('_', '-', app()->getLocale()) }}'>{{ str_replace('_', '-', app()->getLocale()) }}</button>
                <button class="btn btn-primary btn-xs" id="printBill"><span
                        class="glyphicon glyphicon-print"></span></button>
                <button class="btn btn-primary btn-xs" id="downloadImg"><span
                        class="glyphicon glyphicon-download-alt"></span></button>
            </div>
            <div class="container-fluid" id="site-index" style="background-color:#fff;">
                <div class="page-header text-center" style="border-bottom: dashed 1px;">
                    <h3>{{ __($sales_invoice['officeName']) }}</h3>
                    <div>{{ __($sales_invoice['officeAddress']) }}</div>
                    @if ($sales_invoice['gstNo'] != '' && $sales_invoice['gstNo'] != null)
                        <div>{{ __('GST No') }}: {{ __($sales_invoice['gstNo']) }}</div>
                    @endif
                    <div style="display: flex; justify-content:center; flex-wrap:wrap;"> <div>  {{ __('Contact No') }}: {{ $sales_invoice['officeContactNo'] }},</div> <div>{{ __('Email') }}:
                        {{ strtolower($sales_invoice['officeEmail']) }}</div></div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-10 col-xs-10">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">{{ __('Time') }} :
                            {{ date('h:i a', strtotime($sales_invoice['invoice_time'])) }}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-12">{{ __('Date') }} :
                            {{ date('d-M-Y', strtotime($sales_invoice['invoice_date'])) }}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-xs-126">{{ __('Bill number') }} : {{ $sales_invoice['invoice_no'] }}
                        </div>
                    </div>

                    <div class="row">
                        {{-- <div class="col-md-12 col-xs-12">BILL TYPE : RETAIL</div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">{{ __('Name') }} : {{ $sales_invoice['customerName'] }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">{{ __('Mobile') }} : {{ $sales_invoice['contactNo'] }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">{{ __('Vehicle No') }} : {{ $sales_invoice['vehicleNo'] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-xs-2 pr-2 qr-svg">
                    {{-- <img style="float:right"
                        src="https://chart.googleapis.com/chart?chs=107x107&amp;cht=qr&amp;chl=.http://ebill.nukkadshops.com/ZzJINjgvQXV6MUNVRnlLa0d6bHY1T3I3cnJNL2lxVzhybzZaamV6bFIwcGJucEYzeWFBZDlsYUk2eTRtTlZIaERXMTBJK0JBZ1l3Y3FBM24rdVIxZlE9PQ==."
                        title="webBill"> --}}
                    {!! QrCode::size(100)->generate($current_url) !!}
                </div>
            </div>

            <hr style="border-top: dashed 1px;">

            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="text-center">{{ __('BILL OF SUPPLY') }}</div>
                </div>
            </div>
            <hr style="border-top: dashed 1px;">

            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <table class="table table-hover" style="margin-bottom:0px;">
                        <thead>

                            <tr>
                                <td style="border-top: none;">{{ __('ITEM NAME') }}</td>
                                <td style="border-top: none;">{{ __('RATE') }}</td>
                                <td style="border-top: none;">{{ __('Qty') }}</td>
                                <td colspan="2" style="border-top: none;" align="right">{{ __('Total') }}</td>
                            </tr>
                        </thead>
                        <tbody>

                            <tr style="border-top: dashed 1px;">
                                <td style="border-top: none;">{{ $sales_invoice['productName'] }}</td>
                                <td style="border-top: none;">{{ $sales_invoice['productUnitPrice'] }}</td>
                                <td style="border-top: none;">{{ $sales_invoice['productQuantity'] }} </td>
                                <td colspan="2" style="border-top: none;" align="right">
                                    {{ $sales_invoice['productTotalPrice'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>




            @if ($sales_invoice['discount'] > 0)
                <hr style="border-top: dashed 1px;">
                <div class="row" style="font-weight:bold;font-size:14px;">
                    <div class="col-md-8 col-xs-6">{{ __('Sub Total') }} : </div>
                    <div class="col-md-4 col-xs-6 text-right">{{ $sales_invoice['productTotalPrice'] }}</div>
                </div>
                <div class="row" style="font-weight:bold;font-size:14px;">
                    <div class="col-md-8 col-xs-6">{{ __('Discount') }} : </div>
                    <div class="col-md-4 col-xs-6 text-right">- {{ $sales_invoice['discount'] }}</div>
                </div>
            @endif
            <hr style="border-top: dashed 1px;">
            <div class="row" style="font-weight:bold;font-size:14px;  ">
                <div class="col-md-8 col-xs-6">{{ __('Total') }} : </div>
                <div class="col-md-4 col-xs-6 text-right">
                    {{ number_format($sales_invoice['invoice_sub_total'], 2, '.', '') }}</div>
            </div>


            <hr style="border-top: dashed 1px;">
            <div class="row" style="font-weight:bold;font-size:14px;">
                <div class="col-md-12 col-xs-12">{{ __('Payment Mode') }} : {{ $sales_invoice['paymentType'] }}</div>
            </div>
            <hr style="border-top: dashed 1px;">

            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="text-center">{{ __($sales_invoice['summeryLine']) }}</div>
                </div>
            </div>



        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('js/html2canvas.js') }}"></script>
    <script src="{{ asset('js/canvas2image.js') }}"></script>
    <script>
        $(function() {
            $('#changeLanguage').on('click', function() {

                let language = $('html').attr('lang');
                if (language == 'en') {
                    // $('html').attr('lang','bn');
                    $('#changeLanguage').html("BN");
                    $('#changeLanguage').attr('date-lang','bn');
                    language = 'bn';
                } else if (language== 'bn') {
                    // $('html').attr('lang','in');
                    $('#changeLanguage').html("IN");
                    $('#changeLanguage').attr('date-lang','in');
                    language = 'in';
                } else if (language == 'in') {
                    // $('html').attr('lang','en');
                    $('#changeLanguage').html("EN");
                    $('#changeLanguage').attr('date-lang','en');
                    language = 'en';
                }


                var url = "{{ route('lang',':lng') }}";
                  url=url.replace(':lng',language);
                  console.log(url);
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(response) {
                            location.reload();
                        }
                    });

            });
            $("#printBill").click(function() {
                window.print();
            });
            $("#downloadImg").click(function() {
                html2canvas($("#site-index"), {
                    onrendered: function(canvas) {
                        saveAs(canvas.toDataURL(), 'C-2223-380.png');
                    }
                });
            });
        });

        function saveAs(uri, filename) {
            var link = document.createElement('a');
            if (typeof link.download === 'string') {
                link.href = uri;
                link.download = filename;

                //Firefox requires the link to be in the body
                document.body.appendChild(link);

                //simulate click
                link.click();

                //remove the link when done
                document.body.removeChild(link);
            } else {
                window.open(uri);
            }
        }
    </script>

</body>

</html>
