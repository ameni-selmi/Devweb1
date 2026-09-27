<?php
require __DIR__ . '/includes/functions.php';

$events = getEvents();

// Liste des clubs pour le filtre, sans doublons : slug => nom
$clubs = [];
foreach ($events as $event) {
    $clubs[$event['club_slug']] = $event['club'];
}

$pageTitle = 'Événements · ClubHub';
$currentPage = 'evenements';
require __DIR__ . '/includes/header.php';
?>
  <main>
    <h1>Tous les événements</h1>
    <p><?= count($events) ?> événements à venir.</p>

    <form class="filters" role="search">
      <p>
        <label for="search">Rechercher</label>
        <input type="search" id="search" name="q" placeholder="Arduino, photo, IA...">
      </p>
      <p>
        <label for="club-filter">Club</label>
        <select id="club-filter" name="club">
          <option value="">Tous les clubs</option>
          <?php foreach ($clubs as $slug => $name): ?>
            <option value="<?= e($slug) ?>"><?= e($name) ?></option>
          <?php endforeach; ?>
        </select>
      </p>
      <p>
        <label for="sort">Trier par</label>
        <select id="sort" name="sort">
          <option value="date">Date</option>
          <option value="places">Places (plus grand d'abord)</option>
        </select>
      </p>
    </form>

    <p class="results-count" aria-live="polite"></p>
    <p class="empty-message" hidden>Aucun événement ne correspond à votre recherche.</p>

    <div class="event-list">
      <?php foreach ($events as $event): ?>
        <?php require __DIR__ . '/includes/event-card.php'; ?>
      <?php endforeach; ?>
    </div>
  </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
