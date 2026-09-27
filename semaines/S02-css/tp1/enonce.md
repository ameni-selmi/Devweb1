# TP1 (noté) : Styliser ClubHub

**Noté sur 20** · En binôme · Durée : 1 h 35 en séance
**Rendu : dépôt Git, ce soir avant 23 h 59** (le dernier commit avant l'heure limite est corrigé)

## Objectifs

* Organiser une feuille de style propre (variables, sections, commentaires).
* Maîtriser le box model et Flexbox.
* Rendre un site responsive avec une approche *mobile first*.

## Ce qu'on vous donne

Dans `tp1/starter/` :

* les trois pages HTML de ClubHub (`index.html`, `evenements.html`, `evenement.html`), déjà reliées à `css/style.css` ;
* un fichier `css/style.css` vide.

Dans `tp1/maquette/` : six captures d'écran, les trois pages en version ordinateur (1280 px) et téléphone (390 px).

Vous pouvez utiliser vos propres pages de l'atelier S01 à la place, à condition qu'elles contiennent les mêmes éléments.

## Règles

* **Un seul fichier CSS** : `css/style.css`. Aucun attribut `style="..."` dans le HTML.
* **Aucun framework, aucune bibliothèque** : pas de Bootstrap, pas de Tailwind, pas de template trouvé en ligne.
* Vous pouvez **ajouter des classes** dans le HTML si besoin. Vous ne devez pas changer le contenu ni la structure sémantique.
* La maquette est une référence, pas un pixel parfait. Les couleurs, espacements et proportions doivent être proches.

## Travail demandé

### Base (jusqu'à 14/20)

1. **Organisation** : en haut du fichier, définissez des **variables CSS** (`:root`) pour au moins les couleurs, le rayon des coins et l'espacement. Utilisez les ensuite partout. Séparez le fichier en sections commentées.
2. **Base** : `box-sizing: border-box` pour tous les éléments, une police sans empattement, une largeur maximale pour le contenu (environ 1100 px, centré).
3. **En-tête** : fond bleu, logo et navigation. Le lien de la page actuelle est souligné en orange (utilisez le sélecteur `a[aria-current="page"]`). Le survol des liens est visible.
4. **Cartes d'événements** : fond blanc, bordure fine, bordure haute bleue, coins arrondis, ombre légère. Le nom du club en petites majuscules orange. Le lien « Voir le détail » est **toujours en bas de la carte**, même si les cartes n'ont pas la même hauteur.
5. **Mise en page des cartes avec Flexbox** :
   * téléphone : 1 carte par ligne ;
   * à partir de 640 px : 2 cartes par ligne ;
   * à partir de 960 px : 3 cartes par ligne.
6. **Pied de page** : fond sombre, texte centré.
7. **Aucune barre de défilement horizontale** à 360 px de large.

### Plus (jusqu'à 17/20)

8. **Page événement** : sur ordinateur (≥ 960 px), le détail et le formulaire sont **côte à côte** (le détail plus large que le formulaire). Sur téléphone, l'un sous l'autre.
9. **Formulaire** : champs sur toute la largeur, labels en gras au dessus des champs, focus visible (bordure ou contour bleu), bouton « S'inscrire » dans le style des boutons du site. Les boutons radio et la case à cocher restent sur la même ligne que leur texte.
10. **Tableau** récapitulatif : en-tête bleu, une ligne sur deux légèrement grisée.
11. **En-tête responsive** : sur téléphone, logo et navigation centrés l'un sous l'autre ; sur tablette et plus, logo à gauche, navigation à droite.

### Défi (jusqu'à 20/20)

Choisissez **un** défi (ou plus) :

* **Formulaire collant** : sur ordinateur, le bloc formulaire reste visible quand on fait défiler la page (`position: sticky`).
* **Grid** : refaites la liste des cartes avec CSS Grid et `auto-fill` + `minmax()`, sans aucune media query pour les cartes. Expliquez en commentaire la différence avec votre version Flexbox.
* **Accessibilité** : vérifiez le contraste de toutes les couleurs de texte (ratio ≥ 4,5:1) avec les DevTools. Notez les ratios dans un fichier `accessibilite.md`, et corrigez ce qui ne passe pas.
* **Impression** : ajoutez `@media print` pour que la page d'un événement s'imprime proprement (pas de navigation, pas de formulaire, texte noir sur blanc).

## Rendu

1. Dans votre dépôt `clubhub`, le dossier contient `index.html`, `evenements.html`, `evenement.html` et `css/style.css`.
2. Un fichier `README.md` avec : les noms du binôme, les défis choisis, et **une chose** que vous avez apprise dans ce TP.
3. Dernier commit avant 23 h 59. L'enseignante corrige ce commit.

## Comment vous serez évalués

Voir la grille dans `grille.md`. En résumé : respect de la maquette, qualité et organisation du CSS, responsive, et respect des règles. **Un CSS copié d'un template ou généré sans être compris** sera repéré à l'oral (l'enseignante peut vous demander d'expliquer une règle) et donnera 0 sur les points concernés.

## Aide

* Fiche : `fiches/css-essentiel.md`
* MDN, Flexbox : https://developer.mozilla.org/fr/docs/Learn/CSS/CSS_layout/Flexbox
* S'entraîner : https://flexboxfroggy.com/#fr
* Tester : F12 → mode responsive (Ctrl+Shift+M)
