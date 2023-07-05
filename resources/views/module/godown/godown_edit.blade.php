<div class="col-md-6">
    @include('module.godown.godown_office')
</div>
<div class="col-md-6 text-right d-flex flex-row justify-content-end">
    <div id="addGodown" class="   mb-2 text-info d-flex flex-column align-items-center btn bg-transparent cursor-none border-0 disabled ">
        <i class="fa fa-plus fa-lg mx-2 "></i> <small  class="small mt-2"> {{ __('Add Godown') }}</small>
    </div>
    <div id="backToList" onclick=" backToList();"
        class="    mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fas fa-warehouse fa-lg  "></i> <small class="small mt-2"> {{ __('Godowns') }}</small>
    </div>
    <div id="allStock" onclick="  getAllStock();"
        class="   mb-2 text-info d-flex flex-column align-items-center cursor-pointer btn btn-link ">
        <i class="fa fa-cubes fa-lg  "></i> <small  class="small mt-2"> {{ __('All Stock') }}</small>

    </div>
</div>
<form id="editGodown" class="w-100 mt-3">
    @csrf
    <div class=" p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <input type="text" class="sr-only" name="officeId" id="officeId"
                            value="{{ $godown['officeId'] }}">

                        <input type="text" class="sr-only" name="godownId" id="godownId"
                            value="{{ $godown['godownId'] }}">
                        <label for="godownName">{{__('Godown Name')}}<span class="text-danger text-lg ml-2">*</span></label>
                        <input type="text" class="form-control" name="godownName" id="godownName"
                            value="{{ $godown['godownName'] }}">
                        <span id="godownNameError" class="text-danger text-sm"></span>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="godownTypeId">{{ __('Godown Type') }}</label>
                        <select name="godownTypeId" id="godownTypeId" class="form-control">
                            @foreach ($godownTypes as $key => $godownType)
                                <option value="{{ $godownType['godownTypeId'] }}"
                                    {{ $godown['godownTypeId'] == $godownType['godownTypeId'] ? 'selected' : '' }}>
                                    {{ $godownType['godownTypeName'] }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-md-3 secondary {{$godown['godownTypeId']==1?'sr-only':''}}">
                    <div class="form-group">
                        <label for="isReserver">{{ __('Use as reserver') }}</label>
                        <select name="isReserver" id="isReserver" class="form-control">
                            <option value="1" {{ $godown['isReserver'] ? 'selected' : '' }}>YES</option>
                            <option value="0" {{ !$godown['isReserver'] ? 'selected' : '' }}>NO</option>
                        </select>
                    </div>
                </div>
                {{-- submit --}}



            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <button id="updateGodown" class="btn btn-info btn-sm">{{__('Save')}}</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</form>
<script>
    $(document).ready(() => {
        $('#godownName').on('keyup', () => {
            $('#godownNameError').html('');
        });
        $('#godownTypeId').on('change', () => {
            godownTypeToggle();
        });


        function godownTypeToggle() {
            let godownTypeId = $('#godownTypeId').val();
            if (godownTypeId == 1) {
                $('#isReserver').val(0);
                $('#isReserver').attr('disabled', true);
                $('.secondary').addClass('sr-only');
            } else {
                $('#isReserver').val(0);
                $('#isReserver').attr('disabled', false);
                $('.secondary').removeClass('sr-only');
            }
        }
        $('#editGodown').on('submit', (e) => {
            e.preventDefault();
            $("#updateGodown").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Save'
            )
            let godownId = $('#godownId').val();
            let officeId = $('#officeId').val();
            let godownName = $('#godownName').val();
            let godownTypeId = $('#godownTypeId').val();
            if (godownName === '') {
                $('#godownNameError').html('Godown Name is required');
                $("#updateGodown").html('Save')
                return;
            }
            let isReserver = $('#isReserver').val();
            let _token = $('input[name=_token]').val();
            $.ajax({
                url: "{{ route('companyadmin.godown.update') }}",
                type: "POST",
                data: {
                    godownId: godownId,
                    officeId: officeId,
                    godownName: godownName,
                    isReserver: isReserver,
                    godownTypeId: godownTypeId,
                    _token: _token
                },
                success: function(response) {

                    if (response.status) {
                        toastr.success(response.message);

                        $("#updateGodown").html('Save')
                        $('#godownNameError').html('');
                        $('#godownName').val('');
                        $('#ListPanel').removeClass('d-none');
                        $('#EntryPanel').addClass('d-none');
                        $('#ListPanel').html(response.html);
                        $('#modalTitle').html("{{ __('Godowns') }}");

                    } else {
                        toastr.error(response.message);
                        $('#godownNameError').html(response.message);
                        $("#updateGodown").html('Save')
                    }

                }
            });

        });
        setTimeout(() => {
           // godownTypeToggle();
        }, 500);



    });
</script>
