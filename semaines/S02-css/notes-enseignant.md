# S02 : Notes pour l'enseignante

## Objectif de la séance

À la fin, chaque étudiant doit pouvoir :

1. expliquer pourquoi une règle CSS gagne sur une autre ;
2. lire le box model d'un élément dans les DevTools ;
3. placer des éléments avec Flexbox ;
4. écrire une mise en page *mobile first* avec des media queries.

Le message clé : **le CSS se débogue dans les DevTools, pas en devinant.**

## Préparation

* [ ] Vérifier que le dossier `tp1/starter/` est bien dans le dépôt du cours, avec les maquettes.
* [ ] Imprimer la grille (`tp1/grille.md`) ou la préparer en tableur, une ligne par binôme.
* [ ] Avoir `tp1/solution/` ouvert dans un onglet (pour montrer, pas pour distribuer).
* [ ] Préparer un dossier vide `demo-css/` avec un `index.html` simple pour le live coding.

## Déroulé minuté

| Temps | Activité | Remarques |
|---|---|---|
| 0:00 | Retour S01 | 2 ou 3 erreurs vues dans les dépôts (titres, labels, `name`). Rappel : ceux qui n'ont pas fini partent du starter. |
| 0:10 | Slides 1 à 7 : sélecteurs, cascade, unités, variables | Aller vite sur les sélecteurs, ils connaissent souvent. |
| 0:20 | Live coding partie 1 : box model | Voir `live-coding.md`. |
| 0:30 | Slides 8 à 14 + live coding partie 2 : Flexbox | Le moment le plus important. Prendre le temps. |
| 0:50 | Slides 15 à 19 + live coding partie 3 : responsive | |
| 1:05 | Pause | |
| 1:15 | Présentation du TP1 (slide 20), lecture de l'énoncé ensemble | 5 min. Montrer les maquettes. Insister : mobile first, un seul fichier, pas de framework. |
| 1:20 | **TP1** | Circuler. Pousser les étudiants à utiliser les DevTools avant de vous appeler. |
| 2:50 | Clôture | Rappeler l'heure limite. Annoncer S03 : JavaScript, sur ces mêmes pages. |

## Points d'attention

* **Le lien en bas de la carte** est le petit « problème Flexbox » du TP. Beaucoup vont essayer `position: absolute` ou des `margin` fixes. Laisser chercher 10 min, puis donner l'indice : « la carte elle même peut être un conteneur flex ».
* **`calc(50% - gap)`** : les étudiants mettent souvent `width: 50%` et ne comprennent pas pourquoi la 2e carte passe à la ligne. Montrer dans les DevTools que le `gap` s'ajoute.
* **Mobile first** : beaucoup écrivent d'abord pour ordinateur, puis des `max-width`. Ce n'est pas faux, mais c'est demandé dans le TP. Expliquer pourquoi (on ajoute des règles au lieu d'en annuler).
* **Copier coller depuis l'IA** : un CSS de 600 lignes avec des animations et des classes qui n'existent pas dans le HTML est un signe. Poser la question orale de la grille.
* **`:has()`** : utilisé dans le corrigé pour la case à cocher. Il est supporté par tous les navigateurs récents. Les étudiants peuvent aussi ajouter une classe au label, c'est accepté.

## Correction

Deux options, selon la taille du groupe :

* **Pendant la séance** (petits groupes) : à partir de 2:20, passer voir chaque binôme avec la grille. 5 min par binôme.
* **Sur le dépôt Git** (gros groupes) : corriger le commit de 23 h 59. Utiliser la grille. Poser les questions orales au début de S03 aux binômes qui posent doute.

Retour à faire au début de S03 : les 3 erreurs les plus fréquentes, et montrer une ou deux belles réalisations (avec l'accord des étudiants).

## Erreurs fréquentes

| Erreur | Réaction |
|---|---|
| Styles dans `style="..."` | Rappel de la règle, pénalité dans la grille |
| Les cartes débordent sur mobile | DevTools → trouver l'élément trop large (souvent une `width` fixe en px) |
| Le CSS ne s'applique pas | Mauvais chemin dans `<link>`, cache du navigateur (Ctrl+Shift+R), faute de frappe dans la classe |
| Media query sans effet | Oubli de la balise `viewport`, ou règle écrite **avant** la règle de base (la cascade gagne) |
| `outline: none` sur les champs | Accessibilité : demander un focus visible |
