<?php

namespace Controller;

use Lib\Form\FormType;
use Model\BlogManager;
use View\Index;
use View\SingleView;

class BlogController
{
    protected $manager;
    protected $name;
    protected $totalPages;

    public function __construct(BlogManager $manager, $offset = 0, $limit = 5)
    {
        $this->manager = $manager;
        $this->manager->setOffset($offset);
        $this->manager->setLimit($limit);
        $this->setTotalPages();
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function setTotalPages()
    {
        $this->totalPages = ceil($this->manager->countPosts() / $this->manager->getLimit());
    }

    public function indexAction($page = 1)
    {
        $posts = $this->manager->getPosts($page);
        foreach ($posts as $post) {
            $post->setDate(new \DateTime($post->getDate()));
        }

        $pages = $this->totalPages;

        $index = new Index($posts, $pages);
        $content = $index->display($page);

        return $content;
    }

    public function viewAction($id)
    {
        $post = $this->manager->getSinglePost($id);
        $post->setDate(new \DateTime($post->getDate()));
        $page = new SingleView($post);
        $content = $page->display();

        return $content;
    }
}
