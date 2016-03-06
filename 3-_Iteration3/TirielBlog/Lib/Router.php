<?php

namespace Lib;

use Lib\Route;
use Model\AdminManager;
use Model\BlogManager;

class Router
{
    private $uri;
    private $blogManager;
    private $adminManager;
    private $routes = [];

    public function __construct($uri)
    {
        if (is_string($uri)) {
            $this->uri = $uri;
        }
        $this->blogManager = new BlogManager;
        $this->adminManager = new AdminManager;

        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../Config/routes.xml');
        $routes = $xml->getElementsByTagName('route');

        foreach ($routes as $xmlroute) {
            $uri = $xmlroute->getAttribute('uri');
            $controller = $xmlroute->getAttribute('controller');
            $action = $xmlroute->getAttribute('action');
            $params = $xmlroute->getAttribute('params');
            $parent = $xmlroute->parentNode->nodeName;

            $route = new Route($uri, $controller, $action, $parent, $params);
            $this->routes[] = $route;
        }
    }

    public function route()
    {
        $uri = $this->uri;

        foreach ($this->routes as $route) {
            if (preg_match('#^'.$route->getUri().'$#', $uri, $matches)) {

                $managerClass = $route->getParent().'Manager';

                if (!empty($route->getParams())) {
                    $route->setVars($matches[1]);
                }
                $controllerClass = '\Controller\\'.$route->getController();
                $controller  = new $controllerClass($this->$managerClass);
                $action = $route->getAction().'Action';

                if (!empty($route->getVars())) {
                    return $page = $controller->$action($route->getVars());
                } else {
                    return $page = $controller->$action();
                }

                if (isset($_POST['comment'])) {
                    $manager->processCommentForm();
                }
            }
        }

        return $page = header('Location: /Web/404.php');
    }
}
