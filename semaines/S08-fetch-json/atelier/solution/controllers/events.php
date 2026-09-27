<?php
// Liste des événements, avec recherche côté serveur : index.php?page=evenements&q=arduino
$repository = new EventRepository(Database::connection());

$query = trim($_GET['q'] ?? '');
$events = $query === '' ? $repository->upcoming() : $repository->search($query);

View::render('events', [
    'pageTitle' => 'Événements · ClubHub',
    'currentPage' => 'evenements',
    'events' => $events,
    'clubs' => $repository->clubs(),
    'query' => $query,
]);
