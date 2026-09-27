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

const DAYS = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
const MONTHS = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

/** "2030-10-14 14:00:00" → "mercredi 14 octobre" */
function formatDate(string $datetime): string
{
    $date = new DateTimeImmutable($datetime);
    return DAYS[(int) $date->format('w')] . ' ' . $date->format('j') . ' ' . MONTHS[(int) $date->format('n') - 1];
}

/** "14:00" → "14 h", "09:30" → "9 h 30" */
function formatHour(string $datetime): string
{
    $date = new DateTimeImmutable($datetime);
    $minutes = $date->format('i');
    return $date->format('G') . ' h' . ($minutes === '00' ? '' : ' ' . $minutes);
}

/** "de 14 h à 17 h" */
function formatTimeRange(string $start, string $end): string
{
    return 'de ' . formatHour($start) . ' à ' . formatHour($end);
}

/** Format ISO pour l'attribut datetime de <time> et pour le tri JS : "2030-10-14T14:00" */
function isoDate(string $datetime): string
{
    return (new DateTimeImmutable($datetime))->format('Y-m-d\TH:i');
}

/** "12 places restantes", "1 place restante", "Complet" */
function placesLabel(int $placesLeft): string
{
    return match (true) {
        $placesLeft <= 0 => 'Complet',
        $placesLeft === 1 => '1 place restante',
        default => $placesLeft . ' places restantes',
    };
}
