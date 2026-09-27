<?php
// Stockage des utilisateurs dans data/users.json (DONNÉ dans le starter).
// C'est provisoire : en séance 6, ce fichier sera remplacé par la base MySQL.

const USERS_FILE = __DIR__ . '/../data/users.json';

/** Tous les utilisateurs, sous forme de tableau de tableaux. */
function readUsers(): array
{
    if (!file_exists(USERS_FILE)) {
        return [];
    }
    $users = json_decode(file_get_contents(USERS_FILE), true);
    return is_array($users) ? $users : [];
}

/** Réécrit tout le fichier (LOCK_EX : deux requêtes en même temps ne se mélangent pas). */
function saveUsers(array $users): void
{
    $json = json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents(USERS_FILE, $json . "\n", LOCK_EX);
}

function findUserByEmail(string $email): ?array
{
    foreach (readUsers() as $user) {
        if (mb_strtolower($user['email']) === mb_strtolower($email)) {
            return $user;
        }
    }
    return null;
}

function findUserById(int $id): ?array
{
    foreach (readUsers() as $user) {
        if ($user['id'] === $id) {
            return $user;
        }
    }
    return null;
}

/** Ajoute un utilisateur et renvoie son nouvel id. */
function addUser(string $name, string $email, string $passwordHash, string $role = 'student'): int
{
    $users = readUsers();
    $id = $users === [] ? 1 : max(array_column($users, 'id')) + 1;
    $users[] = [
        'id' => $id,
        'name' => $name,
        'email' => $email,
        'password_hash' => $passwordHash,
        'role' => $role,
    ];
    saveUsers($users);
    return $id;
}
