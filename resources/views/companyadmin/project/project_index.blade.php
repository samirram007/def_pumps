@extends('layouts.main')
@section('content')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 justify-content-between align-items-center mx-3">
                    <div class="col-sm-6">
                        <h4 class="m-0 text-dark">{{ __('Project List') }}</h4>

                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right border-0 p-0 m-0">
                            <li class="breadcrumb-item "><a href="{{ route('companyadmin.dashboard') }}"
                                    class="text-active">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('Project List') }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="rounded card p-3  bg-white shadow ">
                <div class="row   ">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row   border-bottom pb-2 mb-2">
                                    <div class="col-md-8">
                                        <label class="label text-primary" >{{ __('Project') }} :
                                        {{-- <span>{{$MasterOffice[0]['officeName']}}</span> --}}
                                     </label>
                                    </div>
{{-- @dd($MasterOffice[0]['officeId']) --}}
                                    <div class="col-sm-4 text-right">
                                        {{-- <a href="{{ route('companyadmin.office.create',$MasterOffice[0]['officeId']) }}"
                                            class="load-popup float-right btn btn-rounded btn-outline-info ">
                                            <span class="iconify" data-icon="ep:office-building" data-width="15" data-height="15">
                                            </span> {{ __('Add Office') }}</a> --}}

                                            {{-- <a href="javascript:" data-param="" data-url="{{ route('companyadmin.office.index') }}" title="Edit Area"
                                            class="load-popup float-right btn btn-rounded btn-outline-info px-2 mb-2 ">
                                            <span class="iconify" data-icon="ep:office-building" data-width="15" data-height="15"></span> {{ __('Create Project') }}</a> --}}
                                            <a href="javascript:" data-param=""
                                            data-url="{{ route('companyadmin.project.create') }}" title="Edit Area"
                                            class="load-popup float-right btn btn-rounded btn-outline-info px-2   ">
                                            <span class="iconify" data-icon="carbon:user-profile" data-width="15"
                                                data-height="15"></span> {{ __('Create Project') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="searchPanel" class="searchPanel">
                    <div id="data-grid" class="data-tab-custom rounded">


                        <div class="table-responsive">

                            <table id="table" class="table   table-bordered   ">
                                <thead>
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        <th>Name</th>
                                        <th> Office</th>
                                        <th> Supervisor</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th> User</th>
                                        <th> Task</th>
                                        <th> Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- [
  {
    "projectId": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
    "projectName": "string",
    "projectDescription": "string",
    "projectStatus": 0,
    "createdBy": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
    "createdOn": "2022-10-25T12:36:55.898Z",
    "updatedBy": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
    "updatedOn": "2022-10-25T12:36:55.898Z",
    "isActive": true,
    "isDeleted": true,
    "startDate": "2022-10-25T12:36:55.898Z",
    "endDate": "2022-10-25T12:36:55.898Z",
    "officeId": "3fa85f64-5717-4562-b3fc-2c963f66afa6",
    "taskCount": 0,
    "userCount": 0
  }
] --}}
                                    @foreach ($collections as $key => $data)
                                        @php
                                             $data = (object) $data;
                                             $projectStatus='initialized';
                                             if($data->projectStatus==1){
                                                $projectStatus='Initialized';
                                             }
                                            elseif($data->projectStatus==2){
                                                $projectStatus='In Progress';
                                            }
                                            elseif($data->projectStatus==3){
                                                $projectStatus='Completed';
                                            }
                                        @endphp
                                        <tr>

                                            <td>{{ $data->projectName }}</td>
                                            {{-- <td class="{{ strlen($data->projectDescription)>20 ? 'pre-wrap':'' }}">{{ $data->projectDescription }}</td> --}}
                                            <td>{{ $data->officeName }}</td>
                                            <td>{{ $data->supervisorName }}</td>
                                            <td>{{ date('d-m-Y',strtotime($data->startDate))}} </td>
                                            <td>{{ date('d-m-Y',strtotime($data->endDate))}}</td>
                                            <td>{{ $data->userCount }}</td>
                                            <td class="text-wrap text-truncate">{{ $data->taskCount }}</td>
                                            <td>{{ $projectStatus }}</td>
                                            <td class="text-right " style="overflow: inherit;">
                                                <div class="dropdown d-inline-flex" >
                                                    <button class="btn btn-outline-link dropdown-toggle" type="button"
                                                        data-toggle="dropdown">SELECT
                                                        <span class="caret"></span></button>
                                                    <ul class="dropdown-menu" style="z-index: 1000">
                                                        <li> <a href="{{ route('companyadmin.project.show', $data->projectId) }}"
                                                                class="btn btn-link"> VIEW</a></li>
                                                        <li><a data-param=""
                                                            data-url="{{ route('companyadmin.project.edit', $data->projectId) }}"
                                                            title="Edit"
                                                                class="load-popup btn btn-link"> EDIT</a></li>

                                                        <li><a href="{{ route('companyadmin.project.delete', $data->projectId) }}"
                                                                class="btn btn-link delete"> DELETE</a></li>
                                                        {{-- <li><a href="{{ route('admin.project.config', $data->id) }}"
                                                                class="btn btn-link "> REPORT SETTINGS</a></li> --}}
                                                    </ul>
                                                </div>




                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                         </div>


                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- <script>
        $(document).ready(function() {

            $('#table').DataTable({
                responsive: true,


                    language: {

                        searchPlaceholder: "Search...",
                        sSearch: "",
                        lengthMenu: "Showing  _MENU_ Records",
                        info: "Showing _START_ to _END_ of _TOTAL_ records",
                        infoEmpty: "No records found",
                        infoFiltered: "(filtered from _MAX_ total records)"
                    }


                }

            );
        });
    </script> --}}

    <script>
        /* function SwitchActivation(UserID, ActiveStatus) {
   //onclick="SwitchActivation(1);"
        }*/

        $(document).ready(function() {


            var table = $('#table').DataTable({
                responsive: true,
                select: true,
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
@endsection
