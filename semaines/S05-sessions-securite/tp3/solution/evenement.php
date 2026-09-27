<?php
require __DIR__ . '/includes/bootstrap.php';

// 1. Quel événement ? L'id arrive dans l'URL : evenement.php?id=3
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$event = $id ? findEvent($id) : null;

if ($event === null) {
    http_response_code(404);
    $pageTitle = 'Événement introuvable · ClubHub';
    require __DIR__ . '/includes/header.php';
    echo '<main><h1>Événement introuvable</h1><p><a href="evenements.php">Retour à la liste des événements</a></p></main>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

// 2. Inscription à l'événement (réservée aux utilisateurs connectés)
$user = currentUser();
$errors = [];
$old = ['motivation' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = requireLogin();   // même si le formulaire est caché, le serveur vérifie

    $old['motivation'] = trim($_POST['motivation'] ?? '');
    $rulesAccepted = ($_POST['rules'] ?? '') === '1';

    if (mb_strlen($old['motivation']) > 300) {
        $errors['motivation'] = 'La motivation ne doit pas dépasser 300 caractères.';
    }
    if (!$rulesAccepted) {
        $errors['rules'] = 'Vous devez accepter le règlement.';
    }

    if ($errors === []) {
        if (isRegistered($event['id'])) {
            flash('Vous êtes déjà inscrit à cet événement.', 'info');
        } else {
            // Provisoire : les inscriptions vivent dans la session (séance 6 : base de données)
            $_SESSION['registrations'][$event['id']] = ['motivation' => $old['motivation']];
            flash('Inscription confirmée pour « ' . $event['title'] . ' ».');
        }
        // Post/Redirect/Get : F5 ne renverra pas le formulaire
        redirect('evenement.php?id=' . $event['id']);
    }
}

$pageTitle = $event['title'] . ' · ClubHub';
$currentPage = 'evenement';
require __DIR__ . '/includes/header.php';
?>
  <main class="event-page">
    <article class="event-detail">
      <p class="club"><?= e($event['club']) ?></p>
      <h1><?= e($event['title']) ?></h1>
      <ul class="facts">
        <li><strong>Date :</strong> <time datetime="<?= e($event['date']) ?>"><?= e($event['date_label']) ?></time>, <?= e($event['time_label']) ?></li>
        <li><strong>Lieu :</strong> <?= e($event['location']) ?></li>
        <li><strong>Places :</strong> <?= e($event['capacity']) ?></li>
      </ul>

      <p><?= e($event['description']) ?></p>

      <h2>Au programme</h2>
      <ul>
        <?php foreach ($event['program'] as $step): ?>
          <li><?= e($step) ?></li>
        <?php endforeach; ?>
      </ul>

      <h2>À apporter</h2>
      <ul>
        <?php foreach ($event['bring'] as $thing): ?>
          <li><?= e($thing) ?></li>
        <?php endforeach; ?>
      </ul>
    </article>

    <section class="registration">
      <h2>S'inscrire</h2>

      <?php if ($user === null): ?>
        <p>Vous devez être connecté pour vous inscrire.</p>
        <p>
          <a class="button" href="connexion.php?next=<?= e(urlencode('/evenement.php?id=' . $event['id'])) ?>">Se connecter</a>
          <a href="creer-compte.php">Créer un compte</a>
        </p>
      <?php elseif (isRegistered($event['id'])): ?>
        <p class="form-success">Vous êtes inscrit à cet événement.</p>
        <p><a href="compte.php">Voir mes inscriptions</a></p>
      <?php else: ?>
        <p>Vous vous inscrivez en tant que <strong><?= e($user['name']) ?></strong> (<?= e($user['email']) ?>).</p>
        <form action="evenement.php?id=<?= e($event['id']) ?>" method="post" id="registration-form">
          <p>
            <label for="motivation">Motivation (facultatif)</label>
            <textarea id="motivation" name="motivation" rows="4" maxlength="300"><?= e($old['motivation']) ?></textarea>
            <small class="counter" id="motivation-count">0 / 300</small>
            <small class="field-error"><?= e($errors['motivation'] ?? '') ?></small>
          </p>
          <p>
            <label><input type="checkbox" id="rules" name="rules" value="1" required> J'accepte le règlement du club</label>
            <small class="field-error" id="rules-error"><?= e($errors['rules'] ?? '') ?></small>
          </p>
          <p>
            <button type="submit">S'inscrire</button>
          </p>
        </form>
      <?php endif; ?>
    </section>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
