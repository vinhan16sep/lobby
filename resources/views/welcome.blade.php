@extends('layouts.app')

@section('meta')
@endsection

@section('title')
	Home
@endsection

@section('view')
    <div class="view-home" style="background-image: url('https://images.unsplash.com/photo-1551818255-e6e10975bc17?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1373&q=80')">
        <div class="overlay">
            <div class="container">
                <h1>
                    DX SUMMIT
                    <br>
                    VIETNAM 2021
                </h1>
            </div>

            <div class="links">
                <a href="#">
                    <i class="fab fa-lg fa-facebook"></i>
                </a>
                <a href="#">
                    <i class="fab fa-lg fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('scss/pages/css/home.css') }}">
@endsection

@section('js')
@endsection
