<?php
date_default_timezone_set('Asia/Bangkok');
ini_set('display_errors', true);
error_reporting(E_ALL);

try {
    define('ROOT', realpath(dirname(dirname(dirname(__FILE__)))));

    $loader = new \Phalcon\Loader();
    $loader->registerDirs(array(
        ROOT . '/app/cdn/',
        ROOT . '/app/data/'
    ))->register();

    $di = new \Phalcon\DI\FactoryDefault();

    require_once ROOT . '/app/cdn/config/parameter.php';
    $config = new \Phalcon\Config($parameters);
    $di->setShared('config', $config);

    $di->setShared('url', function () use ($config) {
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri($config->application->base_url);
        return $url;
    });

    $di->setShared('router', function () {
        $router = new \Phalcon\Mvc\Router(false);

        require_once ROOT . '/app/cdn/config/router.php';
        $router->removeExtraSlashes(true);

        return $router;
    });

    $di->setShared('dispatcher', function () {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('ITECH\Cdn\Controller\\');

        $events_manager = new \Phalcon\Events\Manager();
        $events_manager->attach('dispatch', function($event, $dispatcher, $exception) {
            $type = $event->getType();
            if ($type == 'beforeException') {
                if ($exception->getCode() == \Phalcon\Mvc\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND || $exception->getCode() == \Phalcon\Mvc\Dispatcher::EXCEPTION_ACTION_NOT_FOUND) {
                    $dispatcher->forward(array(
                        'module' => 'cdn',
                        'controller' => 'error',
                        'action' => 'error404'
                    ));
                    return false;
                } else {
                    $dispatcher->forward(array(
                        'module' => 'cdn',
                        'controller' => 'error',
                        'action' => 'error',
                        'params' => array($exception)
                    ));
                    return false;
                }
            }
        });

        $dispatcher->setEventsManager($events_manager);
        return $dispatcher;
    });

    $di->setShared('logger', function () {
        $logger = new \Phalcon\Logger\Adapter\File(ROOT . '/log/error.log');
        return $logger;
    });

    $application = new \Phalcon\Mvc\Application($di);
    $application->registerModules(array(
        'cdn' => array(
            'className' => 'ITECH\Cdn\Module',
            'path' => ROOT . '/app/cdn/Module.php'
        ),
        'data' => array(
            'className' => 'ITECH\Data\Module',
            'path' => ROOT . '/app/data/Module.php'
        )
    ));

    echo $application->handle()->getContent();
} catch (\Exception $e) {
    throw new \Phalcon\Exception($e->getMessage());
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage());
}