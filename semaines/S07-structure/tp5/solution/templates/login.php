<main class="auth-page">
  <section class="auth-card">
    <h1>Connexion</h1>
    <?php if ($error !== ''): ?>
      <p class="flash flash-error" role="alert"><?= e($error) ?></p>
    <?php endif; ?>
    <form action="<?= e(url('connexion')) ?>" method="post">
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
    <p>Pas encore de compte ? <a href="<?= e(url('creer-compte')) ?>">Créer un compte</a></p>
    <p class="meta">Comptes de démonstration : amine@campus.example (étudiant), robotique@campus.example (organisateur). Mot de passe : demo1234.</p>
  </section>
</main>
