<?php
// Créer un événement : réservé aux organisateurs.
$user = Auth::requireRole('organizer');

$fields = ['title', 'club', 'description', 'program', 'bring', 'location', 'date', 'start', 'end', 'capacity'];
$old = array_fill_keys($fields, '');
$old['club'] = $user['name'];   // un compte organisateur porte le nom de son club
$errors = [];

if (isPost()) {
    foreach ($fields as $field) {
        $old[$field] = trim($_POST[$field] ?? '');
    }

    // Champs texte obligatoires, avec leur longueur maximale
    $required = ['title' => 150, 'club' => 100, 'description' => 2000, 'program' => 2000, 'location' => 150];
    foreach ($required as $field => $max) {
        if ($old[$field] === '') {
            $errors[$field] = 'Ce champ est obligatoire.';
        } elseif (mb_strlen($old[$field]) > $max) {
            $errors[$field] = "$max caractères maximum.";
        }
    }

    // Date et heures : on construit de vraies dates, et on vérifie qu'elles existent
    $startsAt = DateTimeImmutable::createFromFormat('!Y-m-d H:i', $old['date'] . ' ' . $old['start']);
    $endsAt = DateTimeImmutable::createFromFormat('!Y-m-d H:i', $old['date'] . ' ' . $old['end']);

    if ($startsAt === false) {
        $errors['date'] = 'Date ou heure de début invalide.';
    } elseif ($startsAt <= new DateTimeImmutable()) {
        $errors['date'] = "L'événement doit être dans le futur.";
    }
    if ($endsAt === false) {
        $errors['end'] = 'Heure de fin invalide.';
    } elseif ($startsAt !== false && $endsAt <= $startsAt) {
        $errors['end'] = "La fin doit être après le début.";
    }

    $capacity = filter_var($old['capacity'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 1000]]);
    if ($capacity === false) {
        $errors['capacity'] = 'Entre 1 et 1000 places.';
    }

    if ($errors === []) {
        $id = (new EventRepository(Database::connection()))->create([
            'title' => $old['title'],
            'club' => $old['club'],
            'description' => $old['description'],
            'program' => $old['program'],
            'bring' => $old['bring'],
            'location' => $old['location'],
            'starts_at' => $startsAt->format('Y-m-d H:i:s'),
            'ends_at' => $endsAt->format('Y-m-d H:i:s'),
            'capacity' => $capacity,
        ], $user['id']);

        flash('Événement publié.');
        redirect(url('evenement', ['id' => $id]));
    }
}

View::render('event-new', [
    'pageTitle' => 'Créer un événement · ClubHub',
    'currentPage' => 'nouvel-evenement',
    'old' => $old,
    'errors' => $errors,
]);
