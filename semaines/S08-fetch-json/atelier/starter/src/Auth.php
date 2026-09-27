<?php

/**
 * Qui est connecté, et qui a le droit de faire quoi.
 * Usage : $user = Auth::requireLogin();  ou  Auth::requireRole('organizer');
 */
class Auth
{
    private static ?array $user = null;
    private static bool $loaded = false;

    /** L'utilisateur connecté, ou null. */
    public static function user(): ?array
    {
        if (!self::$loaded) {
            $id = $_SESSION['user_id'] ?? null;
            self::$user = $id !== null ? (new UserRepository(Database::connection()))->find((int) $id) : null;
            self::$loaded = true;
        }
        return self::$user;
    }

    /** Règle de sécurité n° 3 : en haut de chaque contrôleur protégé. */
    public static function requireLogin(): array
    {
        $user = self::user();
        if ($user === null) {
            flash('Connectez vous pour accéder à cette page.', 'info');
            redirect(url('connexion', ['next' => $_SERVER['REQUEST_URI']]));
        }
        return $user;
    }

    /** Connecté ET avec le bon rôle. Sinon : 403. */
    public static function requireRole(string $role): array
    {
        $user = self::requireLogin();
        if ($user['role'] !== $role) {
            View::forbidden('Cette page est réservée aux organisateurs.');
        }
        return $user;
    }

    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        self::$user = $user;
        self::$loaded = true;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        self::$user = null;
    }

    /** N'accepte que les chemins locaux pour ?next= (pas de redirection vers un autre site). */
    public static function safeNext(?string $next): string
    {
        if ($next === null || $next === '' || !str_starts_with($next, '/') || str_starts_with($next, '//')) {
            return url('compte');
        }
        return $next;
    }
}
