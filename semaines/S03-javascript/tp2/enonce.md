# TP2 (noté) : ClubHub interactif

**Noté sur 20** · En binôme · Durée : 1 h 40 en séance
**Rendu : dépôt Git, ce soir avant 23 h 59**

## Objectifs

* Sélectionner et modifier des éléments du DOM.
* Réagir aux événements (`input`, `change`, `click`, `submit`).
* Valider un formulaire côté navigateur avec des messages clairs.
* Mémoriser une préférence avec `localStorage`.

## Ce qu'on vous donne

Dans `tp2/starter/` : ClubHub stylé (corrigé du TP1), avec quelques ajouts dans le HTML et le CSS :

* un bouton `.theme-toggle` dans l'en-tête de chaque page ;
* sur `evenements.html` : un formulaire `.filters` (recherche `#search`, club `#club-filter`, tri `#sort`), un paragraphe `.results-count` et un message `.empty-message` (caché) ;
* chaque carte a des attributs `data-club`, `data-date` et `data-places` ;
* sur `evenement.html` : le formulaire a l'id `#registration-form`. Sous chaque champ se trouve un `<small class="field-error" id="...-error">` vide, et sous la motivation un compteur `#motivation-count` ;
* les classes CSS `.is-invalid`, `.field-error`, `.counter`, `.is-near-limit` sont déjà stylées ;
* un fichier `js/app.js` vide, déjà chargé par toutes les pages.

## Règles

* Tout votre code est dans `js/app.js`. **Aucun** `onclick="..."` dans le HTML.
* Pas de jQuery, pas de bibliothèque.
* `const` et `let` seulement, jamais `var`. Comparaisons avec `===`.
* Pour afficher du texte : `textContent`, jamais `innerHTML` avec une donnée saisie.
* Vous pouvez modifier le HTML et le CSS si besoin, mais expliquez pourquoi dans le README.
* La console (F12) ne doit afficher **aucune erreur**, sur aucune page.

## Travail demandé

### Base (jusqu'à 14/20)

**Page `evenements.html`**

1. **Recherche** : quand on tape dans `#search`, seules les cartes dont le texte contient la recherche restent visibles. La recherche ignore les majuscules (« ARDUINO » trouve « Arduino »).
2. **Filtre par club** : quand on choisit un club dans `#club-filter`, seules ses cartes restent visibles. « Tous les clubs » affiche tout. La recherche et le filtre fonctionnent **ensemble**.
3. **Compteur de résultats** : `.results-count` affiche « 3 événements affichés » (et « 1 événement affiché » au singulier). Si aucune carte ne correspond, `.empty-message` apparaît.

**Page `evenement.html`**

4. **Validation à l'envoi** : quand on clique sur « S'inscrire », vérifiez :
   * nom : au moins 3 caractères (sans compter les espaces au début et à la fin) ;
   * email : non vide et au bon format ;
   * niveau : une option choisie ;
   * règlement : case cochée.

   Pour chaque champ invalide : afficher le message dans le `<small>` correspondant, et ajouter la classe `is-invalid` au champ. Si un champ est invalide, le formulaire **n'est pas envoyé**.
5. **Correction** : quand l'utilisateur corrige un champ invalide, son message disparaît sans attendre un nouvel envoi.
6. **Formulaire valide** : comme il n'y a pas encore de serveur, empêchez l'envoi et affichez le paragraphe `.form-success`.

### Plus (jusqu'à 17/20)

7. **Compteur de caractères** : `#motivation-count` affiche « 42 / 300 » pendant la saisie. À partir de 90 % de la limite, ajoutez la classe `is-near-limit`.
8. **Mode sombre** :
   * dans le CSS, complétez la règle `[data-theme="dark"]` en redéfinissant les variables de couleur (environ 6 lignes) ;
   * le bouton `.theme-toggle` bascule entre clair et sombre en changeant `document.documentElement.dataset.theme`. Son texte devient « Mode clair » ou « Mode sombre » ;
   * le choix est **mémorisé** dans `localStorage` et appliqué sur toutes les pages, même après fermeture du navigateur.
9. **Tri** : `#sort` trie les cartes visibles par date ou par nombre de places (du plus grand au plus petit), sans casser le filtre.
10. **Accessibilité** : le premier champ invalide reçoit le focus ; les champs invalides ont `aria-invalid="true"`.

### Défi (jusqu'à 20/20)

Choisissez **un** défi (ou plus) :

* **Favoris** : ajoutez une étoile sur chaque carte. Un clic la met en favori (mémorisé dans `localStorage`). Ajoutez une case « Seulement mes favoris » dans les filtres.
* **Cartes générées** : supprimez les 5 cartes du HTML. Écrivez un tableau d'objets JavaScript avec les 5 événements, et générez les cartes avec `createElement`. Le filtre doit toujours fonctionner. Expliquez en commentaire pourquoi c'est une étape vers ce que fera le serveur.
* **Accents** : la recherche « echecs » trouve « Échecs » (indice : `normalize('NFD')`).
* **Pas de flash** : au chargement d'une page en mode sombre, la page s'affiche un court instant en clair. Trouvez pourquoi et corrigez le. Expliquez dans le README.

## Rendu

1. Dans votre dépôt `clubhub` : `js/app.js`, les pages HTML et `css/style.css` à jour.
2. Dans `README.md`, ajoutez une section « TP2 » : les défis choisis, et **une** erreur de console que vous avez rencontrée et comment vous l'avez corrigée.
3. Dernier commit avant 23 h 59.

## Évaluation

Voir `grille.md`. L'enseignante peut vous demander d'expliquer une fonction de votre code. Code non compris = points non comptés.

## Aide

* Fiche : `fiches/javascript-pour-programmeurs.md`
* MDN, le DOM : https://developer.mozilla.org/fr/docs/Web/API/Document_Object_Model
* MDN, `addEventListener` : https://developer.mozilla.org/fr/docs/Web/API/EventTarget/addEventListener
* Rien ne se passe ? F12 → Console. Lisez l'erreur : elle donne le fichier et la ligne.
