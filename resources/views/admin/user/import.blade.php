@extends('admin.user.base')

@section('action-content')
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Thêm mới ngày sự kiện</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('user.doImport') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="file" class="form-control">
                            <br>
                            <button class="btn btn-success">Import User Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
