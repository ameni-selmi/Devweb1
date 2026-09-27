<?php
// Accès aux événements dans MySQL.
// Règle de sécurité n° 4 : toute valeur venant de l'extérieur passe par prepare() + execute().

// Colonnes communes : les places restantes sont calculées avec un LEFT JOIN sur les inscriptions.
const EVENT_SELECT = '
    SELECT e.*,
           e.capacity - COUNT(r.id) AS places_left
    FROM events e
    LEFT JOIN registrations r ON r.event_id = e.id
';

/** Les événements à venir, du plus proche au plus lointain. */
function getEvents(?int $limit = null): array
{
    $sql = EVENT_SELECT . '
        WHERE e.starts_at >= NOW()
        GROUP BY e.id
        ORDER BY e.starts_at';

    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;   // (int) : on ne met jamais une valeur brute dans le SQL
    }

    // Pas de valeur venant de l'utilisateur : query() suffit
    return db()->query($sql)->fetchAll();
}

/** L'événement qui a cet id, ou null. */
function findEvent(int $id): ?array
{
    $stmt = db()->prepare(EVENT_SELECT . ' WHERE e.id = ? GROUP BY e.id');
    $stmt->execute([$id]);
    $event = $stmt->fetch();
    return $event === false ? null : $event;
}

/** Recherche côté serveur (titre, club, description). Défi du TP4. */
function searchEvents(string $query): array
{
    $stmt = db()->prepare(EVENT_SELECT . '
        WHERE e.starts_at >= NOW()
          AND (e.title LIKE ? OR e.club LIKE ? OR e.description LIKE ?)
        GROUP BY e.id
        ORDER BY e.starts_at');
    $pattern = '%' . $query . '%';
    // Un marqueur par valeur : avec de vraies requêtes préparées, un même :nom ne peut pas servir deux fois
    $stmt->execute([$pattern, $pattern, $pattern]);
    return $stmt->fetchAll();
}

/** Découpe un champ TEXT « une ligne = un élément » en tableau. */
function lines(string $text): array
{
    return array_values(array_filter(array_map('trim', explode("\n", $text)), fn($line) => $line !== ''));
}
