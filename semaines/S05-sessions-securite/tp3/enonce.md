# TP3 (noté) : des comptes pour ClubHub

**Noté sur 20** · En binôme · Durée : 1 h 40 en séance
**Rendu : dépôt Git, ce soir avant 23 h 59**

## Objectifs

* Utiliser une session PHP pour garder un utilisateur connecté.
* Hacher et vérifier des mots de passe correctement.
* Protéger des pages **côté serveur**.
* Appliquer Post/Redirect/Get et afficher des messages flash.

## Ce qu'on vous donne

Dans `tp3/starter/` : le corrigé de l'atelier S04, plus :

* `data/users.json` : trois comptes de démonstration (mot de passe `demo1234`), avec des mots de passe **déjà hachés** ;
* `includes/users.php` : les fonctions `readUsers()`, `saveUsers()`, `findUserByEmail()`, `findUserById()`, `addUser()` pour lire et écrire ce fichier JSON. **Vous ne touchez pas au JSON à la main.** En séance 6, ce fichier sera remplacé par MySQL ;
* `includes/auth.php` : `redirect()` et `safeNext()` sont données, les autres fonctions sont à écrire ;
* le CSS des messages flash (`.flash`, `.flash-success`, `.flash-info`, `.flash-error`), des formulaires de connexion (`.auth-page`, `.auth-card`) et du bouton de déconnexion (`.link-button`).

| Email | Mot de passe | Rôle |
|---|---|---|
| amine@campus.example | demo1234 | student |
| sarra@campus.example | demo1234 | student |
| robotique@campus.example | demo1234 | organizer |

## Règles

* `session_start()` est appelé **une seule fois**, dans `includes/bootstrap.php`, inclus **en premier** par toutes les pages.
* Aucun mot de passe en clair : ni dans le fichier, ni dans la session, ni dans un message.
* Toute page protégée appelle `requireLogin()` **elle même**.
* Toutes les données affichées passent par `e()` (comme en S04).
* Une action qui modifie des données (connexion, déconnexion, inscription, annulation) se fait en **POST**.

## Travail demandé

### Base (jusqu'à 14/20)

1. **Bootstrap** : créez `includes/bootstrap.php` qui démarre la session puis inclut `functions.php`, `users.php` et `auth.php`. Remplacez l'ancien `require` de `functions.php` par celui du bootstrap dans toutes les pages.
2. **Fonctions d'authentification** : complétez `currentUser()`, `requireLogin()`, `loginUser()` et `logoutUser()` dans `includes/auth.php`.
3. **`creer-compte.php`** : formulaire nom, email, mot de passe, confirmation. Validation serveur :
   * nom entre 3 et 100 caractères ;
   * email valide et **pas déjà utilisé** ;
   * mot de passe d'au moins 8 caractères ;
   * confirmation identique.

   Si tout va bien : `addUser()` avec `password_hash()`, puis redirection vers `connexion.php`. Sinon : réaffichage avec les messages sous les champs (sans remettre le mot de passe dans le champ).
4. **`connexion.php`** : email + mot de passe, vérifiés avec `password_verify()`. En cas d'échec : **un seul** message, « Email ou mot de passe incorrect. », sans dire lequel est faux. En cas de succès : `loginUser()` puis redirection vers `compte.php`.
5. **`deconnexion.php`** : déconnecte l'utilisateur, puis redirige vers l'accueil. La déconnexion se fait avec un **bouton dans un petit formulaire POST** dans l'en-tête.
6. **`compte.php`** (protégé) : affiche le nom, l'email et le rôle de l'utilisateur connecté.
7. **En-tête** : si personne n'est connecté, liens « Connexion » et « Créer un compte ». Sinon, « Mon compte » et le bouton « Déconnexion ».

### Plus (jusqu'à 17/20)

8. **Messages flash** : complétez `flash()` et `takeFlash()`. L'en-tête affiche le message flash s'il existe (une seule fois). Utilisez les : « Votre compte est créé », « Bonjour Amine ! », « Vous êtes déconnecté », « Connectez vous pour accéder à cette page ».
9. **S'inscrire à un événement** (sur `evenement.php`) :
   * si personne n'est connecté : pas de formulaire, mais un lien « Se connecter » ;
   * si l'utilisateur est connecté : le formulaire ne demande plus le nom et l'email (on les connaît). Il garde la motivation et la case règlement ;
   * le traitement du POST appelle `requireLogin()` (même si le formulaire est caché : pourquoi ?) ;
   * l'inscription est rangée dans `$_SESSION['registrations'][$eventId]` ;
   * **Post/Redirect/Get** : après l'inscription, flash « Inscription confirmée » et redirection vers la même page. F5 ne doit pas renvoyer le formulaire ;
   * si l'utilisateur est déjà inscrit : la page l'indique au lieu d'afficher le formulaire.
10. **Mes inscriptions** : `compte.php` liste les événements auxquels l'utilisateur est inscrit (titre avec lien, date, lieu).
11. **Annuler** : un bouton « Annuler » (formulaire POST vers `annuler.php`) sur chaque ligne.

### Défi (jusqu'à 20/20)

Choisissez **un** défi (ou plus) :

* **Retour à la page demandée** : un visiteur non connecté qui ouvre `compte.php` (ou clique « Se connecter » sur un événement) revient sur **cette** page après la connexion. Utilisez `?next=` et la fonction `safeNext()`. Expliquez dans le README pourquoi `safeNext()` est nécessaire (cherchez « open redirect »).
* **Limiter les tentatives** : après 5 échecs de connexion, bloquez les essais pendant 60 secondes (compteur et heure dans la session). Expliquez dans le README pourquoi cette protection est **insuffisante** (indice : que fait un attaquant de sa session ?).
* **Cookie de session durci** : réglez le cookie avec `session_set_cookie_params()` (`httponly`, `samesite`). Montrez dans le README, captures DevTools à l'appui, ce que chaque option change.
* **La grande question** : inscrivez vous à deux événements, déconnectez vous, reconnectez vous. Expliquez dans `reponses.md` ce qui se passe et pourquoi, et ce qu'il faudrait pour que l'organisateur d'un club puisse voir la liste de **ses** inscrits.

## Rendu

1. Votre dépôt `clubhub` avec toutes les pages.
2. `README.md`, section « TP3 » : les défis choisis, et la réponse à cette question : « Que contient le cookie `PHPSESSID`, et où sont les vraies données de la session ? »
3. Dernier commit avant 23 h 59. Remettez `data/users.json` dans un état propre (les 3 comptes démo + éventuellement le vôtre).

## Évaluation

Voir `grille.md`. Les **tests de sécurité** de la grille sont passés sur votre rendu : une page protégée accessible sans connexion, ou un mot de passe lisible, coûte cher.

## Aide

* Fiches : `fiches/php-pour-programmeurs.md` (section Sessions), `fiches/securite-checklist.md`
* php.net : `session_start`, `session_destroy` (l'exemple de la documentation), `password_hash`
* F12 → **Application** → **Cookies** : voir votre cookie de session
* *Headers already sent* : du HTML, un espace ou une ligne vide est envoyé **avant** `session_start()` ou `header()`. Faites tout le PHP en haut du fichier.
