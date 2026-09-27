<?php
// Détail d'un événement + inscription.
$pdo = Database::connection();
$events = new EventRepository($pdo);
$registrations = new RegistrationRepository($pdo);

$id = intParam('id');
$event = $id !== null ? $events->find($id) : null;
if ($event === null) {
    View::notFound('Cet événement n\'existe pas.');
}

$user = Auth::user();
$errors = [];
$old = ['motivation' => ''];

if (isPost()) {
    $user = Auth::requireLogin();

    $old['motivation'] = trim($_POST['motivation'] ?? '');
    if (mb_strlen($old['motivation']) > 300) {
        $errors['motivation'] = 'La motivation ne doit pas dépasser 300 caractères.';
    }
    if (($_POST['rules'] ?? '') !== '1') {
        $errors['rules'] = 'Vous devez accepter le règlement.';
    }

    if ($errors === []) {
        match ($registrations->register($user['id'], $event['id'], $old['motivation'])) {
            RegistrationRepository::OK => flash('Inscription confirmée pour « ' . $event['title'] . ' ».'),
            RegistrationRepository::ALREADY => flash('Vous êtes déjà inscrit à cet événement.', 'info'),
            RegistrationRepository::FULL => flash('Désolé, cet événement est complet.', 'error'),
        };
        redirect(url('evenement', ['id' => $event['id']]));
    }
}

View::render('event', [
    'pageTitle' => $event['title'] . ' · ClubHub',
    'event' => $event,
    'user' => $user,
    'alreadyRegistered' => $user !== null && $registrations->exists($user['id'], $event['id']),
    'isOrganizer' => $user !== null && $user['id'] === $event['organizer_id'],
    'errors' => $errors,
    'old' => $old,
]);
