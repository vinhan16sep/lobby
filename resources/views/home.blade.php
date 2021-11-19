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
					<li class="nav-item" role="presentation">
					  	<button class="nav-link active" id="btnTab_1" data-bs-toggle="tab" data-bs-target="#tab_1" type="button" role="tab" aria-controls="tab_1" aria-selected="true">
							  Web 17/11/2021
						  </button>
					</li>
					<li class="nav-item" role="presentation">
					  	<button class="nav-link" id="btnTab_2" data-bs-toggle="tab" data-bs-target="#tab_2" type="button" role="tab" aria-controls="tab_2" aria-selected="false">
							  Thu 18/11/2021
						  </button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="btnTab_3" data-bs-toggle="tab" data-bs-target="#tab_3" type="button" role="tab" aria-controls="tab_3" aria-selected="false">
							Fri 19/11/2021
						</button>
				  </li>
				</ul>
				<div class="tab-content" id="eventTabsContent">
					<div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="btnTab_1">
						<div class="event-schedule">
							@for ($i = 0; $i < 5; $i++)
								<div class="event-item">
									<div class="event-time">
										<h6 class="subtitle-md">
											8h30 - 10h00
										</h6>
									</div>

									<div class="event-content">
										@for ($j = 0; $j < 3; $j++)
											<div class="item-event">
												<div class="ratio-wrapper ratio-wrapper-4-3">
													<div class="overlay">
														<h6 class="subtitle-sm">
															Event name
														</h6>

														<p class="p-sm">
															Nulla faucibus ligula mauris, non lacinia odio interdum eget. Praesent justo ipsum, imperdiet eu finibus vitae, tincidunt ut sem. Suspendisse auctor tellus eget erat posuere facilisis.
														</p>
													</div>
													
													<div class="img-mask">
														<img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80" alt="">
													</div>
												</div>

												<div class="controls">
													<button class="btn btn-outline-default" type="button">
														Detail
													</button>
													<button class="btn btn-outline-default" type="button">
														Detail
													</button>
													<button class="btn btn-primary" type="button">
														Join Event
													</button>
												</div>
											</div>
										@endfor
									</div>
								</div>
							@endfor
						</div>
					</div>
					<div class="tab-pane fade" id="tab_2" role="tabpanel" aria-labelledby="btnTab_2">
						
					</div>
					<div class="tab-pane fade" id="tab_3" role="tabpanel" aria-labelledby="btnTab_3">
						
					</div>
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
							<input type="text" class="form-control input-message" placeholder="Type something to send...">

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
							<input type="text" class="form-control input-message" placeholder="Type something to send...">

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
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('scss/pages/css/dashboard.css') }}">
@endsection

@section('js')
	<script src="{{ asset('js/home/function.js') }}"></script>
@endsection