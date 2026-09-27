<?php
require __DIR__ . '/includes/bootstrap.php';

if (currentUser() !== null) {
    redirect('compte.php');   // déjà connecté
}

$old = ['name' => '', 'email' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['name'] = trim($_POST['name'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';           // pas de trim : un espace peut faire partie du mot de passe
    $confirmation = $_POST['password_confirmation'] ?? '';

    if (mb_strlen($old['name']) < 3 || mb_strlen($old['name']) > 100) {
        $errors['name'] = 'Le nom doit contenir entre 3 et 100 caractères.';
    }
    if (filter_var($old['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = "Cet email n'est pas valide.";
    } elseif (findUserByEmail($old['email']) !== null) {
        $errors['email'] = 'Un compte existe déjà avec cet email.';
    }
    if (mb_strlen($password) < 8) {
        $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }
    if ($password !== $confirmation) {
        $errors['password_confirmation'] = 'Les deux mots de passe ne sont pas identiques.';
    }

    if ($errors === []) {
        // Règle de sécurité n° 2 : on ne stocke JAMAIS le mot de passe, seulement son hachage
        addUser($old['name'], $old['email'], password_hash($password, PASSWORD_DEFAULT));
        flash('Votre compte est créé. Vous pouvez vous connecter.');
        redirect('connexion.php');   // Post/Redirect/Get
    }
}

$pageTitle = 'Créer un compte · ClubHub';
$currentPage = 'creer-compte';
require __DIR__ . '/includes/header.php';
?>
  <main class="auth-page">
    <section class="auth-card">
      <h1>Créer un compte</h1>
      <form action="creer-compte.php" method="post" novalidate>
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
      <p>Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
    </section>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
