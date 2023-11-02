<table class="table table-responsive custom-table-shadow table-striped">
    <thead>
        <tr>
            <td scope="col" class="w-25 pdl-3 fw-600">{{ __('Name') }}</td>
            <td scope="col" class="fw-600">{{ __('Type') }}</td>
            <td scope="col" class="fw-600">{{ __('Contact') }}</td>
            <td class="col text-center fw-600"> {{ __('Last Invoice No') }}</td>
            <td scope="col" class="w-50 fw-600">#</td>
        </tr>
    </thead>
    <tbody>

        @foreach ($offices as $key => $office)

            {{-- {{ $office['godowns'] == null ? '' : json_encode($office['godowns']) }} --}}
            @if ($office['level'] == 0)
                <tr class="v-midlle accordion-item">
                    <td class="pdl-0 text-wrap text-truncate">
                        <button class="border border-0 bg-transparent accordion-button " data-toggle="collapse"
                            data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
                            {{ __($office['officeName']) }}
                        </button>
                    </td>
                    <td class="small  text-truncate">{{ __($office['officeTypeName']) }}</td>
                    <td class="small">{{ __($office['officeContactNo']) }}</td>
                    <td class="text-center small">{{ __($office['lastInvoiceNo']) }}</td>
                    <td class="text-left  " style=" text-align:left!important;">
                        <div class="d-inline-flex">
                            <a href="javascript:" data-param=" "
                                data-url="{{ route('companyadmin.office.show', $office['officeId']) }}" title="View"
                                class="load-popup   mx-2 text-white ">
                                <i class="fa fa-eye fa-lg "></i>
                            </a>
                            <a href="javascript:" data-param="" data-token="{{ csrf_token() }}"
                                data-url="{{ route('companyadmin.office.edit', $office['officeId']) }}" title="Edit"
                                class="load-popup-post   mx-2 text-white d-inline-flex sr-only">
                                <i class="fa fa-edit fa-lg "></i>
                            </a>
                            {{-- @dd(session()->get('user')) --}}
                            @if (json_decode(json_encode(session()->get('userData')), true)['officeId'] == $office['officeId'])
                                <a href="{{ route('companyadmin.office.users', $office['officeId']) }}" data-param=""
                                    data-url="{{ route('companyadmin.office.users', $office['officeId']) }}"
                                    title="Users" class="mx-2 text-white d-inline-flex">
                                    <i class="fa fa-users fa-lg"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @if ($office['children'] != null)
                    @foreach ($office['children'] as $subOfficeKey => $subOffice)
                        @if ($subOffice['level'] == 1)
                            <tr class="collapse show" id="collapseExample">
                                <td class="pdlg-1 text-wrap text-truncate">
                                    {{ __($subOffice['officeName']) }}</td>
                                <td class="small  text-truncate">
                                    {{ __($subOffice['officeTypeName']) }}</td>
                                <td class="small">{{ __($subOffice['officeContactNo']) }}</td>
                                <td class="text-center small">
                                    @if ($subOffice['officeTypeId'] != 1)
                                        @if ($subOffice['lastInvoiceNo'] == null)
                                            <a href="javascript:" data-param=""
                                                data-url="{{ route('companyadmin.office.invoice_no', $subOffice['officeId']) }}"
                                                title="{{ __('Invoice No') }}" class="load-popup highlight">
                                                {{ __('Invoice No') }}
                                            </a>
                                        @else
                                            {{ $subOffice['lastInvoiceNo'] }}
                                        @endif
                                    @else
                                        {{ __('--') }}
                                    @endif

                                </td>
                                <td class="text-left" style="min-width:300px;">
                                    <div class="d-inline-flex">
                                        <a href="javascript:" data-param="{{ base64_encode(json_encode($subOffice)) }}"
                                            data-url="{{ route('companyadmin.office.show', $subOffice['officeId']) }}"
                                            title="View" class="load-popup   mx-2 text-info ">
                                            <i class="fa fa-eye fa-lg "></i>
                                        </a>
                                        <a href="javascript:" data-param="" data-token="{{ csrf_token() }}"
                                            data-url="{{ route('companyadmin.office.edit', $subOffice['officeId']) }}"
                                            title="Edit" class="load-popup-post  mx-2 text-info d-inline-flex">
                                            <i class="fa fa-edit fa-lg "></i>
                                        </a>
                                        <a href="{{ route('companyadmin.office.users', $subOffice['officeId']) }}"
                                            data-param="" data-url="users" title="Users"
                                            class="mx-2 text-info d-inline-flex">
                                            <i class="fa fa-users fa-lg"></i>
                                        </a>
                                        @if ($subOffice['officeTypeId'] != 1)
                                            <a href="javascript:"
                                                data-param="{{ base64_encode(json_encode($subOffice)) }}"
                                                data-url="{{ route('companyadmin.office.godowns', $subOffice['officeId']) }}"
                                                title="{{ __('Godown') }}"
                                                class="load-popup   mx-2 text-info d-inline-flex">
                                                <i class="fas fa-warehouse  "></i>
                                            </a>
                                            <a href="javascript:" data-param=""
                                                data-url="{{ route('companyadmin.office.latest_rate', $subOffice['officeId']) }}"
                                                title="{{ __('Latest Rate') }}"
                                                class="load-popup text-info mx-2 fw-bold {{ $subOffice['level'] <= 1 ? 'd-inline-flex' : 'd-none' }} m-size">
                                                {{ __('@') }}
                                            </a>
                                            <a href="javascript:" data-param=""
                                                data-url="{{ route('companyadmin.office.current_stock', $subOffice['officeId']) }}"
                                                title="{{ __('Current Stock') }}"
                                                class="load-popup  sr-only text-info mx-2 fw-bold {{ $subOffice['level'] <= 1 ? 'd-inline-flex' : 'd-none' }} m-size">
                                                <i class="fa fa-archive" aria-hidden="true"></i>
                                                {{-- <i class="fa fa-cart-plus" aria-hidden="true"></i> --}}
                                            </a>
                                        @else
                                            {{ __(' ') }}
                                        @endif
                                    </div>

                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endif
        @endforeach


        {{-- @dd($offices) --}}

    </tbody>
</table>

