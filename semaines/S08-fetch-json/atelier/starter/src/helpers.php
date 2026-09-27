<?php
// Petites fonctions utilisées partout (dans les contrôleurs et les templates).

/** Règle de sécurité n° 1 : toute donnée affichée passe par e(). */
function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Construit une URL du site : url('evenement', ['id' => 3]) → "index.php?page=evenement&id=3" */
function url(string $page, array $params = []): string
{
    return 'index.php?' . http_build_query(['page' => $page] + $params);
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

function flash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function takeFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function isPost(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/** Un id entier venant de l'URL (?id=3) ou d'un formulaire, ou null. */
function intParam(string $name, int $source = INPUT_GET): ?int
{
    $value = filter_input($source, $name, FILTER_VALIDATE_INT);
    return is_int($value) && $value > 0 ? $value : null;
}

// ---- Dates et affichage ----

const DAYS = ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
const MONTHS = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

function formatDate(string $datetime): string
{
    $date = new DateTimeImmutable($datetime);
    return DAYS[(int) $date->format('w')] . ' ' . $date->format('j') . ' ' . MONTHS[(int) $date->format('n') - 1];
}

function formatHour(string $datetime): string
{
    $date = new DateTimeImmutable($datetime);
    $minutes = $date->format('i');
    return $date->format('G') . ' h' . ($minutes === '00' ? '' : ' ' . $minutes);
}

function formatTimeRange(string $start, string $end): string
{
    return 'de ' . formatHour($start) . ' à ' . formatHour($end);
}

function isoDate(string $datetime): string
{
    return (new DateTimeImmutable($datetime))->format('Y-m-d\TH:i');
}

function placesLabel(int $placesLeft): string
{
    return match (true) {
        $placesLeft <= 0 => 'Complet',
        $placesLeft === 1 => '1 place restante',
        default => $placesLeft . ' places restantes',
    };
}

/** Un texte « une ligne = un élément » → tableau. */
function lines(string $text): array
{
    return array_values(array_filter(array_map('trim', explode("\n", $text)), fn($line) => $line !== ''));
}

/** "Club Échecs" → "club-echecs" */
function slugify(string $text): string
{
    $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', (string) $ascii), '-'));
    return $slug !== '' ? $slug : 'club';
}
