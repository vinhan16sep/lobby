@extends('admin.event-times.base')
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
						<a class="btn btn-primary" href="{{ route('event-times.create') }}">Thêm mới giờ sự kiện</a>
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
									<th>Giờ sự kiện</th>
									<th>Ngày sự kiện</th>
									<th>Sử dụng?</th>
									<th>Hành động</th>
								</tr>
								</thead>
								<tbody>
								@foreach ($eventTimes as $item)
									<tr role="row" class="odd">
										<td class="sorting_1">{{ $item->start_time }} ~ {{ $item->end_time }}</td>
										<td class="sorting_1">{{ $item->eventDay->event_date }}</td>
										@if($item->is_active != 0)
											<td class="hidden-xs"><span class="glyphicon glyphicon-ok" style="color: green;"></span></td>
										@else
											<td class="hidden-xs"></td>
										@endif
										<td>
											<a href="{{ route('event-times.edit', ['id' => $item->id]) }}" class="col-sm-1 col-xs-1 btn-margin">
												<i class="fa fa-pencil"></i>
											</a>
											<a
												href="{{ route('event-times.destroy', ['id' => $item->id]) }}"
												class="col-sm-1 col-xs-1 btn-margin"
												onclick = "return confirm('Chắc chắn xoá?')"
											>
												<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
								@endforeach
								</tbody>
								@if(count($eventTimes) > 0)
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
								to {{count($eventTimes)}} of {{count($eventTimes)}} entries
							</div>
						</div>
						<div class="col-sm-7">
							<div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
								{{ $eventTimes->links() }}
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