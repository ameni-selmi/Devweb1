<?php
// Mon compte (protégé).
$user = Auth::requireLogin();
$pdo = Database::connection();

View::render('account', [
    'pageTitle' => 'Mon compte · ClubHub',
    'currentPage' => 'compte',
    'user' => $user,
    'registrations' => (new RegistrationRepository($pdo))->ofUser($user['id']),
    'myEvents' => $user['role'] === 'organizer' ? (new EventRepository($pdo))->byOrganizer($user['id']) : [],
]);
