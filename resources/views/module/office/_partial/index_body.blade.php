<style>
    .pdl-0 {
        padding-left: 2px !important;
    }

    .pdl-1 {
        padding-left: 20px !important;
    }

    .pdl-2 {
        padding-left: 40px !important;
    }

    .pdl-3 {
        padding-left: 60px !important;
    }

    .pdl-4 {
        padding-left: 80px !important;
    }

    .pdl-5 {
        padding-left: 100px !important;
    }

    .pdlg-1 {
        padding-left: 80px !important;
    }

    .pdlg-2 {
        padding-left: 100px !important;
    }

    .pdlg-3 {
        padding-left: 120px !important;
    }

    .pdlg-4 {
        padding-left: 140px !important;
    }

    .pdlg-5 {
        padding-left: 160px !important;
    }

    .pdl-10 {
        padding-left: 10px !important;
    }

    .m-size {
        font-size: 1.2rem;
        font-weight: 600;
        line-height: 0.5;
    }

    .fw-600 {
        font-weight: 600
    }

    .custom-table-shadow {
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 25%), 0 3px 10px 5px rgb(0 0 0 / 5%) !important
    }

    .accordion-item {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #5796d0), color-stop(100%, #3d6d99));
        width: 100%;
        color: #fff;
    }

    .accordion-item:hover {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #495261), color-stop(100%, #38404b));
    }

    .accordion-button {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        padding: 0.1rem 1.25rem;
        font-size: 1rem;
        color: #fff;
        text-align: left;
        border: 0;
        border-radius: 0;
        overflow-anchor: none;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, border-radius .15s ease;
    }

    .accordion-button:before {
        flex-shrink: 0;
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 20px;
        content: "";
        background-image: url(../images/icons/arrow.svg);
        background-repeat: no-repeat;
        background-size: 1.25rem;
        transition: transform .2s ease-in-out;
        transform: rotate(-180deg);
    }

    .accordion-button:not(.collapsed):before {
        transform: rotate(0deg);
    }

    /*.accordion-button:not(.collapsed)::before{
    background-image: url(../images/icons/arrow.svg);
    transform: rotate(0deg);
    content: "";
}*/
</style>



<div class="card">


    <div class="card-body">

        <div class="column">

            <div class="row">
                <div class="col-lg-12">
                    {{-- @dd($offices) --}}
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
                                            <button class="border border-0 bg-transparent accordion-button "
                                                data-toggle="collapse" data-target="#collapseExample"
                                                aria-expanded="true" aria-controls="collapseExample">
                                                {{ __($office['officeName']) }}
                                            </button>
                                        </td>
                                        <td class="small  text-truncate">{{ __($office['officeTypeName']) }}</td>
                                        <td class="small">{{ __($office['officeContactNo']) }}</td>
                                        <td class="text-center small">{{ __($office['lastInvoiceNo']) }}</td>
                                        <td class="text-left  " style=" text-align:left!important;">
                                            <div class="d-inline-flex">
                                                <a href="javascript:"
                                                    data-param="{{ base64_encode(json_encode($office)) }}"
                                                    data-url="{{ route('companyadmin.office.show', $office['officeId']) }}"
                                                    title="View" class="load-popup   mx-2 text-white ">
                                                    <i class="fa fa-eye fa-lg "></i>
                                                </a>
                                                <a href="javascript:"
                                                    data-param=""
                                                    data-token="{{ csrf_token() }}"
                                                    data-url="{{ route('companyadmin.office.edit', $office['officeId']) }}"
                                                    title="Edit" class="load-popup-post   mx-2 text-white d-inline-flex">
                                                    <i class="fa fa-edit fa-lg "></i>
                                                </a>
                                                {{-- @dd(session()->get('user')) --}}
                                                @if (json_decode(json_encode(session()->get('userData')), true)['officeId'] == $office['officeId'])
                                                    <a href="{{ route('companyadmin.office.users', $office['officeId']) }}"
                                                        data-param=""
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
                                                                    title="{{ __('Invoice No') }}"
                                                                    class="load-popup highlight">
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
                                                            <a href="javascript:"
                                                                data-param="{{ base64_encode(json_encode($subOffice)) }}"
                                                                data-url="{{ route('companyadmin.office.show', $subOffice['officeId']) }}"
                                                                title="View" class="load-popup   mx-2 text-info ">
                                                                <i class="fa fa-eye fa-lg "></i>
                                                            </a>
                                                            <a href="javascript:"
                                                                data-param=""
                                                                data-token="{{ csrf_token() }}"
                                                                data-url="{{ route('companyadmin.office.edit', $subOffice['officeId']) }}"
                                                                title="Edit"
                                                                class="load-popup-post  mx-2 text-info d-inline-flex">
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




                        </tbody>
                    </table>

                </div>
            </div>



        </div>

    </div>

</div>
