<?php
// Démo S06, partie 2 : recherche corrigée avec prepare + execute.
$pdo = new PDO('mysql:host=127.0.0.1;dbname=clubhub;charset=utf8mb4', 'clubhub', 'clubhub', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NUM,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

$q = $_GET['q'] ?? '';
$rows = [];
$error = '';
$sql = 'SELECT title, club FROM events WHERE title LIKE ?';        // le code, avec un trou

$stmt = $pdo->prepare($sql);
$stmt->execute(['%' . $q . '%']);                                  // la donnée, envoyée à part
$rows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Recherche</title></head>
<body>
  <form><input name="q" value="<?= htmlspecialchars($q) ?>" size="60"> <button>Chercher</button></form>
  <p>Requête envoyée à MySQL : <code><?= htmlspecialchars($sql) ?></code></p>
  <?php if ($error !== ''): ?><p style="color:red"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  <table border="1">
    <?php foreach ($rows as $row): ?>
      <tr><td><?= htmlspecialchars((string) $row[0]) ?></td><td><?= htmlspecialchars((string) $row[1]) ?></td></tr>
    <?php endforeach; ?>
  </table>
</body></html>
