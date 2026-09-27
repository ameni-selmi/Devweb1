<?php
// Une carte d'événement. Attend une variable $event (un tableau).
?>
<article class="event-card" data-club="<?= e($event['club_slug']) ?>" data-date="<?= e($event['date']) ?>" data-places="<?= e($event['capacity']) ?>">
  <p class="club"><?= e($event['club']) ?></p>
  <h2><?= e($event['title']) ?></h2>
  <p class="meta"><time datetime="<?= e($event['date']) ?>"><?= e($event['date_label']) ?></time>, <?= e($event['time_label']) ?></p>
  <p class="meta"><?= e($event['location']) ?></p>
  <p class="places"><strong><?= e($event['capacity']) ?></strong> places</p>
  <a href="evenement.php?id=<?= e($event['id']) ?>">Voir le détail</a>
</article>
