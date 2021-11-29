<div class="seminar-cover">
	<div class="ratio-wrapper ratio-wrapper-16-9">
		<div class="img-mask">
			<img src="{{ asset('uploads/seminars/' . $seminar->image) }}" alt="{{ $seminar->name }}"/>
		</div>
	
		<div class="overlay">
			<h6>
				{{ $seminar->name }}
			</h6>
		</div>
	</div>
</div>

@if($seminar->description != null)
	<div class="seminar-desc">
		<p class="p-sm">
			{{ $seminar->description }}
		</p>
	</div>
@endif

<div class="seminar-buttons">
	<a href="javascript:;" class="btn btn-primary" onclick="window.open('{{ $seminar->link }}', '_blank')" role="button">
		Tham gia sự kiện
	</a>
	<button type="button" class="btn btn-default" data-bs-dismiss="modal" style="margin-left: 10px;">
		Đóng
	</button>
</div>



