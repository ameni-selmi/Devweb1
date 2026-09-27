---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · Amani Selmi · S07 · Structurer une application'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Séance 7 : Structurer une application

**Amani Selmi, PhD-Engineer**

---

## Aujourd'hui

1. Pourquoi ranger le code maintenant
2. Les classes en PHP (en 10 minutes, vous connaissez déjà)
3. On construit **ensemble** un mini framework
4. Les **rôles** : qui a le droit de faire quoi
5. **TP5 noté** : finir la migration, ajouter l'organisateur

---

## Regardez `evenement.php` aujourd'hui

* Il lit l'URL
* Il vérifie la session
* Il valide un formulaire
* Il appelle la base
* Il fabrique 100 lignes de HTML

Tout dans un fichier. Et c'est pareil dans **chaque** page.

<div class="piege">

Ce qui fait mal : changer le menu (8 fichiers), trouver une requête SQL, relire une page de 150 lignes.

</div>

---

## Séparer les responsabilités

```
            requête HTTP
                 │
        ┌────────▼────────┐
        │   index.php     │  point d'entrée unique : choisit le contrôleur
        └────────┬────────┘
        ┌────────▼────────┐
        │  contrôleur     │  lit la requête, vérifie les droits, décide
        └───┬─────────┬───┘
   ┌────────▼───┐ ┌───▼──────────┐
   │ repository │ │  template    │
   │ (SQL)      │ │  (HTML)      │
   └────────────┘ └──────────────┘
```

C'est l'idée de **tous** les frameworks (Laravel, Symfony, Django, Express...).

---

## Les classes en PHP

```php
class EventRepository
{
    private const SELECT = 'SELECT ... FROM events ...';

    public function __construct(private PDO $pdo)   // promotion : crée $this->pdo
    {
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare(self::SELECT . ' WHERE e.id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
}

$events = new EventRepository(Database::connection());
$event = $events->find(3);
```

`->` pour un objet, `::` pour une méthode statique ou une constante.

---

## Statique ou pas ?

| | Quand | Exemple |
|---|---|---|
| Méthode d'**instance** | L'objet a besoin de données à lui | `$events->find(3)` utilise `$this->pdo` |
| Méthode **statique** | Un seul état pour toute la requête | `Database::connection()`, `Auth::user()` |

Dans ce cours : repositories en instances, outils globaux en statiques. Simple et suffisant.

---

## Chargement automatique

```php
spl_autoload_register(function (string $class): void {
    $file = __DIR__ . '/' . $class . '.php';
    if (is_file($file)) {
        require $file;
    }
});

$repo = new EventRepository($pdo);   // PHP inclut src/EventRepository.php tout seul
```

Une classe = un fichier, avec le **même nom**.

---

<!-- _class: titre -->

# On construit ensemble
## Un mini framework en 4 pièces

<!-- Live coding : voir live-coding.md. Les étudiants tapent en même temps que vous. -->

---

## Pièce 1 : `Database`

```php
class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../config.php';
            self::$pdo = new PDO(/* comme en S06 */);
        }
        return self::$pdo;
    }
}
```

Notre ancienne fonction `db()`, rangée dans une classe.

---

## Pièce 2 : `View`, les templates

```php
class View
{
    public static function render(string $template, array $data = []): void
    {
        $content = self::capture($template, $data);
        echo self::capture('layout', $data + ['content' => $content]);
    }

    private static function capture(string $template, array $data): string
    {
        extract($data, EXTR_SKIP);   // ['event' => ...] devient $event
        ob_start();                  // on retient l'affichage
        require __DIR__ . '/../templates/' . $template . '.php';
        return ob_get_clean();
    }
}
```

---

## Un template : seulement du HTML et des `e()`

```php
<!-- templates/home.php -->
<main>
  <h1>Prochains événements</h1>
  <?php foreach ($events as $event): ?>
    <?php require __DIR__ . '/partials/event-card.php'; ?>
  <?php endforeach; ?>
</main>
```

* Pas de SQL, pas de `$_POST`, pas de `redirect()`
* Le **layout** contient `<head>`, menu, flash, footer : **un seul** fichier

---

## Pièce 3 : le routeur

```php
// index.php
$routes = [
    'accueil'    => 'home',
    'evenements' => 'events',
    'evenement'  => 'event',
];

$page = $_GET['page'] ?? 'accueil';

if (!is_string($page) || !array_key_exists($page, $routes)) {
    View::notFound();
}

require __DIR__ . '/controllers/' . $routes[$page] . '.php';
```

URL : `index.php?page=evenement&id=3`

---

<!-- _class: question -->

## Question

Pourquoi pas simplement :

```php
require __DIR__ . '/controllers/' . $_GET['page'] . '.php';
```

<!-- ?page=../config → inclut config.php. Ou pire. C'est une inclusion de fichier arbitraire. Toujours une liste blanche. -->

---

## Pièce 4 : un contrôleur

```php
// controllers/home.php
$events = (new EventRepository(Database::connection()))->upcoming(2);

View::render('home', [
    'pageTitle' => 'ClubHub',
    'currentPage' => 'accueil',
    'events' => $events,
]);
```

Court, lisible : **quoi** chercher, **quoi** afficher.

---

## Un contrôleur avec un formulaire

```php
$user = Auth::requireLogin();              // 1. droits
$errors = [];

if (isPost()) {
    $title = trim($_POST['title'] ?? '');  // 2. lire
    if ($title === '') {                   // 3. valider
        $errors['title'] = 'Obligatoire.';
    }
    if ($errors === []) {
        $id = $repo->create(/* ... */);    // 4. agir
        flash('Événement publié.');
        redirect(url('evenement', ['id' => $id]));   // 5. PRG
    }
}

View::render('event-new', ['errors' => $errors]);   // 6. afficher
```

Toujours le même plan.

---

## Les rôles

```sql
role ENUM('student', 'organizer') NOT NULL DEFAULT 'student'
```

```php
public static function requireRole(string $role): array
{
    $user = self::requireLogin();
    if ($user['role'] !== $role) {
        View::forbidden();   // 403
    }
    return $user;
}
```

**401 / redirection** : pas connecté. **403** : connecté, mais pas le droit.

---

## Le piège : le rôle ne suffit pas

Le Club Robotique est organisateur. Il ouvre :

```
index.php?page=inscrits&id=3        ← un événement du Club IA
```

```php
$user = Auth::requireRole('organizer');
$event = $events->find($id);

if ($event['organizer_id'] !== $user['id']) {
    View::forbidden();
}
```

<div class="regle">

Vérifier le **rôle** ET la **propriété** de la ressource. C'est l'une des failles les plus fréquentes du Web (*IDOR*).

</div>

---

## La nouvelle arborescence

```
clubhub/
  index.php            ← la seule page appelée par le navigateur
  config.php           ← hors de Git
  src/                 ← les classes
    bootstrap.php  helpers.php  Database.php  View.php  Auth.php
    EventRepository.php  UserRepository.php  RegistrationRepository.php
  controllers/         ← un fichier par page : home.php, event.php...
  templates/           ← le HTML : layout.php, home.php... partials/
  css/  js/  database/
```

---

## Ce que vous venez de construire

| Notre mini framework | Dans Laravel / Symfony |
|---|---|
| `index.php` + `$routes` | Router |
| `controllers/` | Controllers |
| `templates/` + `View` | Blade / Twig |
| `*Repository` | Eloquent / Doctrine |
| `Auth::requireRole()` | Middleware, Guards |

Vous savez maintenant **ce que fait** un framework. Il fait ça, avec plus d'options.

---

## TP5 (noté)

* **Base** : migrer toutes les pages vers `controllers/` + `templates/`, `UserRepository`, `RegistrationRepository`, `Auth`
* **Plus** : rôle organisateur : créer un événement, voir **ses** inscrits (403 sinon)
* **Défi** : export CSV, modifier un événement, classe `Validator`, URL propres...

Énoncé : `semaines/S07-structure/tp5/enonce.md`

**Rendu : dépôt Git, ce soir 23 h 59.**
