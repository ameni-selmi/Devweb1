# Projet final : cahier des charges

**40 % de la note finale** · En binôme · Distribué en S04, soutenance en S11

## L'idée

Vous avez construit ClubHub avec l'enseignant, étape par étape. Maintenant, vous construisez **votre propre application**, seuls, avec les mêmes fondamentaux.

On ne veut pas un énième site « ajouter / modifier / supprimer ». On veut une application qui **sert à quelqu'un**, qui a **une idée à elle**, et que vous serez fiers de montrer.

La technique reste simple (HTML, CSS, JavaScript, PHP, MySQL, sans framework). La créativité est dans **ce que vous en faites**.

## Les quatre règles

### Règle 1 : un vrai utilisateur

Votre application est pensée pour une personne ou un groupe réel : un club, une association, votre promo, un enseignant, un commerce de votre quartier, votre famille, une équipe de sport...

Dans votre proposition, vous écrivez : **qui** va l'utiliser, **quel problème** elle résout, et **pourquoi** les outils actuels (un groupe WhatsApp, une feuille Excel, un Google Form) ne suffisent pas.

### Règle 2 : une mécanique centrale, au delà du CRUD

Ajouter, modifier, supprimer des éléments, c'est la base, pas le projet. Votre application doit avoir **au moins une mécanique** intéressante : quelque chose qui est **calculé, joué, apparié, classé, planifié ou visualisé**.

C'est ici que votre formation d'ingénieur compte : mettez de la vraie logique dans cette mécanique.

### Règle 3 : seulement les fondamentaux

HTML, CSS, JavaScript, PHP 8, MySQL via PDO. **Interdits** : frameworks et bibliothèques CSS (Bootstrap, Tailwind), bibliothèques JS (jQuery, React, Vue), frameworks PHP (Laravel, Symfony), templates tout faits.

Exception possible, **sur demande écrite** dans la proposition : une petite bibliothèque pour une tâche très précise (par exemple dessiner un graphique). L'enseignant accepte ou refuse.

### Règle 4 : vous devez tout comprendre

L'IA est autorisée. Mais pendant la soutenance, **chacun** de vous doit pouvoir expliquer n'importe quelle partie du code et le modifier en direct. Code non compris = code non compté.

## Exemples d'idées

Ces exemples servent à vous inspirer. Vous pouvez en prendre un, mais une idée à vous est **mieux**.

| Application | Mécanique centrale |
|---|---|
| Binômes de révision | Appariement d'étudiants selon les matières et les créneaux libres communs |
| Réservation du matériel du labo | Détection des conflits de réservation, calendrier de disponibilité |
| Quiz en direct pour un cours | Questions minutées, scores, classement en direct (fetch) |
| Jeu tour par tour à deux (morpion, bataille navale, puissance 4) | Règles du jeu côté serveur, le JS interroge le serveur pour le coup de l'adversaire |
| Mur de questions anonymes pour un amphi | Votes, classement des questions, modération par l'enseignant |
| Suivi d'habitudes | Séries (*streaks*), statistiques, graphique en SVG |
| Escape game web | Énigmes, progression enregistrée, indices qui coûtent des points |
| Covoiturage pour aller à l'école | Correspondance trajets / passagers, places restantes |
| Tournoi sportif ou e-sport de l'école | Génération du tableau (poules, élimination), saisie des scores, classement |
| Partage des dépenses en colocation | Calcul de qui doit combien à qui, en minimisant les remboursements |
| Planning des gardes d'une pharmacie de quartier | Répartition équitable, contraintes d'indisponibilité |
| Raccourcisseur de liens pour un club | Génération de codes, statistiques de visites par jour |

**Idées refusées** (trop génériques, sauf mécanique très originale) : blog simple, boutique en ligne simple, gestion de bibliothèque simple, to do list, clone d'un réseau social.

## Exigences techniques

### Niveau Base (obligatoire, vise environ 10 à 12 / 20)

* HTML sémantique et valide, CSS **responsive** sans framework.
* Au moins **une interaction JavaScript** utile (filtre, validation, affichage dynamique...).
* Au moins un formulaire traité en PHP, avec **validation côté navigateur ET côté serveur**, et des messages d'erreur clairs.
* **Inscription et connexion**, mots de passe **hachés**, au moins une page **protégée**.
* Une base MySQL d'**au moins 3 tables**, utilisée via **PDO avec requêtes préparées**.
* Les **quatre règles de sécurité** partout (voir `fiches/securite-checklist.md`).
* Code sur **Git**, avec des commits réguliers des **deux** membres du binôme.

### Niveau Solide (vise jusqu'à environ 15 / 20)

* Code structuré : classes d'accès aux données, templates, un point d'entrée (`index.php`) comme en S07.
* Au moins une relation entre tables exploitée avec un **JOIN**.
* La **mécanique centrale** fonctionne bien et va clairement au delà du CRUD.
* Gestion propre des cas d'erreur : champ vide, id inexistant, doublon, accès refusé.

### Niveau Avancé (pour aller vers 16 à 20 / 20) : une ou deux options

* Une fonctionnalité en **fetch** + endpoint JSON, sans rechargement de page.
* **Rôles** (par exemple utilisateur / administrateur) avec des droits différents, vérifiés côté serveur.
* Votre propre **mini framework** réutilisable : routeur, rendu de templates, validation des formulaires. Il doit être documenté et utilisé partout dans l'application.
* Une **visualisation** de données en SVG ou `<canvas>`, écrite à la main.
* Un **audit d'accessibilité** (contraste, clavier, lecteur d'écran) avec corrections documentées.
* **Mise en ligne** sur un hébergement réel, avec une URL fonctionnelle le jour de la soutenance.

Faire plus d'options ne remplace pas une Base incomplète. Une Base propre vaut mieux que cinq options cassées.

## Calendrier

| Semaine | Étape | Ce que vous rendez |
|---|---|---|
| S04 | Lancement | Former les binômes. Commencer à chercher une idée et un utilisateur. |
| **S06** | **Proposition** (avant dimanche 23 h 59) | Une page : voir `proposition-modele.md`. L'enseignant valide ou demande des changements en S07. |
| **S08** | **Jalon 1** (en séance) | Schéma de la base créé, pages principales en place, connexion qui fonctionne, dépôt Git à jour. |
| S09 | Revue de code croisée | Vous relisez le projet d'un autre binôme avec une grille, il relit le vôtre. |
| **S10** | **Jalon 2** (en séance) | Fonctionnalités **gelées**. README complet. Démo répétée. |
| **S11** | **Soutenance** | Dernier commit avant le début de la séance S11. |

Chaque jalon manqué : **−1 point** sur la note du projet.

## Livrables

Dans votre dépôt Git :

1. Tout le code de l'application.
2. `database/schema.sql` : création des tables. `database/seed.sql` : des données d'exemple réalistes (au moins 10 lignes dans les tables principales).
3. `config.example.php` : modèle de configuration (le vrai `config.php` avec les mots de passe n'est **pas** dans Git).
4. `README.md` avec :
   * le nom de l'application, l'utilisateur visé et le problème résolu (5 lignes max) ;
   * les comptes de démonstration (email + mot de passe) ;
   * comment installer et lancer le projet (étapes précises) ;
   * le schéma de la base (tables, clés, relations : un dessin ou une liste) ;
   * **le trajet d'une requête** : choisissez une action (par exemple « l'utilisateur clique sur Réserver »), et décrivez tout ce qui se passe, du clic jusqu'à la base de données et retour à l'écran. Nommez les fichiers et les fonctions ;
   * les options Avancé réalisées ;
   * qui a fait quoi dans le binôme.

## Soutenance (12 minutes par binôme)

1. **Démo** (4 min) : montrez l'application et surtout sa mécanique centrale.
2. **Questions individuelles** (5 min) : chaque membre répond **seul**. Exemples : « Où arrivent les données de ce formulaire ? », « Que se passe-t-il si je supprime ce `prepare` ? », « Où est vérifié que cette page est protégée ? », « Ouvrez les DevTools et montrez la requête quand je clique ici. »
3. **Modification en direct** (3 min) : l'enseignant demande une petite modification (par exemple « ajoutez un champ à ce formulaire et enregistrez le en base »). Un membre, choisi par l'enseignant, la fait.

## Notation

Voir `grille.md`. En résumé : **14 points pour le produit** (commun au binôme) et **6 points pour la soutenance individuelle**. Les deux membres d'un binôme peuvent donc avoir des notes différentes.
