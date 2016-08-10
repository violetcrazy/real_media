a:3:{i:0;s:1998:"<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
    <title>File manager</title>
    <link rel="stylesheet" href="<?php echo $this->config->application->base_url; ?>/asset/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $this->config->application->base_url; ?>/asset/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="<?php echo $this->config->application->base_url; ?>/asset/css/style.css">

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
            'asset_url' : '<?php echo $this->config->application->base_url; ?>asset/',
            'allowParent' : '<?php echo $this->config->application->allow_parent; ?>'
        }
    </script>

    <script src="<?php echo $this->config->application->base_url; ?>/asset/js/jquery.js"></script>
    <script src="<?php echo $this->config->application->base_url; ?>/asset/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->application->base_url; ?>/asset/fancybox/jquery.fancybox.pack.js"></script>
    <script src="<?php echo $this->config->application->base_url; ?>/asset/js/ImageTools.js"></script>
</head>
<body>
    ";s:7:"content";N;i:1;s:20:"
</body>
</html>
";}