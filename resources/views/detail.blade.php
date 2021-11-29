@extends('layouts.app')

@section('meta')
@endsection

@section('title')
	DX Summit
@endsection

@section('view')
	<style>
		.just-padding {
			padding: 15px;
		}

		.list-group.list-group-root {
			padding: 0;
			overflow: hidden;
		}

		.list-group.list-group-root .list-group {
			margin-bottom: 0;
		}

		.list-group.list-group-root .list-group-item {
			border-radius: 0;
			border-width: 1px 0 0 0;
		}

		.list-group.list-group-root > .list-group-item:first-child {
			border-top-width: 0;
		}

		.list-group.list-group-root > .list-group > .list-group-item {
			padding-left: 30px;
		}

		.list-group.list-group-root > .list-group > .list-group > .list-group-item {
			padding-left: 45px;
		}
		.per-info span {
			font-size: 16px;
		}
	</style>
	<div class="view-dashboard">
		<div class="dashboard-wrapper">
			<div class="list-events" style="width:100%;">
				<div class="card">
					<div class="card-header" style="height:300px;">
						<div class="header-left">
							<h6 class="subtitle-md">
								Thông tin cá nhân
							</h6>
							<form style="padding-left: 18px;">
								<div class="row">
									<div class="col-4">
										<div class="row">
										<label class="col-form-label"><i class="fa fa-user" aria-hidden="true"></i> Họ tên</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
										</div>
										</div>
									</div>
									<div class="col-4">
										<div class="row">
										<label class="col-form-label"><i class="fa fa-mail-bulk" aria-hidden="true"></i> Email</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" value="{{ Auth::user()->email }}" disabled>
										</div>
										</div>
									</div>
									<div class="col-4">
										<div class="row">
											<label class="col-form-label"><i class="fa fa-phone" aria-hidden="true"></i> Điện thoại</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" value="{{ Auth::user()->phone }}" disabled>
											</div>
										</div>
									</div>
									<!-- Force next columns to break to new line at md breakpoint and up -->
									<div class="w-100 d-none d-md-block"></div>
									<div class="col-4">
										<div class="row">
											<label class="col-form-label"><i class="fa fa-industry" aria-hidden="true"></i> Đơn vị</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" value="{{ Auth::user()->company }}" disabled>
											</div>
										</div>
									</div>
									<div class="col-4">
										<div class="row">
											<label class="col-form-label"><i class="fa fa-portrait" aria-hidden="true"></i> Vị trí</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" value="{{ Auth::user()->position }}" disabled>
											</div>
										</div>
									</div>
									<!-- Force next columns to break to new line at md breakpoint and up -->
									<div class="w-100 d-none d-md-block"></div>
									<div class="col-12">
										<div class="row">
											<label class="col-form-label"><i class="fa fa-address-book" aria-hidden="true"></i> Địa chỉ</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" value="{{ Auth::user()->position }}" disabled>
											</div>
										</div>
									</div>
								</div>
{{--								<div class="row mb-3">--}}
{{--									<label class="col-sm-1 col-form-label"><i class="fa fa-user" aria-hidden="true"></i></label>--}}
{{--									<div class="col-sm-8">--}}
{{--										<input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>--}}
{{--									</div>--}}
{{--								</div>--}}
{{--								<div class="row mb-3">--}}
{{--									<label class="col-sm-1 col-form-label"><i class="fa fa-mail-bulk" aria-hidden="true"></i></label>--}}
{{--									<div class="col-sm-8">--}}
{{--										<input type="text" class="form-control" value="{{ Auth::user()->email }}" disabled>--}}
{{--									</div>--}}
{{--								</div>--}}
							</form>
{{--							<div class="form-group">--}}
{{--								<label><i class="fa fa-user" aria-hidden="true"></i></label>--}}
{{--								<input class="form-control" value="{{ Auth::user()->name }}" disabled />--}}
{{--							</div>--}}
{{--							<p class="p-sm per-info">--}}
{{--								<i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }}--}}
{{--							</p>--}}
{{--							<p class="p-sm per-info">--}}
{{--								<i class="fa fa-mail-bulk" aria-hidden="true"></i> {{ Auth::user()->email }}--}}
{{--							</p>--}}
{{--							<p class="p-sm per-info">--}}
{{--								<i class="fa fa-phone" aria-hidden="true"></i> </span> {{ Auth::user()->phone }}--}}
{{--							</p>--}}
{{--							<p class="p-sm per-info">--}}
{{--								<span style="color: black;">Đơn vị:</span> {{ Auth::user()->company }}--}}
{{--							</p>--}}
{{--							<p class="p-sm per-info">--}}
{{--								<span style="color: black;">Chức danh:</span> {{ Auth::user()->position }}--}}
{{--							</p>--}}
{{--							<p class="p-sm per-info">--}}
{{--								<span style="color: black;">Địa chỉ:</span> {{ Auth::user()->address }}--}}
{{--							</p>--}}
						</div>
					</div>
					<div class="card-header" style="height: 500px;">
						<div class="header-left" style="width: 100%;">
							<h6 class="subtitle-md">
								Danh sách hội thảo đang theo dõi
							</h6>
							<div class="just-padding"
							     style="height: 1000px;max-height: 450px;overflow: auto;width:100%">
								<div class="list-group">
									@foreach ($eventDays as $dKey => $eventDay)
										@php
											$date = new DateTime($eventDay->event_date);
											$dateTxt = $date->format('l');
											$convertArr = [
												'Sunday' => 'Chủ Nhật',
												'Monday' => 'Thứ Hai',
												'Tuesday' => 'Thứ Ba',
												'Wednesday' => 'Thứ Tư',
												'Thursday' => 'Thứ Năm',
												'Friday' => 'Thứ Sáu',
												'Saturday' => 'Thứ Bảy'
											];
											$rawDate = $eventDay->event_date;
											$fDate = $convertArr[$dateTxt] . ', ' . date('d-m-Y', strtotime($eventDay->event_date));
										@endphp
										@if ($eventDay->eventTimes)
											@foreach ($eventDay->eventTimes as $tKey => $eventTime)
												@if ($eventTime->is_active == 1)
													@php
														$fTime = $eventTime->start_time . '~' . $eventTime->end_time;

														$timezone = 'Asia/Ho_Chi_Minh';
														$tFrom = new DateTime($rawDate . ' ' . $eventTime->start_time . ':00', new DateTimeZone($timezone));
														$tFromInt = $tFrom->format('U');
														$tTo = new DateTime($rawDate . ' ' . $eventTime->end_time . ':00', new DateTimeZone($timezone));
														$tToInt = $tTo->format('U');
														$currentTime = time();
													@endphp
													@if ($eventTime->seminars)
														@foreach ($eventTime->seminars as $sKey => $seminar)
															@if ($seminar->is_active == 1 && !empty($seminarArr) && in_array($seminar->id, $seminarArr))
																<div class="row">
																	<div class="col-md-8">
																		<p href="#" class="list-group-item">
																			<i class="fa fa-clock" aria-hidden="true"></i>
																			{{ $fDate . ' ' . $fTime . ' ' . $seminar->name }}
																		</p>
																	</div>
																	<div class="col-md-2">
																		<button class="form-control" onclick="getSeminarDetail('{{ $seminar->id }}')">Thông tin</button>
																	</div>
																	<div class="col-md-2">
																		@if ($tFromInt <= $currentTime && $currentTime <= $tToInt)
																			<button class="form-control btn btn-success" onclick="window.open('{{ $seminar->link }}', '_blank')">Đang diễn ra <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
																		@elseif ($currentTime < $tFromInt)
																			<button class="form-control btn btn-default" disabled>Chưa diễn ra</button>
																		@elseif ($tToInt < $currentTime)
																			<button class="form-control btn btn-danger" disabled>Đã kết thúc</button>
																		@endif
																	</div>
																</div>
															@endif
														@endforeach
													@endif
												@endif
											@endforeach
										@endif
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modalSeminarDetail" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">

				</div>
			</div>
		</div>
	</div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('scss/pages/css/dashboard.css?v=').time() }}">
@endsection

@section('js')
	<script src="{{ asset('js/home/function.js?v=').time() }}"></script>
@endsection