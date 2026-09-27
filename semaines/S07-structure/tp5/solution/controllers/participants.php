<?php
// Liste des inscrits d'un événement : réservée à SON organisateur.
$user = Auth::requireRole('organizer');
$pdo = Database::connection();

$id = intParam('id');
$event = $id !== null ? (new EventRepository($pdo))->find($id) : null;
if ($event === null) {
    View::notFound('Cet événement n\'existe pas.');
}

// Être organisateur ne suffit pas : il faut être l'organisateur de CET événement
if ($event['organizer_id'] !== $user['id']) {
    View::forbidden("Seul l'organisateur de cet événement peut voir ses inscrits.");
}

View::render('participants', [
    'pageTitle' => 'Inscrits · ' . $event['title'] . ' · ClubHub',
    'event' => $event,
    'participants' => (new RegistrationRepository($pdo))->participants($event['id']),
]);
