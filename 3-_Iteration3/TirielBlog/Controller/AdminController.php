<?php

namespace Controller;

use Lib\Controller;
use Model\AdminManager;
use Web\Admin\Index;

class AdminController extends Controller
{
    protected $totalPages;

    public function __construct(AdminManager $manager)
    {
        parent::__construct($manager);
        $this->setTotalPages();
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function setTotalPages()
    {
        $this->totalPages = ceil($this->manager->countPosts() / $this->manager->getLimit());
    }

    public function isAdmin()
    {
        /*if (!isset($_SESSION['adminToken'])) {
            return header('Location: /login');
        } else {*/
            return true;/*
        }*/
    }

    public function indexAction($page = 1)
    {
        if ($this->isAdmin()) {
            $posts = $this->manager->getPosts($page);
            foreach ($posts as $post) {
                $post->setDate(new \DateTime($post->getDate()));
            }

            $pages = $this->totalPages;

            $index = new Index($posts, $pages);
            $content = $index->display($page);

            return $content;
        }
    }

    public function newAction()
    {
        return;
    }

    public function editAction($id)
    {
        return;
    }

    public function deleteAction($id)
    {
        return;
    }
}
