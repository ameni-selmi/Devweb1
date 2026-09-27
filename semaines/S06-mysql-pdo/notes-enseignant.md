# S06 : Notes pour l'enseignante

## Objectif de la séance

À la fin, chaque étudiant doit pouvoir :

1. expliquer pourquoi une base de données règle les problèmes de S05 ;
2. se connecter à MySQL avec PDO correctement configuré ;
3. écrire des requêtes préparées pour lire et écrire ;
4. montrer une injection SQL et expliquer pourquoi `prepare` l'empêche ;
5. utiliser un JOIN et une contrainte `UNIQUE` dans une vraie page.

Le message clé : **une donnée ne doit jamais devenir du code. En HTML, on échappe (`e()`). En SQL, on prépare.**

## Préparation

* [ ] **MySQL en salle** : vérifier avant la séance qu'on peut créer une base et un utilisateur (droits administrateur, service démarré). Sinon, prévoir XAMPP.
* [ ] Publier `tp4/starter/` et le corrigé du TP3.
* [ ] Préparer la démo d'injection (`live-coding/demo/`). **Ne jamais la mettre sur un serveur accessible.**
* [ ] Rappeler la proposition de projet : à rendre cette semaine.

## Déroulé minuté

| Temps | Activité | Remarques |
|---|---|---|
| 0:00 | Retour TP3 + question de fin de S05 | « Où sont passées les inscriptions ? » → slide 3. |
| 0:10 | Modélisation au tableau (slides 4 à 7) | Faire trouver la table `registrations` par la salle. Ne montrer le schéma qu'après. |
| 0:25 | Slides 8 à 10 + live coding partie 1 | Connexion PDO, première requête. |
| 0:35 | Slides 11 à 13 + live coding partie 2 | **La démo d'injection.** C'est le moment fort. |
| 0:50 | Slides 14 à 19 : écrire, erreurs, JOIN, places, organisation | Aller vite sur le SQL, ils le connaissent. |
| 1:05 | Pause | |
| 1:15 | Mise en place du TP (base, scripts, `config.php`) | 10 min, tout le monde ensemble. Personne ne commence le code tant que la base n'est pas importée. |
| 1:25 | **TP4** | Circuler. |
| 2:50 | Clôture | Proposition de projet à rendre. Annoncer S07 : on range le code. |

## Points d'attention

* **La mise en place prend du temps** : utilisateur MySQL, import, `config.php`. D'où les 10 minutes guidées. Les étudiants sous Windows avec XAMPP utilisent souvent phpMyAdmin pour importer : c'est bien.
* **Même nom de fonction** : faire remarquer que `users.php` garde les mêmes fonctions qu'en S05. Les pages changent à peine. C'est une première leçon d'architecture (et la préparation de S07).
* **`EMULATE_PREPARES => false`** : avec cette option, un même `:nom` ne peut pas servir deux fois (`Invalid parameter number`). Certains vont tomber dessus avec la recherche `LIKE`. C'est une bonne occasion de parler de ce qu'est vraiment une requête préparée.
* **`fetch()` renvoie `false`**, pas `null`. D'où `$row === false ? null : $row` dans les fonctions `find...`.
* **`LIMIT ?`** : avec de vraies requêtes préparées, MySQL accepte un paramètre pour `LIMIT` seulement s'il est lié comme entier. Le plus simple pour eux : `(int) $limit` concaténé. Expliquer que c'est acceptable **parce que** le cast garantit un entier, et que c'est la seule exception.
* **Fuseau horaire** : `NOW()` (MySQL) et `new DateTimeImmutable()` (PHP) doivent être dans le même fuseau. Sur une machine de développement, c'est presque toujours le cas. Si un étudiant voit des événements « passés » qui ne le sont pas, c'est ça.
* **Les accents** : `charset=utf8mb4` dans le DSN, sinon `Ã©`. Et la base créée en `utf8mb4`.

## La démo d'injection (à ne pas rater)

Voir `live-coding.md`, partie 2. Voir s'afficher **tous les emails et tous les hachages** de la table `users` depuis un simple champ de recherche frappe beaucoup plus qu'un schéma. Puis ouvrir la version avec `prepare`, et relancer la même attaque.

## Correction

Commencer par la recherche automatique de la grille (1 minute). Puis les tests rapides. Un étudiant qui a concaténé du SQL doit **voir** l'attaque marcher sur son propre code : faites le avec lui.

## Erreurs fréquentes

| Erreur | Réaction |
|---|---|
| `Access denied for user` | `config.php` : utilisateur, mot de passe, et l'utilisateur a bien les droits sur la base |
| `could not find driver` | Extension `pdo_mysql` désactivée dans `php.ini` |
| `Table 'clubhub.events' doesn't exist` | `schema.sql` pas importé, ou importé dans une autre base |
| `Cannot add or update a child row: a foreign key constraint fails` | `seed.sql` importé avant `schema.sql`, ou id qui n'existe pas |
| `Integrity constraint violation: 1062 Duplicate entry` | C'est la contrainte `UNIQUE` qui fait son travail : attraper l'exception |
| Les places ne baissent pas | `JOIN` au lieu de `LEFT JOIN`, ou `COUNT(*)` au lieu de `COUNT(r.id)` |
| Un événement sans inscrit disparaît de la liste | Même cause : `JOIN` au lieu de `LEFT JOIN` |
