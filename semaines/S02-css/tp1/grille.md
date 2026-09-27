# TP1 : Grille de correction (sur 20)

Temps visé : 5 à 8 minutes par binôme. Ouvrir le site à 1280 px, puis à 390 px (DevTools, Ctrl+Shift+M), puis lire `style.css`.

**Binôme :** ................................................

| # | Critère | Points | Note |
|---|---|---|---|
| | **Organisation du CSS (4 pts)** | | |
| 1 | Variables CSS définies dans `:root` et réellement utilisées (au moins couleurs, rayon, espacement) | 2 | |
| 2 | Fichier en sections commentées, lisible, sans répétition inutile | 1 | |
| 3 | `box-sizing: border-box`, largeur max du contenu centrée | 1 | |
| | **Respect de la maquette, version ordinateur (5 pts)** | | |
| 4 | En-tête : fond, logo, navigation à droite, page actuelle soulignée, survol visible | 2 | |
| 5 | Cartes : fond, bordures, coins, ombre, club en orange majuscules | 2 | |
| 6 | Lien « Voir le détail » aligné en bas de toutes les cartes | 1 | |
| | **Responsive (5 pts)** | | |
| 7 | 1 / 2 / 3 cartes par ligne selon la largeur (mobile first : `min-width`) | 3 | |
| 8 | Pas de défilement horizontal à 360 px, texte lisible | 1 | |
| 9 | Pied de page correct | 1 | |
| | *Sous total Base* | *14* | |
| | **Plus (3 pts)** | | |
| 10 | Page événement : détail et formulaire côte à côte sur ordinateur, empilés sur mobile | 1 | |
| 11 | Formulaire stylé : labels, largeur, focus visible, bouton, radios sur une ligne | 1 | |
| 12 | Tableau stylé + en-tête responsive (centré sur mobile) | 1 | |
| | **Défi (3 pts)** | | |
| 13 | Défi(s) réalisé(s) correctement et expliqué(s) dans le README | 3 | |
| | **Pénalités** | | |
| | Attribut `style="..."` dans le HTML | −1 | |
| | Framework ou bibliothèque CSS | −5 | |
| | `!important` utilisé sans raison | −1 | |
| | Rendu en retard (par tranche de 24 h) | −2 | |
| | **Total** | **/20** | |

## Question orale (si doute sur la compréhension)

Choisir une règle au hasard dans leur fichier et demander : « Que fait cette ligne ? Que se passe-t-il si je la supprime ? » Tester en direct dans les DevTools.

Exemples de bonnes questions :

* « Pourquoi le lien est-il en bas de la carte ? » (attendu : `display: flex; flex-direction: column` sur la carte + `margin-top: auto` sur le lien)
* « Pourquoi `min-width` et pas `max-width` dans vos media queries ? » (attendu : mobile first)
* « Si je change `--color-primary`, que se passe-t-il ? »

Si l'étudiant ne peut pas expliquer une partie, les points de cette partie ne sont pas comptés.

## Repères

| Note | Ce que ça ressemble |
|---|---|
| 8 à 10 | Couleurs et polices OK, mais pas de mise en page Flexbox ou pas de responsive |
| 12 à 14 | Base complète, propre, fidèle à la maquette |
| 15 à 17 | Base + page événement en deux colonnes + formulaire soigné |
| 18 à 20 | Tout, plus un défi réussi et bien expliqué |
