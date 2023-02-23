@php
    $className='pdl-'.$data['level'] ;
@endphp
<tr  class="collapse " id="collapseExample{{ $data['masterOfficeId'] }}">
    <td colspan="2"></td>
<td colspan="4">
<p>    email:{{ $data['officeEmail'] }}</p>
<p>    address:{{ $data['officeAddress'] }}</p>
<p>    contact:{{ $data['officeContactNo'] }}</p>
</td>
</tr>
