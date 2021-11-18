
var base_url = location.protocol + "//" + location.host + (location.port ? ':' + location.port : '');
var html = '<div class="modal fade" id="myModal" role="dialog">'
                + '<div class="modal-dialog" style="color:#fff; text-align:center; padding-top:300px;">'
                + '<i class="fa fa-2x fa-spinner fa-spin" aria-hidden="true"></li>'
                + '</div>'
                + '</div>';
var url = window.location.origin;
$("#check-all").change(function() {
    if (this.checked) {
        $(".checkbox").each(function() {
            this.checked=true;
        });
    } else {
        $(".checkbox").each(function() {
            this.checked=false;
        });
    }
});
$('.btn-send-mail').click(function(e){
    e.preventDefault();
    // $("#encypted_ppbtn_all").css('display','block');
    var email = $(this).data('email');
    jQuery.ajax({
        method: "get",
        url: url + '/atelier/admin/subscrie/send/{email}',
        // url: location.protocol + "//" + location.host + (location.port ? ':' + location.port : '') + "/tuoithantien/comment/create_comment",
        data: {email : email},
        beforeSend: function() {
            $("#encypted_ppbtn").css('display','block');
        },
        success: function(res){
          $("#encypted_ppbtn").css('display','none');
          alert('Gửi mail thành công');
        }
    });
});

$('#sendAll').click(function(e){
    e.preventDefault();
    var token = $('#token-send-all').val();
    var ids = [];
    $('.checkbox').each(function() {
        if($(this).prop("checked") == true){
            ids.push(this.id);
        }
        
    });
    if(ids != ''){
        jQuery.ajax({
            method: "post",
            url: url + '/atelier/admin/subscrie/sendAll',
            // url: location.protocol + "//" + location.host + (location.port ? ':' + location.port : '') + "/tuoithantien/comment/create_comment",
            data: {ids : ids, _token : token},
            beforeSend: function() {
                $("#encypted_ppbtn").css('display','block');
            },
            success: function(res){
                $("#encypted_ppbtn").css('display','none');
                alert('Gửi mail thành công');             
            }
        });
    }else{
        alert('Chưa có email được chọn');
    }
    
    return false;
});