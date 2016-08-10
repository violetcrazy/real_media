<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
    <title>File manager</title>
    <link rel="stylesheet" href="<?php echo $this->config->application->base_url; ?>asset/filemanager/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $this->config->application->base_url; ?>asset/filemanager/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="<?php echo $this->config->application->base_url; ?>asset/filemanager/css/style.css">

    <script>
        var router = {
            'list_folder': '<?php echo $this->url->get(array('for' => 'get_folder_list')); ?>',
            'entry_folder': '<?php echo $this->url->get(array('for' => 'get_folder_entry')); ?>',
            'add_dir': '<?php echo $this->url->get(array('for' => 'add_dir')); ?>',
            'upload_url': '<?php echo $this->url->get(array('for' => 'upload_file')); ?>',
            'delete_url': '<?php echo $this->url->get(array('for' => 'delete')); ?>',
            'detail_url': '<?php echo $this->url->get(array('for' => 'detail_file')); ?>'
        };

        var config = {
            'upload_url' : '<?php echo $this->config->application->upload_url; ?>',
            'asset_url' : '<?php echo $this->config->application->base_url; ?>asset/filemanager/',
            'allowParent' : '<?php echo $this->config->application->allow_parent; ?>'
        }
    </script>

    <script src="<?php echo $this->config->application->base_url; ?>asset/filemanager/js/jquery.js"></script>
    <script src="<?php echo $this->config->application->base_url; ?>asset/filemanager/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->application->base_url; ?>asset/filemanager/fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?php echo $this->config->application->base_url; ?>asset/filemanager/js/ImageTools.js"></script>
</head>
<body>
    
    <style>
        body {
            position: relative;
        }
    </style>
    <div class="detail-img">
        <div class="col-left">
            <?php if ($width && $height) { ?>
                <img src="<?php echo $src; ?>" alt="">
            <?php } else { ?>
                <br>
                <div class="col-xs-12">
                    <div class="alert alert-info">Không có xem trước cho định dạng file này.</div>
                    Bạn có thể tải file <a href="<?php echo $src; ?>"><b>tại đây</b></a>
                </div>
                <div class="clearfix"></div>
            <?php } ?>
        </div>
        <div class="col-right">
            <p>
                <b id="filename_origin"><?php echo $file_name; ?></b>
            </p>
            <p>
                <?php if ($width && $height) { ?>
                    Size: <b><?php echo $width; ?> x <?php echo $height; ?></b> <br>
                <?php } ?>
                DLượng: <b><?php echo $size; ?></b>KB<br>
                Kiểu: <b><?php echo $type; ?></b>
                <a target="_blank" href="<?php echo $src; ?>">Link tải về</a>
            </p>
            <a href="" class="btn btn-block btn-danger delete-file-single">Xóa file</a>
            <a href="" class="btn btn-block btn-warning btn-change-file">Đổi file</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <input type="file" class="hidden" name="files" id="files-upload-change">
    <script>
        $(document).ready(function (event) {
            $('.delete-file-single').on('click', function (event) {
                event.preventDefault();
                var data = {
                    'meta' : {
                        'type': 'file',
                        'link': '<?php echo $src; ?>'
                    }
                };

                $.post(router.delete_url, data, function (res) {
                    if (res.status == 200) {
                        window.parent.deleteFileFromIframe();
                    } else {
                        $('.detail-image').css({'padding': '15px'}).html('<div class="alert alert-success">'+ data.message +'</div>');
                    }
                });
            });

            $('.btn-change-file').on('click', function (event) {
                event.preventDefault();
                $('#files-upload-change').trigger('click');
            });

            $('#files-upload-change').on('change', function (event) {
                event.preventDefault();

                var file_datas = $(this).prop('files'),
                        $this = $(this);
                totalFile = file_datas.length;
                $.each(file_datas, function(index, file_data){
                    var form_data = new FormData();
                    ImageTools.resize(file_data, {
                        width: 1200,
                        height: 1200
                    }, function(blob, didItResize) {
                        form_data.append('file', blob);
                        form_data.append('file-name', $.trim($('#filename_origin').text()));
                        $.ajax({
                            url: router.upload_url,
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,
                            type: 'post',
                            success: function(data){
                                totalFile --;
                                if (totalFile == 0) {
                                    window.location.reload();
                                }
                            }
                        });
                    });
                });
            })
        })
    </script>

</body>
</html>
