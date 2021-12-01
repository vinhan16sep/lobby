$(document).ready(function () {
    $('.btn-logout').on('click', function (e) {
        e.preventDefault();

        $('#logoutForm').submit();
    });
});

let commonFunc = {};

commonFunc.buildUrl = function (url, k, v) {
    let key = encodeURIComponent(k),
        value = encodeURIComponent(v);

    let baseUrl = url.split('?')[0],
        newParam = key + '=' + value,
        params = '?' + newParam;

    if (url.split('?')[1] === undefined) {
        urlQueryString = '';
    } else {
        urlQueryString = '?' + url.split('?')[1];
    }
    if (urlQueryString) {
        let updateRegex = new RegExp('([?&])' + key + '[^&]*');
        let removeRegex = new RegExp('([?&])' + key + '=[^&;]+[&;]?');

        if (value === undefined || value === null || value === '') {
            params = urlQueryString.replace(removeRegex, '$1');
            params = params.replace(/[&;]$/, '');
        } else if (urlQueryString.match(updateRegex) !== null) {
            params = urlQueryString.replace(updateRegex, '$1' + newParam);
        } else if (urlQueryString == '') {
            params = '?' + newParam;
        } else {
            params = urlQueryString + '&' + newParam;
        }
    }
    params = params === '?' ? '' : params;
    return baseUrl + params;
};

commonFunc.convertToLatin = function (str) {
    let slug = str.toLowerCase();

    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');

    return slug;
};
