<?php
// Connexion, session et messages flash.

/** Redirige vers une autre page et arrête le script. */
function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/** Garde un message pour la PROCHAINE page affichée (après une redirection). */
function flash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

/** Récupère le message flash et le supprime : il ne s'affiche qu'une fois. */
function takeFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/** L'utilisateur connecté, ou null. */
function currentUser(): ?array
{
    static $user = false;   // on ne relit le fichier qu'une fois par requête
    if ($user === false) {
        $id = $_SESSION['user_id'] ?? null;
        $user = $id !== null ? findUserById((int) $id) : null;
    }
    return $user;
}

/** À appeler en haut de chaque page protégée. Règle de sécurité n° 3. */
function requireLogin(): array
{
    $user = currentUser();
    if ($user === null) {
        flash('Connectez vous pour accéder à cette page.', 'info');
        redirect('connexion.php?next=' . urlencode($_SERVER['REQUEST_URI']));
    }
    return $user;
}

function loginUser(array $user): void
{
    session_regenerate_id(true);   // nouvel identifiant de session : protège contre la fixation de session
    $_SESSION['user_id'] = $user['id'];
}

function logoutUser(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}

/**
 * N'accepte que les chemins locaux pour ?next= (sinon : redirection ouverte vers un site pirate).
 * "/evenement.php?id=2" : oui. "https://pirate.example" ou "//pirate.example" : non.
 */
function safeNext(?string $next, string $default = 'compte.php'): string
{
    if ($next === null || $next === '' || !str_starts_with($next, '/') || str_starts_with($next, '//')) {
        return $default;
    }
    return $next;
}

/** Les inscriptions aux événements, gardées dans la session (jusqu'à la séance 6). */
function sessionRegistrations(): array
{
    return $_SESSION['registrations'] ?? [];
}

function isRegistered(int $eventId): bool
{
    return array_key_exists($eventId, sessionRegistrations());
}
