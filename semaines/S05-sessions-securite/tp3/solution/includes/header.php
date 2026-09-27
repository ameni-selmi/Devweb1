<?php
// En-tête commun. Avant d'inclure ce fichier, la page définit :
//   $pageTitle   : le titre de l'onglet
//   $currentPage : 'accueil', 'evenements', 'compte'... (pour aria-current)
$pageTitle ??= 'ClubHub';
$currentPage ??= '';
$user = currentUser();
$flashMessage = takeFlash();

$links = [
    'accueil' => ['index.php', 'Accueil'],
    'evenements' => ['evenements.php', 'Événements'],
];
if ($user !== null) {
    $links['compte'] = ['compte.php', 'Mon compte'];
} else {
    $links['connexion'] = ['connexion.php', 'Connexion'];
    $links['creer-compte'] = ['creer-compte.php', 'Créer un compte'];
}
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
        <?php if ($user !== null): ?>
          <li>
            <form action="deconnexion.php" method="post" class="logout-form">
              <button type="submit" class="link-button">Déconnexion</button>
            </form>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    <button type="button" class="theme-toggle" aria-pressed="false">Mode sombre</button>
  </header>

  <?php if ($flashMessage !== null): ?>
    <p class="flash flash-<?= e($flashMessage['type']) ?>" role="status"><?= e($flashMessage['message']) ?></p>
  <?php endif; ?>
