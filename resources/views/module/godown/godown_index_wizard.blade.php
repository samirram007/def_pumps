<div class="col-md-6">
    {{-- @dd($office) --}}
    @include('module.godown.godown_office')
</div>
<div class="col-md-6 text-right d-flex flex-row justify-content-end">
    <div id="addGodown" class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-plus fa-lg mx-2 "></i> <small  class="small mt-2"> {{ __('Add Godown') }}</small>
    </div>
    <div id="backToList" onclick=" backToList();"
        class="    mb-2 text-info d-flex flex-column align-items-center btn bg-transparent cursor-none border-0 disabled ">
        <i class="fas fa-warehouse fa-lg  "></i> <small class="small mt-2"> {{ __('Godowns') }}</small>
    </div>
    <div id="allStock" onclick="  getAllStock();"
        class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-cubes fa-lg  "></i> <small  class="small mt-2"> {{ __('All Stock') }}</small>

    </div>

</div>


<div class="col-md-12 mt-3">
    <div class="table-responsive">
        {{-- @dd($editData) --}}
        <table class="table table-bordered  text-center">
            <tr>
                <td class="text-left">{{ __('Name') }}</td>
                <td>{{ __('Godown Type') }}</td>
                <td>{{ __('IsReserver') }} ?</td>
                <td>{{ __('Capacity') }}</td>


                <td class="d-none">{{ __('Status') }}</td>
                <td>{{ __('Action') }}</td>
            </tr>


            @foreach ($godowns as $key => $godown)
                <tr>
                    <td class="text-left">{{ $godown['godownName'] }}</td>
                    <td>{{ $godown['godownTypeName'] }}</td>
                    <td>{{ $godown['isReserver'] == 1 ? 'yes' : 'no' }}</td>
                    <td>{{ $godown['capacity'] . ' ltr' }} </td>

                    <td class="d-none">{{ $godown['status'] == 1 ? 'active' : 'inactive' }}</td>
                    <td>
                        <a href="javascript:" class=" godown-edit mx-2 text-info d-inline-flex"
                            data-id="{{ $godown['godownId'] }}" title="{{ __('Edit Godown') }}">
                            <i class=" fa fa-edit fa-lg  " data-id="{{ $godown['godownId'] }}"></i>
                        </a>
                        <a href="javascript:" class=" godown-delete mx-2 text-info d-inline-flex"
                            data-id="{{ $godown['godownId'] }}" title="{{ __('Remove Godown') }}">
                            <i class="fa fa-trash fa-lg  " data-id="{{ $godown['godownId'] }}"></i>
                        </a>
                        <div class=" godown-stock
                                mx-2 text-info d-inline-flex"
                            title="{{ __('Stock Details') }}">
                            <i class="fa fa-archive fa-lg cursor-pointer " data-id="{{ $godown['godownId'] }}"></i>
                        </div>

                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<script>
    $(document).ready(() => {

        $('#addGodown').on('click', () => {
            addGodown();
        });
        $('.godown-edit').on('click', (e) => {

            let godownId = $(e.target).attr('data-id');
            let url = "{{ route('companyadmin.godown.edit', ':id') }}";

            url = url.replace(':id', godownId);

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
                    $('#modalTitle').html("{!! __('Edit Godown') !!}");


                },
                error: function(xhr, status, error) {

                }
            });

        });
        $('.godown-delete').on('click', (e) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let godownId = $(e.target).attr('data-id');
                    let url = "{{ route('companyadmin.godown.delete', ':id') }}";

                    url = url.replace(':id', godownId);

                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: "application/json; charset=utf-8",
                        success: (response) => {
                            if (response.status) {
                                toastr.info("Godown successfully deleted");
                                // $('#EntryPanel').addClass('d-none');
                                // $('#EntryPanel').html('')
                                // $('#ListPanel').removeClass('d-none');
                                $('#ListPanel').html(response.html);
                                $('#modalTitle').html("{!! __('Godowns') !!}");

                            } else {
                                toastr.error("Godown deletion error");
                            }


                        },
                        error: function(xhr, status, error) {
                            toastr.error("Godown deletion error");
                        }
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })


        });

        $('#godownName').on('keyup', () => {
            $('#godownNameError').html('');
        });
    });
</script>
