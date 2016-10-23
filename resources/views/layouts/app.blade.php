<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    @stack('style-head')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script src="/js/jquery-3.1.0.min.js"></script>
    @stack('script-head')
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                @if (!Auth::guest())
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                @endif

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            @if (!Auth::guest())
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li class="{{ is_active(url('dashboard')) }}">
                            <a href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                        @if(Auth::user()->is_admin)
                            <li class="dropdown {{ child_active(route('retails.index')) || child_active(route('users.index')) || child_active(route('calculate_values.index')) ? 'active' : '' }}">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Master Data <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li class="{{ is_active(route('retails.index')) }}">
                                        <a href="{{ route('retails.index') }}">Retails</a>
                                    </li>
                                    <li class="{{ is_active(route('users.index')) }}">
                                        <a href="{{ route('users.index') }}">Users</a>
                                    </li>
                                    <li class="{{ is_active(route('calculate_values.index')) }}" >
                                        <a href="{{ route('calculate_values.index') }}">Calculate Values</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="{{ is_active(url('calculate')) }}">
                            <a href="{{ route('calculate.index') }}">Calculate</a>
                        </li>
                        <li class="{{ is_active(url('history')) }}">
                            <a href="{{ url('history') }}">History</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </nav>

    @yield('content')

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @stack('script-body')
</body>
</html>
