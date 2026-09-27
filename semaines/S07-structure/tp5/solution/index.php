<?php
// Point d'entrée unique (front controller) : TOUTES les pages passent par ici.
// URL : index.php?page=evenement&id=3

require __DIR__ . '/src/bootstrap.php';

// Les pages qui existent : nom dans l'URL => fichier dans controllers/
// C'est une liste blanche : on n'inclut JAMAIS un fichier dont le nom vient directement de l'URL.
$routes = [
    'accueil'        => 'home',
    'evenements'     => 'events',
    'evenement'      => 'event',
    'connexion'      => 'login',
    'creer-compte'   => 'register',
    'deconnexion'    => 'logout',
    'compte'         => 'account',
    'annuler'        => 'cancel',
    'nouvel-evenement' => 'event-new',
    'inscrits'       => 'participants',
];

$page = $_GET['page'] ?? 'accueil';

if (!is_string($page) || !array_key_exists($page, $routes)) {
    View::notFound();
}

require __DIR__ . '/controllers/' . $routes[$page] . '.php';
