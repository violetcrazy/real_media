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
    
    <script src="<?php echo $this->config->application->base_url; ?>asset/filemanager/js/app.js"></script>
    <div class="wrap">
        <div class="list-dir">

            <div class="alert alert-info text-center" style="padding: 5px">
                <b class="total-size"></b> / <b class="total-dir"></b> folder - <b class="total-file"></b> file</div>
            <div class="wrap-list">
                <ul></ul>
            </div>
            <hr>
            <div>
                <a class="logout" href="<?php echo $this->url->get(array('for' => 'logout')); ?>">Đăng xuất</a>
            </div>
        </div>
        <div class="main-content">

            <div class="top-tool text-right">
                <form action="" id="search-result" class="pull-left">
                    <input type="text" name="search" class="form-control" id="search" placeholder="Tìm tên file, thư mục">
                </form>
                <input type="file" class="hidden" name="files" id="files-upload" multiple>
                <a href="" class="btn btn-sm btn-warning btn-rollback">Trở lại</a>
                <a href="" class="btn btn-sm btn-default add-new-dir">Thêm thư mục</a>
                <a href="" class="btn btn-sm btn-primary btn-reload">Làm mới</a>
                <a href="" class="btn btn-sm btn-success btn-bluk-upload">Tải file</a>
                <a href="" class="btn btn-sm btn-danger btn-bluk-delete">Xóa</a>
            </div>

            <div class="list-file">
            </div>

            <div class="footer-tool text-right">
                <button data-callback="<?php echo ($this->request->getQuery('callback') ? $this->request->getQuery('callback') : 'getFileFromFileManager'); ?>"  data-inputReceive="<?php echo ($this->request->getQuery('input-receive') ? $this->request->getQuery('input-receive') : 'false'); ?>" class="btn btn-success disabled" id="send-to-parent">Sử dụng <span class="selected-count"></span></button>
                <button class="btn btn-default disabled" id="cancel-selected">Hủy chọn <span class="selected-count"></span></button>
            </div>

        </div>
    </div>

    <div style="display: none">
        <form action="" id="add-dir" style="width: 320px;">
            <h4>Thêm thư mục mới</h4>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Nhập tên thư mục..." name="dir-name" required>
                <span class="input-group-btn">
                    <button class="btn btn-success" type="submit">Thêm</button>
                </span>
            </div><!-- /input-group -->
        </form>
    </div>
    <script>
        var current_path = '<?php echo $this->session->get('RELATIVE_PATH_CURRENT'); ?>';
    </script>

</body>
</html>
