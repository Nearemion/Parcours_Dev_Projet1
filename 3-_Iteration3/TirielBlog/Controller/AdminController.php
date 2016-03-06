<?php

namespace Controller;

use Lib\Controller;
use Model\AdminManager;
use Web\Admin\Index;
use Web\Admin\SingleView;
use Web\Admin\UserIndex;

class AdminController extends Controller
{
    protected $totalPages;

    public function __construct(AdminManager $manager)
    {
        parent::__construct($manager);
        $this->setTotalPages();
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }

    public function setTotalPages()
    {
        $this->totalPages = ceil($this->manager->countPosts() / $this->manager->getLimit());
    }

    public function isAdmin()
    {
        /*if ($_SESSION['role'] == 2) {*/
            return true;/*
        } else {
            return header('Location: /login');/*
        }*/
    }

    public function indexAction($page = 1)
    {
        if (isset($_POST['username'])) {
            $user = $this->manager->getUserbyName($username);

            if (password_verify($_POST['password'], $user->getPassword())) {
                $_SESSION['is_auth'] = true;
                $_SESSION['id'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['role'] = $user->getRole();
            }
        }
        
        if ($this->isAdmin()) {
            $posts = $this->manager->getPosts($page);
            foreach ($posts as $post) {
                $post->setDate(new \DateTime($post->getDate()));
            }

            $pages = $this->totalPages;

            $index = new Index($posts, $pages);
            $content = $index->display($page);

            return $content;
        }
    }

    public function viewAction($id)
    {
        $post = $this->manager->getSinglePost($id);
        $page = new SingleView($post);
        $content = $page->display();

        return $content;
    }

    public function userAction($page = 1)
    {
        if ($this->isAdmin()) {
            $users = $this->manager->getUsers($page);

            $userPages = ceil($this->manager->countUsers() / $this->manager->getLimit());

            $index = new UserIndex($users, $userPages);
            $content = $index->display($page);

            return $content;
        }
    }

    public function newUserAction()
    {
        $username = $_POST['username'];

        $options = [
                'cost' => 10,
                'salt' => password_hash(file_get_contents(__DIR__.'/../Lib/Salt/salt'), PASSWORD_DEFAULT, ['cost' => 5])
        ];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);

        $role = $_POST['role'];

        $this->manager->addUser($username, $password, $role);
    }

    public function editUserAction($id)
    {
        return;
    }

    public function deleteUserAction($id)
    {
        return;
    }

    public function newPostAction($id)
    {
        return;
    }

    public function editPostAction($id)
    {
        return;
    }

    public function deletePostAction($id)
    {
        return;
    }
}
