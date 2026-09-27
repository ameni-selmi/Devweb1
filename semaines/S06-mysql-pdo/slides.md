---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · Amani Selmi · S06 · MySQL et PDO'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Séance 6 : MySQL et PDO

**Amani Selmi, PhD-Engineer**

---

## Aujourd'hui

1. Pourquoi une base de données
2. Modéliser ClubHub : 3 tables
3. PHP ↔ MySQL avec **PDO**
4. **Injection SQL** et requêtes préparées
5. JOIN, contraintes, transactions (juste ce qu'il faut)
6. **TP4 noté** : ClubHub dans MySQL

---

## Ce qui n'allait pas en séance 5

| Stockage | Problème |
|---|---|
| Tableau PHP (`events.php`) | Il faut modifier le code pour ajouter un événement |
| Fichier `users.json` | Tout relire et tout réécrire à chaque fois. Deux écritures en même temps ? |
| Session | Perdue à la déconnexion. Invisible pour les autres utilisateurs. |

**Il faut un stockage partagé, durable, et qu'on peut interroger.**

---

## Où est la base ?

```
Navigateur ──HTTP──▶ Serveur web + PHP ──PDO──▶ MySQL
           ◀─ HTML ─                   ◀─ lignes ─
```

* Le navigateur ne parle **jamais** à la base.
* PHP envoie du SQL, reçoit des lignes, fabrique le HTML.
* Le mot de passe de la base est sur le serveur, dans `config.php`, **hors de Git**.

---

## Modéliser ClubHub (au tableau)

Qui ? Quoi ? Quel lien ?

* Un **utilisateur** a un nom, un email, un mot de passe (haché), un rôle
* Un **événement** a un titre, un club, un lieu, des dates, une capacité, un organisateur
* Un utilisateur s'**inscrit** à plusieurs événements. Un événement a plusieurs inscrits.

→ Relation **plusieurs à plusieurs** → une table au milieu.

<!-- Faire le schéma au tableau avec les étudiants AVANT de montrer la slide suivante. -->

---

## Le schéma

```
users                    registrations               events
┌───────────────┐        ┌──────────────┐        ┌────────────────┐
│ id         PK │◀───────│ user_id   FK │        │ id          PK │
│ name          │        │ event_id  FK │───────▶│ title          │
│ email  UNIQUE │        │ motivation   │        │ club           │
│ password_hash │        │ created_at   │        │ starts_at      │
│ role          │        └──────────────┘        │ capacity       │
│ created_at    │   UNIQUE(user_id, event_id)    │ organizer_id FK│──▶ users
└───────────────┘                                └────────────────┘
```

Fichier : `database/schema.sql`

---

## Les contraintes : la base protège aussi

```sql
email VARCHAR(255) NOT NULL,
CONSTRAINT uq_users_email UNIQUE (email),

CONSTRAINT uq_registrations_user_event UNIQUE (user_id, event_id),
CONSTRAINT fk_registrations_event
    FOREIGN KEY (event_id) REFERENCES events (id) ON DELETE CASCADE,
```

* `UNIQUE` : pas deux comptes avec le même email, pas deux inscriptions identiques
* `FOREIGN KEY` : pas d'inscription à un événement qui n'existe pas
* Même si votre PHP a un bug, **la base refuse**

---

## Rappel SQL express

```sql
SELECT id, title FROM events WHERE capacity > 30 ORDER BY starts_at LIMIT 5;
INSERT INTO users (name, email, password_hash) VALUES ('Amine', 'amine@...', '$2y$...');
UPDATE events SET capacity = 25 WHERE id = 1;
DELETE FROM registrations WHERE user_id = 1 AND event_id = 3;
SELECT COUNT(*) FROM registrations WHERE event_id = 3;
```

Vous connaissez déjà. Aujourd'hui, la nouveauté est **comment PHP l'envoie**.

---

## Se connecter avec PDO

```php
$pdo = new PDO(
    'mysql:host=127.0.0.1;dbname=clubhub;charset=utf8mb4',
    'clubhub',          // utilisateur
    'clubhub',          // mot de passe (depuis config.php)
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);
```

Une fonction `db()` qui crée la connexion **une fois** et la réutilise.

---

## Lire des lignes

```php
// Sans valeur extérieure : query()
$events = db()->query('SELECT * FROM events ORDER BY starts_at')->fetchAll();

foreach ($events as $event) {
    echo $event['title'];
}
```

* `fetchAll()` : toutes les lignes (tableau de tableaux)
* `fetch()` : une ligne, ou `false`
* `fetchColumn()` : la première colonne de la ligne suivante

---

<!-- _class: question -->

## Question

```php
$email = $_POST['email'];
$sql = "SELECT * FROM users WHERE email = '$email'";
```

**Qu'est ce qui peut mal tourner ?**

---

## L'injection SQL

L'utilisateur tape comme email : `' OR '1'='1`

```sql
SELECT * FROM users WHERE email = '' OR '1'='1'
```

→ **tous** les utilisateurs. Ou pire :

```sql
'; DROP TABLE users; --
```

La donnée est devenue du **code**. C'est la même idée que XSS, côté base.

<!-- DÉMO en direct : voir live-coding.md partie 2. Se connecter sans mot de passe. -->

---

## La parade : les requêtes préparées

```php
$stmt = db()->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();
```

1. MySQL reçoit **d'abord** la requête avec un trou `?`
2. **Ensuite** la valeur, qui ne peut être **que** une valeur

Avec des noms : `WHERE email = :email` et `execute(['email' => $email])`

<div class="regle">

Règle de sécurité n° 4 : **jamais** de variable dans une chaîne SQL. Toujours `prepare` + `execute`.

</div>

---

## Écrire

```php
$stmt = db()->prepare(
    'INSERT INTO registrations (user_id, event_id, motivation) VALUES (?, ?, ?)'
);
$stmt->execute([$user['id'], $event['id'], $motivation]);

$newId = (int) db()->lastInsertId();
$deleted = $stmt->rowCount();   // pour UPDATE / DELETE : lignes touchées
```

---

## Quand la base dit non

```php
try {
    $stmt->execute([$userId, $eventId, $motivation]);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {   // contrainte violée
        // ici : déjà inscrit (UNIQUE user_id + event_id)
    } else {
        throw $exception;
    }
}
```

Avec `ERRMODE_EXCEPTION`, une erreur SQL ne passe **jamais** en silence.

---

## Le JOIN : « Mes inscriptions »

```sql
SELECT e.title, e.starts_at, e.location
FROM registrations r
JOIN events e ON e.id = r.event_id
WHERE r.user_id = ?
ORDER BY e.starts_at
```

Et les places restantes de chaque événement :

```sql
SELECT e.*, e.capacity - COUNT(r.id) AS places_left
FROM events e
LEFT JOIN registrations r ON r.event_id = e.id
GROUP BY e.id
```

`LEFT JOIN` : garder les événements **sans** inscrit.

---

## Le problème des places

Il reste **1** place. Deux étudiants cliquent **en même temps**.

1. A lit : 1 place → OK
2. B lit : 1 place → OK
3. A s'inscrit
4. B s'inscrit → **capacité dépassée**

Solution : une **transaction** avec `SELECT ... FOR UPDATE` (défi du TP).

---

## Organiser le code

```
includes/
  db.php             ← db() : la connexion
  events.php         ← getEvents(), findEvent(), searchEvents()
  users.php          ← findUserByEmail(), findUserById(), addUser()
  registrations.php  ← registerUser(), isRegistered(), registrationsOfUser()...
```

* Le SQL est dans ces fichiers, **pas** dans les pages
* `users.php` garde les **mêmes fonctions** qu'en séance 5 : les pages changent à peine

---

## Où en est ClubHub ?

| | S05 | S06 |
|---|---|---|
| Événements | tableau PHP | table `events` |
| Utilisateurs | `users.json` | table `users` |
| Inscriptions | session (perdues !) | table `registrations` |
| Places | capacité fixe | places **restantes**, complet |
| Mes inscriptions | parcours d'un tableau | **JOIN** |

---

## TP4 (noté)

Migrer ClubHub vers MySQL :

* **Base** : connexion PDO, événements et utilisateurs dans la base, requêtes préparées partout
* **Plus** : inscriptions en base, places restantes, JOIN, annulation
* **Défi** : transaction pour les places, recherche côté serveur, preuve d'injection...

Énoncé : `semaines/S06-mysql-pdo/tp4/enonce.md` · Aide : `fiches/sql-pdo.md`

**Rendu : dépôt Git, ce soir 23 h 59. Et la proposition de projet !**
