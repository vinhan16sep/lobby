// Product management
window.onload = function(){
    $('.type').each(function(){
        var type_id = $(this).val();
        var page = $(this).data('page');
        var url = window.location.origin;
        var check = '';
        $.ajax({
            url: url + '/atelier/admin/category/fetchByType/{type_id}',
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



    $('.type').change(function(){
        var type_id = $(this).val();
        var url = window.location.origin;
        $.ajax({
            url: url + '/atelier/admin/category/fetchByType/{type_id}',
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

    $('.kind').change(function(){
        var kind_id = $(this).val();
        var url = window.location.origin;
        $.ajax({
            url: url + '/atelier/admin/category/fetchByKind/{kind_id}',
            method: 'GET',
            data: {
                kind_id : kind_id
            },
            success: function(res){
                var trademarks = res.trademarks;
                $('.trademark').html('');
                $('.trademark').append('<option class="trademark_option" value="">---------------------Chọn dòng sản phẩm---------------------</option>');
                $.each(trademarks, function(key, value){
                    $('.trademark').append('<option value="' + key + '">' + value + '</option>');
                });
                console.log(res.trademarks);
                res.trademarks
            },
        })
    })


    $('.kind').each(function(){
        var kind_id = $(this).data('id');
        
        var page = $(this).data('page');
        var url = window.location.origin;
        var check = '';
        $.ajax({
            url: url + '/atelier/admin/category/fetchByKind/{kind_id}',
            method: 'GET',
            data: {
                kind_id : kind_id
            },
            success: function(res){
                var trademarks = res.trademarks;
                $.each(trademarks, function(key, value){
                    $('.trademark').append('<option value="' + key + '" >' + value + '</option>');
                    $(".trademark").val(page);
                });
                console.log(res.trademarks);
                res.trademarks
            },
        })

    })

    
}
