# S06 : Script de live coding

Utiliser la base `clubhub` créée avec `schema.sql` + `seed.sql` du TP. Le code est dans `live-coding/demo/`.

**Attention** : `recherche-vulnerable.php` est volontairement vulnérable. Ne le mettez jamais sur un serveur accessible.

## Partie 1 : première connexion PDO (10 min)

Créer `liste.php` :

```php
<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=clubhub;charset=utf8mb4', 'clubhub', 'clubhub', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

$events = $pdo->query('SELECT title, capacity FROM events ORDER BY starts_at')->fetchAll();
?>
<ul>
  <?php foreach ($events as $event): ?>
    <li><?= htmlspecialchars($event['title']) ?> (<?= $event['capacity'] ?> places)</li>
  <?php endforeach; ?>
</ul>
```

1. Afficher la page. Puis `var_dump($events)` : « un tableau de tableaux associatifs, comme notre ancien `events.php`. »
2. **Erreur volontaire** : mauvais mot de passe → `Access denied`. Mauvais nom de table → exception avec le message SQL exact. « Grâce à `ERRMODE_EXCEPTION`, rien ne passe en silence. »
3. Enlever `charset=utf8mb4` → accents cassés. Remettre.
4. Ajouter une ligne dans phpMyAdmin (ou en SQL), recharger : elle apparaît. « Plus besoin de modifier le code pour ajouter un événement. »

## Partie 2 : l'injection SQL, en direct (15 min)

1. Ouvrir `recherche-vulnerable.php` et lire le code ensemble :
   ```php
   $q = $_GET['q'] ?? '';
   $sql = "SELECT title, club FROM events WHERE title LIKE '%$q%'";
   $rows = $pdo->query($sql)->fetchAll();
   ```
   La page affiche aussi la requête SQL construite, pour la démo.
2. Chercher `arduino` : un résultat. Montrer la requête affichée. « Tout va bien… »
3. Chercher `'` (une apostrophe seule) : **erreur SQL**. « L'apostrophe a fermé la chaîne. Ce que je tape devient du SQL. »
4. Chercher `' OR '1'='1` : **tous** les événements, même le passé.
5. Le coup de grâce. Chercher :
   ```
   ' UNION SELECT email, password_hash FROM users -- 
   ```
   (avec un espace après `--`). La page affiche **tous les emails et tous les hachages** de mots de passe. « Heureusement qu'ils sont hachés (séance 5). Mais les emails sont perdus. »
6. Ouvrir `recherche-prepare.php` : même page avec `prepare` + `execute`. Rejouer les trois attaques : l'apostrophe est cherchée comme un simple caractère, rien ne fuit.

Phrase de conclusion : « Avec `prepare`, la base reçoit le **code** d'abord et la **donnée** ensuite. La donnée ne peut plus jamais devenir du code. »

## Partie 3 (si le temps) : le JOIN et les places (5 min)

Dans le terminal MySQL ou phpMyAdmin :

```sql
SELECT e.title, e.capacity, COUNT(r.id) AS inscrits, e.capacity - COUNT(r.id) AS restantes
FROM events e
LEFT JOIN registrations r ON r.event_id = e.id
GROUP BY e.id;
```

Changer `LEFT JOIN` en `JOIN` : les événements sans inscrit disparaissent. Changer `COUNT(r.id)` en `COUNT(*)` : un événement sans inscrit compte 1 inscrit. « Deux bugs classiques, que vous allez rencontrer dans le TP. »
