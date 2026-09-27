<?php
// Accès aux utilisateurs dans MySQL.
// Les fonctions ont le MÊME nom et la MÊME signature qu'en S05 (fichier JSON) :
// les pages qui les utilisent n'ont presque pas changé.

function findUserByEmail(string $email): ?array
{
    $stmt = db()->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    return $user === false ? null : $user;
}

function findUserById(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    return $user === false ? null : $user;
}

/** Ajoute un utilisateur et renvoie son id. */
function addUser(string $name, string $email, string $passwordHash, string $role = 'student'): int
{
    $stmt = db()->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email, $passwordHash, $role]);
    return (int) db()->lastInsertId();
}
