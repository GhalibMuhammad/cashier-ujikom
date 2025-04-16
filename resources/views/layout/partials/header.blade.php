<!-- Header -->
<div class="header">

    <!-- Logo -->
    <div class="header-left active">
        <a href="{{ url('index') }}" class="logo logo-normal">
            <img src="{{ URL::asset('/build/img/logo.png') }}" alt="">
        </a>
        <a href="{{ url('index') }}" class="logo logo-white">
            <img src="{{ URL::asset('/build/img/logo-white.png') }}" alt="">
        </a>
        <a href="{{ url('index') }}" class="logo-small">
            <img src="{{ URL::asset('/build/img/logo-small.png') }}" alt="">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- Search -->
        <li class="nav-item nav-searchinputs">
        </li>
        <!-- /Search -->


        <!-- Select Store -->
        <li class="nav-item dropdown has-arrow main-drop select-store-dropdown">

        </li>
        <!-- /Select Store -->

        <!-- Flag -->
        <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
        </li>
        <!-- /Flag -->

        <li class="nav-item nav-item-box">
        </li>
        <li class="nav-item nav-item-box">
        </li>
        <!-- Notifications -->
        <li class="nav-item dropdown nav-item-box">
        </li>
        <!-- /Notifications -->

        <li class="nav-item nav-item-box">
        </li>
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user-info">
                    <span class="user-letter">
                        <img src="{{ URL::asset('/build/img/profiles/avator1.jpg') }}" alt=""
                            class="img-fluid">
                    </span>
                    <span class="user-detail">
                        @if (Auth::check())
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role">{{ Auth::user()->role }}</span>
                        @endif
                    </span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <span class="user-img"><img src="{{ URL::asset('/build/img/profiles/avator1.jpg') }}"
                                alt="">
                            <span class="status online"></span></span>
                        <div class="profilesets">
                        @if (Auth::check())
                            <h6>{{ Auth::user()->name }}</h6>
                            <h5>{{ Auth::user()->role }}</h5>
                        @endif
                        </div>
                    </div>
                    <hr class="m-0">
                  
                    <hr class="m-0">
                    <a class="dropdown-item logout pb-0" href="{{ url('signin-3') }}"><img
                            src="{{ URL::asset('/build/img/icons/log-out.svg') }}" class="me-2"
                            alt="img">Logout</a>
                </div>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ url('signin') }}">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>
<!-- /Header -->
