<main class="auth-page">
  <section class="auth-card">
    <h1>Créer un compte</h1>
    <form action="<?= e(url('creer-compte')) ?>" method="post" novalidate>
      <p>
        <label for="name">Nom complet</label>
        <input type="text" id="name" name="name" required autocomplete="name" value="<?= e($old['name']) ?>">
        <small class="field-error"><?= e($errors['name'] ?? '') ?></small>
      </p>
      <p>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required autocomplete="email" value="<?= e($old['email']) ?>">
        <small class="field-error"><?= e($errors['email'] ?? '') ?></small>
      </p>
      <p>
        <label for="password">Mot de passe (8 caractères minimum)</label>
        <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password">
        <small class="field-error"><?= e($errors['password'] ?? '') ?></small>
      </p>
      <p>
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
        <small class="field-error"><?= e($errors['password_confirmation'] ?? '') ?></small>
      </p>
      <p><button type="submit">Créer mon compte</button></p>
    </form>
    <p>Déjà un compte ? <a href="<?= e(url('connexion')) ?>">Se connecter</a></p>
  </section>
</main>
