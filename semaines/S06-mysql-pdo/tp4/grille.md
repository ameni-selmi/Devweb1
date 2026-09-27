# TP4 : Grille de correction (sur 20)

Temps visé : 8 à 10 minutes par binôme.

**Binôme :** ................................................

## Recherche automatique (1 minute, dans leur dossier)

```bash
# Variables PHP à l'intérieur d'une chaîne SQL : doit ne rien trouver
grep -rnE "(query|prepare|exec)\s*\(\s*\"[^\"]*\\\$" --include=*.php .
grep -rnE "(SELECT|INSERT|UPDATE|DELETE|WHERE)[^;]*['\"]\s*\.\s*\\\$" --include=*.php .
# config.php ne doit pas être suivi par Git
git ls-files | grep config.php
# SQL dans les pages (doit ne rien trouver hors de includes/)
grep -lnE "prepare\(|query\(" *.php
```

Tout résultat suspect : l'ouvrir et vérifier à la main.

## Tests rapides

| Test | Attendu | OK ? |
|---|---|---|
| Connexion avec l'email `' OR '1'='1` | Refusée | |
| `evenement.php?id=1 OR 1=1` | 404 | |
| Se déconnecter, se reconnecter | Les inscriptions sont toujours là | |
| S'inscrire deux fois au même événement (deux onglets) | Message clair, pas d'erreur PHP | |
| Événement complet (id 7 du seed) | Pas de formulaire ; POST direct refusé | |
| Modifier `event_id` du bouton Annuler dans les DevTools | N'annule pas l'inscription d'un autre | |

## Grille

| # | Critère | Points | Note |
|---|---|---|---|
| | **Connexion et organisation (4 pts)** | | |
| 1 | `db()` : DSN avec `utf8mb4`, les 3 options, connexion unique | 1,5 | |
| 2 | `config.php` hors de Git, `config.example.php` présent, installation décrite | 1 | |
| 3 | SQL seulement dans `includes/`, fonctions bien nommées | 1,5 | |
| | **Données (6 pts)** | | |
| 4 | Événements depuis la base (à venir, triés), `findEvent` préparé, 404 conservée | 2 | |
| 5 | Utilisateurs en base : création, connexion, `created_at` affiché | 2 | |
| 6 | Dates et programme correctement affichés | 1 | |
| 7 | Anciens fichiers `data/` supprimés | 1 | |
| | **Sécurité (4 pts)** | | |
| 8 | Requêtes préparées partout (recherche automatique propre) | 3 | |
| 9 | Question 5 (injection) : réponse juste et expliquée | 1 | |
| | *Sous total Base* | *14* | |
| | **Plus (3 pts)** | | |
| 10 | Inscriptions en base, JOIN pour « Mes inscriptions » | 1 | |
| 11 | Places restantes calculées en SQL, complet refusé côté serveur | 1 | |
| 12 | Doublon géré (`23000`), annulation limitée à ses propres inscriptions | 1 | |
| | **Défi (3 pts)** | | |
| 13 | Défi(s) réalisé(s) et expliqué(s) | 3 | |
| | **Pénalités** | | |
| | Une variable dans une chaîne SQL (par occurrence) | −3 | |
| | `config.php` avec mot de passe dans Git | −2 | |
| | Utilisateur `root` dans `config.example.php` | −1 | |
| | Rendu en retard (par tranche de 24 h) | −2 | |
| | **Total** | **/20** | |

## Questions orales possibles

* « Montrez moi la requête de cette page. Pourquoi `prepare` ? Que devient `' OR '1'='1` avec votre code ? »
* « Pourquoi `LEFT JOIN` et pas `JOIN` pour compter les places ? Que se passe-t-il pour un événement sans inscrit ? »
* « Qui empêche une double inscription : votre PHP ou la base ? Et si les deux ? »
* « Où est le mot de passe de la base ? Pourquoi n'est il pas dans Git ? »
* « Deux personnes cliquent sur la dernière place en même temps. Que se passe-t-il chez vous ? »

## Repères

| Note | Ce que ça ressemble |
|---|---|
| < 10 | Connexion qui ne marche pas, ou SQL concaténé |
| 10 à 14 | Base complète, requêtes préparées partout |
| 15 à 17 | + inscriptions en base, JOIN, places, doublons |
| 18 à 20 | + un défi réussi (la transaction est le plus formateur) |
