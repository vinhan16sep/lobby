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
