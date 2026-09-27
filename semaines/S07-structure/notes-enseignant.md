# S07 : Notes pour l'enseignante

## Objectif de la séance

À la fin, chaque étudiant doit pouvoir :

1. expliquer le rôle du front controller, des contrôleurs, des templates et des repositories ;
2. écrire une classe PHP avec un constructeur et l'utiliser ;
3. ajouter une nouvelle page dans cette structure sans aide ;
4. vérifier un rôle **et** la propriété d'une ressource.

Le message clé : **un framework n'est pas de la magie. C'est une façon de ranger le code, que vous pouvez écrire vous mêmes.**

## Préparation

* [ ] Publier le corrigé du TP4 **avant** la séance : c'est le point de départ de la construction collective.
* [ ] Avoir `tp5/starter/` prêt à publier **pendant** la séance (pour les binômes qui décrochent pendant la construction).
* [ ] Relire les propositions de projet reçues et préparer un retour court (voir plus bas).
* [ ] Réinitialiser votre base avec `schema.sql` + `seed.sql`.

## Déroulé minuté

| Temps | Activité | Remarques |
|---|---|---|
| 0:00 | Retour sur les propositions de projet | 10 min en tout : 3 bonnes idées (anonymes), 3 problèmes fréquents (voir plus bas). Retours individuels écrits dans les dépôts. |
| 0:10 | Slides 1 à 7 | Le problème (fichiers de 150 lignes), l'architecture, les classes. Aller vite sur la syntaxe. |
| 0:20 | **Construction collective** (slides 8 à 16, `live-coding.md`) | 50 min. Les étudiants tapent avec vous. S'arrêter à chaque étape pour vérifier que tout le monde a une page qui marche. |
| 1:10 | Pause | |
| 1:20 | Slides 17 à 22 : contrôleur avec formulaire, rôles, IDOR, bilan | 10 min. |
| 1:30 | **TP5** | Circuler. Les binômes qui ont décroché partent du starter. |
| 2:50 | Clôture | Slide « ce que vous venez de construire » : faire le lien avec les frameworks. Annoncer S08 : fetch, et jalon 1 du projet. |

## Retour sur les propositions de projet

Problèmes fréquents à nommer (sans citer de binôme) :

* **Pas de mécanique centrale** : « une application pour gérer les X » sans rien de calculé. Demander : qu'est ce que votre application sait faire qu'une feuille de calcul partagée ne sait pas faire ?
* **Trop gros** : paiement en ligne, chat en temps réel, application mobile, carte interactive complète. Aider à couper : une version simple de la mécanique d'abord.
* **Pas de vrai utilisateur** : « tout le monde ». Demander un nom de club, de promo, de commerce.
* **Tables mal pensées** : une colonne `participants` avec une liste de noms séparés par des virgules. Montrer la table d'association de ClubHub.

## Points d'attention

* **La construction collective est le cœur de la séance.** Ne pas aller trop vite : si la moitié de la salle a une erreur, s'arrêter. Mieux vaut finir avec 4 étapes comprises que 5 étapes copiées.
* **`extract()` et `ob_start()`** : les deux fonctions « magiques » de `View`. Les démontrer avec des exemples minuscules (voir le script).
* **La promotion de propriété** (`__construct(private PDO $pdo)`) surprend ceux qui viennent de Java. Montrer la version longue une fois.
* **`Class not found`** : casse du nom de fichier (`userRepository.php`), surtout sous Linux et macOS.
* **Les anciennes pages** coexistent avec les nouvelles pendant le TP (elles ont leur propre bootstrap). C'est voulu : on migre page par page, et le site marche à chaque étape. C'est comme ça qu'on fait dans la vraie vie.
* **IDOR** (slide 20) : c'est la faille la plus « réelle » du cours. La plupart des binômes vont vérifier le rôle et oublier la propriété. Le test de la grille le détecte en 10 secondes.
* **Le temps** : le TP5 est dense. Si un binôme n'a pas le temps de faire le Plus, la Base bien faite vaut 14. C'est normal, et c'est ce qui compte pour le projet.

## Lien avec le projet

Dire explicitement : « Pour le projet, partez de **cette** structure. Copiez `src/`, `index.php`, `templates/layout.php`, et remplacez ClubHub par votre application. » C'est le critère « Solide » du projet.

## Erreurs fréquentes

| Erreur | Réaction |
|---|---|
| `Class "X" not found` | Nom du fichier = nom de la classe, dans `src/`, même casse |
| `Undefined variable $events` dans un template | La clé manque dans le tableau passé à `View::render()` |
| `Cannot modify header information` | `redirect()` ou `flash()` après `View::render()` : toute la logique d'abord |
| Le CSS ne se charge plus | Chemin relatif : `css/style.css` depuis `index.php`, c'est bon ; depuis une autre URL (défi URL propres), il faut `/css/style.css` |
| Deux fois le menu sur la page | Le template inclut encore l'ancien `header.php` |
| `Using $this when not in object context` | Méthode appelée avec `::` alors qu'elle n'est pas statique, ou `$this` dans une méthode statique |
