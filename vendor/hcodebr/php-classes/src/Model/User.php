<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;

class User
{
    
    public static function login($login, $password)
    {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM")

    }

}