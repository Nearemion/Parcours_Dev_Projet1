<?php

namespace View;

use Lib\Entity\Post;

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
        $display = '<h1>Liste des articles présentés sur ce blog:</h1><br />';
        $posts = $this->posts;
        $pages = $this->pages;

        foreach ($posts as $post) {
            if (strlen($post->getContent()) > 200) {
                $debut = substr($post->getContent(), 0, 200);
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

            $display .= '<div class="row"><h3 class="col-sm-8"><a href="/post-'.$post->getId().'">'.htmlspecialchars($post->getTitle()).'</a></h3><div class="col-sm-12">'.nl2br(htmlspecialchars($post->getContent())).'</div><p class="col-sm-offset-8 col-sm-4"><em>Par '.htmlspecialchars($post->getAuthor()).' le '.$post->getDate()->format('d-m-Y').'.</em> '.$comments.'</p></div>';
        }

        $display .= '<div class="btn-group" role="button">';
        for ($i=1; $i <= $pages; $i++) {
            $display .= '<a href="/'.$i.'" ';
            if ($i == $page) {
                $display .= 'class="btn btn-primary">'.$i.'</a>';
            } else {
                $display .= 'class="btn btn-default">'.$i.'</a>';
            }
        }
        $display .= '</div>';

        return $display;
    }
}
