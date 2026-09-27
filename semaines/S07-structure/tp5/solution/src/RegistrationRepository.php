<?php

/** Tout le SQL qui concerne les inscriptions aux événements. */
class RegistrationRepository
{
    public const OK = 'ok';
    public const ALREADY = 'already';
    public const FULL = 'full';

    public function __construct(private PDO $pdo)
    {
    }

    public function exists(int $userId, int $eventId): bool
    {
        $stmt = $this->pdo->prepare('SELECT 1 FROM registrations WHERE user_id = ? AND event_id = ?');
        $stmt->execute([$userId, $eventId]);
        return $stmt->fetchColumn() !== false;
    }

    /** Inscrit un utilisateur. Transaction + FOR UPDATE : la dernière place ne peut pas être prise deux fois. */
    public function register(int $userId, int $eventId, string $motivation): string
    {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('SELECT capacity FROM events WHERE id = ? FOR UPDATE');
            $stmt->execute([$eventId]);
            $capacity = (int) $stmt->fetchColumn();

            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM registrations WHERE event_id = ?');
            $stmt->execute([$eventId]);
            if ((int) $stmt->fetchColumn() >= $capacity) {
                $this->pdo->rollBack();
                return self::FULL;
            }

            $stmt = $this->pdo->prepare('INSERT INTO registrations (user_id, event_id, motivation) VALUES (?, ?, ?)');
            $stmt->execute([$userId, $eventId, $motivation]);
            $this->pdo->commit();
            return self::OK;
        } catch (PDOException $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            if ($exception->getCode() === '23000') {   // contrainte UNIQUE (user_id, event_id)
                return self::ALREADY;
            }
            throw $exception;
        }
    }

    /** N'annule que l'inscription de CET utilisateur, et seulement pour un événement à venir. */
    public function cancel(int $userId, int $eventId): bool
    {
        $stmt = $this->pdo->prepare('
            DELETE r FROM registrations r
            JOIN events e ON e.id = r.event_id
            WHERE r.user_id = ? AND r.event_id = ? AND e.starts_at >= NOW()');
        $stmt->execute([$userId, $eventId]);
        return $stmt->rowCount() === 1;
    }

    /** Les inscriptions d'un utilisateur, avec l'événement (JOIN). */
    public function ofUser(int $userId): array
    {
        $stmt = $this->pdo->prepare('
            SELECT e.id, e.title, e.club, e.location, e.starts_at, e.ends_at, r.created_at AS registered_at
            FROM registrations r
            JOIN events e ON e.id = r.event_id
            WHERE r.user_id = ?
            ORDER BY e.starts_at');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /** Les inscrits d'un événement, avec leur nom et leur email (JOIN). */
    public function participants(int $eventId): array
    {
        $stmt = $this->pdo->prepare('
            SELECT u.name, u.email, r.motivation, r.created_at
            FROM registrations r
            JOIN users u ON u.id = r.user_id
            WHERE r.event_id = ?
            ORDER BY r.created_at');
        $stmt->execute([$eventId]);
        return $stmt->fetchAll();
    }
}
