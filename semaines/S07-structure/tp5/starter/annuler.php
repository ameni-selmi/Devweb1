<?php
require __DIR__ . '/includes/bootstrap.php';

$user = requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('compte.php');
}

$eventId = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);

// cancelRegistration filtre sur user_id : impossible d'annuler l'inscription de quelqu'un d'autre
if ($eventId && cancelRegistration($user['id'], $eventId)) {
    flash('Votre inscription est annulée.', 'info');
}

redirect('compte.php');
