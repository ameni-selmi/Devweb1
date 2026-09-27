<?php
// Connexion, session et messages flash : À COMPLÉTER (TP3).
// Les fonctions redirect() et safeNext() sont données. Écrivez le corps des autres.

/** Redirige vers une autre page et arrête le script. (DONNÉE) */
function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/**
 * N'accepte que les chemins locaux pour ?next= (DONNÉE).
 * "/evenement.php?id=2" : oui. "https://pirate.example" ou "//pirate.example" : non.
 */
function safeNext(?string $next, string $default = 'compte.php'): string
{
    if ($next === null || $next === '' || !str_starts_with($next, '/') || str_starts_with($next, '//')) {
        return $default;
    }
    return $next;
}

/** Garde un message pour la PROCHAINE page affichée. $type : 'success', 'info' ou 'error'. */
function flash(string $message, string $type = 'success'): void
{
    // TODO : ranger ['message' => ..., 'type' => ...] dans $_SESSION['flash']
}

/** Récupère le message flash et le supprime (il ne s'affiche qu'une fois). */
function takeFlash(): ?array
{
    // TODO
    return null;
}

/** L'utilisateur connecté (tableau), ou null. Indice : $_SESSION['user_id'] + findUserById(). */
function currentUser(): ?array
{
    // TODO
    return null;
}

/** Page protégée : si personne n'est connecté, flash + redirection vers connexion.php. Sinon renvoie l'utilisateur. */
function requireLogin(): array
{
    // TODO
}

/** Connecte l'utilisateur. N'oubliez pas session_regenerate_id(true). */
function loginUser(array $user): void
{
    // TODO
}

/** Déconnecte : vide $_SESSION, supprime le cookie de session, détruit la session. */
function logoutUser(): void
{
    // TODO (voir la documentation de session_destroy() sur php.net : l'exemple est presque parfait)
}
