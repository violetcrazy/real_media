/* global url_upload */

$(document).ready(function(){

})
.on('click', '.btn-upload-img', function(event){
    event.preventDefault();
    $(this).closest('.block-avarta').find('[name="files"]').trigger('click');
})
.on('change', '.upload-avatar', function(event){
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
            $this.closest('div').find('img.main').attr('src', data.result.image_url);
            $this.closest('div').find('.field-value').val(data.result.image_url);
        }
    });
});
