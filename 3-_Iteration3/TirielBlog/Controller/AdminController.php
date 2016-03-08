<?php

namespace Controller;

use Lib\Controller;
use Model\AdminManager;
use Web\Admin\Index;
use Web\Admin\SingleView;
use Web\Admin\UserForm;
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
        if ($_SESSION['role'] == 2) {
            return true;
        } else {
            return header('Location: /login');
        }
    }

    public function logoutAction()
    {
        session_destroy();
        header('Location: /');
    }

    public function indexAction($page = 1)
    {
        if (isset($_POST['username'])) {
            $username = $_POST['username'];

            if (($_POST['csrf_token'] == $_SESSION['token'])/* && ($_POST['csrf_token_time'] >= (time() - (15*60)))*/) {
                $user = $this->manager->getUserByName($username);

                if (password_verify($_POST['password'], $user->getPassword())) {
                    $_SESSION['is_auth'] = true;
                    $_SESSION['id'] = $user->getId();
                    $_SESSION['username'] = $user->getUsername();
                    $_SESSION['role'] = $user->getRole();

                    header('Location: /admin/');
                }
            } else {
                return header('Location: /login');
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

    public function userFormAction($id = null)
    {
        $userForm = new UserForm;
        if (!empty($id)) {
            $user = $this->manager->getUserbyId($id);
            return $userForm->userForm($user);

        } else {
            return $userForm->userForm();
        }
    }

    public function saveUserAction()
    {
        if ($_POST['password'] != $_POST['password2']) {
            header('Location: /admin/user/new');
        }

        $username = $_POST['username'];

        $options = [
                'cost' => 10,
                'salt' => password_hash(file_get_contents(__DIR__.'/../Lib/Salt/salt'), PASSWORD_DEFAULT, ['cost' => 5])
        ];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);

        $role = $_POST['role'];

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            
            $this->manager->editUser($id, $username, $password, $role);
        } else {
            $this->manager->addUser($username, $password, $role);
        }
        
        return header('Location: /admin/user');
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
