<?php
// Création de compte.
if (Auth::user() !== null) {
    redirect(url('compte'));
}

$users = new UserRepository(Database::connection());
$old = ['name' => '', 'email' => ''];
$errors = [];

if (isPost()) {
    $old['name'] = trim($_POST['name'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmation = $_POST['password_confirmation'] ?? '';

    if (mb_strlen($old['name']) < 3 || mb_strlen($old['name']) > 100) {
        $errors['name'] = 'Le nom doit contenir entre 3 et 100 caractères.';
    }
    if (filter_var($old['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = "Cet email n'est pas valide.";
    } elseif ($users->findByEmail($old['email']) !== null) {
        $errors['email'] = 'Un compte existe déjà avec cet email.';
    }
    if (mb_strlen($password) < 8) {
        $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères.';
    }
    if ($password !== $confirmation) {
        $errors['password_confirmation'] = 'Les deux mots de passe ne sont pas identiques.';
    }

    if ($errors === []) {
        $users->create($old['name'], $old['email'], password_hash($password, PASSWORD_DEFAULT));
        flash('Votre compte est créé. Vous pouvez vous connecter.');
        redirect(url('connexion'));
    }
}

View::render('register', [
    'pageTitle' => 'Créer un compte · ClubHub',
    'currentPage' => 'creer-compte',
    'old' => $old,
    'errors' => $errors,
]);
