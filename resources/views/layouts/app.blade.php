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
	<!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "281491382864");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v12.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

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
							Tri???n l??m
						</a>
						<a href="https://dxsummit.vn/dien-gia-2/" class="btn" target="_blank">
							Di???n gi???
						</a>
						<a href="https://dxsummit.vn/chuong-trinh/" class="btn" target="_blank">
							Ch????ng tr??nh
						</a>
						<a href="https://edtvn-my.sharepoint.com/:f:/g/personal/vinasa_edt_com_vn/EitvM51fED5PprReOMuko-4Bn-83M6tYMbhm2OrKp4bQUg?e=T3QXWi" class="btn" target="_blank">
							Download
						</a>

						<div class="dropdown">
							<button class="btn dropdown-toggle" data-bs-toggle="dropdown" type="button"
									style="{{ (last(request()->segments()) != 'home' && last(request()->segments()) != 'detail') ? 'color: var(--text-subtitle);' : '' }}">
								K???t n???i
							</button>

							<div class="dropdown-menu dropdown-menu-end">
								<a href="https://vinasa.org.vn/vinasa/4/3074/4336/dang-ky-hoi-vien-vinasa/" class="dropdown-item" target="_blank">
									????ng k?? h???i vi??n VINASA
								</a>
								<a href="https://danhbaict.vn/" class="dropdown-item" target="_blank">
									Danhbaict.vn
								</a>
								<a href="https://connect.vinasa.org.vn/" class="dropdown-item" target="_blank">
									VINASA Connect
								</a>
								<a href="https://docs.google.com/forms/d/e/1FAIpQLSfzVp3HCOUeCi3miyWReONCTKhbOMdFLGZWXGd9KHLnI3T20g/viewform" class="dropdown-item" target="_blank">
									K???t n???i v???i Invest Hong Kong
								</a>
								<a href="https://docs.google.com/forms/d/e/1FAIpQLScBXjD9SZ4R4Hu_gAMxRvnkTK9wdPd6uWyqAGRah85W1-Kdow/viewform" class="dropdown-item" target="_blank">
									G???p g??? DN ????i Loan
								</a>
								<a href="https://academy.vinasa.org.vn/dang-ky/" class="dropdown-item" target="_blank">
									????o t???o CN m???i v?? C??S
								</a>
								<a href="https://mdx.vinasa.org.vn/tu-van/" class="dropdown-item" target="_blank">
									T?? v???n Khung C??S s???n xu???t
								</a>
							</div>
						</div>
					@endif

					@if (!Auth::user())
						@if (last(request()->segments()) == 'register')
							<a href="{{ route('default') }}" class="btn btn-primary">
								????ng nh???p
							</a>
						@else
							<a href="{{ route('register') }}" class="btn btn-primary">
								????ng k??
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
									<i class="fas fa-user"></i> Th??ng tin t??i kho???n
								</a>
								<a href="#" class="dropdown-item btn-logout">
									<i class="fas fa-sign-out-alt"></i> ????ng xu???t
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
					?? HI???P H???I PH???N M???M & D???CH V??? CNTT VI???T NAM (VINASA)
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
					Tr??? s??? ch??nh:
				</p>

				<p class="p-sm">
					T???ng 11, t??a nh?? Cung Tr?? th???c th??nh ph???, 01 T??n Th???t Thuy???t, C???u Gi???y, H?? N???i
					<br>
					??i???n tho???i: (024) 3577 2336 - 3577 2338; Fax: (024) 3577 2337
				</p>

				<p>
					V??n ph??ng Tp. H??? Ch?? Minh:
				</p>

				<p class="p-sm">
					T???ng 4, T??a nh?? QTSC, 97-101 Nguy???n C??ng Tr???, P. Nguy???n Th??i B??nh, Q. 1, TP.HCM
					<br>
					??i???n tho???i: (028) 3821 2001
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
