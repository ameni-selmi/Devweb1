<?php
// Connexion.
$next = Auth::safeNext($_GET['next'] ?? $_POST['next'] ?? null);

if (Auth::user() !== null) {
    redirect($next);
}

$email = '';
$error = '';

if (isPost()) {
    $email = trim($_POST['email'] ?? '');
    $user = (new UserRepository(Database::connection()))->findByEmail($email);

    if ($user !== null && password_verify($_POST['password'] ?? '', $user['password_hash'])) {
        Auth::login($user);
        flash('Bonjour ' . $user['name'] . ' !');
        redirect($next);
    }
    $error = 'Email ou mot de passe incorrect.';
}

View::render('login', [
    'pageTitle' => 'Connexion · ClubHub',
    'currentPage' => 'connexion',
    'email' => $email,
    'error' => $error,
    'next' => $next,
]);
