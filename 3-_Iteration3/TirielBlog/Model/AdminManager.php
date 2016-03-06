<?php

namespace Model;

use Lib\Entity\User;
use Lib\Manager;

class AdminManager extends Manager
{
    public function setLimit()
    {
        $nodes = $this->config->getElementsByTagName('postsperpage');
        foreach ($nodes as $node) {
            if ($node->getAttribute('page') == 'admin') {
                $this->limit = intval($node->getAttribute('limit'));
            }
        }
    }

    public function getUserbyName($username)
    {
        $query = $this->dao->prepare('SELECT * FROM blog_users WHERE username = '.$username);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Lib\Entity\User');

        return $query->fetchAll();
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

    public function addUser($username, $password, $role)
    {
        $query = $this->dao->prepare('INSERT INTO blog_users (username, password, role) VALUES (:username, :password, :role)');
        $query->bindParam(':username', $username, \PDO::PARAM_STR);
        $query->bindParam(':password', $password, \PDO::PARAM_STR);
        $query->bindParam(':role', $role, \PDO::PARAM_INT);
        return $query->execute();
    }

    public function countUsers()
    {
        $rows = $this->dao->query('SELECT COUNT(*) FROM blog_users')->fetchColumn();
        return $rows;
    }
}
