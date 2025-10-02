<?php
// src/Core/Database.php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(array $config): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        try {
            self::$pdo = new PDO(
                $config['db']['dsn'],
                $config['db']['user'],
                $config['db']['pass'],
                $config['db']['options']
            );
        } catch (PDOException $e) {
            // Nikad ne odavati kredencijale u poruci
            die('Database connection error.');
        }

        return self::$pdo;
    }
}
