<div id="google_address_search_panel" class=" full-height sr-only">

    {{-- <input type="text" id="address_search" class="form-control sr-only" placeholder="type your address here."> --}}
    <div id="address_search_list">

    </div>
</div>
<style>
   .full-height {
    margin-block-start: -1rem;
    margin-block-end: 1rem;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    height: calc(200px - 2.5rem);
    max-height: calc(200px - 2.5rem);
    width: 100%;
    z-index: 1000;
    background: rgb(255, 255, 255);
    overflow: hidden;
    box-shadow: 0px 5px 6px 1px #99999973;

}
</style>
<script>
    $('#address_search').on('keyup', function() {
        var address = $(this).val();
        var stateName = $('#stateId').find("option:selected").text();

        if (address.length > 3) {
            address_search(address,stateName);
        }
    });
    async function address_search(address,stateName){
        $.ajax({
                url: "{{ route('hub.address.search') }}",
                type: "GET",
                data: {
                    address: address,
                    stateName:stateName,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#address_search_list').html(response.html);
                }
            });
    }
</script>
