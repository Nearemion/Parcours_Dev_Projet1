<?php

namespace Model;

use Lib\Manager;

class AdminManager extends Manager
{
    public function setLimit()
    {
        $nodes = $this->config->getElementsByTagName('postsperpage');
        foreach ($nodes as $node) {
            if ($node->getAttribute('page') == 'admin') {
                $this->limit = intval($node->getAttribute('limit'));
            }
        }
    }
}
