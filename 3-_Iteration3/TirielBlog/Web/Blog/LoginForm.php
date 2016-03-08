<?php

namespace Web\Blog;

use Lib\Form\FormType;
use Lib\Form\Input;
use Web\Blog\Blog;

class LoginForm extends Blog
{
    public function LoginForm()
    {
        $username = new Input(array(
            'type' => 'text',
            'name' => 'username',
            'label' => 'Nom d\'utilisateur :',
            'attributes' => 'class="form-control"'
        ));

        $password = new Input(array(
            'type' => 'password',
            'name' => 'password',
            'label' => 'Mot de passe :',
            'attributes' => 'class="form-control"'
        ));

        $submit = new Input(array(
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Se connecter',
            'attributes' => 'class="btn btn-primary"'
        ));

        $form = new FormType(array(
            'action' => '/admin/',
            'method' => 'post',
            'attributes' => 'class="well" id="login"'
        ));
        $form->addField($username);
        $form->addField($password);
        $form->addField($submit);

        $content = 
        '<h3 class="text-center">Connexion :</h3>'.$form->createView();

        return $this->getPage($content);
    }
}
