@extends('admin.blog-category.base')

@section('action-content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Cập nhật danh mục sản phẩm</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('blog-category.update', ['id' => $detail['id']]) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">Tên danh mục</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ $detail['title'] }}" required autofocus>

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Slug</label>

                                <div class="col-md-6">
                                    <input id="slug" type="text" class="form-control" name="slug" value="{{ $detail['slug'] }}" required readonly>

                                    @if ($errors->has('slug'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('slug') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="is_active" value="0">
                            <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                <label for="is_active" class="col-md-4 control-label">Dùng danh mục?</label>

                                <div class="col-md-6">
                                    <input id="is_active" type="checkbox" class="minimal" name="is_active" value="1"
                                           @if($detail['is_active'] == 1)
                                           checked
                                            @endif
                                    >
                                    @if ($errors->has('is_active'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_active') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="avatar" class="col-md-4 control-label" >Hình ảnh đang dùng</label>
                                <div class="col-md-6">
                                    <img src="{{ asset('storage/app/'. $detail['image']) }}" width="150">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="avatar" class="col-md-4 control-label" >Hình ảnh</label>
                                <div class="col-md-6">
                                    <input type="file" id="image" name="image" >
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Giới thiệu ngắn</label>

                                <div class="col-md-6">
                                    <textarea id="description" rows="10" class="form-control" name="description" value="{{ $detail['description'] }}">{{ $detail['description'] }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        OK
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
