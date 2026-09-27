<main>
  <section class="hero">
    <h1>Tous les événements des clubs, au même endroit</h1>
    <p>Ateliers, conférences, sorties, tournois : découvrez ce que font les clubs étudiants et réservez votre place en quelques secondes.</p>
    <a class="button" href="<?= e(url('evenements')) ?>">Voir les événements</a>
  </section>

  <section>
    <h2>Prochains événements</h2>
    <div class="event-list">
      <?php foreach ($events as $event): ?>
        <?php require __DIR__ . '/partials/event-card.php'; ?>
      <?php endforeach; ?>
    </div>
  </section>
</main>
