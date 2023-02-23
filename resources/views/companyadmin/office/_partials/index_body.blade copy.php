@if ($collections[0]['level'] == 0)
    {{-- @dd($collections[0]) --}}
    <div class="card">
        <div class="card-header card-primary" id="headingOne">
            <h3 class="mb-0">{{ $collections[0]['officeName'] }}</h3>
            <h4>{{ $collections[0]['officeTypeName'] }}</h4>
        </div>

        <div class="card-body">
            <p>{{ __('Email') }}: {{ $collections[0]['officeEmail'] }}</p>
            <p>{{ __('Contact') }}: {{ $collections[0]['officeContactNo'] }}</p>
            <p>{{ __('location') }}: {{ $collections[0]['officeAddress'] }}</p>
            <div>
                <div class="accordion" id="accordionExample">
                    {{-- @dd($offices) --}}
                    @foreach ($collections as $key => $office)
                        @if ($office['level'] == '1')
                            <div class="card border-0  ">
                                <div class="card-header p-2 border-left
                                bg-primary border-2 rounded-none text-light"
                                id="heading{{ $office['officeId'] }}">
                                    <div class="panel panel-success  text-dark w-100 border-0 text-left "
                                    style="cursor-pointer"
                                        data-toggle="collapse" data-target="#collapse{{ $office['officeId'] }}"
                                        aria-expanded="false" aria-controls="collapse{{ $office['officeId'] }}">
                                        <h3 class="mb-0 text-light">{{ $office['officeName'] }}</h3>
                                        <small class="text-light small">{{ $office['officeTypeName'] }}</small>
                                    </div>

                                </div>

                                <div id="collapse{{ $office['officeId'] }}" class="collapse "
                                    aria-labelledby="heading{{ $office['officeId'] }} "
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <p>{{ __('Email') }}: {{ $office['officeEmail'] }}</p>
                                        <p>{{ __('Contact') }}: {{ $office['officeContactNo'] }}</p>
                                        <p>{{ __('location') }}: {{ $office['officeAddress'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach


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
