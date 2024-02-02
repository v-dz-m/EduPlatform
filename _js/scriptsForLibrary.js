function showDetails() {
    if ($(this).closest('.book').find('.book-details').css('display', 'none')) {
        $('.book-details').slideUp();
        $(this).closest('.book').children('.book-details').slideDown();
    }
}

function hideBooks() {
    var $author = $('#filterAuthor').val();
    var $year = $('#filterYear').val();
    $('.book').removeClass('hidden');
    $('.book').each(function () {
        if (($author != 0 && $(this).data('author') != $author) ||
            ($year != 0 && $(this).data('year') != $year)) {
            $(this).addClass('hidden');
        }
    });
}