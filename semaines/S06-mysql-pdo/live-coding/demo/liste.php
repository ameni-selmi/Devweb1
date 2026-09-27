<?php
// Démo S06, partie 1 : première connexion PDO
$pdo = new PDO('mysql:host=127.0.0.1;dbname=clubhub;charset=utf8mb4', 'clubhub', 'clubhub', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

$events = $pdo->query('SELECT title, capacity FROM events ORDER BY starts_at')->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Liste</title></head>
<body>
<ul>
  <?php foreach ($events as $event): ?>
    <li><?= htmlspecialchars($event['title']) ?> (<?= $event['capacity'] ?> places)</li>
  <?php endforeach; ?>
</ul>
</body></html>
