<?php

function list_files($directory = '.')
{
    if ($directory != '.')
    {
        $directory = rtrim($directory, '/') . '/';
    }
    $ar = array();
    if ($handle = opendir($directory))
    {
        while (false !== ($file = readdir($handle)))
        {
            if ($file != '.' && $file != '..')
            {
                if(strrpos($file, 'png',0) ){
                  array_push($ar, $file);
                }
            }
        }

        closedir($handle);
    }
    sort($ar);
    foreach ($ar as $key => $value) {
        echo "INSERT INTO `land_icon` (`icon_id`, `icon1`, `icon2`, `created_at`, `updated_at`) VALUES (NULL, '". $value ."', NULL, CURRENT_TIMESTAMP, NULL);";
        echo '<br>';
    }
}
list_files();
