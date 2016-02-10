<?php

namespace Model;

use Lib\Entity\Post;
use Model\PDOFactory;
use \PDO;

class BlogManager
{
    protected $dao;
    protected $offset;
    protected $limit;

    public function __construct()
    {
        $this->dao = PDOFactory::getMysqlCo();
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function setOffset($offset)
    {
        if (is_int($offset) && isset($offset)) {
            $this->offset = $offset;
        }
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        if (is_int($limit) && isset($limit)) {
            $this->limit = $limit;
        }
    }

    public function getPosts($page)
    {
        $currentOffset = ($page-1) * $this->offset;

        $query = $this->dao->prepare('SELECT * FROM blog_posts ORDER BY date DESC LIMIT :offset, :limit');
        $query->bindParam(':offset', $currentOffset, \PDO::PARAM_INT);
        $query->bindParam(':limit', $this->limit, \PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Lib\Entity\Post');

        $result = $query->fetchAll();

        return $result;
    }

    public function getSinglePost($id)
    {
        $query = $this->dao->prepare('SELECT * FROM blog_posts WHERE id = :id');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Lib\Entity\Post');

        $result = $query->fetchObject('\Lib\Entity\Post');

        return $result;
    }

    public function countPosts()
    {
        $rows = $this->dao->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
        return $rows;
    }
}
