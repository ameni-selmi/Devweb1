<?php

/**
 * Qui est connecté, et qui a le droit de faire quoi : À COMPLÉTER (TP5).
 * Reprenez vos fonctions de includes/auth.php (TP3 et TP4) et transformez les en méthodes statiques.
 * Usage attendu : $user = Auth::requireLogin();  Auth::login($user);  Auth::user();
 */
class Auth
{
    /** L'utilisateur connecté, ou null. Indice : new UserRepository(Database::connection()) */
    public static function user(): ?array
    {
        // TODO
        return null;
    }

    /** Si personne n'est connecté : flash + redirection vers url('connexion', ['next' => ...]). */
    public static function requireLogin(): array
    {
        // TODO
    }

    /** (Plus) Connecté ET avec le bon rôle. Sinon : View::forbidden(). */
    public static function requireRole(string $role): array
    {
        // TODO
    }

    public static function login(array $user): void
    {
        // TODO : session_regenerate_id(true) + $_SESSION['user_id']
    }

    public static function logout(): void
    {
        // TODO
    }

    /** N'accepte que les chemins locaux pour ?next= (DONNÉE). */
    public static function safeNext(?string $next): string
    {
        if ($next === null || $next === '' || !str_starts_with($next, '/') || str_starts_with($next, '//')) {
            return url('compte');
        }
        return $next;
    }
}
