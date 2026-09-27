<?php
// Inclus EN PREMIER par chaque page, avant tout HTML.

// Cookie de session : invisible pour JavaScript (httponly) et jamais envoyé depuis un autre site (samesite)
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

require __DIR__ . '/functions.php';
require __DIR__ . '/db.php';
require __DIR__ . '/events.php';
require __DIR__ . '/users.php';
require __DIR__ . '/registrations.php';
require __DIR__ . '/auth.php';
