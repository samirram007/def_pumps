@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center p-3">
            <div class="col-md-12 ">
                <div class="row mx-auto">
                    @include('companyadmin._partial.section_header')
                </div>

                <div class="row pb-2">
                    @include('companyadmin._partial.section_filter')
                </div>
                <section>
                    <div class="row">
                        <div class="col-md-8" id="section_graph1">
                            @include('companyadmin._partial.section_graph1')
                        </div>
                        <div class="col-md-4" id="section_graph2">
                            @include('companyadmin._partial.section_graph2')
                        </div>


                    </div>

                </section>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(6, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
                // console.log(start);
                // $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    // 'Today': [moment(), moment()],
                    // 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);


            $('#filter').click(function() {
                // $('#section_graph1').html('');
                // $('#section_graph2').html('');
                $('#filter').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );

                var office = $('#office').val();
                var isAdmin = $('#office').find(':selected').attr('data-isAdmin');

                var date = $('#reportrange').text();
                var dateArray = date.split(' - ');
                var startDate = dateArray[0];
                var endDate = dateArray[1];
                $.ajax({
                    url: "{{ route('companyadmin.dashboard_filter') }}",
                    type: "POST",
                    data: {
                        officeId: office,
                        fromDate: startDate,
                        toDate: endDate,
                        isAdmin: isAdmin,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        $('#section_graph1').html(response.graph1);
                        $('#section_graph2').html(response.graph2);
                        setTimeout(() => {
                            $('#filter').html("{{ __('Filter') }}");
                        }, 1000);

                    }
                });
                setTimeout(() => {
                    $('#filter').html("{{ __('Filter') }}");
                }, 1000);
            });

        });
    </script>
    <style>
        .optionGroup {
            font-weight: bold;
            font-style: italic;
        }

        .optionChild {
            /* padding-left: 30px; */
            padding: 20px;
            font-size: 14px;
        }

        .form-group {
            padding: 0;
            margin: 10px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .form-group label {
            font-size: 0.875rem;
            line-height: 1.4rem;
            vertical-align: bottom;
            margin-bottom: -10px;
            margin-left: 9px;
            background: #fff;
            background: radial-gradient(circle, rgba(255, 255, 255, 1) 75%, rgb(255 255 255 / 0%) 100%);
            padding: 0 6px;
        }

        input+label {
            position: relative;
            z-index: 999;
        }

        select.form-control,
        select.asColorPicker-input,
        .dataTables_wrapper select,
        .jsgrid .jsgrid-table .jsgrid-filter-row select,
        .select2-container--default select.select2-selection--single,
        .select2-container--default .select2-selection--single select.select2-search__field,
        select.typeahead,
        select.tt-query,
        select.tt-hint,
        .form-control {
            padding: .4375rem .75rem;

            outline: none;
            color: #979292;
            border: 1px solid #cbd3db;
            overflow: hidden;
        }
    </style>
@endsection
