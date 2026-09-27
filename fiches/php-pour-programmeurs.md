# Aide-mémoire : PHP pour programmeurs

## Lancer

```bash
php -S localhost:8000          # dans le dossier du projet
php -l fichier.php             # vérifier la syntaxe
```

Toujours ouvrir `http://localhost:8000/...`, jamais le fichier directement.

## Syntaxe

```php
<?php
$count = 3;                        // variables : $
const MAX = 20;                    // constante
$name = 'Amine';
echo "Bonjour $name";              // interpolation dans "..." seulement
echo 'Bonjour ' . $name . ' !';    // concaténation : le point

if ($count >= 3 && $name !== '') {
} elseif ($count === 0) {
} else {
}

for ($i = 0; $i < 3; $i++) { }
foreach ($items as $item) { }
foreach ($items as $key => $value) { }

function add(int $a, int $b): int
{
    return $a + $b;
}

$x = $value ?? 'défaut';           // si $value n'existe pas ou vaut null
$label = $n > 1 ? 'places' : 'place';
```

`===` et `!==` comme en JS. Types dans les signatures : `int`, `string`, `bool`, `array`, `?array` (ou null), `void`.

## Dans le HTML

```php
<h1><?= e($title) ?></h1>

<?php foreach ($events as $event): ?>
  <li><?= e($event['title']) ?></li>
<?php endforeach; ?>

<?php if ($errors !== []): ?>
  <p>Erreur</p>
<?php else: ?>
  <p>OK</p>
<?php endif; ?>
```

## Tableaux

```php
$list = ['a', 'b', 'c'];                 // liste
$event = ['title' => 'Atelier', 'capacity' => 20];   // associatif

count($list)
$list[] = 'd';                           // ajouter à la fin
in_array('b', $list, true)               // contient ? (true = strict)
array_key_exists('title', $event)
array_slice($list, 0, 2)                 // les 2 premiers
array_filter($events, fn($e) => $e['capacity'] > 25)
array_map(fn($e) => $e['title'], $events)
usort($events, fn($a, $b) => $a['capacity'] <=> $b['capacity'])
[$a, $b] = [1, 2];                       // déstructuration
```

## Chaînes

```php
trim($s)                 mb_strlen($s)            // longueur (UTF-8)
strtolower($s)           mb_strtolower($s)
str_contains($s, 'x')    str_starts_with($s, 'x')
sprintf('%d places', $n) implode(', ', $list)     explode(',', $s)
```

## Recevoir des données

```php
$_SERVER['REQUEST_METHOD']              // 'GET' ou 'POST'
$_GET['id'] ?? null                     // dans l'URL : ?id=3
$_POST['email'] ?? ''                   // corps d'un formulaire POST
filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)   // int, false ou null
filter_var($email, FILTER_VALIDATE_EMAIL)            // la chaîne ou false
```

**Tout ce qui arrive est une chaîne** (ou un tableau), et peut être falsifié.

## Inclure des fichiers

```php
require __DIR__ . '/includes/functions.php';   // erreur fatale si absent
require_once ...                               // une seule fois
$events = require __DIR__ . '/data/events.php'; // un fichier peut renvoyer une valeur
```

## Réponses HTTP

```php
http_response_code(404);
header('Location: evenements.php');    // redirection
exit;                                  // toujours après une redirection
header('Content-Type: application/json');
echo json_encode($data);
```

`header()` doit être appelé **avant** tout affichage (sinon : *headers already sent*).

## Sessions (séance 5)

```php
session_start();                        // en haut, avant tout HTML
$_SESSION['user_id'] = 3;
unset($_SESSION['user_id']);
session_regenerate_id(true);            // après la connexion
password_hash($pwd, PASSWORD_DEFAULT);
password_verify($pwd, $hash);
```

## Classes (séance 7)

```php
class EventRepository
{
    public function __construct(private PDO $pdo) {}

    public function find(int $id): ?array
    {
        // ...
    }
}

$repo = new EventRepository($pdo);
$event = $repo->find(3);
```

## Déboguer

```php
var_dump($variable);                    // type + valeur
echo '<pre>' . print_r($array, true) . '</pre>';
```

En développement seulement : `ini_set('display_errors', '1'); error_reporting(E_ALL);`
Page blanche ? Lisez le **terminal** où tourne `php -S`.
