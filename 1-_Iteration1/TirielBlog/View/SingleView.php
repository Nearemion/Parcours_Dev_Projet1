<?php

namespace View;

use Lib\Entity\Post;

class SingleView
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function display()
    {
        $post = $this->post;
        $display =
            '<div class="row">
            <h1 class="col-sm-8">'.htmlspecialchars($post->getTitle()).'</h1>
            <div class="col-sm-12">'.nl2br(htmlspecialchars($post->getContent())).'</div><div class="col-sm-8">
            <p><em>Par '.htmlspecialchars($post->getAuthor()).' le '.$post->getDate('d-m-Y').' à '.$post->getDate('H:i:s').'</em></p>
            </div></div>
            <div><a href="/"><button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-chevron-left"> </span>Retour à l\'index</button></a></div>';

        return $display;
    }
}
