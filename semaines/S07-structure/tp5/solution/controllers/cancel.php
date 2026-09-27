<?php
// Annuler une inscription (POST, protégé).
$user = Auth::requireLogin();

if (!isPost()) {
    redirect(url('compte'));
}

$eventId = intParam('event_id', INPUT_POST);
if ($eventId !== null && (new RegistrationRepository(Database::connection()))->cancel($user['id'], $eventId)) {
    flash('Votre inscription est annulée.', 'info');
} else {
    flash("Cette inscription ne peut pas être annulée.", 'error');
}

redirect(url('compte'));
