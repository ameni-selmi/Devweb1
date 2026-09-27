<?php
// POST index.php?page=api-inscription  corps JSON : {"eventId": 3, "motivation": "...", "rules": true}
// Réponses : 200 inscrit, 401 pas connecté, 404 événement inconnu, 409 déjà inscrit ou complet, 422 données invalides
if (!isPost()) {
    jsonResponse(['error' => 'Méthode non autorisée.'], 405);
}

$user = Auth::user();
if ($user === null) {
    jsonResponse(['error' => 'Connectez vous pour vous inscrire.'], 401);
}

$body = jsonBody();
$eventId = filter_var($body['eventId'] ?? null, FILTER_VALIDATE_INT);
$motivation = trim((string) ($body['motivation'] ?? ''));

$pdo = Database::connection();
$events = new EventRepository($pdo);
$event = $eventId ? $events->find($eventId) : null;
if ($event === null) {
    jsonResponse(['error' => 'Événement introuvable.'], 404);
}

// Même validation que le formulaire classique : le serveur ne fait jamais confiance au JS
$errors = [];
if (mb_strlen($motivation) > 300) {
    $errors['motivation'] = 'La motivation ne doit pas dépasser 300 caractères.';
}
if (($body['rules'] ?? false) !== true) {
    $errors['rules'] = 'Vous devez accepter le règlement.';
}
if ($errors !== []) {
    jsonResponse(['error' => 'Données invalides.', 'fields' => $errors], 422);
}

$result = (new RegistrationRepository($pdo))->register($user['id'], $event['id'], $motivation);
$placesLeft = (int) $events->find($event['id'])['places_left'];

match ($result) {
    RegistrationRepository::OK => jsonResponse([
        'registered' => true,
        'message' => 'Inscription confirmée pour « ' . $event['title'] . ' ».',
        'placesLeft' => $placesLeft,
        'placesLabel' => placesLabel($placesLeft),
    ]),
    RegistrationRepository::ALREADY => jsonResponse(['error' => 'Vous êtes déjà inscrit à cet événement.'], 409),
    RegistrationRepository::FULL => jsonResponse(['error' => 'Désolé, cet événement est complet.'], 409),
};
