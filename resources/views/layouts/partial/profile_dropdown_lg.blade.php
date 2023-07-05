<div class="dropdown-menu dropdown-menu-right dropdwn-menu-profile navbar-dropdown text-center bg-light"
    aria-labelledby="profileDropdown">

    <div style="width:350px; height:100px; background:#138891; position:relative;margin-bottom: 35px;">
        <div class="text-white py-4 font-weight-bold text-uppercase">
            {{ $user['roleName'] }}
        </div>

        <div
            style="position: absolute; bottom:0; margin:0 auto; display:flex; justify-content:center; width:100%; text-align:center">
            <img class="text-capitalize"
                style="width: 70px; height: 70px; border-radius: 50%; margin: 10px; margin-bottom: -35px; border: 3px solid #fff;"
                src="{{ !empty($user['image']) ? $user['image'] : url('upload/no_image.jpg') }}"
                alt="{{ $user['firstName'][0] }}" />
        </div>

    </div>
    {{-- route exists --}}
    <div class="h5">

        {{ $user['firstName'] }} {{ $user['surName'] }}

    </div>
    <div class="mt-n1 mb-4">
        <i class="fa fa-phone fa-flip-horizontal text-gray" style="color:#20815ca9; font-size:0.8rem; "
            aria-hidden="true"></i>
        {{ $user['phoneNumber'] }}
    </div>
    @if ($user['email'] != '')
        <div style="display: flex; justify-content:space-between; width:100%; text-align:left;font-size:12px;">
            <div class="py-2 px-4" style="width:10%; color:#556d7ea9 ">
                <i class="fa fa-envelope  " style="color:#ee5d58a2; font-size:1.2rem; " aria-hidden="true"></i>
            </div>
            <div class="p-1 text-left d-flex align-items-center" style="width:90%;">
                {{ $user['email'] }}
            </div>
        </div>
    @endif
    @if ($user['officeName'] != '')
        <div style="display: flex; justify-content:space-between; text-align:left; font-size:12px;">
            <div class="py-2 px-4" style="width:10%; color:#556d7ea9 ">
                <i class="fa fa-building fa-sm  " style="color:#607a8ba9; font-size:1.2rem; " aria-hidden="true"></i>
            </div>
            <div class="p-1 text-left d-flex align-items-center" style="width:90%;  ">
                {{ $user['officeName'] }}
            </div>
        </div>
    @endif


    <div class="mt-4"
        style="display: flex; justify-content:space-between;
    text-align:left; font-size:12px; background:#dfe5e69a; padding-top:10px;">
        <div class="py-1 px-3" style="width:25%; ">
        </div>
        <div class="p-1 text-left" style="width:75%; zoom:70%;">
            <div class="lights-toggle">
                {{-- <label for="lights-toggle" class="text-xs"><span>Turn me <span
                            class="label-text">dark</span></span></label> --}}
                <input id="lights-toggle" type="checkbox" name="lights-toggle" class="switch" checked="checked">
                <label for="lights-toggle" class="text-xs text-uppercase " style="font-size: 16px">
                    <span class="">Turn me <span class="label-text">light</span></span></label>

            </div>
        </div>
    </div>
    {{-- <a class="dropdown-item" href="javascript:">

    </a> --}}
    <div style=" display:flex; justify-content:space-between ; border-top:0.5px solid rgb(194, 193, 193);">
        @if (session()->has('isSuperAdmin') && session()->get('isSuperAdmin') && session()->get('roleName') != 'superadmin')
            <div style="width:50%;border-right:0.5px solid rgb(194, 193, 193);">
                {{-- Previous user --}}
                <a href="{{ route('switchmode', 'none') }}" class="dropdown-item  ">
                    <i class="fa fa-arrow-left mr-3" aria-hidden="true"></i>
                    <span class="menu-title  " style="color:rgb(133, 129, 129)!important;">{{ __('Previous User') }}
                    </span>

                </a>

            </div>
            <div style="width:50%">
                <a href="{{ route('switchmode', session()->get('superAdminId')) }}" class="dropdown-item">
                    <i class="fa fa-power-off mr-3"></i>
                    <span class="menu-title" style="color:rgb(133, 129, 129)!important;">{{ __('Exit User') }} </span>

                </a>
            </div>
        @else
            <div style="width:50%; left:0;border-right:0.5px solid rgb(194, 193, 193);">
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="ti-power-off text-primary"></i>
                    <span class="menu-title" style="color:rgb(133, 129, 129)!important;">{{ __('Logout') }} </span>
                </a>
            </div>
        @endif
    </div>

</div>
