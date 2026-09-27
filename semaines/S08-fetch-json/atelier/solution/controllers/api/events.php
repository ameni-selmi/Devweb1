<?php
// GET index.php?page=api-evenements&q=arduino → la liste des événements en JSON
$repository = new EventRepository(Database::connection());

$query = trim($_GET['q'] ?? '');
$events = $query === '' ? $repository->upcoming() : $repository->search($query);

// On choisit ce qu'on envoie : jamais toute la ligne de la base sans réfléchir
$data = array_map(fn(array $event): array => [
    'id' => $event['id'],
    'title' => $event['title'],
    'club' => $event['club'],
    'clubSlug' => $event['club_slug'],
    'location' => $event['location'],
    'startsAt' => isoDate($event['starts_at']),
    'dateLabel' => formatDate($event['starts_at']) . ', ' . formatHour($event['starts_at']),
    'placesLeft' => (int) $event['places_left'],
    'placesLabel' => placesLabel((int) $event['places_left']),
    'url' => url('evenement', ['id' => $event['id']]),
], $events);

jsonResponse(['events' => $data]);
