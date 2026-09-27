<?php
// Démo S05 : une connexion minimale dans un seul fichier (pour la démo, PAS pour le TP)
session_start();

$users = [
    'amine@campus.example' => ['name' => 'Amine', 'hash' => '$2y$12$LZtCv6e1Er9pAXzRqPMkL.WngXDO2mAhU/hq0GPcgkDDyiuEmyPDy'],   // mot de passe : demo1234
];

if (($_POST['action'] ?? '') === 'logout') {
    $_SESSION = [];
    session_destroy();
    header('Location: mini-login.php');
    exit;
}

$error = '';
if (($_POST['action'] ?? '') === 'login') {
    $user = $users[$_POST['email'] ?? ''] ?? null;
    if ($user !== null && password_verify($_POST['password'] ?? '', $user['hash'])) {
        session_regenerate_id(true);
        $_SESSION['name'] = $user['name'];
        header('Location: mini-login.php');   // Post/Redirect/Get
        exit;
    }
    $error = 'Email ou mot de passe incorrect.';
}
?>
<!DOCTYPE html>
<html lang="fr"><head><meta charset="UTF-8"><title>Mini login</title></head>
<body>
<?php if (isset($_SESSION['name'])): ?>
  <p>Bonjour <?= htmlspecialchars($_SESSION['name']) ?></p>
  <p><a href="secret.php">Page secrète</a></p>
  <form method="post"><button name="action" value="logout">Déconnexion</button></form>
<?php else: ?>
  <p><?= htmlspecialchars($error) ?></p>
  <form method="post">
    <input name="email" type="email" placeholder="email">
    <input name="password" type="password" placeholder="mot de passe">
    <button name="action" value="login">Connexion</button>
  </form>
<?php endif; ?>
</body></html>
