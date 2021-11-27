@extends('admin.user.base')
@section('action-content')
	<!-- Main content -->
	<section class="content">
		<div class="box ">
			<div class="box-header">
				<div class="row">
					@if(Session::has('error'))
						<p class="alert {{ Session::get('alert-class', 'alert-warning') }}">{{ Session::get('error') }}
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						</p>
					@endif
					@if(Session::has('success'))
						<p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						</p>
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
							<table id="example2" class="table table-bordered table-hover dataTable" role="grid"
							       aria-describedby="example2_info">
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
{{--											<a href="{{ route('user.edit', ['id' => $item->id]) }}" class="col-sm-1 col-xs-1 btn-margin" disabled="disabled">--}}
{{--												<i class="fa fa-pencil"></i>--}}
{{--											</a>--}}
{{--											<a--}}
{{--												href="{{ route('user.destroy', ['id' => $item->id]) }}"--}}
{{--												class="col-sm-1 col-xs-1 btn-margin"--}}
{{--												onclick = "return confirm('Chắc chắn xoá?')"--}}
{{--												disabled="disabled"--}}
{{--											>--}}
{{--												<i class="fa fa-trash"></i>--}}
{{--											</a>--}}
											<a
												href="javascript:void(0);"
												class="col-sm-1 col-xs-1 btn-margin"
												onclick = "showWishList('{{ $item->id }}')"
											>
												<i class="fa fa-star"></i>
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
								@if(count($users) > 0)
								@endif
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5">
							<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1
								to {{count($users)}} of {{count($users)}} entries
							</div>
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
        <div class="modal fade" id="wishlistModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
	                <div class="modal-header" style="text-align: center; font-size: 20px;">
		                Danh sách hội thảo <span id="modalUsername" style="font-weight: bold; color: red;"></span> theo dõi
	                </div>
                    <div class="modal-body">
	                    <table id="tblWishlist" class="table table-bordered table-hover dataTable" role="grid"
	                           aria-describedby="example2_info">
		                    <thead>
		                    <tr role="row">
			                    <th>Tên hội thảo</th>
			                    <th>Ngày sự kiện</th>
			                    <th>Giờ sự kiện</th>
		                    </tr>
		                    </thead>
		                    <tbody id="listData">
		                    </tbody>
	                    </table>
                    </div>
                    <div class="modal-footer" style="text-align: center">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                            Đóng
                        </button>
                    </div>
                </div>

            </div>
        </div>
	</section>
    <script>
		function showWishList(userId) {
            $.ajax({
                url: '{{ route('seminars.getUserWishlist') }}',
                method: 'GET',
                data: {
                    userId: userId
                },
                success: function (res) {
                    if (res.code == '200') {
						let data = res.data;
                        $('#listData').html();
                        let html = '';
                        data.seminars.forEach(function(item) {
                            html += '<tr>';
                            html += '<td>' + item.name + '</td>';
                            html += '<td>' + item.event_date + '</td>';
                            html += '<td>' + item.start_time + ' ~ ' + item.end_time + '</td>';
                            html += '</tr>';
                        });
                        $('#listData').html(html);
                        $('#modalUsername').text(data.user);

                        $('#wishlistModal').modal('show');
                    }
                }
            });
		}
    </script>
	<!-- /.content -->
	</div>
@endsection