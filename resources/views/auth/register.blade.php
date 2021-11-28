@extends('layouts.app')
@section('meta')
@endsection

@section('title')
	DX Summit
@endsection
@section('view')
	<style>
		.form-group.has-error .help-block {
			color: #dd4b39;
			font-size: 12px;
		}
		.form-group.has-error .form-control {
			border-color: #dd4b39;
			box-shadow: none;
		}
	</style>
	<div class="view-home" style="background-image: url('{{ asset("public/img/Wallpaper.jpg") }}')">
		<div class="overlay">
			<div class="form-login" style="width: 60%;">
				<div class="panel panel-default" style="width: 100%;">
					<div class="panel-heading" style="font-size: 20px; font-weight: bold;">Đăng ký tài khoản</div>
					<div class="panel-body">
						<form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
							{{ csrf_field() }}
							<div class="row">
								<div class="col-md-6 col-xs-12">

									<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
										<label for="name" class="control-label">Họ tên</label>

										<input id="name" type="text" class="form-control" name="name"
										       value="{{ old('name') }}"
										       autofocus>

										@if ($errors->has('name'))
											<span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
										@endif
									</div>

									<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
										<label for="email" class="control-label">Email</label>

										<input id="email" type="email" class="form-control" name="email"
										       value="{{ old('email') }}">

										@if ($errors->has('email'))
											<span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
										@endif
									</div>

									<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
										<label for="password" class="control-label">Mật khẩu</label>

										<input id="password" type="password" class="form-control" name="password">

										@if ($errors->has('password'))
											<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
										@endif
									</div>

									<div class="form-group">
										<label for="password-confirm" class="control-label">Nhập lại mật khẩu</label>

										<input id="password-confirm" type="password" class="form-control"
										       name="password_confirmation">
										<div class="col-md-6">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-xs-12">
									<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
										<label for="phone" class="control-label">Số điện thoại</label>

										<input id="phone" type="text" class="form-control" name="phone"
										       value="{{ old('phone') }}">

										@if ($errors->has('phone'))
											<span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span>
										@endif
									</div>

									<div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
										<label for="position" class="control-label">Chức danh</label>

										<input id="position" type="text" class="form-control" name="position"
										       value="{{ old('position') }}">

										@if ($errors->has('position'))
											<span class="help-block"><strong>{{ $errors->first('position') }}</strong></span>
										@endif
									</div>

									<div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
										<label for="company" class="control-label">Đơn vị</label>

										<input id="company" type="text" class="form-control" name="company"
										       value="{{ old('company') }}">

										@if ($errors->has('company'))
											<span class="help-block"><strong>{{ $errors->first('company') }}</strong></span>
										@endif
									</div>

									<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
										<label for="address" class="control-label">Địa chỉ</label>

										<input id="address" type="text" class="form-control" name="address"
										       value="{{ old('address') }}">

										@if ($errors->has('address'))
											<span class="help-block"><strong>{{ $errors->first('address') }}</strong></span>
										@endif
									</div>
								</div>
							</div>


							<br>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Đăng ký
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('scss/pages/css/home.css') }}">
@endsection

@section('js')
@endsection
