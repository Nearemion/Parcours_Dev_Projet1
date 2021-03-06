<?php

namespace View;

use Lib\Form\FormType;
use Lib\Form\Input;
use Lib\Form\Textarea;

class CommentForm
{
    public function commentForm($id)
    {
        $postId = new Input(array(
            'type' => 'hidden',
            'name' => 'postId',
            'value' => $id
        ));
        $pseudo = new Input(array(
            'type' => 'text',
            'name' => 'pseudo',
            'label' => 'Nom ou pseudo :',
            'labelAttributes' => 'class="col-sm-4"',
            'attributes' => 'placeholder="Votre nom" class="form-control col-sm-8"'
        ));
        $mail = new Input(array(
            'type' => 'email',
            'name' => 'email',
            'label' => 'Adresse mail :',
            'labelAttributes' => 'class="col-sm-4"',
            'attributes' => 'placeholder="email@example.com" class="form-control col-sm-8"'
        ));
        $comment = new Textarea(array(
            'name' => 'comment',
            'label' => 'Commentaire :*',
            'labelAttributes' => 'class="col-sm-4"',
            'attributes' => 'class="form-control col-sm-8" required'
        ));
        $submit = new Input(array(
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Commenter',
            'attributes' => 'class="btn btn-primary"'
        ));
                
        $form = new FormType(array(
            'action' => '/post-'.$id,
            'method' => 'post',
            'attributes' => 'class="form-horizontal"'
        ));
        $form->addField($postId);
        $form->addField($pseudo);
        $form->addField($mail);
        $form->addField($comment);
        $form->addField($submit);

        return $form->createView();
    }
}
