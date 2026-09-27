<?php
// En-tête commun. Avant d'inclure ce fichier, la page définit :
//   $pageTitle   : le titre de l'onglet
//   $currentPage : 'accueil', 'evenements' ou 'evenement' (pour aria-current)
$pageTitle ??= 'ClubHub';
$currentPage ??= '';

$links = [
    'accueil' => ['index.php', 'Accueil'],
    'evenements' => ['evenements.php', 'Événements'],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="site-header">
    <a class="logo" href="index.php">ClubHub</a>
    <nav>
      <ul>
        <?php foreach ($links as $key => [$url, $label]): ?>
          <li><a href="<?= e($url) ?>"<?= $key === $currentPage ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <button type="button" class="theme-toggle" aria-pressed="false">Mode sombre</button>
  </header>
