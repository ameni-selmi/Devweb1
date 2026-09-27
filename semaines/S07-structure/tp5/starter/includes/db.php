<?php
// Connexion à la base de données : une seule connexion PDO par requête HTTP.

function db(): PDO
{
    static $pdo = null;   // gardée entre deux appels de db() pendant la même requête

    if ($pdo === null) {
        $configFile = __DIR__ . '/../config.php';
        if (!file_exists($configFile)) {
            exit('Fichier config.php manquant : copiez config.example.php en config.php.');
        }
        $config = require $configFile;

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $config['db_host'],
            $config['db_port'],
            $config['db_name']
        );

        $pdo = new PDO($dsn, $config['db_user'], $config['db_password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // une erreur SQL lance une exception
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // les lignes sont des tableaux associatifs
            PDO::ATTR_EMULATE_PREPARES => false,                // vraies requêtes préparées côté MySQL
        ]);
    }

    return $pdo;
}
