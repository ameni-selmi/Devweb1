<?php
require __DIR__ . '/includes/functions.php';

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

// 2. Traitement du formulaire (seulement si la requête est un POST)
$old = ['name' => '', 'email' => '', 'level' => '', 'experience' => 'no', 'motivation' => ''];
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données, avec une valeur par défaut si le champ est absent
    $old['name'] = trim($_POST['name'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $old['level'] = $_POST['level'] ?? '';
    $old['experience'] = $_POST['experience'] ?? '';
    $old['motivation'] = trim($_POST['motivation'] ?? '');
    $rulesAccepted = ($_POST['rules'] ?? '') === '1';

    // Valider : on ne fait JAMAIS confiance au navigateur
    if (mb_strlen($old['name']) < 3) {
        $errors['name'] = 'Le nom doit contenir au moins 3 caractères.';
    } elseif (mb_strlen($old['name']) > 100) {
        $errors['name'] = 'Le nom est trop long (100 caractères maximum).';
    }
    if (filter_var($old['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = "Cet email n'est pas valide.";
    }
    if (!array_key_exists($old['level'], LEVELS)) {
        $errors['level'] = 'Choisissez votre niveau.';
    }
    if (!in_array($old['experience'], ['yes', 'no'], true)) {
        $errors['experience'] = 'Répondez par oui ou par non.';
    }
    if (mb_strlen($old['motivation']) > 300) {
        $errors['motivation'] = 'La motivation ne doit pas dépasser 300 caractères.';
    }
    if (!$rulesAccepted) {
        $errors['rules'] = 'Vous devez accepter le règlement.';
    }

    $success = $errors === [];
    // Pas encore de stockage : on affiche seulement une confirmation.
    // (Séance 5 : Post/Redirect/Get. Séance 6 : enregistrement en base.)
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

      <?php if ($success): ?>
        <p class="form-success">
          Merci <?= e($old['name']) ?> ! Votre inscription à « <?= e($event['title']) ?> » est bien reçue.
          Une confirmation sera envoyée à <?= e($old['email']) ?>.
        </p>
        <p><a href="evenements.php">Voir les autres événements</a></p>
      <?php else: ?>
        <?php if ($errors !== []): ?>
          <p class="field-error" role="alert">Le formulaire contient des erreurs. Corrigez les champs indiqués.</p>
        <?php endif; ?>

        <form action="evenement.php?id=<?= e($event['id']) ?>" method="post" id="registration-form">
          <p>
            <label for="name">Nom complet</label>
            <input type="text" id="name" name="name" required minlength="3" maxlength="100" autocomplete="name"
                   value="<?= e($old['name']) ?>"<?= isset($errors['name']) ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="field-error" id="name-error"><?= e($errors['name'] ?? '') ?></small>
          </p>
          <p>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required autocomplete="email" placeholder="prenom.nom@campus.example"
                   value="<?= e($old['email']) ?>"<?= isset($errors['email']) ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
            <small class="field-error" id="email-error"><?= e($errors['email'] ?? '') ?></small>
          </p>
          <p>
            <label for="level">Niveau d'études</label>
            <select id="level" name="level" required<?= isset($errors['level']) ? ' class="is-invalid" aria-invalid="true"' : '' ?>>
              <option value="">Choisir...</option>
              <?php foreach (LEVELS as $value => $label): ?>
                <option value="<?= e($value) ?>"<?= (string) $value === $old['level'] ? ' selected' : '' ?>><?= e($label) ?></option>
              <?php endforeach; ?>
            </select>
            <small class="field-error" id="level-error"><?= e($errors['level'] ?? '') ?></small>
          </p>
          <fieldset>
            <legend>Avez vous déjà participé à un événement de ce club ?</legend>
            <label><input type="radio" name="experience" value="yes"<?= $old['experience'] === 'yes' ? ' checked' : '' ?>> Oui</label>
            <label><input type="radio" name="experience" value="no"<?= $old['experience'] !== 'yes' ? ' checked' : '' ?>> Non</label>
          </fieldset>
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
