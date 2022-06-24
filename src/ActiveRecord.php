<?php

namespace Post;

use Dotenv\Dotenv;
use PDO;

require_once('../vendor/autoload.php');
$dotenv = Dotenv::createImmutable('../');

$dotenv->load();


class ActiveRecord
{
    protected static $connection;

    protected static function connect()
    {
        if (!isset(self::$connection)) {
            $dsn = "pgsql:host=" . $_ENV['HOST'] . ";port=" . $_ENV['PORT'] . ";dbname=" . $_ENV['DBNAME'];
            self::$connection = new PDO(
                $dsn,
                $_ENV['USER'],
                $_ENV['PASSWORD']
            );
        }
    }

    protected static function unsetConnect()
    {
        self::$connection = null;
    }
}