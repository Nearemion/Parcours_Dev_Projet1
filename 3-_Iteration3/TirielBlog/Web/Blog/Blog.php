<?php

namespace Web\Blog;

class Blog
{
    protected $page;

    public function getPage($content)
    {
        $this->page = 
        '<aside class="col-sm-3">
            <h3>Bienvenue sur mon blog!</h3>
            <p>Ce post est là pour expliquer le pourquoi du comment.<br /><br />
            En effet, ce blog est développé petit à petit, sous forme d\'itérations.
            Chaque itération permet d\'ajouter son lot de fonctionnalités à l\'ensemble, pour permettre d\'aboutir à la création d\'un mini CMS de blogging compact.<br /><br />
            Le tout est codé en PHP orienté objet, et le code source est consultable sur GitHub via le lien présent en bas de chaque page.<br /><br />
            Au terme de l\'itération 3, le système devrait être complet et utilisable, bien que perfectible et améliorable. Il comprendra un système d\'affichage de posts avec:<br />
            <ul>
                <li>un index listant les résumés derniers posts et un système de pagination</li>
                <li>une système de vue de chaque post dans son intégralité</li>
                <li>un système de commentaire avec possibilité d\'utilisation des Gravatar</li>
                <li>un système d\'administration avec authentification pour poster, éditer ou effacer des posts, modérer les commentaires à priori ou à posteriori, et une gestion des utilisateurs.</li>
            </ul>
            Merci pour votre lecture!</p>
        </aside>
        <article class="col-sm-9">'.$content.'</article>';

        return $this->page;
    }
}
