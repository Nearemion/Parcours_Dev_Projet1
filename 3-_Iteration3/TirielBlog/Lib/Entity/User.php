<?php

namespace Lib\Entity;

class User
{
    private $id;
    private $username;
    private $password;
    private $role;
    private $roles;

    const NONE = 0;
    const AUTHOR = 1;
    const ADMIN = 2;

    public function __construct($id, $username, $password, $role)
    {
        $this->setId($id);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setRole($role);
        $this->setRoles([NONE, AUTHOR, ADMIN]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        if (in_array($role, $this->getRoles())) {
           $this->role = $role;
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
}