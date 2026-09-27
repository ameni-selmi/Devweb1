<?php
// Fonctions utilisées sur toutes les pages.

/**
 * Échappe une valeur avant de l'afficher dans du HTML.
 * Règle de sécurité n° 1 : TOUTE donnée affichée passe par e().
 */
function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Renvoie tous les événements. */
function getEvents(): array
{
    return require __DIR__ . '/../data/events.php';
}

/** Renvoie l'événement qui a cet id, ou null s'il n'existe pas. */
function findEvent(int $id): ?array
{
    foreach (getEvents() as $event) {
        if ($event['id'] === $id) {
            return $event;
        }
    }
    return null;
}

/** Les niveaux acceptés dans le formulaire : valeur envoyée => texte affiché. */
const LEVELS = ['1' => '1re année', '2' => '2e année', '3' => '3e année'];
