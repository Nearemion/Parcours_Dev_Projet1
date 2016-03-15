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
                <div class="col-sm-12">'.nl2br(htmlspecialchars($post->getContent())).'</div>
                <div class="col-sm-offset-7 col-sm-5">
                    <p><em>Par '.htmlspecialchars($post->getAuthor()).' le '.$post->getDate()->format('d-m-Y').' à '.$post->getDate()->format('H:i:s').'.</em>';

        if (empty($comments)) {
            $content .= ' Aucun commentaire.';
        }

        $content .= 
            '</p>
            </div>
        </div>
            <div class="row">
                <a href="/" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-chevron-left"> </span>Retour à l\'index</a>
            </div><br />';

        foreach ($comments as $comment) {
            if ($comment->getPublished() == 1) {
                $content .=
                '<aside class="separator">
                    <div class="row">
                        <img src="http://www.gravatar.com/avatar/'.$comment->getGHash().'?s=80" alt="Gravatar" class="col-sm-1" />
                        <div class="col-sm-11">
                            <h3 class="col-sm-10"><a href="mailto:'.htmlspecialchars($comment->getMailAdress()).'">'.htmlspecialchars($comment->getPseudo()).'</a></h3>
                            <p class="col-sm-2"><em>Le '.$comment->getCommentDate()->format('Y-m-d').' à '.$comment->getCommentDate()->format('H:i:s').'</em></p>
                            <div class="col-sm-11">
                                <p>'.htmlspecialchars($comment->getComment()).'</p>
                            </div>
                        </div>
                    </div>
                </aside><br />';
            } else {
                $content .=
                '<aside class="separator">
                <h4>Commentaire en cours de modération</h4>
                </aside><br />';
            }
        }

        $commentForm = new CommentForm;
        $content .= $commentForm->commentForm($post->getId()).'<br />';;

        return $this->getPage($content);
    }
}
