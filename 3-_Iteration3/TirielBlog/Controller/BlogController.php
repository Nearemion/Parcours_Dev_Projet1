<?php

namespace Controller;

use Lib\Controller;
use Lib\Form\FormType;
use Model\BlogManager;
use Web\Blog\Index;
use Web\Blog\SingleView;

class BlogController extends Controller
{
    protected $totalPages;

    public function __construct(BlogManager $manager)
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
        $page = new SingleView($post);
        $content = $page->display();

        return $content;
    }
}
