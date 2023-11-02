<div class="text-sm small">

    <div> {{__('Office')}} : {{ $office['officeName'] }}</div>
    <div> {{__('Type')}} : {{ $office['officeTypeName'] }}</div>
    <div> {{ $office['officeAddress'] != '' ? 'Address' . ' : ' . $office['officeAddress'] : $office['registeredAddress'] }}</div>
</div>
