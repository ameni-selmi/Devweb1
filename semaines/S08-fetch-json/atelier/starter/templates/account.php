<?php $roles = ['student' => 'Étudiant', 'organizer' => 'Organisateur']; ?>
<main>
  <h1>Mon compte</h1>

  <section class="account-card">
    <h2>Mes informations</h2>
    <ul class="facts">
      <li><strong>Nom :</strong> <?= e($user['name']) ?></li>
      <li><strong>Email :</strong> <?= e($user['email']) ?></li>
      <li><strong>Rôle :</strong> <?= e($roles[$user['role']] ?? $user['role']) ?></li>
      <li><strong>Membre depuis le :</strong> <?= e(formatDate($user['created_at'])) ?></li>
    </ul>
  </section>

  <?php if ($user['role'] === 'organizer'): ?>
    <section>
      <h2>Mes événements</h2>
      <p><a class="button" href="<?= e(url('nouvel-evenement')) ?>">Créer un événement</a></p>
      <?php if ($myEvents === []): ?>
        <p class="empty-message">Vous n'avez encore créé aucun événement.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr><th scope="col">Événement</th><th scope="col">Date</th><th scope="col">Inscrits</th><th scope="col">Action</th></tr>
          </thead>
          <tbody>
            <?php foreach ($myEvents as $event): ?>
              <tr>
                <td><a href="<?= e(url('evenement', ['id' => $event['id']])) ?>"><?= e($event['title']) ?></a></td>
                <td><?= e(formatDate($event['starts_at'])) ?></td>
                <td><?= e($event['capacity'] - $event['places_left']) ?> / <?= e($event['capacity']) ?></td>
                <td><a href="<?= e(url('inscrits', ['id' => $event['id']])) ?>">Voir les inscrits</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </section>
  <?php endif; ?>

  <section>
    <h2>Mes inscriptions</h2>
    <?php if ($registrations === []): ?>
      <p class="empty-message">Vous n'êtes inscrit à aucun événement. <a href="<?= e(url('evenements')) ?>">Voir les événements</a></p>
    <?php else: ?>
      <table>
        <thead>
          <tr><th scope="col">Événement</th><th scope="col">Date</th><th scope="col">Lieu</th><th scope="col">Action</th></tr>
        </thead>
        <tbody>
          <?php foreach ($registrations as $registration): ?>
            <?php $isPast = new DateTimeImmutable($registration['starts_at']) < new DateTimeImmutable(); ?>
            <tr>
              <td><a href="<?= e(url('evenement', ['id' => $registration['id']])) ?>"><?= e($registration['title']) ?></a></td>
              <td><?= e(formatDate($registration['starts_at'])) ?>, <?= e(formatHour($registration['starts_at'])) ?></td>
              <td><?= e($registration['location']) ?></td>
              <td>
                <?php if ($isPast): ?>
                  <span class="meta">Terminé</span>
                <?php else: ?>
                  <form action="<?= e(url('annuler')) ?>" method="post">
                    <input type="hidden" name="event_id" value="<?= e($registration['id']) ?>">
                    <button type="submit" class="button-small">Annuler</button>
                  </form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>
</main>
