<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('scss/css/min/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('scss/pages/css/min/style.min.css') }}">

    @yield('css')
</head>
<body>
    <div class="page">
        <div class="page-header">
            <header>
                <div class="header-brand">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                    </a>
                </div>

                <div class="header-menu">

                </div>

                <div class="header-user">
                    @if (Auth::guest())
                        <a href="{{ route('login') }}" class="btn">
                            Login
                        </a>

                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Register
                        </a>
                    @else
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button">
                                <div class="user-info">
                                    <div class="img-mask img-mask-circle">
                                        <img src="https://images.unsplash.com/photo-1558507652-2d9626c4e67a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=687&q=80" alt="User Avatar">
                                    </div>
            
                                    <h6 class="subtitle-md">
                                        {{ Auth::user()->name }}
                                    </h6>
                                </div>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item btn-logout">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>

                                <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="header-expand-control">
                    <button class="btn btn-expand-menu" type="button">
                        <span class="line"></span>
                    </button>
                </div>
            </header>
        </div>

        <div class="page-body">
            @yield('view')
        </div>

        <div class="page-footer">
            <footer>
                <p class="p-sm">
                    <b>Company Info 1:</b> Info
                </p>

                <p class="p-sm">
                    <b>Company Info 2:</b> Info
                </p>

                <p class="p-sm">
                    <b>Company Info 3:</b> Info
                </p>
            </footer>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('js/function.js') }}"></script>
    @yield('js')
</body>
</html>
