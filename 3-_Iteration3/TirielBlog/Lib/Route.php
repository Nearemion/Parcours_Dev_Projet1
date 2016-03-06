<?php

namespace Lib;

class Route
{
    private $uri;
    private $params;
    private $controller;
    private $action;
    private $manager;
    private $vars;

    public function __construct($uri, $controller, $action, $manager, $params = null)
    {
        $this->setUri($uri);
        $this->setController($controller);
        $this->setAction($action);
        $this->setManager($manager);
        $this->setParams($params);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($param)
    {
        $this->params = $param;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function setVars($var)
    {
        $this->vars = $var;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function setManager($manager)
    {
        $this->manager = $manager;
    }
}
