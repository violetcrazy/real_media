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
        echo '  <span class="item-icon-select">
                    <img src="http://localhost.cdn.land.com/asset/frontend/upload/icon/black/'.$value.'" alt="">
                </span>
            ';
    }
}
list_files();
