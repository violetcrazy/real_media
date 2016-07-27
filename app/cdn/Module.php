<?php
namespace ITECH\Cdn;

class Module
{
    public function registerAutoloaders()
    {
        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces(array(
            'ITECH\Data\Lib' => ROOT . '/app/data/lib/',
            'ITECH\Cdn\Controller' => ROOT . '/app/cdn/controller/'
        ));

        $loader->register();
    }

    public function registerServices($di)
    {
        $config = $di->getService('config')->getDefinition();

        $di->set('volt', function ($view, $di) use ($config) {
            $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

            $volt->setOptions(array(
                'compiledPath' => ROOT . '/cache/cdn/volt/',
                'compiledSeparator' => $config->volt->compiled_separator,
                'compileAlways' => (bool)$config->volt->debug,
                'stat' => (bool)$config->volt->stat
            ));
            return $volt;
        });

        $di->setShared('view', function () {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir(ROOT . '/app/cdn/view/');
            $view->registerEngines(array(
                '.volt' => 'volt'
            ));

            return $view;
        });
    }
}