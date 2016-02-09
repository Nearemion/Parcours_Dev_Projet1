<?php

use Controller\BlogController;
use Lib\SplClassLoader;
use Model\BlogManager;

require __DIR__.'./Lib/SplClassLoader.php';

$controllerLoader = new SplClassLoader('Controller', './');
$controllerLoader->register();

$entityLoader= new SplClassLoader('Entity', './');
$entityLoader->register();

$modelLoader = new SplClassLoader('Model', './');
$modelLoader->register();

$viewLoader = new SplClassLoader('View', './');
$viewLoader->register();

$manager = new BlogManager;
$controller = new BlogController($manager);

$uri = $_SERVER['REQUEST_URI'];

if (preg_match('#^/([0-9]*)$#', $uri, $route)) {

    if ($route[1] !== 1 && (int) $route[1] > 2) {
        $controller->getManager()->setOffset((($route[1]-2)*5));
        $content = $controller->indexAction($route[1]);
    } else if ($route[1] == 2) {
        $controller->getManager()->setOffset(5);
        $content = $controller->indexAction($route[1]);
    } else {
        $content = $controller->indexAction();
    }

} else if (preg_match('#/post-([0-9]*)$#', $uri, $route)) {

    $content = $controller->viewAction($route[1]);
} else {
    header('Location: View/404.php');
}

include './View/layout.php';
