$(document).ready(function () {
    $('.btn-logout').on('click', function (e) {
        e.preventDefault();

        $('#logoutForm').submit();
    });
});
