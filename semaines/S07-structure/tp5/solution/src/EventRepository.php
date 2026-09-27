<?php

/**
 * Tout le SQL qui concerne les événements.
 * Usage : $events = new EventRepository(Database::connection());
 */
class EventRepository
{
    // Les places restantes sont calculées avec un LEFT JOIN sur les inscriptions
    private const SELECT = '
        SELECT e.*, e.capacity - COUNT(r.id) AS places_left
        FROM events e
        LEFT JOIN registrations r ON r.event_id = e.id
    ';

    public function __construct(private PDO $pdo)
    {
    }

    /** Les événements à venir, du plus proche au plus lointain. */
    public function upcoming(?int $limit = null): array
    {
        $sql = self::SELECT . ' WHERE e.starts_at >= NOW() GROUP BY e.id ORDER BY e.starts_at';
        if ($limit !== null) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        return $this->pdo->query($sql)->fetchAll();
    }

    public function search(string $query): array
    {
        $stmt = $this->pdo->prepare(self::SELECT . '
            WHERE e.starts_at >= NOW()
              AND (e.title LIKE ? OR e.club LIKE ? OR e.description LIKE ?)
            GROUP BY e.id
            ORDER BY e.starts_at');
        $pattern = '%' . $query . '%';
        $stmt->execute([$pattern, $pattern, $pattern]);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare(self::SELECT . ' WHERE e.id = ? GROUP BY e.id');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /** Les événements créés par un organisateur (passés compris), avec le nombre d'inscrits. */
    public function byOrganizer(int $organizerId): array
    {
        $stmt = $this->pdo->prepare(self::SELECT . '
            WHERE e.organizer_id = ?
            GROUP BY e.id
            ORDER BY e.starts_at DESC');
        $stmt->execute([$organizerId]);
        return $stmt->fetchAll();
    }

    /** La liste des clubs pour le filtre : slug => nom. */
    public function clubs(): array
    {
        $rows = $this->pdo->query('SELECT DISTINCT club_slug, club FROM events ORDER BY club')->fetchAll();
        return array_column($rows, 'club', 'club_slug');
    }

    /** Crée un événement et renvoie son id. $data vient d'un formulaire DÉJÀ validé. */
    public function create(array $data, int $organizerId): int
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO events (title, club, club_slug, description, program, bring, location, starts_at, ends_at, capacity, organizer_id)
            VALUES (:title, :club, :club_slug, :description, :program, :bring, :location, :starts_at, :ends_at, :capacity, :organizer_id)');
        $stmt->execute([
            'title' => $data['title'],
            'club' => $data['club'],
            'club_slug' => slugify($data['club']),
            'description' => $data['description'],
            'program' => $data['program'],
            'bring' => $data['bring'],
            'location' => $data['location'],
            'starts_at' => $data['starts_at'],
            'ends_at' => $data['ends_at'],
            'capacity' => $data['capacity'],
            'organizer_id' => $organizerId,
        ]);
        return (int) $this->pdo->lastInsertId();
    }
}
