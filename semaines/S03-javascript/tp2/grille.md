# TP2 : Grille de correction (sur 20)

Temps visé : 5 à 8 minutes par binôme. Ouvrir la console (F12) **avant** de tester. Tester `evenements.html` puis `evenement.html`, puis lire `app.js`.

**Binôme :** ................................................

| # | Critère | Points | Note |
|---|---|---|---|
| | **Qualité du code (3 pts)** | | |
| 1 | Aucune erreur dans la console, sur les 3 pages | 1 | |
| 2 | `const`/`let`, `===`, pas de `onclick` dans le HTML, `textContent` et pas `innerHTML` | 1 | |
| 3 | Code organisé : petites fonctions nommées, éléments cherchés une fois, `if (element)` pour les pages | 1 | |
| | **Filtre (5 pts)** | | |
| 4 | Recherche texte, insensible à la casse | 2 | |
| 5 | Filtre par club, qui fonctionne **avec** la recherche | 2 | |
| 6 | Compteur de résultats (avec singulier) + message « aucun résultat » | 1 | |
| | **Validation (6 pts)** | | |
| 7 | Les 4 règles vérifiées à l'envoi, messages dans les bons `<small>` | 3 | |
| 8 | Classe `is-invalid`, envoi bloqué si erreur, message de succès si tout est bon | 2 | |
| 9 | Le message disparaît quand on corrige le champ | 1 | |
| | *Sous total Base* | *14* | |
| | **Plus (3 pts)** | | |
| 10 | Compteur de caractères avec `is-near-limit` | 0,5 | |
| 11 | Mode sombre : variables CSS + bouton + mémorisé sur toutes les pages | 1,5 | |
| 12 | Tri qui respecte le filtre | 0,5 | |
| 13 | Focus sur le premier champ invalide + `aria-invalid` | 0,5 | |
| | **Défi (3 pts)** | | |
| 14 | Défi(s) réalisé(s) et expliqué(s) | 3 | |
| | **Pénalités** | | |
| | Utilisation de jQuery ou d'une bibliothèque | −5 | |
| | `innerHTML` avec une donnée saisie par l'utilisateur | −1 | |
| | Rendu en retard (par tranche de 24 h) | −2 | |
| | **Total** | **/20** | |

## Tests rapides

1. Taper `ARDUINO` → 1 carte. Choisir « Club Photo » avec `ARDUINO` toujours tapé → 0 carte + message.
2. Vider la recherche, choisir « Tous les clubs » → 5 cartes, compteur « 5 événements affichés ».
3. Sur `evenement.html`, cliquer « S'inscrire » sans rien remplir → 4 messages. Remplir le nom → son message disparaît.
4. Saisir `<b>test</b>` dans le nom : rien ne doit apparaître en gras nulle part.
5. Mode sombre, puis changer de page, puis recharger → toujours sombre.

## Questions orales possibles

* « Pourquoi `defer` sur la balise script ? Et si on l'enlève ? »
* « Pourquoi écouter `submit` sur le formulaire et pas `click` sur le bouton ? »
* « Votre validation est parfaite. Le serveur doit il vérifier quand même ? » (Attendu : oui, toujours. Le JS se désactive ou se contourne.)
* « Où est stocké le thème ? Le serveur le connaît il ? »

## Repères

| Note | Ce que ça ressemble |
|---|---|
| 8 à 10 | Recherche ou validation qui marche à moitié, erreurs dans la console |
| 12 à 14 | Base complète et propre |
| 15 à 17 | Base + mode sombre mémorisé + compteur + tri |
| 18 à 20 | Tout, plus un défi bien fait et expliqué |
