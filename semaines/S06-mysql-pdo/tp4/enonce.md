# TP4 (noté) : ClubHub dans MySQL

**Noté sur 20** · En binôme · Durée : 1 h 40 en séance
**Rendu : dépôt Git, ce soir avant 23 h 59**

## Objectifs

* Créer une base à partir d'un script SQL.
* Se connecter à MySQL avec PDO, correctement configuré.
* Remplacer tous les accès aux données par des requêtes préparées.
* Utiliser un JOIN et les contraintes de la base.

## Ce qu'on vous donne

Dans `tp4/starter/` : le corrigé du TP3, plus :

* `database/schema.sql` : les tables `users`, `events`, `registrations` (celles que nous avons dessinées ensemble) ;
* `database/seed.sql` : 7 comptes (mot de passe `demo1234`), 7 événements (dont un passé et un complet), quelques inscriptions. Les dates sont calculées à partir d'aujourd'hui ;
* `config.example.php` et `.gitignore` (qui ignore `config.php`) ;
* `includes/db.php` : le squelette de la fonction `db()` ;
* dans `includes/functions.php` : `formatDate()`, `formatHour()`, `formatTimeRange()`, `isoDate()`, `placesLabel()` pour afficher les dates et les places.

Le starter **fonctionne encore** avec les anciens fichiers (`data/events.php`, `data/users.json`). Vous allez les remplacer un par un.

## Mise en place (10 min)

1. Créez la base et l'utilisateur (voir `fiches/installation.md`) :
   ```sql
   CREATE DATABASE clubhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'clubhub'@'localhost' IDENTIFIED BY 'clubhub';
   GRANT ALL PRIVILEGES ON clubhub.* TO 'clubhub'@'localhost';
   ```
2. Importez les deux scripts, **dans cet ordre** :
   ```bash
   mysql -u clubhub -p clubhub < database/schema.sql
   mysql -u clubhub -p clubhub < database/seed.sql
   ```
   (ou phpMyAdmin → base `clubhub` → *Importer*.)
3. Copiez `config.example.php` en `config.php` et adaptez si besoin. Vérifiez que `git status` **n'affiche pas** `config.php`.

Pour tout remettre à zéro pendant le TP : relancez les deux scripts.

## Règles

* **Jamais** de variable dans une chaîne SQL. `prepare()` + `execute()` dès qu'une valeur vient de l'extérieur (`$_GET`, `$_POST`, session, fonction appelée avec un paramètre).
* Le SQL est dans `includes/events.php`, `includes/users.php`, `includes/registrations.php`. **Aucune** requête SQL dans les pages.
* `config.php` n'est pas dans Git.
* Toutes les règles des TP précédents restent valables (`e()`, `requireLogin()`, POST, PRG).

## Travail demandé

### Base (jusqu'à 14/20)

1. **Connexion** : complétez `db()` dans `includes/db.php`. Incluez `db.php` dans le bootstrap. Testez avec une page temporaire qui affiche `db()->query('SELECT COUNT(*) FROM events')->fetchColumn()` (puis supprimez la).
2. **Événements** : créez `includes/events.php` avec :
   * `getEvents(?int $limit = null): array` : les événements **à venir** (`starts_at >= NOW()`), triés par date ;
   * `findEvent(int $id): ?array` : un événement par son id (requête préparée).

   Supprimez l'ancienne version dans `functions.php` et le fichier `data/events.php`. Adaptez l'affichage : les dates viennent de `starts_at` et `ends_at` (utilisez `formatDate()` et `formatTimeRange()`), et le programme est un texte avec une étape par ligne (fonction `lines()` à écrire, ou `explode("\n", ...)`).
3. **Utilisateurs** : réécrivez `includes/users.php` avec les **mêmes fonctions** (`findUserByEmail`, `findUserById`, `addUser`), mais en SQL. Supprimez `data/users.json`. La création de compte et la connexion doivent marcher **sans changer** `connexion.php` ni `creer-compte.php` (ou presque).
4. **Mon compte** : affichez aussi la date de création du compte (`created_at`).
5. **Test d'injection** : dans le README, écrivez ce qui se passe quand on se connecte avec l'email `' OR '1'='1` et n'importe quel mot de passe. Expliquez pourquoi.

### Plus (jusqu'à 17/20)

6. **Inscriptions en base** : créez `includes/registrations.php` avec :
   * `isRegistered(int $userId, int $eventId): bool` ;
   * `registerUser(int $userId, int $eventId, string $motivation): string` qui renvoie `'ok'`, `'already'` ou `'full'` ;
   * `cancelRegistration(int $userId, int $eventId): bool` ;
   * `registrationsOfUser(int $userId): array` avec un **JOIN** sur `events`.

   Remplacez `$_SESSION['registrations']` partout. Les inscriptions doivent **survivre à la déconnexion**.
7. **Places restantes** : sur les cartes et la page de l'événement, affichez « 12 places restantes » (ou « Complet »), calculé en SQL (`LEFT JOIN` + `COUNT` + `GROUP BY`). Un événement complet n'affiche plus le formulaire, **et** le serveur refuse l'inscription.
8. **Doublon** : une deuxième inscription au même événement est refusée par la contrainte `UNIQUE` : attrapez la `PDOException` (code `'23000'`) et affichez un message clair au lieu d'une erreur.
9. **Annulation sûre** : on ne peut annuler que **sa propre** inscription, même en modifiant l'`event_id` dans les DevTools. Expliquez dans le README comment votre requête le garantit.

### Défi (jusqu'à 20/20)

Choisissez **un** défi (ou plus) :

* **La dernière place** : deux utilisateurs peuvent réserver la dernière place en même temps. Rendez `registerUser()` sûre avec une **transaction** et `SELECT ... FOR UPDATE`. Expliquez le scénario et votre solution dans le README.
* **Recherche côté serveur** : `evenements.php?q=arduino` filtre avec `LIKE` en SQL (requête préparée !). Le formulaire de filtre doit marcher **sans JavaScript**.
* **Preuve d'injection** : dans un fichier `demo-injection.php` (hors du site, à ne jamais mettre en ligne), écrivez volontairement une connexion vulnérable, montrez l'attaque, puis la version corrigée. Captures d'écran dans le README.
* **Événements passés** : dans « Mon compte », séparez « À venir » et « Passés ». On ne peut plus annuler un événement passé (vérifié côté serveur).

## Rendu

1. Votre dépôt `clubhub`, **sans** `config.php`, avec `database/schema.sql` et `database/seed.sql`.
2. `README.md`, section « TP4 » : comment installer la base (3 commandes), la réponse de la question 5, les défis choisis.
3. Dernier commit avant 23 h 59.

**N'oubliez pas** : la proposition de projet (`PROPOSITION.md`) est à rendre cette semaine aussi.

## Évaluation

Voir `grille.md`. La correction commence par une recherche automatique de SQL dangereux dans votre code. Une seule variable dans une chaîne SQL coûte cher.

## Aide

* Fiche : `fiches/sql-pdo.md`
* `SQLSTATE[HY000] [1045] Access denied` : mauvais utilisateur ou mot de passe dans `config.php`.
* `SQLSTATE[HY000] [2002]` : MySQL n'est pas démarré, ou mauvais hôte / port.
* `Invalid parameter number` : le nombre de `?` ne correspond pas au tableau passé à `execute()`. Avec de vraies requêtes préparées, un même `:nom` ne peut pas être utilisé deux fois dans la requête.
* Accents cassés (`Ã©`) : oubli de `charset=utf8mb4` dans le DSN.
