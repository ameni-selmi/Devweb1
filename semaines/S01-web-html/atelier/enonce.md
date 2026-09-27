# Atelier S01 : ClubHub, version 0 (HTML pur)

**Non noté** · En binôme · Durée : 1 h 10 en séance + travail personnel

## Objectifs

* Écrire des pages HTML valides et **sémantiques**.
* Construire un formulaire correct (labels, `name`, types adaptés).
* Relier des pages entre elles.

## Contexte

Pendant tout le cours, vous allez construire **ClubHub**, la plateforme des clubs étudiants : les clubs publient des événements, les étudiants s'inscrivent. Aujourd'hui, vous créez la version 0 : trois pages statiques, **sans CSS**.

## Travail demandé

### Base (tout le monde)

Créez un dossier `clubhub/` avec trois fichiers.

**1. `index.html` : accueil**
* Un `header` avec le nom « ClubHub » et une `nav` vers les trois pages.
* Un `main` avec : un `h1`, une phrase de présentation, une section « Prochains événements » avec **2 événements** (titre, club, date, lien vers la page de l'événement).
* Un `footer` (nom du site et une courte phrase).

**2. `evenements.html` : tous les événements**
* Même `header` et même `footer`.
* Les **5 événements** ci-dessous, chacun dans un `article` avec : titre, club, date et heure (balise `<time>`), lieu, nombre de places, lien « Voir le détail ».

| Club | Événement | Date | Lieu | Places |
|---|---|---|---|---|
| Club Robotique | Atelier Arduino pour débutants | 14/10, 14 h | Salle B204 | 20 |
| Club Photo | Sortie photo en ville | 17/10, 9 h | Entrée principale | 15 |
| Club IA | Conférence : l'IA dans l'industrie | 21/10, 10 h | Amphithéâtre A | 120 |
| Club Échecs | Tournoi blitz inter promo | 24/10, 15 h | Foyer des étudiants | 32 |
| Club Entrepreneuriat | Hackathon impact social | 31/10, 9 h | Salle C101 | 40 |

**3. `evenement.html` : détail d'un événement (Atelier Arduino)**
* Titre, club, date, lieu, places, une description de 3 ou 4 lignes.
* Une liste « Au programme » (`ul`) et « À apporter » (`ul`).
* Un **formulaire d'inscription** envoyé en `POST` vers `inscription.php` (le fichier n'existe pas encore, c'est normal) :
  * nom complet (texte, obligatoire, 3 caractères minimum)
  * email (obligatoire)
  * niveau d'études (`select` : 1re année, 2e année, 3e année)
  * « Avez vous déjà utilisé un Arduino ? » (boutons `radio` oui / non)
  * motivation (`textarea`, facultatif)
  * case à cocher « J'accepte le règlement du club » (obligatoire)
  * bouton « S'inscrire »

Chaque champ a un `label` relié, et un attribut `name`.

### Plus

* Sur `evenements.html`, ajoutez aussi un **tableau** récapitulatif (événement, date, places) avec `thead` et `tbody`.
* Ajoutez une image (n'importe laquelle, libre de droits) avec un vrai texte `alt`.
* Vos trois pages passent le validateur **validator.w3.org** sans erreur.

### Défi

* Ouvrez F12 → Network, soumettez le formulaire. Trouvez la requête `POST`, et dans l'onglet *Payload* retrouvez vos données. Que se passe-t-il si un champ n'a pas d'attribut `name` ? Notez la réponse dans un fichier `reponses.md`.
* Changez `method="post"` en `method="get"`. Où sont les données maintenant ? Pourquoi est-ce une mauvaise idée pour un mot de passe ?

## Rendu

* Créez un dépôt Git `clubhub` (GitHub ou GitLab), ajoutez l'enseignante.
* Poussez vos trois pages avant la séance S02.
* Ces pages sont le point de départ du **TP1 noté**. Si vous n'avez pas fini, vous pourrez partir du corrigé.

## Aide

* MDN, les éléments HTML : https://developer.mozilla.org/fr/docs/Web/HTML/Element
* MDN, les formulaires : https://developer.mozilla.org/fr/docs/Learn/Forms
* Fiche : `fiches/html-essentiel.md`
