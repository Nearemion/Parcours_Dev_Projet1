<?php

namespace Model;

use Lib\Entity\Comment;
use Lib\Entity\Post;
use Lib\Entity\User;
use Lib\Manager;

class AdminManager extends Manager
{
    public function setLimit()
    {
        $this->limit = $this->config->postsperpage->admin;
    }

    public function getUserByName($username)
    {
        $query = $this->dao->prepare('SELECT * FROM blog_users WHERE username = :username');
        $query->bindParam(':username', $username, \PDO::PARAM_STR);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        $user = new User($row);

        return $user;
    }

    public function getUserbyId($id)
    {
        $query = $this->dao->prepare('SELECT * FROM blog_users WHERE id = '.$id);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Lib\Entity\User');

        return $query->fetchAll();
    }

    public function getUsers($page = 1)
    {
        $currentOffset = ($page-1) * $this->offset;
        $users = [];

        $query = $this->dao->prepare('SELECT * FROM blog_users ORDER BY id DESC LIMIT :offset, :limit');
        $query->bindParam(':offset', $currentOffset, \PDO::PARAM_INT);
        $query->bindParam(':limit', $this->limit, \PDO::PARAM_INT);
        $query->execute();

        while (($row = $query->fetch(\PDO::FETCH_ASSOC)) !== false) {
            $user = new User($row);
            $users[] = $user;
        }

        return $users;
    }

    public function savePost(Post $post)
    {
        if (!is_null($post->getId())) {
            $query = $this->dao->prepare('UPDATE blog_posts SET title = :title, content = :content, author = :author, date = NOW() WHERE id = :id');
            $query->bindParam(':id', $post->getId(), \PDO::PARAM_INT);
        } else {
            $query = $this->dao->prepare('INSERT INTO blog_posts (title, content, author, date) VALUES (:title, :content, :author, NOW())');
        }
        $query->bindParam(':title', $post->getTitle(), \PDO::PARAM_STR);
        $query->bindParam(':content', $post->getContent(), \PDO::PARAM_STR);
        $query->bindParam(':author', $post->getAuthor(), \PDO::PARAM_STR);

        return $query->execute;
    }

    public function addUser($username, $password, $role)
    {
        if (($_POST['csrf_token'] == $_SESSION['token'])/* && ($_POST['csrf_token_time'] >= (time() - (15*60)))*/) {
            $query = $this->dao->prepare('INSERT INTO blog_users (username, password, role) VALUES (:username, :password, :role)');
            $query->bindParam(':username', $username, \PDO::PARAM_STR);
            $query->bindParam(':password', $password, \PDO::PARAM_STR);
            $query->bindParam(':role', $role, \PDO::PARAM_INT);
            return $query->execute();
        }
    }

    public function editUser($id, $username, $password, $role)
    {
        if (($_POST['csrf_token'] == $_SESSION['token'])/* && ($_POST['csrf_token_time'] >= (time() - (15*60)))*/) {
            $query = $this->dao->prepare('UPDATE blog_users SET username = :username, password = :password, role = :role WHERE id ='.$id);
            $query->bindParam(':username', $username, \PDO::PARAM_STR);
            $query->bindParam(':password', $password, \PDO::PARAM_STR);
            $query->bindParam(':role', intval($role), \PDO::PARAM_INT);
            return $query->execute();
        }
    }

    public function deleteUser($id)
    {
        $query = $this->dao->prepare('DELETE FROM blog_users WHERE id ='.$id);
        return $query->execute();
    }

    public function deletePost($id)
    {
        $query = $this->dao->prepare('DELETE FROM blog_posts WHERE id ='.$id);
        return $query->execute();
    }

    public function saveModComsConfig($bool)
    {
        if (is_bool($bool)) {
            $query = $this->dao->prepare('ALTER TABLE blog_comments MODIFY published TINYINT UNSIGNED NOT NULL DEFAULT :bool');

            if ($bool == true) {
                $int = 0;
                $query->bindParam(':bool', $int, \PDO::PARAM_INT);
            } else {
                $int = 1;
                $query->bindParam(':bool', $int, \PDO::PARAM_INT);
            }

            $query->execute();
            return header('Location: /admin/config');
        }
    }

    public function getCom($id)
    {
        $query = $this->dao->prepare('SELECT * FROM blog_comments WHERE id ='.$id);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        $comment = new Comment($row);

        return $comment;
    }

    public function publishCom($id)
    {
        $query = $this->dao->prepare('UPDATE blog_comments SET published = 1 WHERE id ='.$id);
        return $query->execute();
    }

    public function comDelete($id)
    {
        $query = $this->dao->prepare('DELETE FROM blog_comments WHERE id ='.$id);
        return $query->execute();
    }

    public function countUsers()
    {
        $rows = $this->dao->query('SELECT COUNT(*) FROM blog_users')->fetchColumn();
        return $rows;
    }
}
