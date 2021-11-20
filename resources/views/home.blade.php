@extends('layouts.app')


@section('meta')
@endsection

@section('title')
	Dashboard
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
				<ul class="nav nav-tabs" id="eventTabs" role="tablist">

					@foreach ($eventDays as $dKey => $eventDay)
						<li class="nav-item" role="presentation">
							<button class="nav-link {{ $dKey == 0 ? 'active' : '' }}" id="btnTab_{{ $dKey + 1  }}"
							        data-bs-toggle="tab" data-bs-target="#tab_{{ $dKey + 1  }}"
							        type="button" role="tab" aria-controls="tab_{{ $dKey + 1  }}" aria-selected="true">
								{{ $eventDay->event_date  }}
							</button>
						</li>
					@endforeach
				</ul>
				<div class="tab-content" id="eventTabsContent">
					@foreach ($eventDays as $dKey => $eventDay)
						<div class="tab-pane fade {{ $dKey == 0 ? 'show active' : '' }}" id="tab_{{ $dKey + 1  }}"
						     role="tabpanel" aria-labelledby="btnTab_{{ $dKey + 1  }}">
							<div class="event-schedule">
								@if ($eventDay->eventTimes)
									@foreach ($eventDay->eventTimes as $tKey => $eventTime)
										<div class="event-item">
											<div class="event-time">
												<h6 class="subtitle-md">
													{{ $eventTime->start_time }} - {{ $eventTime->end_time }}
												</h6>
											</div>
											<div class="event-content">
												@if ($eventTime->seminars)
													@foreach ($eventTime->seminars as $sKey => $seminar)
														<div class="item-event">
															<div class="ratio-wrapper ratio-wrapper-4-3">
																<div class="overlay">
																	<h6 class="subtitle-sm">
																		{{ $seminar->name }}
																	</h6>

																	<p class="p-sm">
																		{{ $seminar->description }}
																	</p>
																</div>

																<div class="img-mask">
																	<img src="{{ asset('uploads/seminars/' . $seminar->image) }}"
																	     width="300" height="200"
																	     alt="{{ $seminar->name }}"/>
																</div>
															</div>

															<div class="controls">
																@if (!empty($seminarArr) && in_array($seminar->id, $seminarArr))
																	<button class="btn btn-outline-default"
																	        type="button" disabled>
																		Followed
																	</button>
																@else
																	<button class="btn btn-outline-default"
																	        type="button"
																	        onclick="addToWishlist('{{ $seminar->id }}')">
																		Follow
																	</button>
																@endif
																<button class="btn btn-outline-default" type="button">
																	Detail
																</button>
																<button class="btn btn-primary" type="button"
																        onclick="window.open('{{ $seminar->link }}', '_blank')">
																	Join Event
																</button>
															</div>
														</div>
													@endforeach
												@endif
											</div>
										</div>
									@endforeach
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>

			<div class="chat-area">
				<div class="chat-box chat-public">
					<div class="card">
						<div class="card-body">
							<div class="list-users-wrapper">
								<div class="list-users" id="appendListUsers"></div>
							</div>

							<div class="chat-append append-message"></div>
						</div>

						<div class="card-footer">
							<input type="text" class="form-control input-message"
							       placeholder="Type something to send...">

							<button class="btn btn-primary btn-send-message" type="button">
								Send
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
							       placeholder="Type something to send...">

							<button class="btn btn-primary btn-send-message" type="button">
								Send
							</button>
						</div>
					</div>
				</div>

				<a href="#" class="select-user select-user-prepare" style="display: none">
					<div class="img-mask img-mask-circle">
						<img src="" alt="">
					</div>

					<div class="status">
						<div class="circle"></div>
					</div>
				</a>
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
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				</div>
			</div>

		</div>
	</div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('scss/pages/css/dashboard.css') }}">
@endsection

@section('js')
	<script src="{{ asset('js/home/function.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
	<script>
        const SOCKET_URL = '{{ env('SOCKET_URL') }}';
        const userId = '{{ $userId }}';
	</script>
	<script src="{{ asset('js/socket/socket_client.js') }}"></script>

	<script type="text/javascript">
        function addToWishlist(seminarId) {
            $.ajax({
                url: '{{ route('home.addToWishlist') }}',
                method: 'GET',
                data: {
                    seminarId: seminarId
                },
                success: function (res) {
					if (res.code == '200') {
                        $('#followSuccessModal').modal('show');
                    }
                },
            });
        }
	</script>

@endsection