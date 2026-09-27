# TP5 (noté) : structurer ClubHub et ajouter les organisateurs

**Noté sur 20** · En binôme · Durée : 1 h 40 en séance
**Rendu : dépôt Git, ce soir avant 23 h 59**

## Objectifs

* Organiser une application avec un point d'entrée, des contrôleurs, des templates et des classes d'accès aux données.
* Écrire et utiliser des classes PHP.
* Gérer des rôles, et vérifier à la fois le rôle **et** la propriété d'une ressource.

## Ce qu'on vous donne

Dans `tp5/starter/` : le corrigé du TP4 (les anciennes pages dans la racine et `includes/`), **plus** ce que nous avons construit ensemble en début de séance :

| Fichier | Rôle | État |
|---|---|---|
| `index.php` | Front controller + liste des routes | 2 routes : `accueil`, `evenements` |
| `src/bootstrap.php` | Session + chargement automatique des classes | complet |
| `src/helpers.php` | `e()`, `url()`, `redirect()`, `flash()`, `isPost()`, `intParam()`, dates, `slugify()` | complet |
| `src/Database.php` | `Database::connection()` | complet |
| `src/View.php` | `View::render()`, `View::notFound()`, `View::forbidden()` | complet |
| `src/EventRepository.php` | `upcoming()`, `search()`, `find()`, `clubs()` | à compléter (Plus) |
| `src/UserRepository.php` | | squelette |
| `src/Auth.php` | | squelette (`safeNext()` donnée) |
| `templates/layout.php`, `error.php`, `home.php`, `events.php`, `partials/event-card.php` | Templates | complets |
| `controllers/home.php`, `controllers/events.php` | Contrôleurs | complets |

Les liens du menu vers des pages pas encore migrées donnent une 404 : c'est normal, c'est votre travail.

## Règles

* Le navigateur n'appelle **que** `index.php`. À la fin du TP, il ne reste à la racine que `index.php`, `config.php` et `config.example.php`.
* Les **contrôleurs** lisent la requête, vérifient les droits, appellent les repositories et `View::render()`. Pas de HTML (sauf rien du tout).
* Les **templates** affichent. Pas de SQL, pas de `$_POST`, pas de `redirect()`. Toutes les données passent par `e()`.
* Les **repositories** contiennent tout le SQL, avec des requêtes préparées.
* Les liens et les `action` des formulaires utilisent `url('page', [...])`.
* Toutes les règles de sécurité des TP précédents restent valables.

## Travail demandé

### Base (jusqu'à 14/20)

1. **`UserRepository`** : `find()`, `findByEmail()`, `create()`, avec `$this->pdo`.
2. **`Auth`** : complétez `user()`, `requireLogin()`, `login()`, `logout()` (reprenez vos fonctions de `includes/auth.php`).
3. **`RegistrationRepository`** : `exists()`, `register()` (qui renvoie `'ok'`, `'already'` ou `'full'`), `cancel()`, `ofUser()`. Reprenez `includes/registrations.php`.
4. **Migrer les pages** : pour chacune, un contrôleur dans `controllers/`, un template dans `templates/`, une route dans `index.php`.

   | Ancienne page | Route | Contrôleur | Template |
   |---|---|---|---|
   | `evenement.php` | `evenement` | `event.php` | `event.php` |
   | `connexion.php` | `connexion` | `login.php` | `login.php` |
   | `creer-compte.php` | `creer-compte` | `register.php` | `register.php` |
   | `deconnexion.php` | `deconnexion` | `logout.php` | (aucun) |
   | `compte.php` | `compte` | `account.php` | `account.php` |
   | `annuler.php` | `annuler` | `cancel.php` | (aucun) |

   Tout doit marcher comme avant : inscription, connexion, inscription à un événement, annulation, messages flash, PRG, 404.
5. **Nettoyage** : supprimez les anciennes pages de la racine et le dossier `includes/`. Le site fonctionne toujours.

### Plus (jusqu'à 17/20) : le rôle organisateur

Les comptes organisateurs du seed : `robotique@campus.example`, `photo@campus.example`, etc. (mot de passe `demo1234`).

6. **`Auth::requireRole(string $role)`** : redirige vers la connexion si personne n'est connecté, et affiche une page **403** si le rôle ne correspond pas.
7. **Créer un événement** : route `nouvel-evenement`, réservée aux organisateurs. Formulaire : titre, club (prérempli avec le nom du compte), description, programme (une étape par ligne), à apporter, lieu, date, heure de début, heure de fin, nombre de places. Validation serveur complète :
   * champs texte obligatoires, avec une longueur maximale ;
   * la date et les heures forment de vraies dates (`DateTimeImmutable::createFromFormat`) ;
   * l'événement est dans le futur, et la fin est après le début ;
   * entre 1 et 1000 places.

   Si tout va bien : `EventRepository::create()`, flash, redirection vers la page du nouvel événement. Le lien « Créer un événement » apparaît dans le menu **seulement** pour les organisateurs.
8. **Mes événements** : dans « Mon compte », un organisateur voit la liste de **ses** événements avec le nombre d'inscrits (`EventRepository::byOrganizer()`).
9. **Les inscrits** : route `inscrits&id=...`, liste des inscrits d'un événement (nom, email, motivation), avec un JOIN sur `users`. Réservée à l'organisateur **de cet événement** : un autre organisateur reçoit une 403. Un lien « Voir les inscrits » apparaît sur la page de l'événement pour son organisateur.

### Défi (jusqu'à 20/20)

Choisissez **un** défi (ou plus) :

* **Export CSV** : un bouton « Télécharger (CSV) » sur la page des inscrits. Le contrôleur envoie les en-têtes `Content-Type: text/csv` et `Content-Disposition: attachment` et écrit avec `fputcsv()`. Mêmes droits que la page.
* **Modifier un événement** : route `modifier-evenement&id=...`, même formulaire prérempli, réservé à son organisateur. Réutilisez le template de création (un seul template pour les deux). On ne peut pas descendre la capacité sous le nombre d'inscrits.
* **Classe `Validator`** : écrivez une petite classe réutilisable (`required()`, `maxLength()`, `email()`, `intBetween()`, `errors()`) et utilisez la dans **tous** les formulaires. Comparez le nombre de lignes avant et après dans le README.
* **URL propres** : `/evenements/3` au lieu de `index.php?page=evenement&id=3`, avec `php -S localhost:8000 index.php` (le routeur reçoit toutes les requêtes) et un `.htaccess` pour Apache. Les fichiers CSS et JS doivent toujours être servis.

## Rendu

1. Votre dépôt `clubhub` : `index.php`, `src/`, `controllers/`, `templates/`, `css/`, `js/`, `database/`, `config.example.php`. Plus d'anciennes pages.
2. `README.md`, section « TP5 » : un schéma (texte ou image) de ce qui se passe quand on ouvre `index.php?page=evenement&id=3`, fichier par fichier ; les défis choisis.
3. Dernier commit avant 23 h 59.

## Évaluation

Voir `grille.md`. Les tests de droits (étudiant, autre organisateur, bon organisateur) sont faits sur votre rendu.

## Aide

* Revoir `live-coding.md` de cette séance : c'est exactement ce que nous avons construit ensemble.
* `Class "UserRepository" not found` : le fichier doit s'appeler `src/UserRepository.php`, avec exactement le même nom (majuscules comprises).
* `Undefined variable $events` dans un template : la clé n'a pas été passée dans le tableau de `View::render()`.
* Une page blanche après une redirection : `redirect()` est appelé **après** `View::render()`. Toute la logique d'abord, l'affichage à la fin.
