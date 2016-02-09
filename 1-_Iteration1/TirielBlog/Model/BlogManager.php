<?php

namespace TirielBlog\Model;

class BlogManager
{
    protected $dao;
    protected $offset;
    protected $limit;

    public function __construct($offset, $limit)
    {
        $this->dao = PDOFactory::getMysqlCo();
        $this->offset = (int) $offset;
        $this->limit = (int) $limit;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getPosts($page)
    {
        $currentOffset = ($page-1) * $this->offset;

        $query = $this->dao->prepare('SELECT (*) FROM blog_posts ORDER BY date DESC LIMIT :offset, :limit');
        $query->bindParam(':offset', $currentOffset, PDO::PARAM_INT);
        $query->bindParam(':limit', $this->limit, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function countPosts()
    {
        $rows = $this->dao->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
        return $rows;
    }
}
