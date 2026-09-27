<?php
require __DIR__ . '/includes/bootstrap.php';

$user = requireLogin();   // page protégée : première ligne après le bootstrap

// Les inscriptions sont dans la session : [event_id => ['motivation' => ...]]
$registrations = [];
foreach (sessionRegistrations() as $eventId => $registration) {
    $event = findEvent($eventId);
    if ($event !== null) {
        $registrations[] = ['event' => $event, 'motivation' => $registration['motivation']];
    }
}

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
            <?php foreach ($registrations as ['event' => $event]): ?>
              <tr>
                <td><a href="evenement.php?id=<?= e($event['id']) ?>"><?= e($event['title']) ?></a></td>
                <td><?= e($event['date_label']) ?></td>
                <td><?= e($event['location']) ?></td>
                <td>
                  <form action="annuler.php" method="post">
                    <input type="hidden" name="event_id" value="<?= e($event['id']) ?>">
                    <button type="submit" class="button-small">Annuler</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p class="meta">Attention : ces inscriptions sont gardées dans votre session. Elles disparaîtront à la déconnexion. (Nous réglerons ce problème en séance 6.)</p>
      <?php endif; ?>
    </section>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
