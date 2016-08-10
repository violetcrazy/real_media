$(document).ready(function() {
    var process = false;
    var id = $('#category_id').val(),
        articleId = $('#load_filter_article_id').val();
        filterQueryValue = $('#load_filter_query_value_ajax').val();
    if (id != '') {
        if (!process) {
            process = true;

            $.ajax({
                'url': $('#load_filter_ajax_url').val(),
                'type': 'GET',
                'data': {'category_id': id, 'article_id' : articleId, 'filter_query_value': filterQueryValue},
                'success': function(response) {
                    if (typeof response != 'undefined') {
                        $('#filter-attribute').html(response);
                    } else {
                        alert('An unknown error occurred, please try again.');
                    }
                }
            }).done(function() {
                process = false;
            });
        }
    }

    $(document).on('change', '#category_id', function() {
        var id = $(this).val(),
            article_id = $('#load_filter_article_id').val();
        if (!process) {
            process = true;

            $.ajax({
                'url': $('#load_filter_ajax_url').val(),
                'type': 'GET',
                'data': {'category_id': id, 'article_id' : article_id},
                'success': function(response) {
                    if (typeof response != 'undefined') {
                        $('#filter-attribute').html(response);
                    } else {
                        alert('An unknown error occurred, please try again.');
                    }
                }
            }).done(function() {
                process = false;
            });
        }
    });
});