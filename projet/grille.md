# Projet final : grille de notation (sur 20)

**Binôme :** ................................................ **Application :** ............................

## Partie A : le produit (14 points, commun au binôme)

À remplir **avant** la soutenance, à partir du dépôt Git (dernier commit avant S11) et de l'application lancée.

| # | Critère | Points | Note |
|---|---|---|---|
| | **Base (6 pts)** | | |
| A1 | HTML sémantique, CSS responsive sans framework, présentation soignée | 1 | |
| A2 | Au moins une interaction JavaScript utile et propre | 1 | |
| A3 | Formulaires : validation navigateur **et** serveur, messages d'erreur clairs | 1 | |
| A4 | Inscription / connexion, mots de passe hachés, pages protégées côté serveur | 1 | |
| A5 | BD ≥ 3 tables cohérentes, PDO, requêtes préparées partout | 1 | |
| A6 | Les quatre règles de sécurité appliquées partout (voir tests ci dessous) | 1 | |
| | **Solide (4 pts)** | | |
| A7 | Code structuré : accès aux données dans des classes, templates, point d'entrée unique | 1,5 | |
| A8 | Relation exploitée avec un JOIN | 0,5 | |
| A9 | **Mécanique centrale** : fonctionne, va au delà du CRUD, logique intéressante | 1,5 | |
| A10 | Cas d'erreur gérés (id inexistant, doublon, champ vide, accès refusé) | 0,5 | |
| | **Avancé (2 pts)** | | |
| A11 | Une ou deux options Avancé réalisées correctement (1 pt chacune, 2 max) | 2 | |
| | **Projet (2 pts)** | | |
| A12 | Originalité et utilité : vrai utilisateur, vrai problème, idée personnelle | 1 | |
| A13 | README complet (dont le trajet d'une requête), `schema.sql` + `seed.sql`, commits réguliers des deux membres | 1 | |
| | **Total produit** | **/14** | |
| | Jalons manqués (−1 chacun) | | |
| | Bibliothèque ou framework non autorisé | −3 | |

### Tests rapides de sécurité (A6), 3 minutes

* Saisir `<script>alert(1)</script>` dans un champ texte, puis afficher la donnée → aucune alerte.
* Saisir `' OR '1'='1` dans un champ de recherche ou de connexion → pas de comportement anormal.
* Se déconnecter, puis ouvrir directement l'URL d'une page protégée → redirection.
* Changer un `id` dans l'URL (`?id=3` → `?id=4`) sur une ressource personnelle → accès refusé.
* Regarder la table `users` → mots de passe hachés (`$2y$...`).
* `grep -rn "query(" .` et `grep -rn "\$_\(GET\|POST\)" .` → aucune variable dans une chaîne SQL.

Une faille trouvée = A6 à 0.

## Partie B : la soutenance (6 points, individuelle)

| # | Critère | Points | Étudiant 1 | Étudiant 2 |
|---|---|---|---|---|
| B1 | Démo claire, mécanique centrale bien présentée (note commune) | 1 | | |
| B2 | Questions individuelles : explique correctement le code, le trajet d'une requête, la sécurité | 3 | | |
| B3 | Modification en direct : réussie, ou démarche correcte | 2 | | |
| | **Total soutenance** | **/6** | | |

### Règle de compréhension

Si un étudiant ne peut pas expliquer une partie importante de **son** propre code (par exemple la connexion, ou la mécanique centrale), les points de la Partie A correspondants ne lui sont **pas** comptés. Le noter clairement sur la grille.

## Note finale

| | Étudiant 1 | Étudiant 2 |
|---|---|---|
| Produit (/14) | | |
| Soutenance (/6) | | |
| **Total (/20)** | | |

## Repères

| Note | Ce que ça ressemble |
|---|---|
| < 10 | Base incomplète : pas de connexion, ou pas de BD, ou failles de sécurité, ou code non compris |
| 10 à 12 | Base complète et propre, application simple, bonne soutenance |
| 13 à 15 | Base + code structuré + une vraie mécanique centrale |
| 16 à 18 | Tout cela + une option Avancé bien faite + idée originale |
| 19 à 20 | Application dont on voudrait se servir, code exemplaire, soutenance parfaite |
