<div class="col-12">
    <div class="row border-bottom border-primary">
        <div class="col-md-6">
            <div> {{ __('Subject') }}: <span class="border-bottom border-info">{{ $allData['title'] }}</span></div>
            <div> {{ __('Posted By') }}: {{ $allData['userDetails']['firstName'] }}
                {{ $allData['userDetails']['firstName'] == $allData['userDetails']['surName'] ? '' : $allData['userDetails']['surName'] }}
            </div>
            <div> {{ __('Recipient Read Status') }}: <span id="readStatus">{!! $allData['readStatus'] != true
                ? '<span class="badge badge-success rounded-circle" style="color:#ffffff00">O</span>'
                : '<span class="badge badge-warning rounded-circle" style="color:#ffffff00">O</span>' !!}</span>
            </div>

        </div>
        <div class="col-md-6">
            <div class="text-right"> {{ __('Ticket No') }}: <span class="badge badge-outline-info">
                    {{ $allData['supportId'] }}</span></div>
            <div class="text-right"> {{ __('Started On') }}: {{ date('d-M-Y H:i:s', strtotime($allData['createdOn'])) }}
            </div>
            <div class="text-right"> {{ __('Modified On') }}: <span
                    id="lastModifyOn">{{ date('d-M-Y H:i:s', strtotime($allData['lastModifyOn'])) }}</span></div>
            <div class="text-right"> {{ __('Chat Count') }}: <span id="chatCount">{{ $allData['chatCount'] }}</span>
                <a href="javascript:" onclick="ChatBody();" title="Reload" class=" badge badge-primary ">
                    <i class="fa fa-refresh"></i>{{ __('Check') }}
                </a>
            </div>
        </div>
    </div>



</div>
<div id="chatWindow" class="bg-light pb-3">
    <div class="card border-0 shadow-none" style="height:50vh; overflow-y:auto ">
        <div id="ChatBody" class="card-body d-flex  flex-row ">

            @include('support.chat_body')

        </div>
    </div>
    <div class="row px-4 border-top py-2">
        {{-- @dd($SupportDetails) --}}
        <form id="MessageForm" action="" method="post" enctype="multipart/form-data" class="w-100">
            <div class="d-flex mb-3 border-info">
                <div class="w-100">
                    {{-- @dd($SupportDetails[0]) --}}
                    <input type="text" class="sr-only" id="supportId" name="supportId"
                        value="{{ $SupportDetails[0]['supportId'] }}">
                    <input type="text" class="form-control" name="bodyText" id="bodyText"
                        placeholder="{{ __('Message') }}" value="">
                </div>
                <div class="position-absolete">

                    <div class="d-flex align-items-center">
                        <input type="file" name="Attachment" id="Attachment" class="form-control d-none">

                        {{-- <div id="AttachmentMask" class="btn btn-link"><i class="fa fa-paperclip fa-lg"
                                aria-hidden="true"></i></div> --}}
                        <img id="AttachmentMask" class="btn btn-link"
                            style="height: 40px; width:50px; padding:0 5px !important;"
                            src="{{ asset('upload/thumb_paper-clip.png') }}">
                        <input id="send-btn" type="submit" class="btn btn-primary" id="sendMessage"
                            value="{{ __('Send') }}">
                    </div>

                </div>



            </div>
        </form>
    </div>
</div>

<script>
    var element = document.getElementById('ChatBody');

   // element.scrollTop = element.scrollHeight;

    $(document).on('click', '#AttachmentMask', function() {
        $('#Attachment').click();
    });

    $(document).on('change', '#Attachment', function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#AttachmentMask').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);

    });
$(document).ready(function() {
    ChatBody();
});

    $("#MessageForm").on("submit", function(event) {
        event.preventDefault();
        // get data from form
        var form = $('#MessageForm')[0];

        var data = new FormData(form);
        data.append('_token', '{{ csrf_token() }}');
        $.ajax({
            type: "POST",
            url: "{{ route('store.support_details') }}",
            data: data,
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            success: function(msg) {
                // console.log(msg);
                toastr.success("Posted Successfully");
                ChatBody();
                $("#bodyText").val('');
                $("#bodyText").focus();
                $('#Attachment').val('');
                $('#AttachmentMask').attr('src', '{{ asset('upload/thumb_paper-clip.png') }}');

                // {{ asset('upload/thumb_paper-clip.png') }}
                // Display message back to the user here
            }
        });

        // event.preventDefault();

    });
    //  setInterval(ChatBody, 1000);
    function ChatBody(supportId = 0) {
        // console.log('ChatBody');
        if (supportId == 0) {
            var supportId = $('#supportId').val()
        }

        // alert(supportId);
        var url = "{{ route('support.chat', ':supportId') }}";
        url = url.replace(':supportId', supportId);
        //  alert(url);
        $.ajax({
            type: "GET",
            url: url,
            success: function(msg) {

                $("#ChatBody").html(msg.html);
                $("#lastModifyOn").html(msg.lastModifyOn);
                $("#chatCount").html(msg.chatCount);
                $("#readStatus").html(msg.readStatus == true ?
                    '<span class="badge badge-success rounded-circle" style="color:#ffffff00">O</span>' :
                    '<span class="badge badge-warning rounded-circle" style="color:#ffffff00">O</span>');


            }
        });
    }

</script>
