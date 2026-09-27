<?php
require __DIR__ . '/includes/bootstrap.php';

$next = safeNext($_GET['next'] ?? $_POST['next'] ?? null);

if (currentUser() !== null) {
    redirect($next);
}

$email = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = findUserByEmail($email);

    // password_verify compare le mot de passe tapé avec le hachage stocké
    if ($user !== null && password_verify($password, $user['password_hash'])) {
        loginUser($user);
        flash('Bonjour ' . $user['name'] . ' !');
        redirect($next);
    }

    // Même message dans les deux cas : on ne dit pas à un attaquant si l'email existe
    $error = 'Email ou mot de passe incorrect.';
}

$pageTitle = 'Connexion · ClubHub';
$currentPage = 'connexion';
require __DIR__ . '/includes/header.php';
?>
  <main class="auth-page">
    <section class="auth-card">
      <h1>Connexion</h1>
      <?php if ($error !== ''): ?>
        <p class="flash flash-error" role="alert"><?= e($error) ?></p>
      <?php endif; ?>
      <form action="connexion.php" method="post">
        <input type="hidden" name="next" value="<?= e($next) ?>">
        <p>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required autocomplete="email" value="<?= e($email) ?>">
        </p>
        <p>
          <label for="password">Mot de passe</label>
          <input type="password" id="password" name="password" required autocomplete="current-password">
        </p>
        <p><button type="submit">Se connecter</button></p>
      </form>
      <p>Pas encore de compte ? <a href="creer-compte.php">Créer un compte</a></p>
      <p class="meta">Comptes de démonstration : amine@campus.example, sarra@campus.example (mot de passe : demo1234).</p>
    </section>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
