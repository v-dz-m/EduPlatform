$(document).ready(function () {
    $('.header-info').children('h2').css('cursor', 'pointer');
    $('.header-info').on('click', 'h2', function () {
        location.href = 'http://localhost/diplom/pl_main/';
    });
});