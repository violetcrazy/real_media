<?php
namespace ITECH\Data;

class Module
{
    public function registerAutoloaders()
    {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            'ITECH\Data\Lib' => ROOT . '/app/data/lib/'
        ));
        $loader->register();
    }

    public function registerServices($di)
    {

    }
}