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
                        Logo
                    </a>
                </div>

                <div class="header-menu">

                </div>

                <div class="header-user">
                    <div class="dropdown">
                        <button class="btn" data-bs-toggle="dropdown" type="button">
                            <div class="user-info">
                                <div class="img-mask img-mask-circle">
                                    <img src="https://images.unsplash.com/photo-1558507652-2d9626c4e67a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=687&q=80" alt="User Avatar">
                                </div>
        
                                <h6 class="subtitle-md">
                                    User Name
                                </h6>
                            </div>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
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
    </div>

    <script src="{{ asset('plugins/jquery/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    @yield('js')
</body>
</html>
