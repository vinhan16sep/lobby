@extends('admin.seminars.base')
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
						<a class="btn btn-primary" href="{{ route('seminars.create') }}">Thêm mới hội thảo</a>
					</div>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
					<div class="row">
						<div class="col-sm-12">
							<table id="example2" class="table table-bordered table-hover dataTable" role="grid"
							       aria-describedby="example2_info">
								<thead>
								<tr role="row">
									<th>ID</th>
									<th>Ảnh</th>
									<th>Tên hội thảo</th>
									<th>Ngày sự kiện</th>
									<th>Giờ sự kiện</th>
                                    <th>Hội thảo chính?</th>
									<th>Sử dụng?</th>
									<th>Hành động</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($seminars as $item)
									<tr role="row" class="odd">
										<td class="sorting_1">{{ $item->id }}</td>
										<td class="sorting_1"><img src="{{ asset('uploads/seminars/' . $item->image) }}" width="300" height="200" /></td>
										<td class="sorting_1">{{ $item->name }}</td>
										<td class="sorting_1">{{ $item->eventDay->event_date }}</td>
										<td class="sorting_1">{{ $item->eventTime->start_time }} ~ {{ $item->eventTime->end_time }}</td>
                                        @if($item->is_main != 0)
                                            <td class="hidden-xs"><span class="glyphicon glyphicon-ok" style="color: green;"></span></td>
                                        @else
                                            <td class="hidden-xs"></td>
                                        @endif
										@if($item->is_active != 0)
											<td class="hidden-xs"><span class="glyphicon glyphicon-ok" style="color: green;"></span></td>
										@else
											<td class="hidden-xs"></td>
										@endif
										<td>
											<a href="{{ route('seminars.edit', ['id' => $item->id]) }}" class="col-sm-1 col-xs-1 btn-margin">
												<i class="fa fa-pencil"></i>
											</a>
											<a
												href="{{ route('seminars.destroy', ['id' => $item->id]) }}"
												class="col-sm-1 col-xs-1 btn-margin"
												onclick = "return confirm('Chắc chắn xoá?')"
											>
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
								@if(count($seminars) > 0)
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
							<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1
								to {{count($seminars)}} of {{count($seminars)}} entries
							</div>
						</div>
						<div class="col-sm-7">
							<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
								{{ $seminars->links() }}
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