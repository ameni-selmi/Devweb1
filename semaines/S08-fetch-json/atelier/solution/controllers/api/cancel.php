<?php
// POST index.php?page=api-annulation  corps JSON : {"eventId": 3}
if (!isPost()) {
    jsonResponse(['error' => 'Méthode non autorisée.'], 405);
}

$user = Auth::user();
if ($user === null) {
    jsonResponse(['error' => 'Connectez vous.'], 401);
}

$eventId = filter_var(jsonBody()['eventId'] ?? null, FILTER_VALIDATE_INT);

if ($eventId && (new RegistrationRepository(Database::connection()))->cancel($user['id'], $eventId)) {
    jsonResponse(['cancelled' => true, 'message' => 'Votre inscription est annulée.']);
}

jsonResponse(['error' => 'Cette inscription ne peut pas être annulée.'], 409);
