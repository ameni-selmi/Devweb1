# S05 : Script de live coding

Démo dans un dossier séparé, **pas sur ClubHub**. Le code final est dans `live-coding/demo/`.

## Partie 1 : cookie et session (15 min)

1. Créer `compteur.php` **sans** session :
   ```php
   <?php
   $visits = 0;
   $visits++;
   echo "Visites : $visits";
   ```
   Recharger : toujours 1. « On l'a vu en S04. »
2. Version cookie :
   ```php
   <?php
   $visits = (int) ($_COOKIE['visits'] ?? 0) + 1;
   setcookie('visits', (string) $visits);
   echo "Visites : $visits";
   ```
   Recharger : ça compte. F12 → Application → Cookies : le cookie `visits` est là. **Le modifier à la main** : `visits` = 1000. Recharger : 1001. « L'utilisateur contrôle ses cookies. Imaginez `role=admin`. »
3. Version session :
   ```php
   <?php
   session_start();
   $_SESSION['visits'] = ($_SESSION['visits'] ?? 0) + 1;
   echo "Visites : {$_SESSION['visits']}";
   ```
   Recharger : ça compte. Dans les DevTools : un seul cookie, `PHPSESSID`, une chaîne aléatoire. « Le compteur est sur le serveur. » Montrer le fichier de session si possible (`php -i | grep session.save_path`).
4. **Vol de session** : copier la valeur de `PHPSESSID`, ouvrir un autre navigateur (ou une fenêtre privée), créer le cookie `PHPSESSID` à la main avec la même valeur, recharger. Le compteur continue. « Voler ce cookie, c'est voler la session. D'où : XSS (S04), HTTPS, `httponly`. »

## Partie 2 : une connexion minimale (20 min)

Fichier `mini-login.php` (tout dans un seul fichier pour la démo, **pas** pour le TP) :

1. Générer un hachage dans le terminal :
   ```bash
   php -r "echo password_hash('demo1234', PASSWORD_DEFAULT), PHP_EOL;"
   ```
   Le relancer : un hachage différent. « Le sel change à chaque fois. » Puis :
   ```bash
   php -r "var_dump(password_verify('demo1234', '<collez le hachage>'));"
   ```
2. Écrire la page :
   ```php
   <?php
   session_start();

   $users = [
       'amine@campus.example' => ['name' => 'Amine', 'hash' => '$2y$12$...'],   // collez votre hachage
   ];

   if (($_POST['action'] ?? '') === 'logout') {
       $_SESSION = [];
       session_destroy();
       header('Location: mini-login.php');
       exit;
   }

   $error = '';
   if (($_POST['action'] ?? '') === 'login') {
       $user = $users[$_POST['email'] ?? ''] ?? null;
       if ($user !== null && password_verify($_POST['password'] ?? '', $user['hash'])) {
           session_regenerate_id(true);
           $_SESSION['name'] = $user['name'];
           header('Location: mini-login.php');   // PRG
           exit;
       }
       $error = 'Email ou mot de passe incorrect.';
   }
   ?>
   <!DOCTYPE html>
   <html lang="fr"><head><meta charset="UTF-8"><title>Mini login</title></head>
   <body>
   <?php if (isset($_SESSION['name'])): ?>
     <p>Bonjour <?= htmlspecialchars($_SESSION['name']) ?></p>
     <form method="post"><button name="action" value="logout">Déconnexion</button></form>
   <?php else: ?>
     <p><?= htmlspecialchars($error) ?></p>
     <form method="post">
       <input name="email" type="email" placeholder="email">
       <input name="password" type="password" placeholder="mot de passe">
       <button name="action" value="login">Connexion</button>
     </form>
   <?php endif; ?>
   </body></html>
   ```
3. Se connecter. Montrer dans Network : le POST, la réponse **302**, puis le GET. « Voilà Post/Redirect/Get. » Montrer que `PHPSESSID` a **changé** après la connexion (`session_regenerate_id`).
4. Enlever temporairement la redirection après la connexion. Se connecter, puis F5 : le navigateur propose de renvoyer le formulaire. Remettre la redirection.
5. Créer `secret.php` qui affiche « Page secrète » sans vérification. L'ouvrir sans être connecté : ça marche. Ajouter :
   ```php
   session_start();
   if (!isset($_SESSION['name'])) { header('Location: mini-login.php'); exit; }
   ```
   « Chaque page protégée vérifie **elle même**. Cacher le lien ne sert à rien. »
