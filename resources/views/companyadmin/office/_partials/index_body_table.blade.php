<div class="rounded card p-3  bg-white shadow ">
    <div class="row   ">
        <div class="col-md-12">
            <div class="  card-primary">
                <div class="card-body">
                    <div class="row  border-bottom   ">
                        <div class="col-md-8 h3">
                            <label class="label text-primary">{{ __($MasterOffice[0]['officeTypeName']) }} :
                                <span>{{ __($MasterOffice[0]['officeName']) }}</span>
                            </label>
                        </div>
                        {{-- @dd($MasterOffice[0]['officeId']) --}}
                        <div class="col-md-4 invoice-btn">
                            {{-- <a href="{{ route('companyadmin.office.create',$MasterOffice[0]['officeId']) }}"
                                class="load-popup float-right btn btn-rounded btn-outline-info ">
                                <span class="iconify" data-icon="ep:office-building" data-width="15" data-height="15">
                                </span> {{ __('Add Office') }}</a> --}}



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="searchPanel" class="searchPanel">
        <div id="data-grid" class="data-tab-custom rounded">


            <div class="table-responsive">

                <table id="table" class="table  table-striped table-bordered   ">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Type') }}</th>


                            <th> {{ __('ContactNo') }}</th>
                            <th> {{ __('Email') }}</th>
                            <th> {{ __('Address') }}</th>
                            <th class="text-wrap text-truncate text-center"> {{ __('Last Invoice No') }}</th>
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
                                <td>{{ $data->officeName }}</td>
                                <td>{{ __($data->officeTypeName) }}</td>

                                <td>{{ $data->officeContactNo }}</td>
                                <td class="text-wrap text-truncate">{{ $data->officeEmail }}</td>
                                <td class="{{ strlen($data->officeAddress) > 20 ? 'pre-wrap' : '' }}">
                                    {{ $data->officeAddress }}</td>
                                <td class="text-wrap text-truncate text-center">
                                    @if ($data->officeTypeId != 1)
                                        @if ($data->lastInvoiceNo == null)
                                            <a href="javascript:" data-param=""
                                                data-url="{{ route('companyadmin.office.invoice_no', $data->officeId) }}"
                                                title="{{ __('Invoice No') }}"
                                                class="load-popup btn btn-rounded animated-shine">
                                                {{ __('Invoice No') }}
                                            </a>
                                        @else
                                            {{ $data->lastInvoiceNo }}
                                        @endif
                                    @else
                                        {{ __('--') }}
                                    @endif
                                </td>
                                <td class="text-left  "
                                    style="overflow: inherit; text-align:left!important;">
                                    <div class=" d-inline-flex">
                                        <a href="javascript:" data-param=""
                                            data-url="{{ route('companyadmin.office.edit', $data->officeId) }}"
                                            title="{{ __('Edit') }}"
                                            class="load-popup  btn btn-rounded animated-shine m-0 small ">
                                            <i class="fa fa-edit "></i>
                                        </a>
                                        <a href="{{ route('companyadmin.office.users', $data->officeId) }}"
                                            data-param=""
                                            data-url="{{ route('companyadmin.office.users', $data->officeId) }}"
                                            title="{{ __('Users') }}" class="btn btn-rounded animated-shine">
                                            <i class="fa fa-users "></i>
                                        </a>
                                        @if ($data->officeTypeId != 1)
                                            <a href="javascript:" data-param=""
                                                data-url="{{ route('companyadmin.office.latest_rate', $data->officeId) }}"
                                                title="{{ __('Latest Rate') }}"
                                                class="load-popup btn btn-rounded animated-shine mx-2 ">
                                                {{ __('Latest Rate') }}
                                            </a>
                                        @else
                                            {{ __(' ') }}
                                        @endif
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
