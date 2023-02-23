<nav class=" bg-primary  navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start pl-4">
        <a class="navbar-brand brand-logo " href="{{ route('superadmin.dashboard') }}">
            <img src="{{ asset('/css/bn/bn-images/logo.png') }}" class="p-1  img-fluid  shadow-md" alt="logo" />
            {{-- <span class="text-white text-uppercase display-5  ml-2">{{env('APP_NAME')}}</span> --}}
        </a>

        <a class="navbar-brand brand-logo-mini" href="{{ route('superadmin.dashboard') }}">
            <img src="{{ asset('/css/bn/bn-images/logo.png') }}" class="bg-white p-1 rounded-circle img-fluid  shadow-md"  alt="logo" />
            {{-- <span class="text-white text-uppercase display-5 ml-2 hidden-md">Karm</span> --}}
        </a>

    </div>
    {{-- <div class="bg-dark">

    </div> --}}
    {{-- {{ Session->get('productTypeList')}} --}}
    {{-- @if(!empty(Session::get('productTypeList')))

     @dd(Session::get('productTypeList')[0]['productTypeName'] )
    @endif --}}

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
        @if(!empty(Session::get('productTypeList')))
        <a href="javascript:" data-param="1"
        data-url="{{ route('admin.producttype.index') }}" title="Edit Area"
        data-size="md"
        class="load-popup     ">
        <span class=""  >
            <marquee behavior="scroll" direction="right" scrollamount="5">
            <ul class="d-flex" style="list-style:none" >
                @foreach (Session::get('productTypeList') as $productType)

                    <li class="px-4 text-light"> {{$productType['productTypeName'] }} : {{$productType['rate']  }}           </li>
                @endforeach
              </ul>
        </marquee>
        </span>
    </a>


              @endif
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu text-light"></span>
    </button>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav navbar-nav-right text-light">
            <li class="nav-item nav-profile dropdown">
                @php
                $user=App\Http\Controllers\ApiController::user(session()->get('loginid'));

            @endphp
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <i class="fas fa-user-circle mr-2"></i>

                    {{-- <img src="{{ !empty($user->image) ? url('upload/user_images/' . $user->image) : url('upload/no_image'. (($guard=="recruiter") ? '_provider':'') .'.jpg') }}"
                        alt="profile" /> --}}
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

                    @if($user['roleName']=='SuperAdmin')
                    <a class="dropdown-item" href="{{ route('superadmin.user.profile', session()->get('loginid')) }}">
                        <i class=" fas fa-user text-primary"></i>
                        {{ $user['firstName'] }} {{ $user['surName'] }}'s Profile
                    </a>
                    @elseif ($user['roleName']=='Admin' || $user['roleName']=='admin')
                    <a class="dropdown-item" href="{{ route('admin.user.profile', session()->get('loginid')) }}">
                        <i class="fas fa-user text-primary"></i>
                        {{ $user['firstName'] }} {{ $user['surName'] }}'s Profile
                    </a>
                    @elseif ($user['roleName']=='User')
                    <a class="dropdown-item" href="{{ route('user.profile', session()->get('loginid')) }}">
                        <i class="ti-settings text-primary"></i>
                        {{ $user['firstName'] }} {{ $user['surName'] }}'s Profile
                    </a>
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>


            <!-- Authentication Links -->
            @php $locale = session()->get('locale'); @endphp
            {{-- <li class="nav-item nav-profile dropdown d-none">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    @switch($locale)
                        @case('us')
                            <span class="iconify" data-icon="cif:us" style="color: #eee;" data-width="20"
                                data-height="20"></span> {{__('English')}}
                        @break

                        @case('bn')
                            <span class="iconify" data-icon="openmoji:flag-bangladesh" style="color: #eee;" data-width="20"
                                data-height="20"></span> {{__('Bengali')}}
                        @break

                        @case('in')
                            <span class="iconify" data-icon="uil:letter-hindi-a" style="color: rgb(23, 135, 228);"
                                data-width="20" data-height="20"></span>
                                {{__('Hindi')}}
                        @break

                        @default
                            <span class="iconify" data-icon="cif:us" style="color: #eee;" data-width="20"
                                data-height="20"></span> <span class="ml-2">{{__('English')}}</span>
                    @endswitch
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('lang','en')}}"><span class="iconify mr-3" data-icon="cif:us"
                            style="color: #eee;" data-width="20" data-height="20"></span>{{__('English')}}</a>
                    <a class="dropdown-item" href="{{route('lang','bn')}}"><span class="iconify mr-3" data-icon="openmoji:flag-bangladesh"
                            style="color: #eee;" data-width="20" data-height="20"></span>{{__('Bengali')}} </a>
                    <a class="dropdown-item" href="{{route('lang','in')}}"><span class="iconify mr-3" data-icon="uil:letter-hindi-a"
                            style="color: rgb(23, 135, 228);" data-width="20" data-height="20"></span> {{__('Hindi')}}</a>
                </div>
            </li> --}}
        </ul>
    </div>


</nav>

