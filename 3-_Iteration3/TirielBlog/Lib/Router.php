<?php

namespace Lib;

use Lib\Route;
use Model\BlogManager;

class Router
{
    private $uri;
    private $manager;
    private $routes = [];

    public function __construct(BlogManager $manager, $uri)
    {
        if (is_string($uri)) {
            $this->uri = $uri;
        }
        $this->manager = $manager;

        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../Config/routes.xml');
        $routes = $xml->getElementsByTagName('route');

        foreach ($routes as $xmlroute) {
            $uri = $xmlroute->getAttribute('uri');
            $controller = $xmlroute->getAttribute('controller');
            $action = $xmlroute->getAttribute('action');
            $params = $xmlroute->getAttribute('params');

            $route = new Route($uri, $controller, $action, $params);
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
                $controllerClass = '\Controller\\'.$route->getController();
                $controller  = new $controllerClass($this->manager);
                $action = $route->getAction().'Action';

                if (!empty($route->getVars())) {
                    $content = $controller->$action($route->getVars());
                } else {
                    $content = $controller->$action();
                }
                
                return $content;
            }            
        }

        return $content = header('Location: /View/404.php');
    }
}
