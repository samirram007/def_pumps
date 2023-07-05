<div id="data-grid" class="data-tab-custom rounded">


    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    {{-- <th>Image</th> --}}
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Business Entity') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('ContactNo') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collections as $key => $data)
                    @php
                        $data = (object) $data;
                    @endphp
                    <tr>
                        {{-- <td>{{ $key + 1 }} </td> --}}
                        {{-- <td><img style="width: 50px; height:50px; border:1px solid #000000;"
                                src="{{ !empty($data->image) ? url('upload/user_images/' . $data->image) : url('upload/no_image.jpg') }}"
                                alt=""></td> --}}
                        <td>{{ __($data->firstName) }} {{ $data->firstName == $data->surName ? '' : $data->surName }}
                        </td>
                        <td>
                            @if ($routeRole == 'companyadmin')
                                @if (in_array(strtolower($data->roleName), ['superadmin', 'companyadmin']))
                                    <div class="badge badge-success">com</div>
                                @else
                                    <div class="badge badge-warning">pump</div>
                                @endif
                            @endif
                            {{ __($data->office['officeName']) }}
                        </td>
                        <td>{{ __($data->roleName) }}</td>
                        <td>{{ $data->email }}</td>
                        <td class="text-wrap text-truncate">{{ $data->phoneNumber }}</td>
                        <td class="text-right " style="overflow: inherit;">

                            @if (!empty($office))
                                @if (session()->has('isSuperAdmin') && session()->get('isSuperAdmin'))
                                    @if ($data->roleName != 'PumpUser')
                                        <a href="{{ route('switchmode', $data->id) }}"
                                            class="switch-user  mx-2 text-info my-2">
                                            <i class="fa fa-sign-in-alt fa-lg" aria-hidden="true"></i>

                                        </a>
                                    @endif
                                @endif
                                <a href="javascript:" data-param="{{ base64_encode(json_encode($data)) }}"
                                    data-url="{{ route('companyadmin.office_user.edit', [$data->id, $office->officeId]) }}"
                                    title="{{ __('Edit') }}" class="load-popup  mx-2 text-info my-2"> <i
                                        class="fa fa-edit "></i></a>

                                <a href="{{ route('companyadmin.user.delete', $data->id) }}" data-param=""
                                    data-url="{{ route('companyadmin.user.delete', $data->id) }}"
                                    title="{{ __('Delete') }}" class="delete  mx-2 text-info my-2 "><i
                                        class="fa fa-trash "></i></a>
                            @else
                                @if (session()->has('isSuperAdmin') && session()->get('isSuperAdmin'))
                                    @if ($data->roleName != 'PumpUser')
                                        <a href="{{ route('switchmode', $data->id) }}"
                                            class="switch-user  mx-2 text-info my-2">
                                            <i class="fa fa-sign-in-alt fa-lg" aria-hidden="true"></i>

                                        </a>
                                    @endif
                                @endif
                                <a href="javascript:" data-param="{{ base64_encode(json_encode($data)) }}"
                                    data-url="{{ route('companyadmin.user.edit', $data->id) }}"
                                    title="{{ __('Edit') }}" class="load-popup  mx-2 text-info  my-2 "> <i
                                        class="fa fa-edit fa-lg"></i></a>

                                <a href="{{ route('companyadmin.user.delete', $data->id) }}" data-param=""
                                    data-url="{{ route('companyadmin.user.delete', $data->id) }}"
                                    title="{{ __('Delete') }}" class="delete mx-2 text-info  my-2 "><i
                                        class="fa fa-trash fa-lg "></i></a>
                            @endif



                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {

            var table = $('#table').DataTable({
                responsive: true,
                select: false,
                zeroRecords: true,
                "oLanguage": langOpt,

                "order": [
                    [0, "asc"]
                ]
            });
        });
    </script>
</div>
