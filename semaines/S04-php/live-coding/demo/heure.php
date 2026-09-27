<?php
$now = date('H:i:s');
$visits = 0;
$visits++;   // toujours 1 : chaque requête repart de zéro
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Heure</title></head>
<body>
  <h1>Il est <?= $now ?> sur le serveur</h1>
  <p>Visites : <?= $visits ?></p>
</body>
</html>
