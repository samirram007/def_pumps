<style>
    .doc-area {
        width: 200px;
        object-fit: cover;
    }

    .doc-area img,
    .doc-area iframe {
        max-width: 200px;
        max-height: 200px;
    }
</style>
<table class="w-100">

    @forelse ($SupportDetails[0]['supportDetails']  as $key=> $support)
        {{-- @dd($support) --}}
        {{-- @dd(Session::get('loginid')) --}}

        <tr>
            <td class="w-100" style="white-space:nowrap">
                @if ($support['sendBy'] == Session::get('loginid'))
                    {{-- sender --}}
                    <div class="d-flex flex-row justify-content-end mb-4">
                        <div class="p-3 mr-3 border round-border user-chat ">
                            <p class="small mb-0">{{ $support['bodyText'] }}</p>
                            @if (strlen($support['documentPath']) > 0)
                                <div class="doc-area">

                                    @if (in_array(pathinfo($support['documentPath'])['extension'], ['pdf', 'xlsx', 'docx']))
                                        <iframe
                                            src="{{ env('LIVE_SERVER') . '/upload/SupportDoc/' . $support['documentPath'] }}"
                                            alt="" scrolling="no" class="doc-area"></iframe>
                                    @else
                                        <img src="{{ env('LIVE_SERVER') . '/upload/SupportDoc/' . $support['documentPath'] }}"
                                            alt="" class=" img-fluid">
                                    @endif
                                </div>
                            @endif

                            <small class="h6 border-top border-success"
                                style="font-size: 0.6rem;">{{ date('d-m-Y H:i:s', strtotime($support['sendTime'])) }}

                            </small>
                            @if (strlen($support['documentPath']) > 0)
                                <a target="_blank"
                                    href="{{ env('LIVE_SERVER') . '/upload/SupportDoc/' . $support['documentPath'] }}"
                                    class="btn btn-link"><i class="fa fa-download"></i></a>
                            @endif
                        </div>
                        {{-- <img src="{{ asset('dist/img/avatar2.png') }}" alt="avatar 1" class="img-info img-fluid"> --}}
                        @php
                        $documentpath = env('LIVE_SERVER') . '/upload/no_image.jpg';
                    @endphp

                    @if (!empty($support['userResource']['documents']))
                        @foreach ($support['userResource']['documents'] as $no => $document)
                            {{-- @dd($document) --}}
                            @if ($document['documentTypeId'] == 2)
                                @php
                                    $document_path = env('LIVE_SERVER') . '/upload/UserDoc/' . $document['path'];
                                    $documentpath = $document_path;
                                @endphp
                            @endif
                        @endforeach
                    @endif

                    <img src="{{ $documentpath }}" alt="U" class="img-info img-fluid">

                        {{-- <img src="{{ !empty($support['userResource']['documents']) ? env('LIVE_URL') . '/' . $support['userResource']['documents']['path'] : env('LIVE_URL') . '/upload/no_image.jpg' }}"
                            class="img-info img-fluid" alt="U"> --}}
                    </div>
                @else
                    {{-- receiver --}}
                    <div class="d-flex flex-row justify-content-start mb-4">
                        {{-- <img src="{{ asset('dist/img/avatar3.png') }}" class="img-info img-fluid" alt="avatar 1"> --}}
                        {{-- @dd($support) --}}
                        @php
                            $documentpath = env('LIVE_SERVER') . '/upload/no_image.jpg';
                        @endphp

                        @if (!empty($support['userResource']['documents']))
                            @foreach ($support['userResource']['documents'] as $no => $document)
                                {{-- @dd($document) --}}
                                @if ($document['documentTypeId'] == 2)
                                    @php
                                        $document_path = env('LIVE_SERVER') . '/upload/UserDoc/' . $document['path'];
                                        $documentpath = $document_path;
                                    @endphp
                                @endif
                            @endforeach
                        @endif

                        <img src="{{ $documentpath }}" alt="U" class="img-info img-fluid">


                        <div class="p-3 ml-3 support-chat-info">
                            <p class="small mb-0">{{ $support['bodyText'] }}</p>
                            {{-- {{$support['documentPath']}} --}}
                            @if (strlen($support['documentPath']) > 0)
                                <div class="doc-area">

                                    @if (in_array(pathinfo($support['documentPath'])['extension'], ['pdf', 'xlsx', 'docx']))
                                        <iframe
                                            src="{{ env('LIVE_SERVER') . '/upload/SupportDoc/' . $support['documentPath'] }}"
                                            alt="" class="doc-area"></iframe>
                                    @else
                                        <img src="{{ env('LIVE_SERVER') . '/upload/SupportDoc/' . $support['documentPath'] }}"
                                            alt="">
                                    @endif
                                </div>
                            @endif


                            <small class="h6 border-top border-warning"
                                style="font-size: 0.6rem;">{{ date('d-m-Y H:i:s', strtotime($support['sendTime'])) }}</small>
                            @if (strlen($support['documentPath']) > 0)
                                <a target="_blank"
                                    href="{{ env('LIVE_SERVER') . '/upload/SupportDoc/' . $support['documentPath'] }}"
                                    class="btn btn-link"><i class="fa fa-download"></i></a>
                            @endif
                        </div>
                    </div>
                @endif
            </td>
        </tr>





    @empty
    @endforelse
</table>

<script>
    // setInterval(() => {
    //     ChatBody();
    // }, 2000);
</script>
