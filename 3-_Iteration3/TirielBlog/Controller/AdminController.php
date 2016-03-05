<?php

namespace Controller;

use Lib\Controller;

class AdminController extends Controller
{
    public function indexAction($page = 1)
    {
        $posts = $this->manager->getPosts($page);
        foreach ($posts as $post) {
            $post->setDate(new \DateTime($post->getDate()));
        }

        $pages = $this->totalPages;

        $index = new IndexAdmin($posts, $pages);
        $content = $index->display($page);

        return $content;
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
