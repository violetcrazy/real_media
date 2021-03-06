<?php
$parameters = array();

$parameters = array(
    'cache' => array(
        'lifetime' => 300,
        'prefix' => '_file_',
        'type' => 'apc',
        'memcache' => array(
            'host' => '127.0.0.1',
            'port' => '11211',
            'persistent' => false
        ),
        'redis' => array(
            'host' => '127.0.0.1',
            'port' => '6379',
            'auth' => 'redis',
            'persistent' => false
        ),
        'metadata' => array(
            'prefix' => 'file_',
            'lifetime' => '31536000'
        )
    ),

    'volt' => array(
        'debug' => true,
        'stat' => true,
        'compiled_separator' => '_'
    ),

    'application' => array(
        'protocol' => 'http://',
        'pagination_limit' => '3',
        'base_url' => 'http://cdnjinn.codex4u.com/',
        'token' => '363b122c528f54df4a0446b6bab05515', // j
        'token_user' => '93d68a20c24c803791b5fce92f51cfc3', // jinn
        'upload_dir' => ROOT . '/web/filemanager/uploads/',
        'upload_url' => 'http://cdnjinn.codex4u.com/uploads/',
        'allow_parent' => 'http://adminjinn.codex4u.com/',
        'session_domain' => '.jinn.vn',
        'session_name' => 'jinn',
    ),
);
