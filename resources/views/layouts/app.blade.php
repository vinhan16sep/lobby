<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

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
                        <img src="{{ asset('img/logo_w.svg') }}" alt="Logo">
                    </a>
                </div>

                <div class="header-menu" style="width: 80%;text-align: right;">
                    <a href="https://dxsummit.vn/" class="btn btn-primary" target="_blank">
                        Trang chính sự kiện
                    </a>
                    <a href="https://dxsummit.vn/chuong-trinh/" class="btn btn-primary">
                        Chương trình
                    </a>
                    <a href="https://dxsummit.vn/lien-he/" class="btn btn-primary">
                        Liên hệ
                    </a>
                </div>

                <div class="header-user">
                    @if (Auth::guest())
                        {{-- <a href="{{ route('login') }}" class="btn">
                            Login
                        </a>

                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Register
                        </a> --}}
                    @else
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button">
                                <div class="user-info">
                                    <div class="img-mask img-mask-circle">
                                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Avatar of {{ Auth::user()->name }}">
                                    </div>
            
                                    <h6 class="subtitle-md">
                                        {{ Auth::user()->email }}
                                    </h6>
                                </div>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item btn-logout">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
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
                <h6 class="subtitle-sm">
                    © HIỆP HỘI PHẦN MỀM & DỊCH VỤ CNTT VIỆT NAM (VINASA)
                </h6>

                <p>
                    <a href="mailto:contact@vinasa.org.vn">
                        Email: contact@vinasa.org.vn
                    </a>
                    | 
                    <a href="https://www.vinasa.org.vn" target="_blank">
                        Website: www.vinasa.org.vn
                    </a>
                </p>

                <p>
                    Trụ sở chính:
                </p>

                <p class="p-sm">
                    Tầng 11, tòa nhà Cung Trí thức thành phố, 01 Tôn Thất Thuyết, Cầu Giấy, Hà Nội
                    <br>
                    Điện thoại: (024) 3577 2336 - 3577 2338; Fax: (024) 3577 2337
                </p>
                
                <p>
                    Văn phòng Tp. Hồ Chí Minh:
                </p>

                <p class="p-sm">
                    Tầng 4, Tòa nhà QTSC, 97-101 Nguyễn Công Trứ, P. Nguyễn Thái Bình, Q. 1, TP.HCM
                    <br>
                    Điện thoại: (028) 3821 2001
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
