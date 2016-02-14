<?php

namespace Lib;

use Controller\BlogController;
use Model\BlogManager;

class Router
{
    private $uri;
    private $controller;
    private $manager;

    public function __construct(BlogController $controller, BlogManager $manager, $uri)
    {
        if (is_string($uri)) {
            $this->uri = $uri;
        }
        $this->controller = $controller;
        $this->manager = $manager;
    }

    public function route()
    {
        $uri = $this->uri;
        $controller = $this->controller;

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

        return $content;
    }
}
