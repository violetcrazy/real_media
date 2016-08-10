$(document).ready(function() {
    $('.send-email-agent').click(function() {
        var target = $(this).data('target');
        var title = $(this).data('title');
        $(target).find('#title_article').val(title);
    });
});