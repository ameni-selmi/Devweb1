# Plan du semestre : Développement Web 1

33 h en présentiel (11 × 3 h) + environ 2 h de travail personnel par semaine.

## Vue d'ensemble

| Sem. | Sujet | Théorie | Pratique | Rendu noté | AA | Chap. fiche |
|---|---|---|---|---|---|---|
| S01 | Comment fonctionne le Web + HTML | 1 h 15 | 1 h 45 | | AA1, AA2 | 1, 2 |
| S02 | CSS | 1 h | 2 h | **TP1** (15 %) | AA2 | 3 |
| S03 | JavaScript dans le navigateur | 1 h | 2 h | **TP2** (7,5 %) | AA3 | 6 |
| S04 | PHP et le serveur | 1 h 15 | 1 h 45 | | AA4 | 4, 9 |
| S05 | Sessions, connexion, sécurité | 1 h | 2 h | **TP3** (7,5 %) | AA4 | 5 |
| S06 | MySQL et PDO | 1 h | 2 h | **TP4** (15 %) | AA5 | 7 |
| S07 | Structurer une application | 1 h | 2 h | **TP5** (15 %) | AA4, AA5 | 7, 8 |
| S08 | fetch et JSON | 45 min | 2 h 15 | Jalon 1 | AA3, AA5 | 6, 8 |
| S09 | Atelier projet + revue de code | 15 min | 2 h 45 | | tous | 10 |
| S10 | Atelier projet | 15 min | 2 h 45 | Jalon 2 | tous | 10 |
| S11 | Soutenances | | 3 h | **Projet** (40 %) | tous | 10 |
| | **Total** | **≈ 8 h 45** | **≈ 24 h** | | | |

### Répartition du contrôle continu (60 %)

La fiche impose : TP1 à TP3 = 30 %, TP4 et TP5 = 30 %. Proposition :

| TP | Poids | Justification |
|---|---|---|
| TP1 : HTML/CSS | 15 % | Gros travail, deux semaines de contenu |
| TP2 : JavaScript | 7,5 % | TP plus court |
| TP3 : PHP, sessions | 7,5 % | TP plus court |
| TP4 : MySQL, PDO | 15 % | |
| TP5 : Structure + JOIN | 15 % | |

À ajuster si le département préfère 10 % par TP.

### Jalons du projet (non notés, mais obligatoires)

| Quand | Quoi |
|---|---|
| S04 | Cahier des charges distribué, binômes formés |
| S06 | Proposition d'une page (utilisateur, mécanique, tables) → validée par l'enseignant |
| S08 | Jalon 1 : schéma BD créé, pages principales en place, dépôt Git à jour |
| S10 | Jalon 2 : fonctionnalités gelées, README écrit |
| S11 | Soutenance |

Un jalon manqué = −1 point sur la note du projet (règle annoncée en S04).

---

## S01 : Comment fonctionne le Web + HTML

**Objectifs** : expliquer le chemin d'une requête ; lire une requête et une réponse dans les DevTools ; écrire une page HTML sémantique avec un formulaire.

| Durée | Activité |
|---|---|
| 15 min | Présentation du cours, évaluation, projet, politique IA |
| 10 min | Quiz diagnostic (papier ou formulaire) |
| 35 min | Cours : client/serveur, URL, DNS, HTTP, méthodes, codes, HTTPS. Démo DevTools onglet Network |
| 15 min | Cours : HTML, structure, sémantique, formulaires |
| 10 min | Pause |
| 20 min | Live coding : page d'accueil ClubHub |
| 70 min | Atelier : les 3 pages de ClubHub en HTML pur |
| 5 min | Clôture : à préparer pour S02 |

**Travail personnel** : terminer les 3 pages, créer le dépôt Git, pousser.

## S02 : CSS (TP1 noté)

**Objectifs** : sélecteurs et cascade ; box model ; Flexbox ; responsive avec media queries ; variables CSS.

| Durée | Activité |
|---|---|
| 10 min | Correction flash de l'atelier S01 |
| 40 min | Cours + live coding : cascade, box model, Flexbox |
| 15 min | Cours + live coding : responsive, mobile first, media queries |
| 10 min | Pause |
| 95 min | **TP1** : styliser ClubHub d'après la maquette |
| 10 min | Correction par checklist (fin de séance) ou rendu Git avant 23 h 59 |

## S03 : JavaScript dans le navigateur (TP2 noté)

**Objectifs** : syntaxe JS pour programmeurs ; DOM ; événements ; validation de formulaire ; créer / supprimer des éléments.

| Durée | Activité |
|---|---|
| 10 min | Retour TP1 : erreurs fréquentes |
| 20 min | JS pour programmeurs : ce qui est différent de C/Java/Python |
| 30 min | Live coding : DOM, événements, filtre des événements |
| 10 min | Pause |
| 100 min | **TP2** : filtre, validation, compteur de places, mode sombre |
| 10 min | Correction |

## S04 : PHP et le serveur

**Objectifs** : différence code client / code serveur ; installer et lancer un serveur PHP ; lire `$_GET` et `$_POST` ; valider côté serveur ; échapper la sortie ; `include` pour le layout.

| Durée | Activité |
|---|---|
| 10 min | Retour TP2 |
| 15 min | Installation : `php -S` ou XAMPP (tout le monde doit voir « Hello » avant de continuer) |
| 30 min | Cours : où s'exécute le code, cycle d'une requête PHP, `$_GET`, `$_POST`, première faille XSS |
| 20 min | PHP pour programmeurs : syntaxe, tableaux associatifs, fonctions |
| 10 min | Pause |
| 20 min | Présentation du projet final |
| 70 min | Atelier : ClubHub en PHP, layout commun, formulaire d'inscription traité et validé |
| 5 min | Clôture |

## S05 : Sessions, connexion, sécurité (TP3 noté)

**Objectifs** : HTTP sans état ; cookies et sessions ; inscription et connexion ; hachage ; protéger une page ; Post/Redirect/Get ; messages flash.

| Durée | Activité |
|---|---|
| 10 min | Retour atelier S04 |
| 25 min | Cours : pourquoi HTTP oublie tout, cookie, session, démo DevTools (onglet Application) |
| 25 min | Live coding : connexion / déconnexion, `password_hash`, page protégée |
| 10 min | Pause |
| 100 min | **TP3** : comptes utilisateurs (stockés dans un fichier JSON en attendant la BD), espace protégé |
| 10 min | Correction |

Remarque : en S05, les utilisateurs sont stockés dans `data/users.json`. C'est volontaire : on voit la logique de session sans mélanger avec SQL. En S06, on remplace le fichier par MySQL, et les étudiants voient l'intérêt d'une BD.

## S06 : MySQL et PDO (TP4 noté)

**Objectifs** : modéliser 2 à 3 tables ; rappel SQL ; connexion PDO ; requêtes préparées ; comprendre l'injection SQL.

| Durée | Activité |
|---|---|
| 10 min | Rappel des propositions de projet à rendre ce soir |
| 20 min | Modélisation ClubHub (au tableau), rappel SQL rapide |
| 30 min | Live coding : PDO, `fetchAll`, `prepare`/`execute`, démo d'injection SQL en direct |
| 10 min | Pause |
| 100 min | **TP4** : migrer ClubHub vers MySQL (événements + utilisateurs) |
| 10 min | Correction |

**Rendu projet** : proposition d'une page, avant dimanche 23 h 59.

## S07 : Structurer une application (TP5 noté)

**Objectifs** : syntaxe des classes PHP ; classe `Database` ; *repository* ; templates ; front controller avec mini routeur ; JOIN.

| Durée | Activité |
|---|---|
| 10 min | Retour sur les propositions de projet |
| 50 min | Construction collective d'un mini framework : `Database`, `EventRepository`, `render()`, routeur |
| 10 min | Pause |
| 100 min | **TP5** : restructurer ClubHub + table `registrations` + page « Mes inscriptions » avec JOIN |
| 10 min | Correction |

## S08 : fetch et JSON

**Objectifs** : endpoint PHP qui renvoie du JSON ; `fetch` + `async`/`await` ; mise à jour du DOM sans rechargement ; relecture de la checklist sécurité.

| Durée | Activité |
|---|---|
| 30 min | Cours + live coding : bouton « Je participe » en fetch |
| 15 min | Checklist sécurité : chaque binôme l'applique à son projet |
| 10 min | Pause |
| 120 min | Atelier projet + validation du jalon 1 par l'enseignant (5 min par binôme) |
| 5 min | Clôture |

## S09 : Atelier projet + revue de code

| Durée | Activité |
|---|---|
| 15 min | Les 5 erreurs vues dans les projets cette semaine |
| 30 min | Revue de code croisée : chaque binôme relit un autre projet avec une grille |
| 10 min | Pause |
| 125 min | Travail projet, points individuels avec l'enseignant |

## S10 : Atelier projet

| Durée | Activité |
|---|---|
| 15 min | Préparer une soutenance : format, questions types |
| 150 min | Travail projet, répétition de démo, jalon 2 (gel des fonctionnalités) |
| 15 min | Planning des soutenances |

Si plus de 12 binômes : commencer des soutenances dans la dernière heure de S10.

## S11 : Soutenances

15 minutes par binôme, notation comprise (voir `projet/soutenance.md`). 12 binômes par séance de 3 h.
