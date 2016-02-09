<?php

namespace TirielBlog\Controller;

use TirielBlog\Model\BlogManager;

class BlogController
{
    protected $manager;
    protected $name;
    protected $totalPages;

    public function __construct(BlogManager $manager)
    {
        $this->manager = $manager;
        $this->setTotalPages();
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function setTotalPages()
    {
        $this->totalPages = ceil($manager->countPosts() / $manager->getLimit());
    }

    public function indexAction($page = 1)
    {
        $posts = $this->manager->getPosts($page);
        foreach ($posts as $post) {
            $post->setDate(new \DateTime($post->getDate()));
        }

        $pages = $this->totalPages;

        $index = new Index($posts, $pages);
        $content = $index->display();

        return $content;
    }
}
