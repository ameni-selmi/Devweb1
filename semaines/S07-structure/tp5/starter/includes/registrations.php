<?php
// Inscriptions aux événements, dans MySQL (elles étaient dans la session en S05).

function isRegistered(int $userId, int $eventId): bool
{
    $stmt = db()->prepare('SELECT 1 FROM registrations WHERE user_id = ? AND event_id = ?');
    $stmt->execute([$userId, $eventId]);
    return $stmt->fetchColumn() !== false;
}

/**
 * Inscrit un utilisateur. Renvoie 'ok', 'already' (déjà inscrit) ou 'full' (complet).
 * La transaction + FOR UPDATE empêchent deux inscriptions simultanées de dépasser la capacité.
 */
function registerUser(int $userId, int $eventId, string $motivation): string
{
    $pdo = db();
    $pdo->beginTransaction();
    try {
        // Verrouille la ligne de l'événement jusqu'à la fin de la transaction
        $stmt = $pdo->prepare('SELECT capacity FROM events WHERE id = ? FOR UPDATE');
        $stmt->execute([$eventId]);
        $capacity = (int) $stmt->fetchColumn();

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM registrations WHERE event_id = ?');
        $stmt->execute([$eventId]);
        if ((int) $stmt->fetchColumn() >= $capacity) {
            $pdo->rollBack();
            return 'full';
        }

        $stmt = $pdo->prepare('INSERT INTO registrations (user_id, event_id, motivation) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $eventId, $motivation]);
        $pdo->commit();
        return 'ok';
    } catch (PDOException $exception) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        // 23000 = violation de contrainte : ici, la contrainte UNIQUE (user_id, event_id)
        if ($exception->getCode() === '23000') {
            return 'already';
        }
        throw $exception;
    }
}

/** Annule une inscription. Le WHERE user_id = ? garantit qu'on n'annule que LA SIENNE. */
function cancelRegistration(int $userId, int $eventId): bool
{
    $stmt = db()->prepare('DELETE FROM registrations WHERE user_id = ? AND event_id = ?');
    $stmt->execute([$userId, $eventId]);
    return $stmt->rowCount() === 1;
}

/** Les inscriptions d'un utilisateur, avec les informations de l'événement (JOIN). */
function registrationsOfUser(int $userId): array
{
    $stmt = db()->prepare('
        SELECT e.id, e.title, e.club, e.location, e.starts_at, e.ends_at, r.created_at AS registered_at
        FROM registrations r
        JOIN events e ON e.id = r.event_id
        WHERE r.user_id = ?
        ORDER BY e.starts_at');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}
