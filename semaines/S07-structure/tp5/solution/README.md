# Corrigé TP5

À publier **après** la date limite du rendu.

## Installation

```bash
mysql -u clubhub -p clubhub < database/schema.sql
mysql -u clubhub -p clubhub < database/seed.sql
cp config.example.php config.php
php -S localhost:8000
```

Ouvrir `http://localhost:8000/index.php`. Comptes (mot de passe `demo1234`) : `amine@campus.example` (étudiant), `robotique@campus.example` (organisateur du Club Robotique), et un compte organisateur par club.

## Trajet de `index.php?page=evenement&id=3`

1. `index.php` inclut `src/bootstrap.php` : session, autoloader, `helpers.php`.
2. `index.php` lit `page=evenement`, le trouve dans `$routes`, inclut `controllers/event.php`.
3. Le contrôleur lit `id` avec `intParam()`, crée `EventRepository` (l'autoloader inclut `src/EventRepository.php`, qui demande `Database::connection()`), appelle `find(3)`.
4. Si l'événement n'existe pas : `View::notFound()` → 404.
5. Si c'est un POST : `Auth::requireLogin()`, validation, `RegistrationRepository::register()`, `flash()`, `redirect()`.
6. Sinon : `View::render('event', [...])` exécute `templates/event.php`, capture le HTML, puis exécute `templates/layout.php` avec ce HTML dans `$content`.

## Ce que couvre le corrigé

* Base et Plus complets.
* Pas de défi : ils sont corrigés au cas par cas. Le défi « URL propres » demande de revoir `url()` et le chemin du CSS et du JS dans le layout.

## Points à commenter en correction collective

* `index.php` : la liste blanche de routes ;
* `Auth::requireRole()` puis la comparaison `organizer_id === user id` dans `controllers/participants.php` ;
* `RegistrationRepository::cancel()` : `DELETE ... JOIN events ... WHERE starts_at >= NOW()` empêche d'annuler un événement passé, même en forgeant la requête ;
* `controllers/event-new.php` : validation des dates avec `createFromFormat('!Y-m-d H:i', ...)`.

Ce dossier est le **starter de la séance 8**.
