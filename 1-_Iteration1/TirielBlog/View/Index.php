<?php

namespace TirielBlog\View;

class Index
{
    private $posts;
    private $pages;

    public function __construct($posts, $pages)
    {
        $this->posts = $posts;
        $this->pages = $pages;
    }

    public function display($page)
    {
        $display = '<h1>Liste des articles présentés sur ce blog:</h1>';
        $posts = $this->posts;
        $pages = $this->pages;

        foreach ($posts as $post) {
            if (strlen($post->getContent()) > 200) {
                $debut = substr($post->getContent(), 0, 200);
                $debut = substr($debut, 0, strrpos($debut, ' ')).'...';
                $post->setContent($debut);
            }

            $display .=
            '<div class="row">
            <h3 class="col-sm-8"><a href="#/post-'.$post->getId()'">'.$post->getTitle().'</a></h3>
            <div class="col-sm-12">'.$post->getContent().'</div>
            <p><em>Par '.$post->getAuthor().' le '.$post->getDate('d-m-Y').' à '.$post->getDate('H:i:s').'</em></p>
            </div>';
        }

        $display .= '<div class="btn-group" role="group">'
        for ($i=1; $i <= $pages; $i++) {
            $display .= '<button type="button"';
            if ($i === $page) {
                $display .= 'class="btn btn-default active"><a href="#/'.$i.'">'.$i.'</a></button>';
            } else {
                $display .= 'class="btn btn-default"><a href="#/'.$i.'">'.$i.'</button>';
            }
        }
        $display .= '</div>';

        return $display;
    }
}
