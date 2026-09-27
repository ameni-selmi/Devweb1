<?php $placesLeft = (int) $event['places_left']; ?>
<article class="event-card" data-club="<?= e($event['club_slug']) ?>" data-date="<?= e(isoDate($event['starts_at'])) ?>" data-places="<?= e($placesLeft) ?>">
  <p class="club"><?= e($event['club']) ?></p>
  <h2><?= e($event['title']) ?></h2>
  <p class="meta"><time datetime="<?= e(isoDate($event['starts_at'])) ?>"><?= e(formatDate($event['starts_at'])) ?></time>, <?= e(formatHour($event['starts_at'])) ?></p>
  <p class="meta"><?= e($event['location']) ?></p>
  <p class="places<?= $placesLeft <= 0 ? ' is-full' : '' ?>"><strong><?= e(placesLabel($placesLeft)) ?></strong></p>
  <a href="<?= e(url('evenement', ['id' => $event['id']])) ?>">Voir le détail</a>
</article>
