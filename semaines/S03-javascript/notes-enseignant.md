# S03 : Notes pour l'enseignante

## Objectif de la séance

À la fin, chaque étudiant doit pouvoir :

1. trouver un élément du DOM et le modifier ;
2. brancher un écouteur d'événement et utiliser `preventDefault()` ;
3. valider un formulaire avec ses propres messages ;
4. lire une erreur dans la console et la corriger seul.

Le message clé : **JavaScript s'exécute chez l'utilisateur. Il améliore l'expérience, il ne protège rien.**

## Préparation

* [ ] Publier `tp2/starter/` dans le dépôt du cours (le corrigé TP1 est donc public, c'est normal).
* [ ] Préparer le dossier de démo `live-coding/demo/` (fichiers donnés dans `live-coding.md`).
* [ ] Avoir le retour du TP1 : 3 erreurs fréquentes, 1 ou 2 beaux rendus à montrer (avec accord).
* [ ] Grille TP2 imprimée ou en tableur.

## Déroulé minuté

| Temps | Activité | Remarques |
|---|---|---|
| 0:00 | Retour TP1 | Erreurs fréquentes, questions orales en attente de la correction. |
| 0:10 | Slides 1 à 8 : JS pour programmeurs | Aller vite. Insister sur `===`, `"5" + 1`, `const`, les fonctions comme valeurs. |
| 0:25 | Slides 9 à 14 : le DOM | Faire tester `document.querySelector('h1').textContent = 'Coucou'` dans la console, sur n'importe quel site. Effet garanti. |
| 0:35 | Live coding partie 1 et 2 | Voir `live-coding.md`. |
| 1:00 | Slides 15 à 21 : événements, validation, localStorage | |
| 1:10 | Pause | |
| 1:20 | Présentation du TP2 (slide 22) | 5 min. Montrer les ajouts du starter : `data-*`, `<small>` d'erreur. |
| 1:25 | **TP2** | Circuler. Première question à chaque appel : « la console dit quoi ? » |
| 2:50 | Clôture | Annoncer S04 : le serveur arrive. Demander d'installer PHP avant la séance (fiche `installation.md`). |

## Points d'attention

* **`null` partout** : l'erreur n° 1 est `Cannot read properties of null`. Soit le sélecteur est faux, soit l'élément n'existe pas sur **cette** page. Leur apprendre à lire la ligne de l'erreur, puis à tester le sélecteur dans la console.
* **Un fichier, trois pages** : le même `app.js` tourne partout. Sans `if (form)`, le code de la page événement plante sur l'accueil. C'est une bonne occasion de parler de programmation défensive.
* **Recherche + filtre ensemble** : beaucoup écrivent deux écouteurs qui cachent les cartes chacun de leur côté, et le dernier gagne. La bonne idée : **une** fonction `update()` qui lit l'état des deux champs et décide pour chaque carte.
* **`hidden` et Flexbox** : `display: flex` sur la carte écrase l'attribut `hidden`. D'où la règle `[hidden] { display: none !important; }` dans le CSS du starter. Le montrer si quelqu'un bloque.
* **`innerHTML`** : les étudiants qui ont appris le JS en ligne l'utilisent partout. Dire que c'est interdit ici avec une donnée utilisateur, et montrer pourquoi : taper `<img src=x onerror=alert(1)>` dans un champ copié avec `innerHTML`. C'est aussi la préparation de la faille XSS en S04.
* **L'IA** : un code avec des classes ES6 complexes, des modules ou un framework maison pour un TP de 100 lignes est suspect. Question orale.

## Question à poser à la fin

« Votre validation est parfaite. Je désactive JavaScript (F12 → Ctrl+Shift+P → *Disable JavaScript*). Que se passe-t-il ? » Le montrer en direct : les attributs `required` du HTML reprennent la main… et si on les enlève dans l'inspecteur, rien n'arrête plus le formulaire. Conclusion : en S04, le serveur devra tout revérifier.

## Correction

* **Pendant la séance** : à partir de 2:20, grille à la main, tests rapides de la grille (5 min par binôme).
* **Sur Git** : corriger le commit de 23 h 59, et poser les questions orales au début de S04.

## Erreurs fréquentes

| Erreur | Réaction |
|---|---|
| `Cannot read properties of null` | Mauvais sélecteur, ou élément absent de cette page → `if (element)` |
| Le formulaire s'envoie quand même | `preventDefault()` oublié, ou appelé seulement dans un `if` qui n'est pas atteint |
| `"20" > "120"` est `true` | Les `data-*` sont des chaînes → `Number()` |
| Le thème revient en clair au changement de page | `localStorage` écrit mais jamais relu au chargement |
| Le filtre ne marche qu'une fois | La liste des cartes est relue après avoir été modifiée, ou les cartes supprimées au lieu d'être cachées |
