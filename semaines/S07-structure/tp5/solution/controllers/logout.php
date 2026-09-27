<?php
// Déconnexion : POST seulement.
if (!isPost()) {
    http_response_code(405);
    header('Allow: POST');
    exit('Méthode non autorisée.');
}

Auth::logout();
session_start();
session_regenerate_id(true);
flash('Vous êtes déconnecté.', 'info');
redirect(url('accueil'));
