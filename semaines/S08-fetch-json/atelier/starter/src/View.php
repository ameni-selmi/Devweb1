<?php

/**
 * Affiche un template dans le layout commun.
 * Usage : View::render('event', ['event' => $event, 'pageTitle' => '...']);
 */
class View
{
    public static function render(string $template, array $data = []): void
    {
        // Le contenu du template est capturé, puis placé dans le layout
        $content = self::capture($template, $data);
        echo self::capture('layout', $data + ['content' => $content]);
    }

    /** Page 404 propre, puis arrêt. */
    public static function notFound(string $message = "Cette page n'existe pas."): never
    {
        http_response_code(404);
        self::render('error', ['pageTitle' => 'Page introuvable · ClubHub', 'title' => 'Page introuvable', 'message' => $message]);
        exit;
    }

    /** Page 403 propre, puis arrêt. */
    public static function forbidden(string $message = "Vous n'avez pas le droit d'accéder à cette page."): never
    {
        http_response_code(403);
        self::render('error', ['pageTitle' => 'Accès refusé · ClubHub', 'title' => 'Accès refusé', 'message' => $message]);
        exit;
    }

    /** Exécute un template et renvoie le HTML produit, au lieu de l'afficher. */
    private static function capture(string $template, array $data): string
    {
        $file = __DIR__ . '/../templates/' . $template . '.php';
        extract($data, EXTR_SKIP);   // ['event' => ...] devient la variable $event dans le template
        ob_start();            // à partir d'ici, tout ce qui est affiché est gardé en mémoire
        require $file;
        return ob_get_clean(); // on récupère ce qui a été affiché
    }
}
