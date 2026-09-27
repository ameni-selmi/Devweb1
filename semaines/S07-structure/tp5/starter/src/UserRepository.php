<?php

/** Tout le SQL qui concerne les utilisateurs : À COMPLÉTER (TP5). */
class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    // TODO : find(int $id): ?array, findByEmail(string $email): ?array,
    //        create(string $name, string $email, string $passwordHash, string $role = 'student'): int
    // Reprenez les requêtes de includes/users.php, en utilisant $this->pdo.
}
