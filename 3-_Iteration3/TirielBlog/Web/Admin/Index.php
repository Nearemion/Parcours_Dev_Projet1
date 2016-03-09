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
            '<div class="row separator">
                <article class="col-sm-6">
                <h4><a href="/admin/post/'.$post->getId().'">'.htmlspecialchars($post->getTitle()).'</a></h4>
                <p>'.nl2br(htmlspecialchars($post->getContent())).'</p>
                </article>
                <p class="col-sm-4"><em>Par '.htmlspecialchars($post->getAuthor()).' le '.$post->getDate()->format('d-m-Y').'.</em> '.$comments.'</p>
                <p class="col-sm-2">
                    <a href="/admin/post/'.$post->getId().'" class="btn btn-info"><span class="glyphicon glyphicon-ok"></span></a>
                    <a href="/admin/post/edit/'.$post->getId().'" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="/admin/post/delete/'.$post->getId().'" class="btn btn-danger delete"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
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
