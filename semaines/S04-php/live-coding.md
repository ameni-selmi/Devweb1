# S04 : Script de live coding

Travailler dans un dossier vide `demo-php/`, **pas sur ClubHub** (c'est l'atelier). Le code final est dans `live-coding/demo/`.

## Partie 1 : le cycle d'une requête (15 min)

1. Créer `heure.php` :
   ```php
   <?php
   $now = date('H:i:s');
   ?>
   <!DOCTYPE html>
   <html lang="fr">
   <head><meta charset="UTF-8"><title>Heure</title></head>
   <body>
     <h1>Il est <?= $now ?> sur le serveur</h1>
   </body>
   </html>
   ```
2. Lancer `php -S localhost:8000`. Ouvrir la page. Recharger plusieurs fois : l'heure change. « Le HTML est fabriqué **à chaque requête**. »
3. Ctrl+U (code source) : aucune trace de PHP. « Le navigateur ne voit que le résultat. »
4. Montrer le terminal : une ligne par requête (et la requête `favicon.ico` en 404 : bonne occasion de rappeler que le navigateur demande des choses tout seul).
5. Ajouter un compteur :
   ```php
   $visits = 0;
   $visits++;
   ```
   Afficher `$visits`. Recharger : toujours 1. Demander pourquoi. « Chaque requête repart de zéro. Pour se souvenir, il faudra une session (séance 5) ou une base de données (séance 6). »
6. Ouvrir `file:///.../heure.php` dans le navigateur. Montrer que ça ne marche pas. « Toujours `http://localhost`. »

## Partie 2 : un formulaire, la validation, XSS (20 min)

1. Créer `salut.php` :
   ```php
   <?php
   $name = '';
   $error = '';
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $name = trim($_POST['name'] ?? '');
   }
   ?>
   <!DOCTYPE html>
   <html lang="fr">
   <head><meta charset="UTF-8"><title>Salut</title></head>
   <body>
     <?php if ($name !== ''): ?>
       <p>Salut <?= $name ?> !</p>
     <?php endif; ?>
     <form method="post">
       <label for="name">Votre nom</label>
       <input id="name" name="name" required>
       <button>Envoyer</button>
     </form>
   </body>
   </html>
   ```
2. Tester avec « Sarra ». Ouvrir F12 → Network → la requête POST → *Payload* : `name=Sarra`. « Voilà ce que PHP reçoit dans `$_POST`. »
3. **La faille** : taper `<b>Sarra</b>` → en gras. Puis `<script>alert('XSS')</script>` → l'alerte s'affiche. Expliquer ce qu'un attaquant ferait avec `document.cookie`.
4. Écrire `e()` en direct, remplacer `<?= $name ?>` par `<?= e($name) ?>`. Retester : le texte s'affiche tel quel. Ctrl+U : `&lt;script&gt;`.
5. **Contourner le navigateur** : ajouter une règle (au moins 3 caractères) seulement en HTML (`minlength="3"`). Puis dans le terminal :
   ```bash
   curl -X POST -d "name=A" http://localhost:8000/salut.php
   ```
   La réponse contient « Salut A ! ». « `curl` se moque du `minlength`. »
6. Ajouter la validation PHP :
   ```php
   if (mb_strlen($name) < 3) {
       $error = 'Au moins 3 caractères.';
       // et on n'affiche pas le salut
   }
   ```
   Relancer `curl` : l'erreur est dans la réponse.
7. Garder la valeur saisie : `value="<?= e($name) ?>"`. « L'utilisateur ne doit jamais tout retaper. » Montrer ce qui se passe **sans** `e()` si on tape `"><script>alert(1)</script>` : l'attribut est cassé. C'est pour ça que `e()` utilise `ENT_QUOTES`.

## Partie 3 (si le temps) : `$_GET` et `require` (5 min)

`salut.php?name=Amine` : lire `$_GET['name']`. Montrer que `?name=<script>...` dans un lien partagé serait une attaque aussi. Puis extraire le `<head>` dans `header.php` et l'inclure avec `require __DIR__ . '/header.php';`.
