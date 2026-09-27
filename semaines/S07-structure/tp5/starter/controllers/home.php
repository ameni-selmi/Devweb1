<?php
// Page d'accueil : les 2 prochains événements.
$events = (new EventRepository(Database::connection()))->upcoming(2);

View::render('home', [
    'pageTitle' => 'ClubHub : les événements des clubs étudiants',
    'currentPage' => 'accueil',
    'events' => $events,
]);
