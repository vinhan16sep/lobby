@extends('admin.layouts.app-template')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Quản lý ngày sự kiện
            </h1>
            <ol class="breadcrumb">
                <!-- li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li-->
                {{--<li class="active">Product Mangement</li>--}}
            </ol>
        </section>
    @yield('action-content')
    <!-- /.content -->
    </div>
@endsection
<script src="{{ asset ("public/admin/js/product.js") }}" type="text/javascript"></script>