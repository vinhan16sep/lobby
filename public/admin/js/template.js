

$(function(){
	$("#config-form").validate({
		rules: {
			name: {
				required: true
			}
		},
	});
	$("[name^=title]").each(function(){
		$(this).rules("add", {
			required: true,
		});   
	});

	$('.btn-config-close').click(function(){
		$(this).parents('.remove-config').fadeOut();
		$(this).parents('.remove-config').find('input').prop('disabled', true);
	})
});
var total = '';
$('#btn-total').click(function(){
	stt = $('.content-config > div:last-child input').data('child');
	var total = $('#total').val();
	for (var i = 1; i <= parseInt(total); i++) {
		var content = 	'<div class="form-group remove-config row-'+ (i + stt) +'">'+
							'<label for="title" class="col-md-2 control-label">Thông Số <span>'+ (i + 1 + stt) +'</span></label>'+
							'<div class="col-md-8">'+
								'<input type="text" class="form-control config-validate" name="title['+ (i + stt) +']" value="" data-child="'+ (i + stt) +'" >'+
							'</div>'+
							'<div class="col-md-1" style="padding-top: 7px" >'+
                                '<i class="fa fa-times-circle btn-config-close" aria-hidden="true" data-stt="'+ (i + stt) +'"></i>'+
                            '</div>'+
						'</div>';
		$('.content-config').append(content);
	}
	$(".config-validate").each(function(){
		$(this).rules("add", {
			required: true,
		});   
	});

	$('.btn-config-close').click(function(){
		var new_stt = parseInt($(this).data('stt'));
		$(this).parents('.remove-config').remove();
		// $(this).parents('.remove-config').fadeOut();

		// $(this).parents('.remove-config').find('input').prop('disabled', true);
		// var id = $(this).parents('.remove-config').nextAll().find('label').find('span').text();
		var $this = $(this);
		var $this2 = $this.closest('.remove-config').find('label').find('span');
		var $entryID = parseInt($this2.text());
		var entries = $('.remove-config').find('label').find('span').not($this2).filter(function(){
			return parseInt($(this).text()) > $entryID;
		});
		// console.log(entries);
		entries.each(function(index, value){
			var id = $entryID + index + 1;
			$(value).text($(value).text().replace(id, (id-1)));
		});
	})
});

