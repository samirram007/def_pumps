<div id="google_address_search_panel" class="position-absolute full-height sr-only">

    <input type="text" id="address_search" class="form-control" placeholder="type your address here.">
    <div id="address_search_list">

    </div>
</div>
<style>
    .full-height {
        margin-top: 2.5rem;
        height: calc(100% - 2.5rem);
        max-height: calc(100% - 2.5rem);
        width: 100%;
        z-index: 1000;
        background: rgb(255, 255, 255);
        overflow-y: auto;
    }
</style>
<script>
    $('#address_search').on('keyup', function() {
        var address = $(this).val();
        if (address.length > 3) {
            $.ajax({
                url: "{{ route('office.address.search') }}",
                type: "GET",
                data: {
                    address: address,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#address_search_list').html(response.html);
                }
            });
        }
    });
</script>
