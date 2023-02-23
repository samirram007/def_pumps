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
    .m-size{
        font-size: 1.5rem;
    font-weight: 600;
    line-height: 0.5;
    }
    .fw-600 { font-weight:600}

 .custom-table-shadow {box-shadow:0 2px 5px 0 rgb(0 0 0 / 25%), 0 3px 10px 5px rgb(0 0 0 / 5%) !important}   
.accordion-item {background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#5796d0), color-stop(100%,#3d6d99)); width:100%; color:#fff;}
.accordion-item:hover { background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#495261), color-stop(100%,#38404b));}
.accordion-button {position: relative;display: flex;align-items: center;width: 100%;padding: 0.1rem 1.25rem;font-size: 1rem;color: #fff;text-align: left;
border: 0;border-radius: 0;overflow-anchor: none;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,border-radius .15s ease;
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

.accordion-button:not(.collapsed):before {transform: rotate(0deg);}

/*.accordion-button:not(.collapsed)::before{
    background-image: url(../images/icons/arrow.svg);
    transform: rotate(0deg);
    content: "";
}*/

</style>
@if ($collections[0]['level'] == 0)
    {{-- @dd($collections[0]) --}}
    <div class="card">
        {{-- <div class="card-header card-primary" id="headingOne">
            <h3 class="mb-0">{{ $collections[0]['officeName'] }}</h3>
            <h4>{{ $collections[0]['officeTypeName'] }}</h4>
        </div> --}}

        <div class="card-body">
            {{-- <p>{{ __('Email') }}: {{ $collections[0]['officeEmail'] }}</p>
            <p>{{ __('Contact') }}: {{ $collections[0]['officeContactNo'] }}</p>
            <p>{{ __('location') }}: {{ $collections[0]['officeAddress'] }}</p> --}}
            <div class="column">

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-responsive custom-table-shadow table-striped">
                            <thead>
                                <tr>
                                    <td scope="col" class="w-50 pdl-3 fw-600">{{__('Name')}}</td>
                                    <td scope="col" class="fw-600">{{__('Type')}}</td>
                                    <td scope="col" class="fw-600">{{__('Contact')}}</td>
                                    <td class="col text-center fw-600"> {{ __('Last Invoice No') }}</td>
                                    <td scope="col fw-600">#</td>
                                </tr>
                            </thead>
                            <tbody>
                               
                                        <tr class="v-midlle accordion-item">
                                            <td class="pdl-0 text-wrap text-truncate">
                                                <button class="border border-0 bg-transparent accordion-button"  data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
                                                    Lexus Industries
                                                </button>
                                            </td>
                                            <td class="small  text-truncate">Company</td>
                                            <td class="small"></td>
                                            <td class="text-center small">--</td>
                                            <td class="text-left  " style=" text-align:left!important;">
                                                <div class="d-inline-flex">
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/show/9228188f-9085-404c-6669-08db0905751f" title="View" class="load-popup   mx-2 text-white ">
                                                        <i class="fa fa-eye fa-lg "></i>
                                                    </a>
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/edit/9228188f-9085-404c-6669-08db0905751f" title="Edit" class="load-popup   mx-2 text-white d-inline-flex">
                                                        <i class="fa fa-edit fa-lg "></i>
                                                    </a>
                                                    <a href="http://115.124.120.251:5007/companyadmin/office/users/9228188f-9085-404c-6669-08db0905751f" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/users/9228188f-9085-404c-6669-08db0905751f" title="Users" class="mx-2 text-white d-inline-flex">
                                                        <i class="fa fa-users fa-lg"></i>
                                                    </a>
                                                            
                                                </div>
                                            </td>
                                        </tr>
                                    
                                        <tr class="collapse" id="collapseExample">
                                            <td class="pdlg-1 text-wrap text-truncate">Deep Lubricants</td>
                                            <td class="small  text-truncate">Company</td>
                                            <td class="small">1831389378</td>
                                            <td class="text-center small">--</td>
                                            <td class="text-left">
                                                <div class="d-inline-flex">
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/show/b0728bf4-7c3e-4c28-666c-08db0905751f" title="View" class="load-popup   mx-2 text-info ">
                                                        <i class="fa fa-eye fa-lg "></i>
                                                    </a>
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/edit/b0728bf4-7c3e-4c28-666c-08db0905751f" title="Edit" class="load-popup   mx-2 text-info d-inline-flex">
                                                        <i class="fa fa-edit fa-lg "></i>
                                                    </a>
                                                    <a href="http://115.124.120.251:5007/companyadmin/office/users/b0728bf4-7c3e-4c28-666c-08db0905751f" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/users/b0728bf4-7c3e-4c28-666c-08db0905751f" title="Users" class="mx-2 text-info d-inline-flex">
                                                        <i class="fa fa-users fa-lg"></i>
                                                    </a>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr class="collapse" id="collapseExample" >
                                            <td class="pdlg-1 text-wrap text-truncate">  LX-Ret-Varanasi</td>
                                            <td class="small  text-truncate">Retail Pumps</td>
                                            <td class="small"></td>
                                            <td class="text-center small">103</td>
                                            <td class="text-left">
                                                <div class="d-inline-flex">
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/show/089e58a1-6afa-4d43-666a-08db0905751f" title="View" class="load-popup   mx-2 text-info ">
                                                        <i class="fa fa-eye fa-lg "></i>
                                                    </a>
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/edit/089e58a1-6afa-4d43-666a-08db0905751f" title="Edit" class="load-popup   mx-2 text-info d-inline-flex">
                                                        <i class="fa fa-edit fa-lg "></i>
                                                    </a>
                                                    <a href="http://115.124.120.251:5007/companyadmin/office/users/089e58a1-6afa-4d43-666a-08db0905751f" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/users/089e58a1-6afa-4d43-666a-08db0905751f" title="Users" class="mx-2 text-info d-inline-flex">
                                                        <i class="fa fa-users fa-lg"></i>
                                                    </a>
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/latest_rate/089e58a1-6afa-4d43-666a-08db0905751f" title="Latest Rate" class="load-popup text-info mx-2 fw-bold d-inline-flex m-size">
                                                            @
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="collapseExample">
                                            <td class="pdlg-1 text-wrap text-truncate">  LX-Whl-Kasi</td>
                                            <td class="small  text-truncate">Wholesale Pumps</td>
                                            <td class="small">1831389379</td>
                                            <td class="text-center small">1001</td>
                                            <td class="text-left">
                                                <div class="d-inline-flex">
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/show/369b5489-14f5-4c67-666b-08db0905751f" title="View" class="load-popup   mx-2 text-info ">
                                                        <i class="fa fa-eye fa-lg "></i>
                                                    </a>
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/edit/369b5489-14f5-4c67-666b-08db0905751f" title="Edit" class="load-popup   mx-2 text-info d-inline-flex">
                                                        <i class="fa fa-edit fa-lg "></i>
                                                    </a>
                                                    <a href="http://115.124.120.251:5007/companyadmin/office/users/369b5489-14f5-4c67-666b-08db0905751f" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/users/369b5489-14f5-4c67-666b-08db0905751f" title="Users" class="mx-2 text-info d-inline-flex">
                                                        <i class="fa fa-users fa-lg"></i>
                                                    </a>
                                                    <a href="javascript:" data-param="" data-url="http://115.124.120.251:5007/companyadmin/office/latest_rate/369b5489-14f5-4c67-666b-08db0905751f" title="Latest Rate" class="load-popup text-info mx-2 fw-bold d-inline-flex m-size">
                                                      @
                                                    </a>
                                                </div>
                                                </td>
                                         </tr>
                                            
                            </tbody>   
                        </table>
                        
                    </div>
                </div>  
                  
                <!-- div class="row">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                {{-- <td>O</td> --}}
                                {{-- <td>Level</td> --}}
                                <td scope="col">{{__('Name')}}</td>
                                <td scope="col">{{__('Type')}}</td>
                                <td scope="col">{{__('Contact')}}</td>
                                <td class="col   text-center"> {{ __('Last Invoice No') }}</td>
                                <td scope="col">#</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offices as $key => $office)

                                @include('module.office._partial.table_row', ['data' => $office])
                                  @if ($office['children'] != null)
                                    @foreach ($office['children'] as $key => $child)

                                        @include('module.office._partial.table_row', ['data' => $child])

                                        {{-- @if ($child['children'] != null)
                                            @foreach ($child['children'] as $child_key => $sub_child)

                                                    @include('module.office._partial.table_row', [ 'data' => $sub_child, ])
                                                      @if ($sub_child['children'] != null)
                                                    @foreach ($sub_child['children'] as $sub_child_key => $sub_child1)
                                                            @include('module.office._partial.table_row', [
                                                                'data' => $sub_child1,
                                                            ])
                                                        @if ($sub_child1['children'] != null)
                                                            @foreach ($sub_child1['children'] as $sub_child1_key => $sub_child2)
                                                                    @include('module.office._partial.table_row',['data' => $sub_child2])
                                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif --}}
                                    @endforeach
                                @endif
                            @endforeach

                    </table>
                </div -->

            </div>

        </div>

    </div>
@endif

{{-- @foreach ($offices as $office)

                  @if ($office['level'] == '0')
                    <div class="office-item">
                      <p class="office-name">{{ $office['officeName'] }}</p>
                      <p class="office-id">OfficeId: {{ $office['officeId'] }}</p>
                      <p class="office-master-id">MasterOfficeId: {{ $office['masterOfficeId'] }}</p>
                      <p class="office-level">Level: {{ $office['level'] }}</p>
                      <div class="office-children">
                        @foreach ($office['children'] as $child)
                          @if ($child['masterOfficeId'] == $office['officeId'])
                            <div class="office-item pl-4">
                              <p class="office-name">{{ $child['officeName'] }}</p>
                              <p class="office-id">OfficeId: {{ $child['officeId'] }}</p>
                              <p class="office-master-id">MasterOfficeId: {{ $child['masterOfficeId'] }}</p>
                              <p class="office-level">Level: {{ $child['level'] }}</p>
                            </div>
                          @endif
                        @endforeach
                      </div>
                    </div>
                  @endif
                @endforeach --}}
