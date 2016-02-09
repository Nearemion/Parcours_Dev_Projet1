<?php

namespace TirielBlog\Model;

class PDOFactory
{
    public static function getMysqlCo()
    {
        $db = new PDO('mysql:host=localhost;dbname=tiriel_blog', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}
