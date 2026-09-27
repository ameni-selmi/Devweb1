# S07 : Script de construction collective (50 min)

Ici, le live coding **est** le début du TP. Les étudiants partent du corrigé du TP4 et tapent **en même temps** que vous. À la fin, tout le monde a exactement le contenu de `tp5/starter/`. Les binômes qui se perdent récupèrent le starter.

Afficher votre éditeur en grand. Avancer par étapes courtes, et vérifier dans le navigateur **à chaque étape**.

## Étape 0 : créer les dossiers (2 min)

```bash
mkdir src controllers templates templates/partials
```

« Trois familles de fichiers : les classes, les contrôleurs, le HTML. »

## Étape 1 : `src/Database.php` (5 min)

1. Créer la classe (voir `tp5/solution/src/Database.php`). Déplacer le contenu de `db()` dedans.
2. Expliquer `private static ?PDO $pdo = null;` : « une seule connexion, gardée dans la classe ».
3. Montrer `self::$pdo` (statique) par opposition à `$this->pdo` (qu'on verra dans les repositories).

## Étape 2 : `src/bootstrap.php` et `src/helpers.php` (8 min)

1. `bootstrap.php` : `session_start()`, puis l'**autoloader** :
   ```php
   spl_autoload_register(function (string $class): void {
       $file = __DIR__ . '/' . $class . '.php';
       if (is_file($file)) {
           require $file;
       }
   });
   require __DIR__ . '/helpers.php';
   ```
   Demander : « que fait PHP quand il voit `new EventRepository` et que la classe n'existe pas encore ? » Mettre un `echo "chargement de $class\n";` dans l'autoloader pour le montrer, puis l'enlever.
2. `helpers.php` : copier `e()`, `redirect()`, `flash()`, `takeFlash()`, les fonctions de dates de `includes/functions.php`. Ajouter **`url()`** :
   ```php
   function url(string $page, array $params = []): string
   {
       return 'index.php?' . http_build_query(['page' => $page] + $params);
   }
   ```
   Tester dans un coin : `echo url('evenement', ['id' => 3]);`. « Si un jour on change la forme des URL, on change **une** fonction. »
3. Ajouter `isPost()` et `intParam()` (copier du corrigé). « Des petites fonctions qui rendent les contrôleurs lisibles. »

## Étape 3 : `src/View.php` et le layout (12 min)

1. Écrire `View::render()` et `capture()` **devant eux**, ligne par ligne. Expliquer `extract()` et `ob_start()` avec un petit test :
   ```php
   ob_start();
   echo 'Bonjour';
   $html = ob_get_clean();
   echo strtoupper($html);   // BONJOUR
   ```
   « `ob_start()` met l'affichage dans une boîte au lieu de l'envoyer. On récupère la boîte, et on la met dans le layout. »
2. Créer `templates/layout.php` en partant de `includes/header.php` + `includes/footer.php` : le contenu de la page est `<?= $content ?>`. Remplacer les liens par `url(...)`.
   Remarque : le layout appelle `Auth::user()`. Créer tout de suite un `src/Auth.php` minimal avec `user()` qui renvoie `null` : « on le complétera dans le TP ».
3. Ajouter `View::notFound()` et `View::forbidden()` + `templates/error.php`.

## Étape 4 : le premier repository (8 min)

1. `src/EventRepository.php` avec `__construct(private PDO $pdo)` : expliquer la **promotion de propriété** (PHP 8) : « c'est la même chose que déclarer `private PDO $pdo;` et écrire `$this->pdo = $pdo;` dans le constructeur ».
2. Déplacer `getEvents()` → `upcoming()`, `findEvent()` → `find()`, `searchEvents()` → `search()`. Ajouter `clubs()`.
3. « Pourquoi un objet et pas des fonctions ? » Réponse courte : il **porte** sa connexion ; on pourrait lui donner une autre base (une base de test) sans changer une ligne.

## Étape 5 : le routeur et les deux premières pages (12 min)

1. Remplacer `index.php` par le front controller (voir `tp5/starter/index.php`) avec deux routes.
2. `controllers/home.php` (5 lignes) et `templates/home.php` (le `<main>` de l'ancien `index.php`). Déplacer `includes/event-card.php` vers `templates/partials/`, remplacer le lien par `url()`.
3. Tester `index.php`. Puis `controllers/events.php` + `templates/events.php`. Tester `index.php?page=evenements` **et** la recherche.
4. **La question de sécurité** (slide 16) : écrire temporairement
   ```php
   require __DIR__ . '/controllers/' . $_GET['page'] . '.php';
   ```
   et ouvrir `index.php?page=../config`. Page blanche… mais `config.php` a été exécuté. Avec d'autres chemins, c'est bien pire. Remettre la liste blanche. « On ne met **jamais** une donnée de l'utilisateur dans un chemin de fichier. »
5. Tester `index.php?page=nimporte` → 404 propre.

## Transition vers le TP (1 min)

« Vous avez deux pages sur huit. Le TP : migrer les six autres, puis ajouter les organisateurs. Tout le monde a exactement ce que j'ai à l'écran ? Sinon, prenez `tp5/starter/`. »
