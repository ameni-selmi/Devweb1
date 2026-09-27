<?php
// Chargé une seule fois, par index.php.

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

// Chargement automatique des classes : quand PHP rencontre « new EventRepository »,
// il appelle cette fonction, qui inclut src/EventRepository.php.
spl_autoload_register(function (string $class): void {
    $file = __DIR__ . '/' . $class . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require __DIR__ . '/helpers.php';
