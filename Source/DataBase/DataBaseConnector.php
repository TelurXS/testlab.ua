<?php

namespace DataBase;

use const Config\DB_HOST;
use const Config\DB_NAME;
use const Config\DB_USER;
use const Config\DB_PASSWORD;

use PDO;
use Exception;

class DataBaseConnector
{
    public static function Connect($host, $name, $user, $password)
    {
        try
        {
            return new PDO("mysql:host=".$host.";dbname=".$name, $user, $password);
        }
        catch (Exception $e)
        {
            Dump($e);
        }
    }

    public static function Default()
    {
        return self::Connect(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
    }
}

$defCon = DataBaseConnector::Default();


?>