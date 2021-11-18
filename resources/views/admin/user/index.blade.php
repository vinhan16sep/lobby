@extends('admin.user.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box ">
  <div class="box-header">
    <div class="row">
          @if(Session::has('error'))
            <p class="alert {{ Session::get('alert-class', 'alert-warning') }}">{{ Session::get('error') }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
          @endif
          @if(Session::has('success'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
          @endif
        <div class="col-sm-4">
          <a class="btn btn-primary" href="javascript:void(0);" disabled="disabled">Thêm mới user</a>
          <a class="btn btn-primary" href="{{ route('user.import') }}">Import user</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      {{-- <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('user.search') }}">
         {{ csrf_field() }}
         @component('admin.layouts.search', ['title' => 'Tìm kiếm'])
          @component('admin.user.search-panel.two-cols-search-row', ['items' => ['Name'],
          'oldVals' => [isset($searchingVals) ? $searchingVals['title'] : '']])
          @endcomponent
          <br>
        @endcomponent
      </form> --}}
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th>Họ tên</th>
                <th>Email</th>
                <th>Hành động</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($users as $item)
                <tr role="row" class="odd">
                  <td class="sorting_1">{{ $item->name }}</td>
                  <td class="sorting_1">{{ $item->email }}</td>
                  <td>
                    <form class="row" method="POST" action="{{ route('user.destroy', ['id' => $item->id]) }}" onsubmit = "return confirm('Chắc chắn xoá?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="javascript:void(0);" disabled="disabled" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                        Sửa
                        </a>
{{--                        @if ($user->username != Auth::user()->username)--}}
                        <button type="submit" href="javascript:void(0);" disabled="disabled" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                          Xoá
                        </button>
                        {{--@endif--}}
                    </form>
                  </td>
              </tr>
            @endforeach
            </tbody>
            @if(count($users) > 0)
            {{-- <tfoot>
              <tr>
                <th>Tên danh mục</th>
                <th>Sử dụng?</th>
                <th>Hành động</th>
              </tr>
            </tfoot> --}}
            @endif
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($users)}} of {{count($users)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $users->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  </div>
@endsection