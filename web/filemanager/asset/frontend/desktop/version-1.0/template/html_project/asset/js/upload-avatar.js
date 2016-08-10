/* global url_upload */

$(document).ready(function(){
    $('.btn-upload-img').click(function(event){
        event.preventDefault();
        $('#upload-avatar').trigger('click');
    });

    $('#upload-avatar').change(function(){
        var file_data = $(this).prop('files')[0];
        $this = $(this);
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('type_upload', 'avatar');

        $.ajax({
            url: url_upload, 
            dataType: 'json',
            data: form_data,
            cache: false,
            processData: false,
            contentType: false,
            type: 'post',
            success: function(data) {
                console.log(data)
                $this.closest('div').find('img').attr('src', data.result.image_url);
            }
        });
    });
});