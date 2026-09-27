<?php
// Connexion à la base de données : À COMPLÉTER (TP4, question 1).

function db(): PDO
{
    static $pdo = null;   // la même connexion est réutilisée pendant toute la requête

    if ($pdo === null) {
        $config = require __DIR__ . '/../config.php';

        // TODO :
        // 1. construire le DSN : 'mysql:host=...;port=...;dbname=...;charset=utf8mb4'
        // 2. créer le PDO avec ces trois options :
        //      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        //      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        //      PDO::ATTR_EMULATE_PREPARES => false
    }

    return $pdo;
}
