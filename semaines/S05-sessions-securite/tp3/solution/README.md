# Corrigé TP3

À publier **après** la date limite du rendu.

Lancer : `php -S localhost:8000` dans ce dossier. Comptes : `amine@campus.example`, `sarra@campus.example`, `robotique@campus.example`, mot de passe `demo1234`.

* Couvre la Base, le Plus, et les défis « retour à la page demandée » (`?next=` + `safeNext()`) et « cookie durci » (`session_set_cookie_params` dans `bootstrap.php`).
* Le défi « limiter les tentatives » n'est pas dans ce corrigé. Réponse à la question : un attaquant supprime simplement son cookie de session et recommence à zéro. Une vraie limite se fait côté serveur par adresse IP ou par compte, dans un stockage partagé (une table en BD).

Points à commenter en correction collective :

* `bootstrap.php` : un seul endroit pour `session_start()` et les `require` ;
* `requireLogin()` dans le **traitement** du POST de `evenement.php`, pas seulement dans l'affichage ;
* `deconnexion.php` : refus du GET (405), puis nouvelle session vide avec un nouvel identifiant pour transporter le message flash ;
* les inscriptions sont dans `$_SESSION['registrations']` : elles disparaissent à la déconnexion. C'est le point de départ de la séance 6.

Ce dossier est le **starter du TP4**.
