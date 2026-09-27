# Checklist sécurité (obligatoire dans les TP et le projet)

Principe : **le serveur ne fait jamais confiance au navigateur.** Tout ce qui vient du client (`$_GET`, `$_POST`, `$_COOKIE`, headers, JSON) peut être modifié.

## Les quatre règles

| # | Règle | Comment | Contre quoi |
|---|---|---|---|
| 1 | **Échapper toute sortie** | `<?= e($value) ?>` avec `function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }` | XSS (injection de JavaScript) |
| 2 | **Préparer toute requête** | `$stmt = $pdo->prepare('... WHERE id = ?'); $stmt->execute([$id]);` | Injection SQL |
| 3 | **Hacher les mots de passe** | `password_hash($pwd, PASSWORD_DEFAULT)` puis `password_verify($pwd, $hash)` | Vol de la base |
| 4 | **Vérifier l'accès côté serveur** | En haut de chaque page protégée : `requireLogin();` et vérifier que la ressource appartient à l'utilisateur | Accès non autorisé |

## À vérifier avant chaque rendu

* [ ] Aucune variable concaténée dans une chaîne SQL (`"... WHERE id = $id"` est **interdit**).
* [ ] Toutes les données affichées passent par `e()`.
* [ ] Toutes les données reçues sont **validées côté serveur** (type, longueur, format), même si le JS les valide déjà.
* [ ] Les actions qui modifient des données utilisent **POST**, jamais GET.
* [ ] Après un POST réussi : **redirection** (Post/Redirect/Get).
* [ ] Aucun mot de passe en clair, nulle part (ni en base, ni dans Git).
* [ ] Chaque page protégée vérifie la session **elle même**.
* [ ] Un utilisateur ne peut pas modifier la ressource d'un autre en changeant un `id` dans l'URL.
* [ ] `session_regenerate_id(true)` après la connexion.
* [ ] Les erreurs PHP détaillées ne sont pas affichées aux utilisateurs en production.
* [ ] Le fichier de configuration (mot de passe BD) n'est pas dans Git (`.gitignore` + `config.example.php`).
