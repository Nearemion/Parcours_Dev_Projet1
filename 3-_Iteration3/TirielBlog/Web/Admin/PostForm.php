<?php

namespace Web\Admin;

use Lib\Form\FormType;
use Lib\Form\Input;
use Lib\Form\Textarea;

class PostForm extends Admin
{
    public function postForm($post = null)
    {
        $title = new Input(array(
            'type' => 'text',
            'name' => 'title',
            'label' => 'Titre de l\'article :',
            'attributes' => 'class="form-control" required'
            ));

        $author = new Input(array(
            'type' => 'text',
            'name' => 'author',
            'label' => 'Auteur :',
            'attributes' => 'class="form-control"',
            'value' => $_SESSION['username']
            ));

        $content = new Textarea(array(
            'name' => 'content',
            'label' => 'Contenu :',
            'attributes' => 'rows="10" class="form-control" id="content" required'
            ));

        $submit = new Input(array(
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Enregistrer',
            'attributes' => 'class="btn btn-primary"'
            ));

        if (!is_null($post)) {
            $title->setValue($post[0]->getTitle());
            $author->setValue($post[0]->getAuthor());
            $content->setPlaceholder($post[0]->getContent());
        }

        $form = new FormType(array(
            'action' => '/admin/post/save',
            'method' => 'post',
            'attributes' => 'class="well"'
            ));

        $form->addField($title);
        $form->addField($author);
        $form->addField($content);
        $form->addField($submit);

        if (!is_null($post)) {
            $content = '<h3>Editer un post :</h3>';
        } else {
            $content = '<h3>Nouveau post :</h3>';
        }

        $content .= $form->createView();

        return $this->getPage($content);
    }
}