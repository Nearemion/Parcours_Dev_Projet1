<?php

namespace Model;

use Lib\Entity\Comment;
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
        $posts = [];

        $query = $this->dao->prepare('SELECT * FROM blog_posts ORDER BY date DESC LIMIT :offset, :limit');
        $query->bindParam(':offset', $currentOffset, \PDO::PARAM_INT);
        $query->bindParam(':limit', $this->limit, \PDO::PARAM_INT);
        $query->execute();

        while (($row = $query->fetch(PDO::FETCH_ASSOC)) !== false) {
            $post = new Post($row);
            $posts[] = $post;
        }

        return $posts;
    }

    public function getSinglePost($id)
    {
        $result = [];
        $query = $this->dao->prepare('SELECT blog_posts.id as id, blog_posts.title, blog_posts.author, blog_posts.content, blog_posts.date as postDate, blog_comments.id as commentId, blog_comments.pseudo, blog_comments.mailAdress, blog_comments.gHash, blog_comments.comment, blog_comments.commentDate, blog_comments.postId FROM blog_posts LEFT JOIN blog_comments ON blog_posts.id = blog_comments.postId WHERE blog_posts.id = :id');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        while (($row = $query->fetch(PDO::FETCH_ASSOC)) !== false) {
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
                    'date' => new \DateTime($row['commentDate']));
                $comment = new Comment($commentArray);
                $result[] = $comment;
            }
        }

        return $result;
    }

    public function countPosts()
    {
        $rows = $this->dao->query('SELECT COUNT(*) FROM blog_posts')->fetchColumn();
        return $rows;
    }

    public function processCommentForm()
    {
        if ($_POST['csrf_token'] == $_SESSION['token']) {
            if (!empty($_POST['pseudo'])) {
                $pseudo = htmlspecialchars($_POST['pseudo']);
            } else {
                $pseudo = 'A.Nonymous';
            }

            if (!empty($_POST['email'])) {
                $mail = htmlspecialchars($_POST['email']);
            } else {
                $mail = "email@example.com";
            }

            $gHash = md5(strtolower(trim($mail)));
            $comment = htmlspecialchars($_POST['comment']);
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $postId = $_POST['postId'];

            $query = $this->dao->prepare('INSERT INTO blog_comments (pseudo, mailAdress, gHash, comment, commentDate, postId) VALUES (:pseudo, :mailAdress, :gHash, :comment, :commentDate, :postId)');
            $query->bindParam(':pseudo', $pseudo, \PDO::PARAM_STR);
            $query->bindParam(':mailAdress', $mail, \PDO::PARAM_STR);
            $query->bindParam(':gHash', $gHash, \PDO::PARAM_STR);
            $query->bindParam(':comment', $comment, \PDO::PARAM_STR);
            $query->bindParam(':commentDate', $date);
            $query->bindParam(':postId', $postId, \PDO::PARAM_INT);

            $query->execute();

            $update = $this->dao->prepare('UPDATE blog_posts SET nbComment = nbComment+1 WHERE id = :id');
            $update->bindParam(':id', $_POST['postId'], \PDO::PARAM_INT);
            $update->execute();
        }
    }
}
