# TP5 : Grille de correction (sur 20)

Temps visé : 10 minutes par binôme. Réinitialiser la base avec `schema.sql` + `seed.sql` avant de tester.

**Binôme :** ................................................

## Tests de droits (3 minutes)

| Test | Attendu | OK ? |
|---|---|---|
| `index.php?page=../config` et `index.php?page=nimporte` | 404 | |
| `index.php?page=compte` sans être connecté | Redirection vers la connexion | |
| Connecté en `amine@campus.example`, ouvrir `?page=nouvel-evenement` | 403 | |
| Connecté en `robotique@campus.example`, ouvrir `?page=inscrits&id=3` (événement du Club IA) | 403 | |
| Connecté en `robotique@campus.example`, ouvrir `?page=inscrits&id=1` | La liste s'affiche | |
| Créer un événement avec une fin avant le début, puis dans le passé | Refusé, messages clairs | |

## Structure (lecture du code, 3 minutes)

```bash
ls *.php                                   # seulement index.php, config.php, config.example.php
grep -rln "SELECT\|INSERT\|DELETE" controllers templates   # rien
grep -rln "\$_POST\|redirect(" templates                  # rien
```

## Grille

| # | Critère | Points | Note |
|---|---|---|---|
| | **Classes (5 pts)** | | |
| 1 | `UserRepository` et `RegistrationRepository` : requêtes préparées, `$this->pdo`, bons retours | 2,5 | |
| 2 | `Auth` : `user()`, `requireLogin()`, `login()` (avec `session_regenerate_id`), `logout()` | 2,5 | |
| | **Migration (7 pts)** | | |
| 3 | Les 6 pages migrées, toutes les fonctionnalités des TP3 et TP4 marchent encore | 4 | |
| 4 | Plus aucune ancienne page ni `includes/` ; une route par page | 1 | |
| 5 | Séparation respectée : pas de SQL hors des repositories, pas de logique dans les templates | 2 | |
| | **Qualité (2 pts)** | | |
| 6 | `url()` partout, `e()` partout, contrôleurs courts et lisibles | 1 | |
| 7 | README : trajet de la requête `?page=evenement&id=3` juste et précis | 1 | |
| | *Sous total Base* | *14* | |
| | **Plus (3 pts)** | | |
| 8 | `requireRole()` avec 403 ; menu adapté au rôle | 0,5 | |
| 9 | Création d'événement : validation serveur complète, PRG | 1 | |
| 10 | « Mes événements » avec le nombre d'inscrits | 0,5 | |
| 11 | Liste des inscrits (JOIN) réservée à l'organisateur **de l'événement** | 1 | |
| | **Défi (3 pts)** | | |
| 12 | Défi(s) réalisé(s) et expliqué(s) | 3 | |
| | **Pénalités** | | |
| | `require` d'un fichier dont le nom vient de l'URL | −4 | |
| | Un organisateur peut voir les inscrits d'un autre | −3 | |
| | Rendu en retard (par tranche de 24 h) | −2 | |
| | **Total** | **/20** | |

## Questions orales possibles

* « J'ouvre `index.php?page=evenement&id=3`. Racontez moi, fichier par fichier, ce qui s'exécute. »
* « Pourquoi une liste de routes plutôt que `require $_GET['page'] . '.php'` ? »
* « Que fait `ob_start()` dans `View` ? Pourquoi en a-t-on besoin ? »
* « `requireRole('organizer')` suffit il pour la page des inscrits ? Pourquoi ? »
* « Où ajouteriez vous une nouvelle page "Mes favoris" ? Quels fichiers ? »

## Repères

| Note | Ce que ça ressemble |
|---|---|
| < 10 | Migration à moitié faite, fonctionnalités cassées |
| 10 à 14 | Tout est migré et marche, structure propre |
| 15 à 17 | + rôle organisateur avec les bons contrôles de droits |
| 18 à 20 | + un défi bien intégré dans la structure |
