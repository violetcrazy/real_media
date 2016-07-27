$(document).ready(function () {
    var process = false;
    $(document).on('change', '#province_id', function () {
        if (!process) {
            process = true;

            var province_id = $(this).val();
            var link = $(this).attr('data-url');
            $.ajax({
                "url": link,
                "type": "GET",
                "data": {"province_id": province_id},
                "success": function (response) {
                    if (typeof response != "undefined") {
                        $('#district_id').html(response);
                    } else {
                        alert('An unknown error occurred, please try again.');
                    }
                }
            }).done(function () {
                process = false;
            });
        }
    });

    $('.date-picker').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    $('#label').tagsInput({
        'width': '100%',
        'defaultText': ''
    });

    $('#file_avatar').change(function () {
        var link = $(this).attr('data-url');
        $("#form-user").ajaxSubmit({
            url: link, 
            type: 'post',
            beforeSubmit: function() {
                $('.status-upload-avatar').show();
                $('<div class="ajax-upload"></div>').insertAfter('.status-upload-avatar');
            },
            success: function (response) {
                if (typeof response != "undefined" && response.status == '200') {
                    $('.status-upload-avatar').html('<span class="btn btn-success btn-squared">' + response.message + '</span>'); 
                    $('.avatar-preview img').attr('src', response.result.avatar);
                    $('.status-upload-avatar').show();
                    $('.ajax-upload').remove();
                } else {
                    if (response.status == '400') {
                        $('.status-upload-avatar').html('<span class="btn btn-danger btn-squared">' + response.message + '</span>'); 
                        $('.ajax-upload').remove();
                    } else {
                        $('.status-upload-avatar').html('<span class="btn btn-danger btn-squared">An unknown error occurred, please try again.</span>'); 
                        $('.ajax-upload').remove();
                    } 
                }
            }
        });
    });
    
    $(document).on('click', '#delete-avatar', function () {
        if (!process) {
            process = true;
            var id = $('#id').val(),
                link = $(this).attr('data-url');
            $.ajax({
                'url': link,
                'type': 'POST',
                'data': {'id': id},
                'beforeSend': function() {
                    $('.status-upload-avatar').show();
                    $('<div class="ajax-upload"></div>').insertAfter('.status-upload-avatar');
                },
                'success': function (response) {
                    if (typeof response != "undefined" && response.status == '200') {
                        $('.status-upload-avatar').html('<span class="btn btn-success btn-squared">' + response.message + '</span>'); 
                        $('.avatar-preview img').attr('src', response.result.avatar);
                        $('.status-upload-avatar').show();
                        $('.ajax-upload').remove();
                    } else {
                        if (response.status == '400') {
                            $('.ajax-upload').remove();
                            $('.status-upload-avatar').html('<span class="btn btn-danger btn-squared">' + response.message + '</span>'); 
                        } else {
                            $('.ajax-upload').remove();
                            $('.status-upload-avatar').html('<span class="btn btn-danger btn-squared">An unknown error occurred, please try again.</span>'); 
                        } 
                    }
                }
            }).done(function () {
                process = false;
            });
        }
    });

    $('#file_cover').change(function () {
        var link = $(this).attr('data-url');
        $("#form-user").ajaxSubmit({
            url: link, 
            type: 'post', 
            beforeSubmit: function() {
                $('.status-upload-cover').show();
                $('<div class="ajax-upload"></div>').insertAfter('.status-upload-cover');
            },
            success: function (response) {
                if (typeof response != "undefined" && response.status == '200') {
                    $('.status-upload-cover').html('<span class="btn btn-success btn-squared">' + response.message + '</span>'); 
                    $('.cover-preview img').attr('src', response.result.avatar);
                    $('.status-upload-cover').show();
                    $('.ajax-upload').remove();
                } else {
                    if (response.status == '400') {
                        $('.ajax-upload').remove();
                        $('.status-upload-cover').html('<span class="btn btn-danger btn-squared">' + response.message + '</span>'); 
                    } else {
                        $('.ajax-upload').remove();
                        $('.status-upload-cover').html('<span class="btn btn-danger btn-squared">An unknown error occurred, please try again.</span>'); 
                    } 
                }
            }
        });
    });

    $(document).on('click', '#delete-cover', function () {
        if (!process) {
            process = true;
            var id = $('#id').val(),
                link = $(this).attr('data-url');
            $.ajax({
                'url': link,
                'type': 'POST',
                'data': {'id': id},
                'beforeSend': function() {
                    $('.status-upload-cover').show();
                    $('<div class="ajax-upload"></div>').insertAfter('.status-upload-cover');
                },
                'success': function (response) {
                    if (typeof response != "undefined" && response.status == '200') {
                        $('.status-upload-cover').html('<span class="btn btn-success btn-squared">' + response.message + '</span>'); 
                        $('.cover-preview img').attr('src', response.result.cover);
                        $('.status-upload-cover').show();
                        $('.ajax-upload').remove();
                    } else {
                        if (response.status == '400') {
                            $('.ajax-upload').remove();
                            $('.status-upload-cover').html('<span class="btn btn-danger btn-squared">' + response.message + '</span>'); 
                        } else {
                            $('.ajax-upload').remove();
                            $('.status-upload-cover').html('<span class="btn btn-danger btn-squared">An unknown error occurred, please try again.</span>'); 
                        } 
                    }
                }
            }).done(function () {
                process = false;
            });
        }
    });
});