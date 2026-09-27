# Plan du cours : Développement Web 1

Amani Selmi, PhD-Engineer

33 h en présentiel (11 séances de 3 h) + environ 2 h de travail personnel par semaine.

## Vue d'ensemble

| Séance | Sujet | Théorie | Pratique | Rendu | AA |
|---|---|---|---|---|---|
| S01 | Comment fonctionne le Web + HTML | 1 h 15 | 1 h 45 | Atelier | AA1, AA2 |
| S02 | CSS : box model, Flexbox, responsive | 1 h | 2 h | **TP1** | AA2 |
| S03 | JavaScript dans le navigateur | 1 h | 2 h | **TP2** | AA3 |
| S04 | PHP et le serveur | 1 h 15 | 1 h 45 | Atelier · projet annoncé | AA1, AA4 |
| S05 | Sessions, connexion, sécurité | 1 h | 2 h | **TP3** | AA4 |
| S06 | MySQL et PDO | 1 h | 2 h | **TP4** · proposition de projet | AA5 |
| S07 | Structurer une application | 1 h | 2 h | **TP5** | AA4, AA5 |
| S08 | fetch et JSON | 45 min | 2 h 15 | Atelier · jalon 1 | AA3, AA5 |
| S09 | Atelier projet + revue de code | 15 min | 2 h 45 | | tous |
| S10 | Atelier projet, préparation de la soutenance | 15 min | 2 h 45 | Jalon 2 | tous |
| S11 | Soutenances | | 3 h | **Projet final** | tous |
| | **Total** | **≈ 8 h 45** | **≈ 24 h** | | |

## Évaluation proposée

| Élément | Poids |
|---|---|
| TP1 : HTML/CSS | 15 % |
| TP2 : JavaScript | 7,5 % |
| TP3 : PHP, sessions | 7,5 % |
| TP4 : MySQL, PDO | 15 % |
| TP5 : Structure, rôles | 15 % |
| **Projet final** (binôme, soutenance individuelle) | **40 %** |

À adapter aux règles de l'établissement. Deux variantes courantes :

* **TP à poids égaux** : 12 % par TP, projet 40 %.
* **Projet seul** (sans contrôle continu) : les TP deviennent obligatoires mais non notés, et le projet vaut 100 %. Dans ce cas, garder les grilles des TP comme retour formatif, et rendre le jalon 1 noté (par exemple 20 % de la note du projet).

## Jalons du projet

| Quand | Quoi |
|---|---|
| S04 | Cahier des charges distribué, binômes formés |
| S06 | Proposition d'une page (utilisateur, mécanique, tables), validée en S07 |
| S08 | Jalon 1 : schéma BD créé, pages principales en place, connexion qui fonctionne |
| S10 | Jalon 2 : fonctionnalités gelées, README écrit, démo répétée |
| S11 | Soutenance |

Un jalon manqué = −1 point sur la note du projet (règle annoncée en S04).

## Adapter à un autre volume horaire

* **Moins de séances (8 à 10)** : fusionner S09 et S10, et faire S08 en 1 h 30 avant de laisser le reste au projet.
* **Plus de séances (13 à 15, par exemple 45 h)** : ajouter une séance « Git et travail en binôme » après S02, dédoubler S07 (structure, puis rôles), ajouter une séance « Mise en ligne » après S08, et une troisième séance d'atelier projet.

---

## S01 : Comment fonctionne le Web + HTML

**Objectifs** : expliquer le chemin d'une requête ; lire une requête et une réponse dans les DevTools ; écrire une page HTML sémantique avec un formulaire.

| Durée | Activité |
|---|---|
| 15 min | Présentation de l'enseignante et du cours : évaluation, projet, politique IA |
| 10 min | Quiz diagnostic |
| 35 min | Cours : client/serveur, URL, DNS, HTTP, méthodes, codes, HTTPS. Démo DevTools |
| 15 min | Cours : HTML, sémantique, formulaires |
| 10 min | Pause |
| 20 min | Live coding : page d'accueil ClubHub |
| 70 min | Atelier : les 3 pages de ClubHub en HTML pur |
| 5 min | Clôture |

## S02 : CSS (TP1)

**Objectifs** : cascade, box model, Flexbox, responsive *mobile first*, variables CSS.

| Durée | Activité |
|---|---|
| 10 min | Retour atelier S01 |
| 55 min | Cours + live coding : cascade, box model, Flexbox, responsive |
| 10 min | Pause |
| 95 min | **TP1** : styliser ClubHub d'après la maquette |
| 10 min | Correction par checklist ou rendu Git le soir même |

## S03 : JavaScript dans le navigateur (TP2)

**Objectifs** : syntaxe JS pour programmeurs ; DOM ; événements ; validation ; `localStorage`.

| Durée | Activité |
|---|---|
| 10 min | Retour TP1 |
| 20 min | JS pour programmeurs : ce qui change par rapport à C, Java, Python |
| 30 min | Live coding : DOM, événements, filtre |
| 10 min | Pause |
| 100 min | **TP2** : filtre et recherche, validation, compteur, mode sombre |
| 10 min | Correction |

## S04 : PHP et le serveur

**Objectifs** : code client et code serveur ; lancer un serveur PHP ; `$_GET`, `$_POST` ; validation serveur ; échapper la sortie ; `include`.

| Durée | Activité |
|---|---|
| 10 min | Retour TP2 |
| 15 min | Installation : tout le monde voit « Bonjour » avant de continuer |
| 30 min | Cours : cycle d'une requête PHP, `$_GET`, `$_POST`, première faille XSS |
| 20 min | PHP pour programmeurs |
| 10 min | Pause |
| 20 min | Présentation du projet final |
| 70 min | Atelier : ClubHub en PHP |
| 5 min | Clôture |

## S05 : Sessions, connexion, sécurité (TP3)

**Objectifs** : HTTP sans état ; cookies et sessions ; inscription et connexion ; hachage ; page protégée ; Post/Redirect/Get ; messages flash.

| Durée | Activité |
|---|---|
| 10 min | Retour atelier S04 |
| 25 min | Cours : cookie, session, démo DevTools (onglet Application) |
| 25 min | Live coding : connexion, `password_hash`, page protégée |
| 10 min | Pause |
| 100 min | **TP3** : comptes utilisateurs (fichier JSON), page « Mon compte », inscription aux événements réservée aux connectés |
| 10 min | Correction : « Déconnectez vous. Où sont passées vos inscriptions ? » |

## S06 : MySQL et PDO (TP4)

**Objectifs** : modéliser 3 tables ; PDO ; requêtes préparées ; injection SQL ; JOIN.

| Durée | Activité |
|---|---|
| 10 min | Rappel : proposition de projet à rendre cette semaine |
| 20 min | Modélisation ClubHub au tableau, rappel SQL rapide |
| 30 min | Live coding : PDO, `prepare`/`execute`, démo d'injection SQL |
| 10 min | Pause |
| 100 min | **TP4** : migrer ClubHub vers MySQL |
| 10 min | Correction |

## S07 : Structurer une application (TP5)

**Objectifs** : classes PHP ; `Database` ; *repository* ; templates ; front controller ; rôles.

| Durée | Activité |
|---|---|
| 10 min | Retour sur les propositions de projet |
| 50 min | Construction collective du mini framework : `Database`, `View`, routeur, un premier repository |
| 10 min | Pause |
| 100 min | **TP5** : finir la migration vers la structure, ajouter le rôle organisateur |
| 10 min | Correction |

## S08 : fetch et JSON

**Objectifs** : endpoint PHP qui renvoie du JSON ; `fetch` + `async`/`await` ; mise à jour du DOM sans rechargement.

| Durée | Activité |
|---|---|
| 30 min | Cours + live coding : bouton « Je participe » en fetch |
| 15 min | Checklist sécurité appliquée à chaque projet |
| 10 min | Pause |
| 120 min | Atelier fetch (30 min) puis projet + validation du jalon 1 |
| 5 min | Clôture |

## S09 : Atelier projet + revue de code

| Durée | Activité |
|---|---|
| 15 min | Les erreurs vues dans les projets |
| 30 min | Revue de code croisée avec une grille |
| 10 min | Pause |
| 125 min | Travail projet, points individuels avec l'enseignante |

## S10 : Atelier projet, préparation de la soutenance

| Durée | Activité |
|---|---|
| 15 min | Préparer une soutenance : format, questions types |
| 150 min | Travail projet, répétition de démo, jalon 2 |
| 15 min | Planning des soutenances |

Si plus de 12 binômes : commencer des soutenances dans la dernière heure de S10.

## S11 : Soutenances

15 minutes par binôme, notation comprise (voir `projet/soutenance.md`). 12 binômes par séance de 3 h. Terminer par 10 minutes de bilan collectif (slides S11).
