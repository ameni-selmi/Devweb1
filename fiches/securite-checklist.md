# Checklist sécurité (obligatoire dans les TP et le projet)

Principe : **le serveur ne fait jamais confiance au navigateur.** Tout ce qui vient du client (`$_GET`, `$_POST`, `$_COOKIE`, headers, JSON envoyé par `fetch`) peut être modifié.

## Les quatre règles

| # | Règle | Comment | Contre quoi | Séance |
|---|---|---|---|---|
| 1 | **Échapper toute sortie** | `<?= e($value) ?>` en PHP, `textContent` en JS | XSS (injection de JavaScript) | S04 |
| 2 | **Hacher les mots de passe** | `password_hash($pwd, PASSWORD_DEFAULT)` puis `password_verify($pwd, $hash)` | Vol de la base | S05 |
| 3 | **Vérifier l'accès côté serveur** | En haut de chaque contrôleur protégé : `Auth::requireLogin()` ou `Auth::requireRole()`, **et** vérifier que la ressource appartient à l'utilisateur | Accès non autorisé, IDOR | S05, S07 |
| 4 | **Préparer toute requête** | `$stmt = $pdo->prepare('... WHERE id = ?'); $stmt->execute([$id]);` | Injection SQL | S06 |

## À vérifier avant chaque rendu

**Sorties**
* [ ] Toutes les données affichées passent par `e()`.
* [ ] En JavaScript : `textContent`, jamais `innerHTML` avec une donnée.

**Entrées**
* [ ] Toutes les données reçues sont **validées côté serveur** (type, longueur, format, valeurs permises), même si le JS les valide déjà.
* [ ] Aucun nom de fichier ni de page ne vient directement de l'URL (`require $_GET[...]` est interdit : liste blanche).

**Base de données**
* [ ] Aucune variable dans une chaîne SQL (`"... WHERE id = $id"` et `'... = ' . $id` sont **interdits**).
* [ ] `config.php` (mot de passe de la base) n'est pas dans Git : `.gitignore` + `config.example.php`.
* [ ] L'utilisateur MySQL de l'application n'est pas `root`.

**Comptes et sessions**
* [ ] Aucun mot de passe en clair, nulle part (base, session, logs, Git).
* [ ] `session_regenerate_id(true)` après la connexion.
* [ ] Message de connexion identique pour « email inconnu » et « mauvais mot de passe ».
* [ ] Cookie de session `httponly` et `samesite=Lax`.

**Droits**
* [ ] Chaque page ou endpoint protégé vérifie la session **lui même**.
* [ ] Un utilisateur ne peut pas lire ou modifier la ressource d'un autre en changeant un `id` (dans l'URL, un champ caché, ou un JSON).
* [ ] Les rôles sont vérifiés côté serveur, pas seulement en cachant des liens.

**HTTP**
* [ ] Les actions qui modifient des données utilisent **POST**, jamais GET (déconnexion comprise).
* [ ] Après un POST réussi : **redirection** (Post/Redirect/Get).
* [ ] Les endpoints JSON renvoient le bon code (401, 403, 404, 409, 422) et ne renvoient **que** les champs utiles (jamais `password_hash`).
* [ ] Les erreurs PHP détaillées ne sont pas affichées en production (`display_errors` à `0`).

## Commandes utiles (dans le dossier du projet)

```bash
# SQL avec une variable : doit ne rien trouver
grep -rnE "(query|prepare|exec)\s*\(\s*\"[^\"]*\\\$" --include=*.php .
grep -rnE "(SELECT|INSERT|UPDATE|DELETE|WHERE)[^;]*['\"]\s*\.\s*\\\$" --include=*.php .
# innerHTML dans le JS : vérifier chaque résultat
grep -rn "innerHTML" --include=*.js .
# config.php suivi par Git : doit ne rien afficher
git ls-files | grep config.php
```

## Cinq attaques à essayer sur votre propre site

1. Taper `<script>alert(1)</script>` dans **chaque** champ texte, puis afficher la donnée.
2. Taper `' OR '1'='1` dans les champs de recherche et de connexion.
3. Se déconnecter, puis ouvrir directement l'URL d'une page protégée.
4. Connecté en utilisateur A, changer un `id` dans l'URL ou dans les DevTools pour viser une ressource de B.
5. Envoyer une requête avec `curl` sans passer par le navigateur (champ vide, valeur absurde).
