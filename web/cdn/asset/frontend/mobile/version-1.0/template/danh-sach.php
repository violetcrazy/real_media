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
                if(strrpos($file, 'html',0) ){
                  array_push($ar, $file);
                }
            }
        }

        closedir($handle);
    }
    sort($ar);
    foreach ($ar as $key => $value) {
        echo '<a href="'.$value.'">'.$value.'</a>';
    }
}
list_files();
?>
<style>
body {
    background-color: #f8f8f8;
    text-align: center;
    width: 600px;
    margin:auto;
    padding: 20px;

}
a{
    background-color: white;
    display: block;
    margin-bottom: 10px;
    text-decoration: none;
    width: 100%;
    float: left;
    margin:  0.5% 1%;
    text-align: left;
    box-shadow: 0 0 2px silver;
    padding: 3px 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    box-sizing: border-box;
}
</style>
