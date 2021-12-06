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
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css?v=').time() }}">
	<link rel="stylesheet" href="{{ asset('scss/css/min/app.min.css?v=').time() }}">
	<link rel="stylesheet" href="{{ asset('scss/pages/css/min/style.min.css?v=').time() }}">

	@yield('css')
</head>
<body>
	{{-- <div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=395331708002882&autoLogAppEvents=1" nonce="FlNjZkkw"></script>

	<div class="fb-page" data-href="https://www.facebook.com/vinasavn/" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/vinasavn/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/vinasavn/">VINASA</a></blockquote></div> --}}

	<!-- FACEBOOK CHAT START -->
	<!--
	<div id="fb-root"></div>
    <script>
		window.fbAsyncInit = function() {
		FB.init({
			xfbml            : true,
			version          : 'v8.0'
		});
		};

		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

	<div class="fb-customerchat"
        attribution=setup_tool
        page_id="395331708002882"
        theme_color="#ff3c00">
    </div>
	-->
	<!-- FACEBOOK CHAT END -->

	<div class="page">
		<div class="page-header">
			<header>
				<div class="header-brand">
					<a href="{{ route('home') }}">
						<img src="{{ asset('img/logo_w.svg') }}" alt="Logo">
					</a>
				</div>

				<div class="header-menu">
					@if (last(request()->segments()) != '' && last(request()->segments()) != 'register')
						<a href="https://dxsummit.vn/gian-hang-trien-lam/" class="btn" target="_blank">
							Triển lãm
						</a>
						<a href="https://dxsummit.vn/dien-gia-2/" class="btn" target="_blank">
							Diễn giả
						</a>
						<a href="https://dxsummit.vn/chuong-trinh/" class="btn" target="_blank">
							Chương trình
						</a>

						<div class="dropdown">
							<button class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"
									style="{{ (last(request()->segments()) != 'home' && last(request()->segments()) != 'detail') ? 'color: var(--text-subtitle);' : '' }}">
								Kết nối
							</button>

							<div class="dropdown-menu dropdown-menu-end">
								<a href="https://vinasa.org.vn/vinasa/4/3074/4336/dang-ky-hoi-vien-vinasa/" class="dropdown-item" target="_blank">
									Đăng ký hội viên VINASA
								</a>
								<a href="https://danhbaict.vn/" class="dropdown-item" target="_blank">
									Danhbaict.vn
								</a>
								<a href="https://connect.vinasa.org.vn/" class="dropdown-item" target="_blank">
									VINASA Connect
								</a>
								<a href="https://docs.google.com/forms/d/e/1FAIpQLSfzVp3HCOUeCi3miyWReONCTKhbOMdFLGZWXGd9KHLnI3T20g/viewform" class="dropdown-item" target="_blank">
									Kết nối với Invest Hong Kong
								</a>
								<a href="https://docs.google.com/forms/d/e/1FAIpQLScBXjD9SZ4R4Hu_gAMxRvnkTK9wdPd6uWyqAGRah85W1-Kdow/viewform" class="dropdown-item" target="_blank">
									Gặp gỡ DN Đài Loan
								</a>
								<a href="https://academy.vinasa.org.vn/dang-ky/" class="dropdown-item" target="_blank">
									Đào tạo CN mới và CĐS
								</a>
								<a href="https://mdx.vinasa.org.vn/tu-van/" class="dropdown-item" target="_blank">
									Tư vấn Khung CĐS sản xuất
								</a>
							</div>
						</div>
					@endif

					@if (!Auth::user())
						@if (last(request()->segments()) == 'register')
							<a href="{{ route('default') }}" class="btn btn-primary">
								Đăng nhập
							</a>
						@else
							<a href="{{ route('register') }}" class="btn btn-primary">
								Đăng ký
							</a>
						@endif
					@endif
				</div>


				@if (!Auth::guest())
					<div class="header-user">
						<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>

						<div class="dropdown">
							<button class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button">
								<div class="user-info">
									<div class="img-mask img-mask-circle">
										<img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
											alt="Avatar of {{ Auth::user()->name }}">
									</div>

									<h6 class="subtitle-md">
										{{ Auth::user()->email }}
									</h6>
								</div>
							</button>

							<div class="dropdown-menu dropdown-menu-end">
								<a href="{{ route('detail') }}" class="dropdown-item">
									<i class="fas fa-user"></i> Thông tin tài khoản
								</a>
								<a href="#" class="dropdown-item btn-logout">
									<i class="fas fa-sign-out-alt"></i> Đăng xuất
								</a>
							</div>
						</div>
					</div>
				@endif


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
			{{-- <footer>
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
			</footer> --}}
		</div>
	</div>

<script src="{{ asset('plugins/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<script src="{{ asset('js/function.js?v=').time() }}"></script>
@yield('js')
</body>
</html>
