<?php

namespace View;

use Lib\Entity\Post;

class SingleView
{
    private $post;
    private $comments = [];

    public function __construct(Post $post)
    {
        $comments = [];
        $this->post = $post;
        $this->comments = $comments;
    }

    public function display()
    {
        $post = $this->post;
        $comments = $this->comments;
        $commentForm = new CommentForm();
        $display =
            '<div class="row">
            <h1 class="col-sm-8">'.htmlspecialchars($post->getTitle()).'</h1>
            <div class="col-sm-12">'.nl2br(htmlspecialchars($post->getContent())).'</div><div class="col-sm-offset-7 col-sm-5">
            <p><em>Par '.htmlspecialchars($post->getAuthor()).' le '.$post->getDate()->format('d-m-Y').' à '.$post->getDate()->format('H:i:s').'.</em>';

        if (empty($comments)) {
            $display .= ' Aucun commentaire.';
        }

        $display .= '</p>
            </div></div>';

        foreach ($comments as $comment) {
                $display .=
                '<div class="row">
                    <div class="col-sm-12"><img src="http://www.gravatar.com/avatar/'.$comment->getGHash().'" alt="Gravatar" />
                    <h3><a href="mailto:'.htmlspecialchars($comment->getMailAdress()).'">'.htmlspecialchars($comment->getPseudo()).'</a></h3></div>
                    <div class="col-sm-12">
                        <p>'.htmlspecialchars($comment->getComment()).'</p>
                    </div>
                    <p><em>Le '.$comment->getDate()->format('d-m-Y').' à '.$comment->getDate()->format('H:i:s').'</em></p>';
        }
        $display .=
        '<div><a href="/"><button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-chevron-left"> </span>Retour à l\'index</button></a></div>';

        $display .=
        '<div class="row">
            <div class="well col-sm-offset-2 col-sm-8">'.$commentForm->commentForm().'</div>
        </div>';

        return $display;
    }
}
