# Course Bible : Développement Web 1

Ce fichier est la référence unique du cours. Toute nouvelle production (slides, TP, notes) doit respecter ce qui est écrit ici. Si une décision change, on la change ici d'abord.

## 1. Cadre

| Élément | Valeur |
|---|---|
| Module | Développement Web (ECUE U1.4.2), S1, cycle ingénieur, tronc commun |
| Durée réelle | 11 semaines × 3 h = 33 h (la fiche prévoit 45 h) |
| Public | 1re année ingénieur, souvent avec une licence en informatique. Savent programmer, pas forcément faire du web. |
| Langue | Cours en français. Termes techniques en anglais quand c'est l'usage : frontend, backend, request, response, endpoint, session, prepared statement, etc. |
| Évaluation (fiche) | Contrôle continu 60 % (TP1 à TP3 : 30 %, TP4 et TP5 : 30 %) + Projet final 40 % |

## 2. Stack technique (figée)

* HTML5 sémantique
* CSS3 sans framework (Flexbox, media queries, variables CSS ; Grid présenté seulement)
* JavaScript moderne sans bibliothèque (`const`/`let`, fonctions fléchées, `querySelector`, `addEventListener`, `fetch`, `async`/`await`)
* PHP 8.2 ou plus, sans framework, sans Composer
* MySQL ou MariaDB, via PDO uniquement, requêtes préparées uniquement
* Serveur de développement : `php -S localhost:8000` par défaut ; XAMPP accepté si c'est ce qui est installé en salle
* Git + GitHub (ou GitLab) pour rendre les TP et le projet

**Interdits dans les TP et le projet** : Bootstrap, Tailwind, jQuery, React/Vue, Laravel/Symfony, templates tout faits, `mysql_*`, concaténation de variables dans du SQL.

## 3. Les quatre règles de sécurité

Elles sont introduites au fil du cours et exigées partout ensuite.

1. **Échapper toute sortie** : `htmlspecialchars()` (fonction `e()` du cours) sur toute donnée affichée. Introduite en S04.
2. **Préparer toute requête** : PDO `prepare()` + `execute()`, jamais de variable dans la chaîne SQL. Introduite en S06.
3. **Hacher les mots de passe** : `password_hash()` / `password_verify()`. Introduite en S05.
4. **Vérifier l'accès côté serveur** : chaque page protégée vérifie la session elle-même. Introduite en S05.

Principe transversal : *le serveur ne fait jamais confiance au navigateur.* La validation JS est du confort, la validation PHP est obligatoire.

## 4. Application fil rouge : ClubHub

Tous les TP construisent la même application, couche par couche. Le projet final est une application différente, choisie par les étudiants.

**ClubHub** : la plateforme des clubs de l'école. Les clubs publient des événements (atelier, conférence, sortie), les étudiants s'inscrivent dans la limite des places.

| Semaine | Ce que ClubHub devient |
|---|---|
| S01 | 3 pages HTML statiques : accueil, liste des événements, page d'un événement avec formulaire d'inscription |
| S02 (TP1) | Les mêmes pages stylisées et responsive selon une maquette |
| S03 (TP2) | Filtre des événements en JS, validation du formulaire, compteur de places, mode sombre |
| S04 | Pages en PHP, layout commun avec `include`, formulaire traité côté serveur |
| S05 (TP3) | Inscription / connexion / déconnexion, espace « Mes inscriptions » protégé |
| S06 (TP4) | Données dans MySQL : événements et utilisateurs, requêtes préparées |
| S07 (TP5) | Code structuré : classes `Database`, `EventRepository`, templates, `index.php` routeur, table `registrations` avec JOIN |
| S08 | Bouton « Je participe » en `fetch` + endpoint JSON, sans rechargement |

### Modèle de données de référence (à partir de S06)

```sql
users(id, name, email UNIQUE, password_hash, role ENUM('student','organizer'), created_at)
events(id, title, description, club, location, starts_at DATETIME, capacity INT, organizer_id FK users)
registrations(id, user_id FK users, event_id FK events, created_at, UNIQUE(user_id, event_id))
```

### Données d'exemple (à réutiliser partout, pour la cohérence)

| Club | Événement | Lieu | Places |
|---|---|---|---|
| Club Robotique | Atelier Arduino pour débutants | Salle B204 | 20 |
| Club Photo | Sortie photo à la médina | Départ : entrée principale | 15 |
| IEEE Student Branch | Conférence : l'IA dans l'industrie | Amphi A | 120 |
| Club Échecs | Tournoi blitz inter promo | Foyer | 32 |
| Enactus | Hackathon impact social | Salle C101 | 40 |

Utilisateurs d'exemple : `amine@ecole.tn`, `sarra@ecole.tn` (student), `club.robotique@ecole.tn` (organizer). Mot de passe démo : `demo1234`.

## 5. Structure du dépôt

```
devweb1/
  COURSE_BIBLE.md          ← ce fichier
  README.md                ← entrée du dépôt (côté étudiant)
  PRODUCTION.md            ← suivi de ce qui est produit / à produire
  plan/plan-semestre.md    ← plan détaillé des 11 semaines
  semaines/SXX-sujet/
    README.md              ← page étudiant de la semaine (objectifs, liens)
    notes-enseignant.md    ← déroulé minuté, points d'attention, questions à poser
    slides.md              ← slides Marp (source éditable)
    live-coding.md         ← script de la démo en direct
    tp/ ou atelier/
      enonce.md            ← énoncé étudiant (niveaux Base / Plus / Défi)
      grille.md            ← grille de correction (TP notés seulement)
      starter/             ← code de départ donné aux étudiants
      solution/            ← corrigé (publié après la séance)
  fiches/                  ← aide-mémoire d'une page
  projet/                  ← cahier des charges, grille, soutenance
  outils/                  ← thème Marp, script de build
  build/                   ← PDF et HTML générés (non versionné)
```

## 6. Conventions de rédaction

* Phrases courtes, ton direct, tutoiement non ; vouvoiement collectif (« vous »).
* Termes anglais en *italique* la première fois dans une semaine, avec la traduction si utile : *request* (requête).
* Code : identifiants en anglais (`$event`, `findAll()`), commentaires en français, textes affichés en français.
* Indentation 2 espaces (HTML, CSS, JS), 4 espaces (PHP, SQL).
* Chaque énoncé suit le même plan : Objectifs → Ce qu'on vous donne → Travail demandé (Base / Plus / Défi) → Rendu → Critères.
* Chaque TP noté a une grille sur 20, corrigeable en 5 à 10 minutes par binôme pendant la séance.
* Les slides montrent les concepts (schémas, règles, pièges). Le code long se fait en live coding, pas sur slide.

## 7. Format des slides

* Source : Markdown Marp (`slides.md`), thème `outils/theme-devweb.css`.
* Build : `bash outils/build.sh` → `build/SXX.pdf` et `build/SXX.html`.
* 15 à 25 slides par semaine. Une idée par slide. Notes de l'orateur en commentaires HTML `<!-- ... -->`.

## 8. Rythme type d'une séance (S01 à S07)

| Durée | Activité |
|---|---|
| 10 min | Retour sur la semaine précédente, question flash |
| 45 à 60 min | Concepts + live coding |
| 10 min | Pause |
| 90 à 105 min | TP / atelier en binôme, enseignant qui circule |
| 10 min | Correction orale d'un point clé, annonce de la suite |

Pour les TP notés : la correction se fait par checklist pendant les 30 dernières minutes, ou à partir du dépôt Git rendu avant minuit le jour même.

## 9. Politique IA (annoncée en S01)

Les outils d'IA sont autorisés. Mais chaque étudiant doit pouvoir expliquer et modifier chaque ligne de son code. La soutenance contient des questions individuelles et une petite modification en direct. Code non compris = code non compté.
