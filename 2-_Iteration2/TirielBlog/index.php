<?php

use Controller\BlogController;
use Model\BlogManager;
use Lib\SplClassLoader;
use Lib\Router;

session_start();

if (!isset($_SESSION['token'])) {
    $token = md5(uniqid(rand(), true));
    $_SESSION['token'] = $token;
} else {
    $token = $_SESSION['token'];
}

require __DIR__.'/Lib/SplClassLoader.php';

$controllerLoader = new SplClassLoader('Controller', '');
$controllerLoader->register();

$libLoader= new SplClassLoader('Lib', '');
$libLoader->register();

$modelLoader = new SplClassLoader('Model', '');
$modelLoader->register();

$viewLoader = new SplClassLoader('View', '');
$viewLoader->register();

$manager = new BlogManager;
$controller = new BlogController($manager);

$uri = $_SERVER['REQUEST_URI'];
$router = new Router($controller, $manager, $uri);
$content = $router->route();

include './View/layout.php';
