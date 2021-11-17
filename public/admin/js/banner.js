$('.show-btn-active').on('click', '.btn-deactive-banner', function(){
	var check = $(this);
	if(confirm('Chắc chắn tắt banner này')){
		var url = $(this).data('url');
		var id = $(this).data('id');
		var token = $('#token').val();
        $.ajax({
            url: url + '/deactive',
            method: 'POST',
            data: {
                id : id, _token : token
            },
            success: function(res){
            	if(res.isExist == true){
            		html = '<a data-url="'
            					+ url
            					+ '" data-id="'
            					+ id
            					+'" href="javascript:void(0)" class="btn btn-success col-sm-3 col-xs-5 btn-margin btn-active-banner"> Bật Banner </a>';
            		check.parent('.show-btn-active').html(html);
            		$('.use-active-' + id).html('');
            		alert('Tăt banner thành công!');
            	}
            },
        });
    }
});


$('.show-btn-active').on('click', '.btn-active-banner', function(){
	var check = $(this);
	if(confirm('Chắc chắn bật banner này')){
		var url = $(this).data('url');
		var id = $(this).data('id');
		var token = $('#token').val();
        $.ajax({
            url: url + '/active',
            method: 'POST',
            data: {
                id : id, _token : token
            },
            success: function(res){
            	if(res.isExist == true){
            		html = '<a data-url="'
            					+ url
            					+ '" data-id="'
            					+ id
            					+'" href="javascript:void(0)" class="btn btn-warning col-sm-3 col-xs-5 btn-margin btn-deactive-banner"> Tắt Banner </a>';
            		check.parent('.show-btn-active').html(html);
            		$('.use-active-' + id).html('<span class="glyphicon glyphicon-ok"></span>');
            		alert(res.message);
            	}else{
                    alert(res.message);
                }
            },
        });
    }
});