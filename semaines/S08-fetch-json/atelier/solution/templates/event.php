<?php $placesLeft = (int) $event['places_left']; ?>
<main class="event-page">
  <article class="event-detail">
    <p class="club"><?= e($event['club']) ?></p>
    <h1><?= e($event['title']) ?></h1>
    <ul class="facts">
      <li><strong>Date :</strong> <time datetime="<?= e(isoDate($event['starts_at'])) ?>"><?= e(formatDate($event['starts_at'])) ?></time>, <?= e(formatTimeRange($event['starts_at'], $event['ends_at'])) ?></li>
      <li><strong>Lieu :</strong> <?= e($event['location']) ?></li>
      <li><strong>Places :</strong> <span id="places-label"><?= e(placesLabel($placesLeft)) ?></span> sur <?= e($event['capacity']) ?></li>
    </ul>

    <?php if ($isOrganizer): ?>
      <p><a class="button" href="<?= e(url('inscrits', ['id' => $event['id']])) ?>">Voir les inscrits</a></p>
    <?php endif; ?>

    <p><?= e($event['description']) ?></p>

    <h2>Au programme</h2>
    <ul>
      <?php foreach (lines($event['program']) as $step): ?>
        <li><?= e($step) ?></li>
      <?php endforeach; ?>
    </ul>

    <h2>À apporter</h2>
    <ul>
      <?php foreach (lines($event['bring']) as $thing): ?>
        <li><?= e($thing) ?></li>
      <?php endforeach; ?>
    </ul>
  </article>

  <section class="registration" data-api="<?= e(url('api-inscription')) ?>" data-event-id="<?= e($event['id']) ?>"
           data-login-url="<?= e(url('connexion', ['next' => '/' . url('evenement', ['id' => $event['id']])])) ?>">
    <h2>S'inscrire</h2>

    <?php if ($alreadyRegistered): ?>
      <p class="form-success">Vous êtes inscrit à cet événement.</p>
      <p><a href="<?= e(url('compte')) ?>">Voir mes inscriptions</a></p>
    <?php elseif ($placesLeft <= 0): ?>
      <p class="flash flash-error">Cet événement est complet.</p>
    <?php elseif ($user === null): ?>
      <p>Vous devez être connecté pour vous inscrire.</p>
      <p>
        <a class="button" href="<?= e(url('connexion', ['next' => '/' . url('evenement', ['id' => $event['id']])])) ?>">Se connecter</a>
        <a href="<?= e(url('creer-compte')) ?>">Créer un compte</a>
      </p>
    <?php else: ?>
      <p>Vous vous inscrivez en tant que <strong><?= e($user['name']) ?></strong> (<?= e($user['email']) ?>).</p>
      <form action="<?= e(url('evenement', ['id' => $event['id']])) ?>" method="post" id="registration-form">
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
