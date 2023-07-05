<div class="text-sm small">
    <div> {{__('Office')}} : {{ $office['officeName'] }}</div>
    <div> {{ $office['officeAddress'] != '' ? 'Address' . ' : ' . $office['officeAddress'] : '' }}</div>
</div>
