<?php
$router->add('/upload', array(
    'module' => 'cdn',
    'controller' => 'image',
    'action' => 'uploadMedia'
))->setName('media_upload');
$router->add('/image/upload', array(
    'module' => 'cdn',
    'controller' => 'image',
    'action' => 'upload'
))->setName('image_upload');

$router->add('/image/delete{query:(/.*)*}', array(
    'module' => 'cdn',
    'controller' => 'image',
    'action' => 'delete'
))->setName('image_delete');

$router->add('/image/watermark{query:(/.*)*}', array(
    'module' => 'cdn',
    'controller' => 'image',
    'action' => 'watermark'
))->setName('image_watermark');

$router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
$router->notFound(array(
    'module' => 'cdn',
    'controller' => 'error',
    'action' => 'error404'
));

$router->add('/image/count-file{query:(/.*)*}', array(
    'module' => 'cdn',
    'controller' => 'image',
    'action' => 'countFile'
))->setName('image_count_file');