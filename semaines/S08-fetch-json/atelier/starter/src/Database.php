<?php

/**
 * La connexion à la base. Une seule instance de PDO pour toute la requête.
 * Usage : $pdo = Database::connection();
 */
class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo === null) {
            $configFile = __DIR__ . '/../config.php';
            if (!is_file($configFile)) {
                exit('Fichier config.php manquant : copiez config.example.php en config.php.');
            }
            $config = require $configFile;

            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                $config['db_host'],
                $config['db_port'],
                $config['db_name']
            );

            self::$pdo = new PDO($dsn, $config['db_user'], $config['db_password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        return self::$pdo;
    }
}
