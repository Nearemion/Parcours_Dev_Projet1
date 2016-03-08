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
        $xmlroutes = $xml->getElementsByTagName('route');

        foreach ($xmlroutes as $xmlroute) {
            $parent = $xmlroute->parentNode->nodeName;
            $uri = $xmlroute->getAttribute('uri');

            $controller = ucfirst($parent.'Controller');
            $action = $xmlroute->getAttribute('action');
            $params = $xmlroute->getAttribute('params');
            $manager = $parent.'Manager';

            $route = new Route($uri, $controller, $action, $manager, $params);
            $this->routes[] = $route;
        }
    }

    public function route()
    {
        $uri = $this->uri;

        foreach ($this->routes as $route) {
            if (preg_match('#^'.$route->getUri().'$#', $uri, $matches)) {

                if (!empty($route->getParams())) {
                    $route->setVars($matches[1]);
                }

                $managerClass = $route->getManager();
                $controllerClass = '\Controller\\'.$route->getController();
                $controller  = new $controllerClass($this->$managerClass);                
                $action = $route->getAction().'Action';

                if (isset($_POST['comment'])) {
                    $this->blogManager->processCommentForm();
                }

                if (!empty($route->getVars())) {
                    return $page = $controller->$action($route->getVars());
                } else {
                    return $page = $controller->$action();
                }
            }
        }

        return $page = header('Location: /Web/404.php');
    }
}
