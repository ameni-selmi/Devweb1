<?php
// Le layout commun à toutes les pages. Variables reçues : $content, $pageTitle, $currentPage.
$pageTitle ??= 'ClubHub';
$currentPage ??= '';
$user = Auth::user();
$flashMessage = takeFlash();

$links = ['accueil' => 'Accueil', 'evenements' => 'Événements'];
if ($user !== null && $user['role'] === 'organizer') {
    $links['nouvel-evenement'] = 'Créer un événement';
}
if ($user !== null) {
    $links['compte'] = 'Mon compte';
} else {
    $links['connexion'] = 'Connexion';
    $links['creer-compte'] = 'Créer un compte';
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
    <a class="logo" href="<?= e(url('accueil')) ?>">ClubHub</a>
    <nav>
      <ul>
        <?php foreach ($links as $page => $label): ?>
          <li><a href="<?= e(url($page)) ?>"<?= $page === $currentPage ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
        <?php if ($user !== null): ?>
          <li>
            <form action="<?= e(url('deconnexion')) ?>" method="post" class="logout-form">
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

  <?= $content /* déjà du HTML, produit par un template qui échappe ses données */ ?>

  <footer class="site-footer">
    <p>ClubHub · La plateforme des clubs étudiants</p>
  </footer>
  <script src="js/app.js" defer></script>
</body>
</html>
