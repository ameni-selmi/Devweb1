# Course Bible : Développement Web 1

Ce fichier est la référence unique du cours. Toute nouvelle production (slides, TP, notes) doit respecter ce qui est écrit ici. Si une décision change, on la change ici d'abord.

Conception et enseignement : **Amani Selmi, PhD-Engineer**

## 1. Cadre

| Élément | Valeur |
|---|---|
| Cours | Développement Web 1 (introduction au développement web, sans framework) |
| Durée | 11 séances de 3 h = 33 h en présentiel, plus environ 2 h de travail personnel par semaine |
| Public | Étudiants de 1re année en école d'ingénieurs (ou niveau équivalent). Ils savent programmer, mais pas forcément faire du web. |
| Langue | Cours en français. Termes techniques en anglais quand c'est l'usage : frontend, backend, request, response, endpoint, session, prepared statement, etc. |
| Évaluation proposée | Contrôle continu 60 % (cinq TP notés) + projet final 40 %. Adaptable (voir `plan/plan-semestre.md`). |

**Règle de réutilisation** : aucun nom d'établissement, aucun code de module, aucune année universitaire, aucune date absolue dans les supports. Les dates des séances s'écrivent « S01, S02... ». Les données d'exemple n'ont pas d'année.

## 2. Acquis d'apprentissage

À la fin du cours, l'étudiant est capable de :

* **AA1** : expliquer le fonctionnement du Web (client, serveur, HTTP, HTTPS) et observer les échanges dans les DevTools ;
* **AA2** : développer des pages web sémantiques, stylisées et responsive (HTML, CSS) ;
* **AA3** : programmer des interactions côté client en JavaScript (DOM, événements, fetch) ;
* **AA4** : programmer côté serveur en PHP (formulaires, sessions, code structuré en classes) ;
* **AA5** : connecter une application à une base MySQL via PDO, de façon sécurisée.

## 3. Stack technique (figée)

* HTML5 sémantique
* CSS3 sans framework (Flexbox, media queries, variables CSS ; Grid présenté seulement)
* JavaScript moderne sans bibliothèque (`const`/`let`, fonctions fléchées, `querySelector`, `addEventListener`, `fetch`, `async`/`await`)
* PHP 8.1 ou plus, sans framework, sans Composer
* MySQL ou MariaDB, via PDO uniquement, requêtes préparées uniquement
* Serveur de développement : `php -S localhost:8000` par défaut ; XAMPP, WAMP, MAMP ou Laragon acceptés (voir `fiches/installation.md`)
* Git + GitHub (ou GitLab) pour rendre les TP et le projet

**Interdits dans les TP et le projet** : Bootstrap, Tailwind, jQuery, React/Vue, Laravel/Symfony, templates tout faits, `mysql_*`, variables concaténées dans du SQL.

## 4. Les quatre règles de sécurité

Introduites au fil du cours, exigées partout ensuite.

1. **Échapper toute sortie** : fonction `e()` (= `htmlspecialchars`) sur toute donnée affichée. Introduite en S04.
2. **Hacher les mots de passe** : `password_hash()` / `password_verify()`. Introduite en S05.
3. **Vérifier l'accès côté serveur** : chaque page protégée appelle `requireLogin()`. Introduite en S05.
4. **Préparer toute requête** : PDO `prepare()` + `execute()`, jamais de variable dans la chaîne SQL. Introduite en S06.

Principe transversal : *le serveur ne fait jamais confiance au navigateur.* La validation JS est du confort, la validation PHP est obligatoire.

## 5. Application fil rouge : ClubHub

Tous les TP construisent la même application, couche par couche. **La solution de la semaine N est le starter de la semaine N+1.** Le projet final est une application différente, choisie par les étudiants.

**ClubHub** : la plateforme des clubs étudiants. Les clubs publient des événements (atelier, conférence, sortie), les étudiants s'inscrivent dans la limite des places.

| Semaine | Ce que ClubHub devient | Stockage |
|---|---|---|
| S01 | 3 pages HTML statiques : accueil, liste, détail + formulaire | aucun |
| S02 (TP1) | Pages stylisées et responsive selon une maquette | aucun |
| S03 (TP2) | Filtre et recherche en JS, validation du formulaire, compteur de caractères, mode sombre | `localStorage` (thème) |
| S04 | Pages en PHP, layout commun, événements depuis un tableau PHP, `evenement.php?id=`, formulaire validé côté serveur | tableau PHP |
| S05 (TP3) | Comptes : inscription, connexion, déconnexion. Page protégée « Mon compte ». S'inscrire à un événement demande d'être connecté. | `users.json` + session |
| S06 (TP4) | Tout dans MySQL : 3 tables, PDO, contrôle des places, « Mes inscriptions » avec JOIN | MySQL |
| S07 (TP5) | Code structuré : classes, templates, `index.php` routeur. Rôle organisateur : créer un événement, voir la liste des inscrits. | MySQL |
| S08 | « Je participe » en `fetch` sans rechargement, recherche en direct, endpoints JSON | MySQL |

Remarque pédagogique (S05) : les inscriptions aux événements sont gardées dans la session. À la déconnexion, elles disparaissent. C'est voulu : les étudiants **ressentent** le besoin d'une base de données avant S06.

### Modèle de données de référence (à partir de S06)

```sql
users(id, name, email UNIQUE, password_hash, role ENUM('student','organizer'), created_at)
events(id, title, club, description, location, starts_at DATETIME, capacity INT, organizer_id FK users)
registrations(id, user_id FK users, event_id FK events, created_at, UNIQUE(user_id, event_id))
```

### Données d'exemple (à réutiliser partout)

| id | Club | Événement | Quand (sans année) | Lieu | Places |
|---|---|---|---|---|---|
| 1 | Club Robotique | Atelier Arduino pour débutants | mercredi 14 octobre, 14 h | Salle B204 | 20 |
| 2 | Club Photo | Sortie photo en ville | samedi 17 octobre, 9 h | Entrée principale | 15 |
| 3 | Club IA | Conférence : l'IA dans l'industrie | mercredi 21 octobre, 10 h | Amphithéâtre A | 120 |
| 4 | Club Échecs | Tournoi blitz inter promo | samedi 24 octobre, 15 h | Foyer des étudiants | 32 |
| 5 | Club Entrepreneuriat | Hackathon impact social | samedi 31 octobre, 9 h | Salle C101 | 40 |

À partir de S06, les dates sont calculées par rapport au jour actuel dans `seed.sql` (par exemple `NOW() + INTERVAL 7 DAY`), pour que les événements soient toujours « à venir ».

Utilisateurs d'exemple (domaine réservé `campus.example`, qui n'existe pas) :

| Nom | Email | Rôle |
|---|---|---|
| Amine Ben Salah | `amine@campus.example` | student |
| Sarra Trabelsi | `sarra@campus.example` | student |
| Club Robotique | `robotique@campus.example` | organizer |

Mot de passe démo pour tous : `demo1234`.

### Code partagé (à garder identique d'une semaine à l'autre)

* `e(string $value): string` : échappement HTML.
* `redirect(string $url): never` : redirection + `exit`.
* `flash(string $message)` / `takeFlash()` : message affiché une fois (à partir de S05).
* `currentUser()`, `requireLogin()`, `requireRole()` (à partir de S05, S07).

## 6. Structure du dépôt

```
devweb1/
  COURSE_BIBLE.md          ← ce fichier
  README.md                ← entrée du dépôt (côté étudiant)
  PRODUCTION.md            ← workflow, état, publication
  plan/plan-semestre.md    ← plan détaillé des 11 séances
  semaines/SXX-sujet/
    README.md              ← page étudiant de la semaine
    notes-enseignant.md    ← déroulé minuté, points d'attention, questions
    slides.md              ← slides (source)
    live-coding.md         ← script de la démo en direct
    tp/ ou atelier/
      enonce.md            ← énoncé étudiant (Base / Plus / Défi)
      grille.md            ← grille de correction (TP notés)
      starter/             ← code de départ
      solution/            ← corrigé testé
  fiches/                  ← aide-mémoire d'une ou deux pages
  projet/                  ← cahier des charges, modèle, grille, soutenance
  outils/                  ← thèmes et scripts de génération
  build/                   ← fichiers générés : PPTX, DOCX, PDF, ZIP (non versionné)
```

## 7. Conventions de rédaction

* Phrases courtes, ton direct, vouvoiement collectif (« vous »).
* Termes anglais en *italique* la première fois, avec la traduction si utile.
* Code : identifiants en anglais (`$event`, `findAll()`), commentaires en français, textes affichés en français.
* Indentation : 2 espaces (HTML, CSS, JS), 4 espaces (PHP, SQL).
* Chaque énoncé suit le même plan : Objectifs → Ce qu'on vous donne → Travail demandé (Base / Plus / Défi) → Rendu → Évaluation → Aide.
* Chaque TP noté a une grille sur 20, corrigeable en 5 à 10 minutes par binôme.
* Les slides montrent les concepts (schémas, règles, pièges). Le code long se fait en live coding.

## 8. Slides

* Source : Markdown (syntaxe Marp), un fichier `slides.md` par semaine.
* Génération : `python3 outils/build_all.py` → PowerPoint **modifiable** (`.pptx`, zones de texte natives), PDF, HTML.
* 15 à 30 slides par semaine. Une idée par slide. Notes de l'orateur en commentaires `<!-- ... -->` (elles vont dans les notes du PowerPoint).
* La première slide de chaque semaine porte le nom de l'enseignante : « Amani Selmi, PhD-Engineer ».
* Classes spéciales : `titre` (slide de titre bleue), `question` (question à la salle). Encadrés : `<div class="piege">` (rouge) et `<div class="regle">` (vert).

## 9. Rythme type d'une séance (S01 à S07)

| Durée | Activité |
|---|---|
| 10 min | Retour sur la semaine précédente |
| 45 à 60 min | Concepts + live coding |
| 10 min | Pause |
| 90 à 105 min | TP / atelier en binôme |
| 10 min | Correction orale d'un point clé, annonce de la suite |

## 10. Politique IA (annoncée en S01)

Les outils d'IA sont autorisés. Chaque étudiant doit pouvoir expliquer et modifier chaque ligne de son code. La soutenance contient des questions individuelles et une modification en direct. Code non compris = code non compté.
