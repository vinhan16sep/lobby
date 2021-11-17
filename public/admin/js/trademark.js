// Product management
window.onload = function(){
    

    $('.type').change(function(){
        var type_id = $(this).val();
        var url = window.location.origin;
        $.ajax({
            url: url + '/atelier/admin/trademark/kind/{type_id}',
            method: 'GET',
            data: {
                type_id : type_id
            },
            success: function(res){
                var kinds = res.kinds;
                $('.kind').html('');
                $('.kind').append('<option class="kind_option" value="">---------------------Chọn dòng sản phẩm---------------------</option>');
                $.each(kinds, function(key, value){
                    $('.kind').append('<option value="' + key + '">' + value + '</option>');
                });
                console.log(res.kinds);
                res.kinds
            },
        })
    })
    $('.type').each(function(){
        var type_id = $(this).val();
        var page = $(this).data('page');
        var url = window.location.origin;
        var check = '';
        $.ajax({
            url: url + '/atelier/admin/trademark/kind/{type_id}',
            method: 'GET',
            data: {
                type_id : type_id
            },
            success: function(res){
                var kinds = res.kinds;
                $.each(kinds, function(key, value){
                    $('.kind').append('<option value="' + key + '" >' + value + '</option>');
                    $(".kind").val(page);
                });
                console.log(res.kinds);
                res.kinds
            },
        })
    })
    
}
