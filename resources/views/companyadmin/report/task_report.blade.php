<div id="data-grid" class="data-tab-custom rounded">


    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered">
            <thead>

                <tr>
                    {{-- <th>ID</th> --}}
                    {{-- <th>Image</th> --}}
                    <th class="text-center">Sl No</th>
                    <th>Office</th>
                    <th>User</th>
                    <th class="text-center">Duration</th>
                    <th class="text-center">Completed Task</th>
                    <th class="text-center">Pending Task</th>
                    <th class="text-center">UnAttend Task</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report as $key =>  $data)
                    @php
                         $data = collect($data);
                        //   dd($data['userDetails']);
                    @endphp
                    <tr>
                        {{-- <td>{{ $key + 1 }} </td> --}}
                        {{-- <td><img style="width: 50px; height:50px; border:1px solid #000000;"
                                src="{{ !empty($data->image) ? url('upload/user_images/' . $data->image) : url('upload/no_image.jpg') }}"
                                alt=""></td> --}}
                        <td  class="text-center">{{ ++$key}} </td>
                        <td>{{ $data['userDetails']['office']['officeName'] }} </td>
                        <td>{{ $data['userDetails']['firstName'] }} {{ $data['userDetails']['surName'] }}</td>
                        <td class="text-center">{{ __(number_format($data['workDuration']/60,2,'.',''). ' hrs') }}</td>
                        <td class="text-center">{{ __($data['completedTask']) }}</td>
                        <td class="text-center">{{ __($data['pendingTask']) }}</td>
                        <td class="text-center">{{ __($data['unAttendTask']) }}</td>
                        <td></td>

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
                "language": {
                    "lengthMenu": 'Show:<select>' +
                        '<option value="10">10</option>' +
                        '<option value="20">20</option>' +
                        '<option value="30">30</option>' +
                        '<option value="40">40</option>' +
                        '<option value="50">50</option>' +
                        '<option value="-1">All</option>' +
                        '</select>  records'
                },

                "order": [
                    [0, "asc"]
                ]
            });


        });
    </script>
</div>
