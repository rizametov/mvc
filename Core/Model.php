<?php declare(strict_types=1);

namespace Core;

use \PDO;
use App\Config;

abstract class Model
{
    protected static function getDB(): PDO
    {
        static $db = null;

        if ($db === null) {
            try {
                $db = new PDO(
                    sprintf('mysql:host=%s;dbname=%s;charset=utf8', Config::DB_HOST, Config::DB_NAME),
                    Config::DB_USER, 
                    Config::DB_PASS, 
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_STRINGIFY_FETCHES => false
                    ]
                );
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        return $db;
    }
}