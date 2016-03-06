<?php

namespace Web\Admin;

use Lib\Entity\Post;
use Web\Admin\Admin;

class Index extends Admin
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
        $content = '<h1>Liste des articles présentés sur ce blog:</h1><br />';
        $posts = $this->posts;
        $pages = $this->pages;

        foreach ($posts as $post) {
            if (strlen($post->getContent()) > 100) {
                $debut = substr($post->getContent(), 0, 100);
                $debut = substr($debut, 0, strrpos($debut, ' ')).'...';
                $post->setContent($debut);
            }
            if ($post->getNbComment() == 0 || $post->getNbComment() == null) {
                $comments = 'Aucun commentaire. ';
            } else if ($post->getNbComment() == 1) {
                $comments = 'Un commentaire. ';
            } else {
                $comments  = $post->getNbComment().' commentaires. ';
            }

            $content .=
            '<div class="row">
                <h4 class="col-sm-8"><a href="/view/'.$post->getId().'">'.htmlspecialchars($post->getTitle()).'</a></h4>
                <div class="col-sm-8">'.nl2br(htmlspecialchars($post->getContent())).'</div>
                <p class="col-sm-4"><em>Par '.htmlspecialchars($post->getAuthor()).' le '.$post->getDate()->format('d-m-Y').'.</em> '.$comments.'</p>
            </div>';
        }

        $content .= '<div><ul class="pagination">';
        for ($i=1; $i <= $pages; $i++) {
            $content .= '<li';
            if ($i == $page) {
                $content .= ' class="active"';
            }
            $content .= '><a href="/'.$i.'">'.$i.'</a></li>';
        }
        $content .= '</ul></div>';

        return $this->getPage($content);
    }
}
