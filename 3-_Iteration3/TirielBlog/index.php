<?php

use Controller\BlogController;
use Model\BlogManager;
use Lib\SplClassLoader;
use Lib\Router;

session_start();

require __DIR__.'/Lib/SplClassLoader.php';

$controllerLoader = new SplClassLoader('Controller', '');
$controllerLoader->register();

$libLoader= new SplClassLoader('Lib', '');
$libLoader->register();

$modelLoader = new SplClassLoader('Model', '');
$modelLoader->register();

$viewLoader = new SplClassLoader('Web', '');
$viewLoader->register();

$uri = $_SERVER['REQUEST_URI'];
$router = new Router($uri);
$content = $router->route();

include './Web/layout.php';
