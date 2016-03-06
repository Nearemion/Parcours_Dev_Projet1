<?php

namespace Web\Admin;

class Admin
{

    public function activeTab($string)
    {
        if (preg_match('#^'.$string.'$#', $_SERVER['REQUEST_URI'])) {
            return ' class="active"';
        }
    }

    public function getPage($content)
    {
        $page = 
        '<nav class="col-sm-3">
            <h3>Menu d\'administration</h3>
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"'.$this->activeTab('/admin/').'><a href="/admin/">Accueil</a></li>
                <li role="presentation"'.$this->activeTab('/admin/post/new').'><a href="/admin/post/new">Nouveau post</a></li>
                <li role="presentation"'.$this->activeTab('/admin/user/').'><a href="/admin/user/">Utilisateurs</a></li>
                <li role="presentation"'.$this->activeTab('/admin/user/new').'><a href="/admin/user/new">Nouvel utilisateur</a></li>
                <li role="presentation"'.$this->activeTab('/logout').' ><a href="/logout">Déconnexion</a></li>
            </ul>
        </nav>
        <article class="col-sm-9">'.$content.'</article>';

        return $page;
    }
}
