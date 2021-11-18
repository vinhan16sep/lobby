// Product management
window.onload = function(){
    var url = window.location.origin;

    $('.remove-image').click(function(){
        var check = $(this);
        var image = $(this).data('image');
        var id = $(this).data('id');
        var token = $('#token').val();
        if(confirm('Chắc chắn xóa ảnh này')){
            $.ajax({
                url: url + '/atelier/admin/trend/deleteImage',
                method: 'POST',
                data: {
                    image : image, id : id, _token : token
                },
                success: function(res){
                    if(res.result == false){
                        alert('Hình ảnh này đang được chọn làm avatar nên không thể xóa!')
                    }else{
                        check.parent('div').fadeOut();
                    }
                    
                },
            });
        }
        
    });

    $('.active-avatar').click(function(){
        var check = $(this);
        var image = $(this).data('image');
        var id = $(this).data('id');
        var token = $('#token').val();
        if(confirm('Chọn ảnh này làm Avatar')){
            $.ajax({
                url: url + '/atelier/admin/trend/activeAvatar',
                method: 'POST',
                data: {
                    image : image, id : id, _token : token
                },
                success: function(res){
                    // check.parent('div').fadeOut();
                    if(res.result == true){
                        alert("Thay đổi Avatar thành công!");
                    }else{
                        alert("Thay đổi Avatar thất bại!");
                    }
                    location.reload();
                },
            });
        }
        
    });

}
