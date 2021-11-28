@extends('layouts.app')

@section('meta')
@endsection

@section('title')
	DX Summit
@endsection

@section('view')
    <div class="view-home" style="background-image: url('{{ asset("public/img/Wallpaper.jpg") }}')">
        <div class="overlay">
            <div class="form-login">
                <div class="panel panel-default">
                    <div class="row">
                        @if(Session::has('error'))
                            <p class="alert {{ Session::get('alert-class', 'alert-warning') }}">{{ Session::get('error') }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                        @endif
                        @if(Session::has('success'))
                            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                        @endif
                    </div>
                    <div class="panel-heading">Đăng nhập</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
    
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">Địa chỉ email</label>
    
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
    
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">Mật khẩu</label>
    
                                <input id="password" type="password" class="form-control" name="password" required>
    
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            {{-- <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
    
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button class="btn btn-block btn-primary" type="submit">
                                        Đăng nhập
                                    </button>
    
                                    {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a> --}}
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
