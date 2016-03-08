<?php

namespace Lib\Entity;

class User
{
    use \Lib\Hydrator;

    private $id;
    private $username;
    private $password;
    private $role;
    public $roles = [];

    const NONE = 0;
    const AUTHOR = 1;
    const ADMIN = 2;

    public function __construct($data)
    {
        $this->hydrate($data);
        $this->setRoles(array(self::NONE, self::AUTHOR, self::ADMIN));
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
        $this->role = intval($role);
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles($roles)
    {
        foreach ($roles as $role) {
            $this->roles[] = $role;
        }
    }
}