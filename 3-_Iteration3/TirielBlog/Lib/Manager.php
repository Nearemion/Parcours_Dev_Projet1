<?php

namespace Lib;

use Lib\Entity\Comment;
use Lib\Entity\Post;
use Model\PDOFactory;

abstract class Manager
{
    protected $dao;
    protected $config;
    protected $offset;
    protected $limit;

    public function __construct()
    {
        $this->config = json_decode(file_get_contents(__DIR__.'/../Config/config.json'));
        $this->setLimit();
        $this->setOffset($this->limit);
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

    abstract public function setLimit();

    public function getPosts($page)
    {
        $currentOffset = ($page-1) * $this->offset;
        $posts = [];

        $query = $this->dao->prepare('SELECT * FROM blog_posts ORDER BY date DESC LIMIT :offset, :limit');
        $query->bindParam(':offset', $currentOffset, \PDO::PARAM_INT);
        $query->bindParam(':limit', $this->limit, \PDO::PARAM_INT);
        $query->execute();

        while (($row = $query->fetch(\PDO::FETCH_ASSOC)) !== false) {
            $post = new Post($row);
            $posts[] = $post;
        }

        return $posts;
    }

    public function getSinglePost($id)
    {
        $result = [];
        $query = $this->dao->prepare('SELECT blog_posts.id as id, blog_posts.title, blog_posts.author, blog_posts.content, blog_posts.date as postDate, blog_comments.id as commentId, blog_comments.pseudo, blog_comments.mailAdress, blog_comments.gHash, blog_comments.comment, blog_comments.commentDate, blog_comments.postId FROM blog_posts LEFT JOIN blog_comments ON blog_posts.id = blog_comments.postId WHERE blog_posts.id = :id AND blog_comments.published = 1');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        while (($row = $query->fetch(\PDO::FETCH_ASSOC)) !== false) {
            $postArray = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'author' => $row['author'],
                'content' => $row['content'],
                'date' => new \DateTime($row['postDate']));
            $post = new Post($postArray);
            $result[] = $post;

            if (!empty($row['commentId'])) {
                $commentArray = array(
                    'id' => $row['commentId'],
                    'pseudo' => $row['pseudo'],
                    'mailAdress' => $row['mailAdress'],
                    'gHash' => $row['gHash'],
                    'comment' => $row['comment'],
                    'commentDate' => new \DateTime($row['commentDate']));
                $comment = new Comment($commentArray);
                $result[] = $comment;
            }
        }
        if (empty($result)) {
            header('Location:./View/404.php');
        }

        return $result;
    }

    public function countPosts()
    {
        $rows = $this->dao->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
        return $rows;
    }
}
