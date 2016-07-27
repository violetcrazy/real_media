<?php
namespace ITECH\Cdn\Controller;

class BaseController extends \Phalcon\Mvc\Controller
{
    public function outputJSON($response)
    {
        $this->view->disable();

        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setJsonContent($response);
        $this->response->send();
    }
}