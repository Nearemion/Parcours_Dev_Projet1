<?php

namespace Web\Admin;

use Lib\Form\FormType;
use Lib\Form\Input;
use Lib\Form\Radio;

class UserForm extends Admin
{
    public function userForm($user = null)
    {
        $username = new Input(array(
            'type' => 'text',
            'name' => 'username',
            'label' => 'Nom d\'utilisateur :',
            'attributes' => 'class="form-control" required'
        ));

        $password1 = new Input(array(
            'type' => 'password',
            'name' => 'password',
            'label' =>'Mot de passe :',
            'attributes' => 'class="form-control" required'
        ));

        $password2 = new Input(array(
            'type' => 'password',
            'name' => 'password2',
            'label' =>'Répetez le mot de passe :',
            'attributes' => 'class="form-control" required'
        ));

        $role0 = new Radio(array(
            'type' => 'radio',
            'name' => 'role',
            'value' => '0',
            'label' => 'Aucun role',
            'attributes' => 'required'
        ));

        $role1 = new Radio(array(
            'type' => 'radio',
            'name' => 'role',
            'value' => '1',
            'label' => 'Auteur',
            'attributes' => 'required'
        ));

        $role2 = new Radio(array(
            'type' => 'radio',
            'name' => 'role',
            'value' => '2',
            'label' => 'Admin',
            'attributes' => 'required'
        ));

        $submit = new Input(array(
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Enregistrer',
            'attributes' => 'class="btn btn-primary"'
        ));

        $form = new FormType(array(
            'action' => '/admin/user/save',
            'method' => 'post',
            'attributes' => 'class="well" id="userForm"'
        ));

        $form->addField($username);
        $form->addField($password1);
        $form->addField($password2);
        $form->addField($role0);
        $form->addField($role1);
        $form->addField($role2);
        $form->addField($submit);

        if (!empty($user)) {
            $username->setValue($user->getUsername());
            $password1->setValue($user->getPassword());
            $password2->setValue($user->getPassword());

            $id = new Input(array(
                'type' => 'hidden',
                'name' => 'id',
                'value' => $user->getId()
            ));
            $form->addField($id);
        }

        if (isset($_POST['username'])) {
            $username->setValue($_POST['username']);           
        }

        $content = '<h3 class="text-center">';
        if (!empty($user)) {
            $content .= 'Editer un utilisateur</h3>';
        } else {
            $content .= 'Ajouter un utilisateur</h3>';
        }

        $content .= $form->createView();

        return $this->getPage($content);
    }
}
