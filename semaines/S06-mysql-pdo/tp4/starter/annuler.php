<?php
require __DIR__ . '/includes/bootstrap.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('compte.php');
}

$eventId = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);

if ($eventId && isRegistered($eventId)) {
    unset($_SESSION['registrations'][$eventId]);
    flash('Votre inscription est annulée.', 'info');
}

redirect('compte.php');
