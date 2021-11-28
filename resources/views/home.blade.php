@extends('layouts.app')

@section('meta')
@endsection

@section('title')
	DX Summit
@endsection

@section('view')
	<div class="view-dashboard">
		<div class="dashboard-wrapper">
			<div class="user-info-wrapper user-info-wrapper-prepare" style="display: none">
				<div class="card">
					<div class="card-body">
						<div class="user-info">
							<div class="img-mask img-mask-circle user-avatar">
								<img src="" alt="">
							</div>

							<div class="text">
								<h6 class="subtitle-md user-name">
									User name
								</h6>

								<p class="p-sm user-position">
									User Position
								</p>
								<p class="p-sm user-company">
									User Company
								</p>

								<button class="btn btn-primary btn-call-chat" type="button">
									Chat
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="list-events">
				<div class="card">
					<div class="card-header">
						<h6 class="subtitle-md">
							Danh sách hội thảo
						</h6>
					</div>
					<div class="card-body">
						<ul class="nav nav-pills" id="eventTabs" role="tablist">
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
								@endphp
								<li class="nav-item" role="presentation">
									<button class="nav-link {{ $dKey == 0 ? 'active' : '' }}"
									        id="btnTab_{{ $dKey + 1  }}"
									        data-bs-toggle="tab" data-bs-target="#tab_{{ $dKey + 1  }}"
									        type="button" role="tab" aria-controls="tab_{{ $dKey + 1  }}"
									        aria-selected="true">
										{{ $convertArr[$dateTxt] }}
										, {{ date('d-m-Y', strtotime($eventDay->event_date))  }}
									</button>
								</li>
							@endforeach
						</ul>
						<div class="tab-content" id="eventTabsContent">
							@foreach ($eventDays as $dKey => $eventDay)
								<div class="tab-pane fade {{ $dKey == 0 ? 'show active' : '' }}"
								     id="tab_{{ $dKey + 1  }}"
								     role="tabpanel" aria-labelledby="btnTab_{{ $dKey + 1  }}">
									<div class="event-schedule">
										@if ($eventDay->eventTimes)
											@foreach ($eventDay->eventTimes as $tKey => $eventTime)
												@if ($eventTime->is_active == 1)
													<div class="event-item">
														<div class="event-time">
															<h6 class="subtitle-md">
																{{ $eventTime->start_time }}
																- {{ $eventTime->end_time }}
															</h6>
														</div>
														<div class="event-content">
															@if ($eventTime->seminars)
																@foreach ($eventTime->seminars as $sKey => $seminar)
																	@if ($seminar->is_active == 1)
																		<div class="item-event">
																			<div class="ratio-wrapper ratio-wrapper-16-9">
																				<div class="overlay">
																					<h6 class="subtitle-md">
																						{{ $seminar->name }}
																					</h6>

																					<div class="controls">
																						@if (!empty($seminarArr) && in_array($seminar->id, $seminarArr))
																							<button class="btn btn-outline-light"
																							        id="btn-{{ $seminar->id }}"
																							        type="button"
																							        disabled>
																								Đã theo dõi
																							</button>
																						@else
																							<button class="btn btn-outline-light"
																							        id="btn-{{ $seminar->id }}"
																							        type="button"
																							        onclick="addToWishlist('{{ $seminar->id }}')">
																								Theo dõi
																							</button>
																						@endif
																						<button class="btn btn-outline-light"
																						        type="button"
																						        onclick="getSeminarDetail('{{ $seminar->id }}')">
																							Chi tiết
																						</button>
																						<button class="btn btn-primary"
																						        type="button"
																						        onclick="window.open('{{ $seminar->link }}', '_blank')">
																							Tham gia sự kiện
																						</button>
																					</div>
																				</div>

																				<div class="img-mask">
																					<img src="{{ asset('uploads/seminars/' . $seminar->image) }}"
																					     width="300" height="200"
																					     alt="{{ $seminar->name }}"/>
																				</div>
																			</div>
																		</div>
																	@endif
																@endforeach
															@endif
														</div>
													</div>
												@endif
											@endforeach
										@endif
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>

			<div class="chat-area">
				<div class="chat-box chat-public">
					<div class="card">
						<div class="card-header">
							<h6 class="subtitle-md">
								Trao đổi - Kết nối
							</h6>
						</div>
						<div class="card-body">
							<div class="list-users-wrapper">
								<div class="list-users" id="appendListUsers"></div>
							</div>

							<div class="chat-append append-message"></div>
						</div>

						<div class="card-footer">
							<input type="text" class="form-control input-message"
							       placeholder="Nội dung tin nhắn ...">

							<button class="btn btn-primary btn-send-message" type="button">
								Gửi
							</button>
						</div>
					</div>
				</div>

				<div class="chat-box chat-private">
					<div class="card">
						<div class="card-header">
							<h6 class="subtitle-md"></h6>

							<button class="btn btn-close-chat" type="button">
								<i class="fas fa-times"></i>
							</button>
						</div>
						<div class="card-body">
							<div class="chat-append append-message"></div>
						</div>
						<div class="card-footer">
							<input type="text" class="form-control input-message"
							       placeholder="Nội dung tin nhắn ...">

							<button class="btn btn-primary btn-send-message" type="button">
								Gửi
							</button>
						</div>
					</div>
				</div>

				<div class="select-user-item select-user-prepare" style="display: none">
					<a href="#" class="select-user">
						<div class="img-mask-wrapper">
							<div class="img-mask img-mask-circle">
								<img src="" alt="">
							</div>

							<div class="unread" style="display: none">
								<div class="circle">
									1
								</div>
							</div>

							<div class="status">
								<div class="circle"></div>
							</div>
						</div>

						<h6 class="subtitle-sm"></h6>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="followSuccessModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<p>Bạn đã đăng ký theo dõi hội thảo thành công</p>
				</div>
				<div class="modal-footer" style="text-align: center">
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">
						Đóng
					</button>
				</div>
			</div>

		</div>
	</div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('scss/pages/css/dashboard.css?v=').time() }}">
@endsection

@section('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
	<script>
        const SOCKET_URL = '{{ config('env.SOCKET_URL') }}';
        const currentUser = {
            id: '{{ $userId }}',
            name: '{{ $userName }}',
            company: '{{ $userCompany }}',
            position: '{{ $userPosition }}'
        };
	</script>
	<script src="{{ asset('js/home/socket_client.js?v=').time() }}"></script>
	<script src="{{ asset('js/home/function.js?v=').time() }}"></script>
@endsection