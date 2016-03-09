<?php

namespace Web\Admin;

use Lib\Entity\User;
use Web\Admin\Admin;

class UserIndex extends Admin
{
    private $users;
    private $pages;

    public function __construct($users, $pages)
    {
        $this->users = $users;
        $this->pages = $pages;
    }

    public function constName($role) {
        $userClass = new \ReflectionClass('\Lib\Entity\User');
        $constants = $userClass->getConstants();

        $constName = null;
        foreach ($constants as $name => $value)
        {
            if ($value == $role)
            {
                $constName = $name;
                break;
            }
        }

        return $constName;
    }

    public function display($page)
    {
        $content = '<h1>Liste des utilisateurs de ce blog:</h1><br />';
        $users = $this->users;
        $pages = $this->pages;

        foreach ($users as $user) {
            $roles = $user->getRoles();
            $content .=
            '<article class="row separator">
                <h4 class="col-sm-6">'.$user->getUsername().'</h4>
                <p class="col-sm-4">Role: '.$this->constName($user->getRole()).'</p>
                <p class="col-sm-2">
                    <a href="/admin/user/edit/'.$user->getId().'" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
                    <a href="/admin/user/delete/'.$user->getId().'" class="btn btn-danger delete"><span class="glyphicon glyphicon-remove"></span></a>
                </p>
            </article>';
        }

        $content .= '<div><ul class="pagination">';
        for ($i=1; $i <= $pages; $i++) {
            $content .= '<li';
            if ($i == $page) {
                $content .= ' class="active"';
            }
            $content .= '><a href="/'.$i.'">'.$i.'</a></li>';
        }
        $content .= '</ul></div>';

        return $this->getPage($content);
    }
}
