<?php
require __DIR__ . '/includes/bootstrap.php';

$nextEvents = getEvents(2);   // les 2 prochains événements (LIMIT 2 en SQL)

$pageTitle = 'ClubHub : les événements des clubs étudiants';
$currentPage = 'accueil';
require __DIR__ . '/includes/header.php';
?>
  <main>
    <section class="hero">
      <h1>Tous les événements des clubs, au même endroit</h1>
      <p>Ateliers, conférences, sorties, tournois : découvrez ce que font les clubs étudiants et réservez votre place en quelques secondes.</p>
      <a class="button" href="evenements.php">Voir les événements</a>
    </section>

    <section>
      <h2>Prochains événements</h2>
      <div class="event-list">
        <?php foreach ($nextEvents as $event): ?>
          <?php require __DIR__ . '/includes/event-card.php'; ?>
        <?php endforeach; ?>
      </div>
    </section>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
