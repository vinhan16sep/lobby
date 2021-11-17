window.onload = function(){
    $('.btn-finish').click(function(e){
        var finish = $(this);
        e.preventDefault();
        var id = $(this).data('id');
        var url = window.location.origin;
        $.ajax({
            url: url + '/atelier/admin/tasting/ajax-finish/{id}',
            method: 'GET',
            data: {
                id : id
            },
            success: function(res){
                var check = res.isExist;
                if(check == true){
                    finish.parents('#row_' + id).fadeOut();
                }
            },
        });
        return true;
    });
}