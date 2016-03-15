<?php

namespace Lib\Entity;

class Comment
{
    use \Lib\Hydrator;

    private $id;
    private $pseudo;
    private $mailAdress;
    private $gHash;
    private $comment;
    private $commentDate;
    private $postId;
    private $published;

    public function __construct($datas)
    {
        $this->hydrate($datas);
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        if (isset($id) && is_int($id)) {
            $this->id = $id;
        }
    }
    
    public function getPseudo()
    {
        return $this->pseudo;
    }
    
    public function setPseudo($pseudo)
    {
        if (isset($pseudo) && is_string($pseudo)) {
            $this->pseudo = $pseudo;
        }
    }
    
    public function getMailAdress()
    {
        return $this->mailAdress;
    }
    
    public function setMailAdress($mail)
    {
        if (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i', $mail)) {
            $this->mailAdress = $mail;
        }
    }

    public function getGHash()
    {
        return $this->gHash;
    }
    
    public function setGHash($gHash)
    {
        $this->gHash = $gHash;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        if (is_string($comment)) {
            $this->comment = $comment;
        }
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    public function setCommentDate($date)
    {
        $this->commentDate = $date;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function setPostId($postId)
    {
        if (is_int($postId)) {
            $this->postId = $postId;
        }
    }

    public function getPublished()
    {
        return $this->published;
    }
    
    public function setPublished($pub)
    {
        $this->published = $pub;
    }
}
