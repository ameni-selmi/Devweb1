<?php
// Test d'installation : lancez `php -S localhost:8000` dans ce dossier,
// puis ouvrez http://localhost:8000/bonjour.php
$heure = date('H:i');
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Bonjour</title></head>
<body>
  <h1>Bonjour !</h1>
  <p>PHP <?= PHP_VERSION ?> fonctionne. Il est <?= $heure ?> sur le serveur.</p>
</body>
</html>
