<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @auth
                            @if (Auth::user()->is('buyer'))
                                <li class="nav-item">
                                    <a class="nav-link" href="/globshoppers">Globshoppers <span class="sr-only">(current)</span></a>
                                </li>
                            @elseif (Auth::user()->is('globshopper'))
                                &nbsp;<li class="nav-item">
                                    <a class="nav-link" href="/globshoppers/edit-portfolio">Portfolio</a>
                                </li>
                            @elseif (Auth::user()->is('admin'))
                                &nbsp;<li class="nav-item">
                                    <a class="nav-link" href="/users/index">Users</a>
                                </li>
                            @endif
                            &nbsp;<li class="nav-item">
                                <a class="nav-link" href="/requests/index">Requests</a>
                            </li>
                            @if (Auth::user()->is('globshopper') || Auth::user()->is('buyer'))
                                <li class="nav-item">
                                    <a href="/notifications">Notifications @if (Auth::user()->newNotifications->count())<span class="badge badge-danger">{{ Auth::user()->newNotifications->count() }}</span>@endif</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('profile') }}">
                                            <i class="fa fa-btn fa-user"></i> Profile
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-btn fa-sign-out"></i> Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/all.js"></script>

</body>
</html>
