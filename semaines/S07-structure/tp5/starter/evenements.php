<?php
require __DIR__ . '/includes/bootstrap.php';

// Recherche côté serveur (fonctionne même sans JavaScript) : evenements.php?q=arduino
$query = trim($_GET['q'] ?? '');
$events = $query === '' ? getEvents() : searchEvents($query);

// Liste des clubs pour le filtre, sans doublons : slug => nom
$clubs = [];
foreach (getEvents() as $event) {
    $clubs[$event['club_slug']] = $event['club'];
}

$pageTitle = 'Événements · ClubHub';
$currentPage = 'evenements';
require __DIR__ . '/includes/header.php';
?>
  <main>
    <h1>Tous les événements</h1>
    <p><?= count($events) ?> événement(s) à venir<?= $query !== '' ? ' pour « ' . e($query) . ' »' : '' ?>.</p>

    <form class="filters" role="search">
      <p>
        <label for="search">Rechercher</label>
        <input type="search" id="search" name="q" placeholder="Arduino, photo, IA..." value="<?= e($query) ?>">
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
          <option value="places">Places restantes (plus grand d'abord)</option>
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
