<?php

namespace Lib\Entity;

class Comment
{
    private $id;
    private $pseudo;
    private $mailAdress;
    private $gHash;
    private $comment;
    private $date;
    
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
    
    public function setGHash()
    {
        $this->gHash = md5(strtolower(trim($this->mailAdress)));
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

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}
