<div class="modal-dialog modal-lg  modal-dialog-centered mt-0">

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="modal-content bg-info">
        <div class="modal-header">
            <h4 class="modal-title text-light">{{ __('Current Stock') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fa fa-times-circle" style="font-size:24px; color:#fff"></i>
            </button>
        </div>
        <form id="formCreate">
            @csrf
            <div class="modal-body bg-light p-0" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
                <div class=" w-100  ">


                    <section class="content">
                        <div class="rounded card p-3 bg-white shadow min-h-100">
                            <div class="row mx-auto">

                                <h3 class="card-title  "> {{ __('Current Stock for') }} {{ $office['officeName'] }} as
                                    on
                                    {{ date('d-m-Y') }}</h3>

                            </div>
                            <div class="row">

                                <div class="card-body">
                                    <table class="table table-bordered  ">
                                        <thead>
                                            <tr style="border-bottom:2px solid #000!important;">
                                                <th>{{ __('Product') }} </th>
                                                <th class="text-right">{{ __('Current Stock') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($current_stock as $item)
                                                <tr>
                                                    <td>
                                                        {{ $item['productTypeName'] }}
                                                        <input type="text" class="sr-only" name="productTypeId[]"
                                                            value="{{ $item['productTypeId'] }}">
                                                        <input type="text" class="sr-only" name="stock[]"
                                                            value="{{ $item['currentStock'] }}">

                                                    </td>
                                                    <td style="border-bottom:2px dashed #000!important;">

                                                        <input type="text" class="bg-white w-100 text-right border-0"
                                                            onInput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                            name="currentStock[]"
                                                            value="{{ number_format($item['currentStock'], 2, '.', '') }}">
                                                    </td>
                                                </tr>

                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div class="row text-center">
                                <div class="col-6 mx-auto">
                                    <input type="text" class="sr-only" name="officeId"
                                        value="{{ $item['officeId'] }}">
                                    <button type="submit" class=" submit btn btn-rounded animated-shine px-4">

                                        <span class="iconify" data-icon="mdi:content-save-all-outline" data-width="15"
                                            data-height="15"></span>
                                        {{ __('Save') }}</button>

                                </div>
                                <div class="col-6 mx-auto">
                                    <button type="button" class=" btn btn-rounded animated-shine-danger px-4"
                                        data-dismiss="modal">{{ __('Cancel') }}</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </form>
    </div>
    @php
        $roleName = Session::get('roleName');

    @endphp

    <script>
        $(document).ready(function() {
            $('#formCreate').on('submit', function(e) {
                e.preventDefault();
                $('.submit').attr('disabled', 'disabled');
                $('.submit').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                );
                var data = $(this).serialize();
                var roleName = "{{ $roleName }}";

                var url = "{{ route($routeRole . '.store_current_stock') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    success: function(data) {
                        if (data.status == true) {
                            toastr.success(data.message);
                            // $('#popup-modal').modal('hide');
                            $("#modal-popup").html('');
                            $("#modal-popup").modal('hide');
                            // $('#fuel_rate_table').DataTable().ajax.reload();
                        } else {
                            toastr.error(data.message);
                            $('.submit').removeAttr('disabled');
                            $('.submit').html("{{ __('Save') }}");
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('.submit').removeAttr('disabled');
                        $('.submit').html("{{ __('Save') }}");
                    }
                });
            });
        });
    </script>

</div>
