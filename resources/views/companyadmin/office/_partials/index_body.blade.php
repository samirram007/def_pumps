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
    .m-size{
        font-size: 1.5rem;
    font-weight: 600;
    line-height: 0.5;
}
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
                    <table class="table  ">
                        <thead>
                            <tr>
                                <td>O</td>
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

                                @include('companyadmin.office._partials.table_row', ['data' => $office])
                                {{-- @include('companyadmin.office._partial.office_details_row', ['data' => $office]) --}}

                                @if ($office['children'] != null)
                                    @foreach ($office['children'] as $key => $child)

                                        @include('companyadmin.office._partials.table_row', ['data' => $child])
                                        {{-- @include('companyadmin.office._partial.office_details_row', ['data' => $child]) --}}

                                        @if ($child['children'] != null)
                                            @foreach ($child['children'] as $child_key => $sub_child)

                                                    @include('companyadmin.office._partials.table_row', [ 'data' => $sub_child, ])
                                                    {{-- @include('companyadmin.office._partial.office_details_row', ['data' => $sub_child]) --}}
                                                @if ($sub_child['children'] != null)
                                                    @foreach ($sub_child['children'] as $sub_child_key => $sub_child1)
                                                            @include('companyadmin.office._partials.table_row', [
                                                                'data' => $sub_child1,
                                                            ])
                                                        @if ($sub_child1['children'] != null)
                                                            @foreach ($sub_child1['children'] as $sub_child1_key => $sub_child2)
                                                                    @include('companyadmin.office._partials.table_row',['data' => $sub_child2])
                                                                    {{-- @include('companyadmin.office._partial.office_details_row', ['data' => $sub_child2]) --}}
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                    </table>
                </div>

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
