<?php

namespace Model;

use \PDO;

class PDOFactory
{
    public static function getMysqlCo()
    {
        $db = new \PDO('mysql:host=localhost;dbname=tiriel_blog', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("SET CHARACTER SET utf8");

        return $db;
    }
}
