<?php

namespace TirielBlog;

use TirielBlog\Controller\BlogController;

$manager = new BlogManager();
$controller = new BlogController($manager);

$uri = $_SERVER['REQUEST_URI'];

if (preg_match('#^/([0-9]*)$#', $uri, $route)) {

    if ($route[1] !== 1 || !isset($route[1])) {
        $content = $controller->indexAction($route[1]);
    } else {
        $content = $controller->indexAction(1);
    }
} else if (preg_match('#^/post([0-9]*)$#', $uri, $route) {

    $content = $controller->viewAction($route[1]);
} else {
    header('Location: ./View/404.php');
}

include './View/layout.php';
