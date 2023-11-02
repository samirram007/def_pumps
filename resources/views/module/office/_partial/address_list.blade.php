
<ul id="myUL">
@forelse ($addressList['results'] as $address )
<div>


        <li><a href="#" data-address="{{$address['formatted_address']}}" data-lat="{{$address['geometry']['location']['lat']}}" data-lng="{{$address['geometry']['location']['lng']}}">{{$address['formatted_address']}}<div class="small"><span class="text-success mr-4">Lat: {{$address['geometry']['location']['lat']}}</span> <span class="text-danger ml-4">Lng: {{$address['geometry']['location']['lng']}}</span></div>

        </a>
        </li>


</div>

@empty

@endforelse
</ul>
<style>
    #myUL {
  /* Remove default list styling */
  list-style-type: none;
  padding: 0;
  margin: 0;
}

#myUL li a {
  border: 1px solid #ddd; /* Add a border to all links */
  margin-top: -1px; /* Prevent double borders */
  background-color: #f6f6f6; /* Grey background color */
  padding: 12px; /* Add some padding */
  text-decoration: none; /* Remove default text underline */
  font-size: 18px; /* Increase the font-size */
  color: black; /* Add a black text color */
  display: block; /* Make it into a block element to fill the whole list */
}

#myUL li a:hover:not(.header) {
  background-color: #eee; /* Add a hover effect to all links, except for headers */
}
</style>
<script>
    $('#myUL li a').on('click', function() {
        var lat = $(this).data('lat');
        var lng = $(this).data('lng');
        var address=$(this).data('address');
        $('#latitude').val(lat);
        $('#longitude').val(lng);
        $('#officeAddress').val(address);
        $('#address_search').val(address);
        // $('#officeAddress').val($(this).text());
        // $('#address_search').val($(this).text());
        $('#google_address_search_panel').addClass('sr-only');
    });
</script>
