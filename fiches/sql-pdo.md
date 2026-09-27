# Aide-mémoire : SQL et PDO

## Créer la base (une fois)

```sql
CREATE DATABASE clubhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'clubhub'@'localhost' IDENTIFIED BY 'clubhub';
GRANT ALL PRIVILEGES ON clubhub.* TO 'clubhub'@'localhost';
```

```bash
mysql -u clubhub -p clubhub < database/schema.sql
mysql -u clubhub -p clubhub < database/seed.sql
```

## Créer une table

```sql
CREATE TABLE events (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(150) NOT NULL,
    capacity     INT UNSIGNED NOT NULL,
    starts_at    DATETIME NOT NULL,
    organizer_id INT UNSIGNED NOT NULL,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_events_organizer FOREIGN KEY (organizer_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

| Type | Pour |
|---|---|
| `INT UNSIGNED` | id, compteurs |
| `VARCHAR(n)` | texte court (nom, email) |
| `TEXT` | texte long |
| `DATETIME` | date + heure |
| `ENUM('a','b')` | valeur parmi une liste |
| `BOOLEAN` | vrai / faux (en fait `TINYINT(1)`) |

Contraintes : `NOT NULL`, `UNIQUE (col)`, `UNIQUE (a, b)`, `FOREIGN KEY ... REFERENCES ... ON DELETE CASCADE`, `CHECK (...)`.

## Requêtes

```sql
SELECT id, title FROM events WHERE capacity > 30 AND club = 'Club IA' ORDER BY starts_at DESC LIMIT 10;
SELECT * FROM events WHERE title LIKE '%arduino%';
SELECT COUNT(*) FROM registrations WHERE event_id = 3;
INSERT INTO users (name, email) VALUES ('Amine', 'amine@campus.example');
UPDATE events SET capacity = 25 WHERE id = 1;
DELETE FROM registrations WHERE user_id = 1 AND event_id = 3;
```

**Toujours** un `WHERE` sur `UPDATE` et `DELETE`.

## JOIN

```sql
-- Les inscriptions d'un utilisateur avec le titre de l'événement
SELECT e.title, r.created_at
FROM registrations r
JOIN events e ON e.id = r.event_id
WHERE r.user_id = 1;

-- Chaque événement avec son nombre d'inscrits (même 0)
SELECT e.id, e.title, COUNT(r.id) AS registered
FROM events e
LEFT JOIN registrations r ON r.event_id = e.id
GROUP BY e.id;
```

`JOIN` : seulement les lignes qui ont une correspondance. `LEFT JOIN` : toutes les lignes de gauche. Avec `LEFT JOIN`, comptez `COUNT(r.id)`, pas `COUNT(*)`.

## Dates

```sql
WHERE starts_at >= NOW()
NOW() + INTERVAL 7 DAY
TIMESTAMP(CURDATE() + INTERVAL 7 DAY, '14:00:00')
DATE(starts_at) = CURDATE()
```

## PDO : connexion

```php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=clubhub;charset=utf8mb4', $user, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);
```

## PDO : lire

```php
// Aucune valeur extérieure : query()
$rows = $pdo->query('SELECT * FROM events ORDER BY starts_at')->fetchAll();

// Une valeur extérieure : prepare() + execute()
$stmt = $pdo->prepare('SELECT * FROM events WHERE id = ?');
$stmt->execute([$id]);
$event = $stmt->fetch();            // une ligne (tableau) ou false
$all   = $stmt->fetchAll();         // toutes les lignes
$count = $stmt->fetchColumn();      // une seule valeur

// Paramètres nommés
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute(['email' => $email]);
```

## PDO : écrire

```php
$stmt = $pdo->prepare('INSERT INTO registrations (user_id, event_id) VALUES (?, ?)');
$stmt->execute([$userId, $eventId]);
$id = (int) $pdo->lastInsertId();

$stmt = $pdo->prepare('DELETE FROM registrations WHERE user_id = ? AND event_id = ?');
$stmt->execute([$userId, $eventId]);
$deleted = $stmt->rowCount();       // nombre de lignes touchées
```

## Erreurs

```php
try {
    $stmt->execute([...]);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {   // contrainte violée (UNIQUE, FOREIGN KEY)
        // message clair pour l'utilisateur
    } else {
        throw $exception;
    }
}
```

## Transaction

```php
$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare('SELECT capacity FROM events WHERE id = ? FOR UPDATE');   // verrouille la ligne
    // ... vérifier, insérer ...
    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    throw $exception;
}
```

## Ce qui est interdit

```php
// JAMAIS : une variable dans la chaîne SQL
$pdo->query("SELECT * FROM users WHERE email = '$email'");
$pdo->query('SELECT * FROM events WHERE id = ' . $_GET['id']);
```

Seule exception tolérée : un entier **forcé** par `(int)`, par exemple pour `LIMIT`.

## Pièges

| Symptôme | Cause |
|---|---|
| `Invalid parameter number` | Pas autant de `?` que de valeurs, ou un `:nom` utilisé deux fois |
| Accents cassés | `charset=utf8mb4` absent du DSN |
| `fetch()` renvoie `false` | Aucune ligne trouvée (ce n'est pas `null`) |
| Les nombres arrivent en chaîne | `ATTR_EMULATE_PREPARES` non désactivé |
