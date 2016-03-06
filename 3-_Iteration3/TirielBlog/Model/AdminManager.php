<?php

namespace Model;

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

    public function addUser($username, $password, $role)
    {
        $query = $this->dao->prepare('INSERT INTO blog_users (username, password, role) VALUES (:username, :password, :role)');
        $query->bindParam(':username', $username, \PDO::PARAM_STR);
        $query->bindParam(':password', $password, \PDO::PARAM_STR);
        $query->bindParam(':role', $role, \PDO::PARAM_INT);
        return $query->execute();
    }
}
