<?php

namespace Lib\Entity;

class Post
{
    use \Lib\Hydrator;

    private $id;
    private $title;
    private $content;
    private $author;
    private $nbComment;
    private $date;

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
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getNbComment()
    {
        return $this->nbComment;
    }

    public function setNbComment($nb)
    {
        $this->nbComment = $nb;
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
