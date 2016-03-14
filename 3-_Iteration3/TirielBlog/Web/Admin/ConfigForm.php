<?php

namespace Web\Admin;

use Lib\Form\FormType;
use Lib\Form\Input;

class ConfigForm extends Admin
{
    private $config;

    public function __construct()
    {
        $this->config = json_decode(file_get_contents(__DIR__.'/../../Config/config.json'));
    }

    public function configForm()
    {
        $config = $this->config;

        $adminPosts = new Input(array(
            'type' => 'text',
            'name' => 'postsAdmin',
            'label' => 'Nombre de posts/utilisateurs sur l\'index de l\'Administration :',
            'value' => strval($config->postsperpage->admin),
            'attributes' => 'class="form-control" required'
        ));

        $blogPosts = new Input(array(
            'type' => 'text',
            'name' => 'postsBlog',
            'label' => 'Nombre de posts/utilisateurs sur l\'index du Blog :',
            'value' => strval($config->postsperpage->blog),
            'attributes' => 'class="form-control" required'
        ));

        $modComs = new Input(array(
            'type' => 'checkbox',
            'name' => 'moderateComs',
            'value' => '1',
            'label' => 'Modérer les commentaires Avant publication :',
        ));

        if ($config->moderate_comments == true) {
            $modComs->setAttributes('class="form-control" checked');
        } else {
            $modComs->setAttributes('class="form-control"');
        }

        $submit = new Input(array(
            'type' => 'submit',
            'name' => 'submit',
            'value' => 'Sauvegarder',
            'attributes' => 'class="btn btn-primary"'
        ));

        $form = new FormType(array(
            'action' => '/admin/config/save',
            'method' => 'post',
            'attributes' => 'class="well" id="configForm"'
        ));

        $form->addField($adminPosts);
        $form->addField($blogPosts);
        $form->addField($modComs);
        $form->addField($submit);

        $content = '<h3>Page de configuration</h3>';
        $content .= $form->createView();

        return $this->getPage($content);
    }
}
