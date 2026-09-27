<?php
// Petite fonction locale pour ne pas répéter le même bloc pour chaque champ
$error = fn(string $field): string => '<small class="field-error">' . e($errors[$field] ?? '') . '</small>';
?>
<main class="auth-page">
  <section class="auth-card form-wide">
    <h1>Créer un événement</h1>
    <form action="<?= e(url('nouvel-evenement')) ?>" method="post" novalidate>
      <p>
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" required maxlength="150" value="<?= e($old['title']) ?>">
        <?= $error('title') ?>
      </p>
      <p>
        <label for="club">Club</label>
        <input type="text" id="club" name="club" required maxlength="100" value="<?= e($old['club']) ?>">
        <?= $error('club') ?>
      </p>
      <p>
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required><?= e($old['description']) ?></textarea>
        <?= $error('description') ?>
      </p>
      <p>
        <label for="program">Programme (une étape par ligne)</label>
        <textarea id="program" name="program" rows="4" required><?= e($old['program']) ?></textarea>
        <?= $error('program') ?>
      </p>
      <p>
        <label for="bring">À apporter (un élément par ligne, facultatif)</label>
        <textarea id="bring" name="bring" rows="2"><?= e($old['bring']) ?></textarea>
      </p>
      <p>
        <label for="location">Lieu</label>
        <input type="text" id="location" name="location" required maxlength="150" value="<?= e($old['location']) ?>">
        <?= $error('location') ?>
      </p>
      <div class="form-row">
        <p>
          <label for="date">Date</label>
          <input type="date" id="date" name="date" required value="<?= e($old['date']) ?>">
          <?= $error('date') ?>
        </p>
        <p>
          <label for="start">Début</label>
          <input type="time" id="start" name="start" required value="<?= e($old['start']) ?>">
          <?= $error('start') ?>
        </p>
        <p>
          <label for="end">Fin</label>
          <input type="time" id="end" name="end" required value="<?= e($old['end']) ?>">
          <?= $error('end') ?>
        </p>
      </div>
      <p>
        <label for="capacity">Nombre de places</label>
        <input type="number" id="capacity" name="capacity" required min="1" max="1000" value="<?= e($old['capacity']) ?>">
        <?= $error('capacity') ?>
      </p>
      <p><button type="submit">Publier l'événement</button></p>
    </form>
  </section>
</main>
