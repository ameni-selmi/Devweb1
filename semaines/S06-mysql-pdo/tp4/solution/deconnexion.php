<?php
require __DIR__ . '/includes/bootstrap.php';

// La déconnexion modifie l'état : elle se fait en POST, jamais par un simple lien GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo 'Méthode non autorisée.';
    exit;
}

logoutUser();

// La session vient d'être détruite : on en ouvre une nouvelle, vide, avec un nouvel identifiant,
// seulement pour transporter le message flash jusqu'à la page suivante
session_start();
session_regenerate_id(true);
flash('Vous êtes déconnecté.', 'info');
redirect('index.php');
