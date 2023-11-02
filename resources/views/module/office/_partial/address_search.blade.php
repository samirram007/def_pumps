<div id="google_address_search_panel" class="position-absolute full-height sr-only">

    <input type="text" id="address_search" class="form-control" placeholder="type your address here.">
    <div id="address_search_list" class="this_overflow">

    </div>
</div>
<style>
    .full-height {
    top: 0;
    margin-top: 1.5rem!important;
    height: 10%!important;
    max-height: 100%!important;
    width: 96.6%!important;
    z-index: 1000!important;
    background: #eeececf8!important;
    color: #0689bd;
border-radius: 10px;

}
.this_overflow{
    overflow-y: auto!important;
}
.full-height .form-control{
    color: #0689bd;
        background: #eceded;
}
#myUL{
    border:1px solid #0689bd;
}
#myUL li a {
    border: 1px solid #ddd;
    margin-top: -1px;
    background-color: #f6f6f6;
    padding-inline: 12px;
    padding-block: 5px;
    text-decoration: none;
    font-size: 14px;
    color: #0689bd;
    display: block;
}
</style>
<script>
    $('#address_search').on('keyup', function() {
        var address = $(this).val();
        $('#address_search_list').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        if (address.length > 1) {
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
