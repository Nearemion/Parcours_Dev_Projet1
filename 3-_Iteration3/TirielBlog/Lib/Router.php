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

        $jsonroutes = json_decode(file_get_contents(__DIR__.'/../Config/routes.json'));

        foreach ($jsonroutes as $jsonroute) {
            $uri = $jsonroute->uri;
            $params = $jsonroute->params;
            $action = $jsonroute->action;
            $parent = $jsonroute->parent;

            $controller = ucfirst($parent.'Controller');
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

        $json = file_get_contents(__DIR__.'/../Config/routes.json');
        $jsonroutes = json_decode($json);
        $constants = get_defined_constants(true);
$json_errors = array();
foreach ($constants["json"] as $name => $value) {
 if (!strncmp($name, "JSON_ERROR_", 11)) {
  $json_errors[$value] = $name;
 }
}

// Affiche les erreurs pour les différentes profondeurs.
foreach (range(1, 5, 4) as $depth) {
    var_dump(json_decode($json, true, $depth));
    echo 'Dernière erreur : ', $json_errors[json_last_error()], PHP_EOL, PHP_EOL;
}
var_dump($this->routes);
    }
}
