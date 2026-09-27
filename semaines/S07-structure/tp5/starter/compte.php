<?php
require __DIR__ . '/includes/bootstrap.php';

$user = requireLogin();   // page protégée : première ligne après le bootstrap

// Un JOIN entre registrations et events, filtré sur l'utilisateur connecté
$registrations = registrationsOfUser($user['id']);

$roles = ['student' => 'Étudiant', 'organizer' => 'Organisateur'];

$pageTitle = 'Mon compte · ClubHub';
$currentPage = 'compte';
require __DIR__ . '/includes/header.php';
?>
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

    <section>
      <h2>Mes inscriptions</h2>
      <?php if ($registrations === []): ?>
        <p class="empty-message">Vous n'êtes inscrit à aucun événement. <a href="evenements.php">Voir les événements</a></p>
      <?php else: ?>
        <table>
          <thead>
            <tr><th scope="col">Événement</th><th scope="col">Date</th><th scope="col">Lieu</th><th scope="col">Action</th></tr>
          </thead>
          <tbody>
            <?php foreach ($registrations as $registration): ?>
              <?php $isPast = new DateTimeImmutable($registration['starts_at']) < new DateTimeImmutable(); ?>
              <tr>
                <td><a href="evenement.php?id=<?= e($registration['id']) ?>"><?= e($registration['title']) ?></a></td>
                <td><?= e(formatDate($registration['starts_at'])) ?>, <?= e(formatHour($registration['starts_at'])) ?></td>
                <td><?= e($registration['location']) ?></td>
                <td>
                  <?php if ($isPast): ?>
                    <span class="meta">Terminé</span>
                  <?php else: ?>
                    <form action="annuler.php" method="post">
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
<?php require __DIR__ . '/includes/footer.php'; ?>
