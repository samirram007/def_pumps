@php
    $className='pdl-'.$data['level'] ;
    $classNameGap='pdlg-'.$data['level'] ;
    $routeRole=session()->get('roleName');
@endphp
<tr
class="collapse {{$data['children']!=null ? 'expand':'' }} {{ $data['level']==0? 'show':'' }} v-midlle"
 id="collapseExample{{ $data['masterOfficeId'] }}"
>
@if($data['children']!=null)
<td class="{{$className}} text-wrap text-truncate w-50">
<button class="icon-bg border border-0 mx-2"
  id="expand{{$data['officeId']}}"  data-toggle="collapse"
data-target="#collapseExample{{ $data['officeId'] }}"
aria-expanded="false" aria-controls="collapseExample{{ $data['officeId']  }}" >

{{ $data['children']!=null ?'+':'' }}
</button>
{{ $data['officeName'] }}
</td>
@else
 <td class="{{$classNameGap}} text-wrap text-truncate">  {{ $data['officeName'] }}</td>
@endif
{{-- <td>{{ $data['level'] }}</td> --}}
{{--<td class="{{$className}} text-wrap text-truncate w-50">{{ $data['officeName'] }}</td>--}}
<td  class="small  text-truncate">{{ $data['officeTypeName'] }}</td>
<td class="small">{{ $data['officeContactNo'] }}</td>
<td class="text-center small">
    @if ($data['officeTypeId'] != 1)
        @if ($data['lastInvoiceNo'] == null)
            <a href="javascript:" data-param=""
                data-url="{{ route('companyadmin.office.invoice_no', $data['officeId']) }}"
                title="{{ __('Invoice No') }}"
                class="load-popup highlight">
                {{ __('Invoice No') }}
            </a>
        @else
            {{ $data['lastInvoiceNo'] }}
        @endif
    @else
        {{ __('--') }}
    @endif
</td>
<td class="text-left  "
style=" text-align:left!important;">
<div class="d-inline-flex">
    <a href="javascript:" data-param=""
    data-url="{{ route('companyadmin.office.show', $data['officeId']) }}"
    title="{{ __('View') }}"
    class="load-popup   mx-2 text-info ">
    <i class="fa fa-eye fa-lg "></i>
</a>
    <a href="javascript:" data-param=""
        data-url="{{ route('companyadmin.office.edit', $data['officeId']) }}"
        title="{{ __('Edit') }}"
        class="load-popup   mx-2 text-info {{$data['level']<=1 ?'d-inline-flex' : 'd-none'}}">
        <i class="fa fa-edit fa-lg "></i>
    </a>
    <a href="{{ route('companyadmin.office.users', $data['officeId']) }}"
        data-param=""
        data-url="{{ route('companyadmin.office.users', $data['officeId']) }}"
        title="{{ __('Users') }}" class="mx-2 text-info {{$data['level']<=1 ?'d-inline-flex' : 'd-none'}}">
        <i class="fa fa-users fa-lg"></i>
    </a>
    @if ($data['officeTypeId'] != 1)
        <a href="javascript:" data-param=""
            data-url="{{ route('companyadmin.office.latest_rate', $data['officeId']) }}"
            title="{{ __('Latest Rate') }}"
            class="load-popup text-info mx-2 fw-bold {{$data['level']<=1 ?'d-inline-flex' : 'd-none'}} m-size">
            {{ __('@') }}
        </a>
    @else
        {{ __(' ') }}
    @endif
</div>




</td>
</tr>
