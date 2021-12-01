@extends('layouts.app')

@section('meta')
@endsection

@section('title')
	DX Summit
@endsection

@section('view')
    <div class="view-home">
        <div class="row g-0">
            <div class="col-md-8">
                <div class="img-mask">
                    <img src="{{ asset("img/banner_login.jpg?v=").time() }}" alt="Banner of Login">
                </div>
            </div>

            <div class="col-md-4">
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
        
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button class="btn btn-block btn-primary" type="submit">
                                            Đăng nhập
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('scss/pages/css/home.css?v=').time() }}">
@endsection

@section('js')
@endsection
