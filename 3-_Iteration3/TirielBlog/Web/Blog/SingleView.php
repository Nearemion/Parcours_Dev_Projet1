<?php

namespace Web\Blog;

use Lib\Entity\Post;
use Web\Blog\Blog;

class SingleView extends Blog
{
    private $post;
    private $comments = [];

    public function __construct($results)
    {
        foreach ($results as $result) {
            if (get_class($result) == 'Lib\Entity\Post') {
                $this->post = $result;
            } else if (get_class($result) == 'Lib\Entity\Comment') {
                $this->comments[] = $result;
            } else {
                $this->post = $results;
            }
        }
    }

    public function display()
    {
        $post = $this->post;
        $comments = $this->comments;
        $commentForm = new CommentForm();

        $content =
            '<div class="row">
            <h1 class="col-sm-8">'.htmlspecialchars($post->getTitle()).'</h1>
            <div class="col-sm-12">'.nl2br(htmlspecialchars($post->getContent())).'</div><div class="col-sm-offset-7 col-sm-5">
            <p><em>Par '.htmlspecialchars($post->getAuthor()).' le '.$post->getDate()->format('d-m-Y').' à '.$post->getDate()->format('H:i:s').'.</em>';

        if (empty($comments)) {
            $content .= ' Aucun commentaire.';
        }

        $content .= '</p>
            </div></div>';

        foreach ($comments as $comment) {
                $content .=
                '<div class="row">
                    <div class="col-sm-12"><img src="http://www.gravatar.com/avatar/'.$comment->getGHash().'?s=80" alt="Gravatar" class="col-sm-1" />
                    <h3 class="col-sm-8"><a href="mailto:'.htmlspecialchars($comment->getMailAdress()).'">'.htmlspecialchars($comment->getPseudo()).'</a></h3></div>
                    <div class="col-sm-offset-1 col-sm-11">
                        <p>'.htmlspecialchars($comment->getComment()).'</p>
                    </div>
                    <p class="col-sm-offset-8"><em>Le '.$comment->getCommentDate()->format('Y-m-d').' à '.$comment->getCommentDate()->format('H:i:s').'</em></p></div>';
        }

        $content .=
        '<br /><div><a href="/"><button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-chevron-left"> </span>Retour à l\'index</button></a></div><br />';

        $content .=
        '<div class="row">
            <div class="well col-sm-offset-2 col-sm-8">'.$commentForm->commentForm($post->getId()).'<br />* : élément obligatoire.</div>
        </div>';

        return $this->getPage($content);
    }
}
