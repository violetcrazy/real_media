$(document).ready(function() {
    var id = $('#category_id').val();
    if (id != '') {
        if (!process) {
            process = true;

            $.ajax({
                'url': $('#load_filter_ajax_url').val(),
                'type': 'GET',
                'data': {'category_id': id},
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
        var id = $(this).val();

        if (!process) {
            process = true;

            $.ajax({
                'url': $('#load_filter_ajax_url').val(),
                'type': 'GET',
                'data': {'category_id': id},
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