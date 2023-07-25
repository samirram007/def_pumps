<div class="modal-dialog modal-lg   mt-4 w-100">
    <script>
        var officeId = "{{ $office['officeId'] }}";

        function backToList() {
            $('#EntryPanel').addClass('d-none');
            $('#ListPanel').removeClass('d-none');
            $('#modalTitle').html("{!! __('Godowns') !!}");
        }

        $('#backToList').click(() => {
            backToList();
        });

        function getAllStock() {
            // console.log('------------');
            let url = "{{ route('companyadmin.godown.current_stock_all', ':id') }}";
            //console.log(url);
            url = url.replace(':id', officeId);

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: "application/json; charset=utf-8",
                success: (response) => {

                    $('#EntryPanel').removeClass('d-none');
                    $('#EntryPanel').html(response.html)
                    $('#ListPanel').addClass('d-none');
                    $('#modalTitle').html("{!! __('Godown Stock') !!}");


                },
                error: function(xhr, status, error) {

                }
            });
        }
        function addGodown() {
            // $('#EntryPanel').removeClass('d-none');
            // $('#ListPanel').addClass('d-none');
            // $('#modalTitle').html("{{ __('Create Godown') }}");
            // $('#EntryPanel').html('');
            let url = "{{ route('companyadmin.godown.create', ':id') }}";
            url = url.replace(':id', officeId);

            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: "application/json; charset=utf-8",
                success: (response) => {

                    $('#EntryPanel').removeClass('d-none');
                    $('#EntryPanel').html(response.html)
                    $('#ListPanel').addClass('d-none');
                    $('#modalTitle').html("{!! __('Create Godown') !!}");


                },
                error: function(xhr, status, error) {

                }
            });

        }

        $('.all-stock').on('click', function() {
            getAllStock();


        });

        $('.godown-stock').on('click', function(e) {
            let godownId = $(e.target).attr('data-id');
            let url = "{{ route('companyadmin.godown.current_stock', ':id') }}";
            //console.log(url);
            url = url.replace(':id', godownId);
            //console.log(url);
            $.ajax({
                url: url,
                type: "GET",
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: "application/json; charset=utf-8",
                success: (response) => {
                    //console.log(response);
                    $('#EntryPanel').removeClass('d-none');
                    $('#EntryPanel').html(response.html)
                    $('#ListPanel').addClass('d-none');
                    $('#modalTitle').html("{!! __('Godown Stock') !!}");


                },
                error: function(xhr, status, error) {

                }
            });

        });
    </script>
    <script>
        // getAllStock();
    </script>
    <div class="modal-content bg-light">
        <div class="modal-header align-items-center">
            <h4 class="modal-title text-light" id="modalTitle">{{ __($modal_name) }}</h4>
            @include('module.office._partial.settings_menu')

        </div>

        <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">

            <div class=" w-100  ">
                {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

                <section class="content ">
                    <div class="rounded card p-3 bg-white shadow min-h-100">
                        <div id="EntryPanel" class="row d-none">

                            {{-- @include('module.godown.godown_create') --}}
                        </div>

                        <div id="ListPanel" class="row">
                            @include('module.godown.godown_index')
                        </div>
                    </div>



                </section>
            </div>
        </div>


    </div>
<style>
    .bg-transparent{
        background:transparent!important;
        border: none!important;
    }
</style>
</div>
