<main>
  <p class="club"><?= e($event['club']) ?></p>
  <h1>Inscrits : <?= e($event['title']) ?></h1>
  <p><?= e(formatDate($event['starts_at'])) ?>, <?= e(formatTimeRange($event['starts_at'], $event['ends_at'])) ?> · <?= e(count($participants)) ?> inscrit(s) sur <?= e($event['capacity']) ?> places.</p>

  <?php if ($participants === []): ?>
    <p class="empty-message">Personne n'est encore inscrit.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th scope="col">#</th><th scope="col">Nom</th><th scope="col">Email</th><th scope="col">Motivation</th></tr>
      </thead>
      <tbody>
        <?php foreach ($participants as $index => $participant): ?>
          <tr>
            <td><?= e($index + 1) ?></td>
            <td><?= e($participant['name']) ?></td>
            <td><a href="mailto:<?= e($participant['email']) ?>"><?= e($participant['email']) ?></a></td>
            <td><?= e($participant['motivation'] !== '' ? $participant['motivation'] : '·') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
  <p><a href="<?= e(url('compte')) ?>">Retour à mon compte</a></p>
</main>
