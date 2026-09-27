# S02 : Script de live coding

Travailler sur un petit fichier de démo, **pas sur ClubHub** (c'est le TP). Fichier de départ :

```html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Démo CSS</title>
  <link rel="stylesheet" href="demo.css">
</head>
<body>
  <header class="bar">
    <strong>Logo</strong>
    <nav><a href="#">Un</a> <a href="#">Deux</a> <a href="#">Trois</a></nav>
  </header>
  <main>
    <div class="cards">
      <div class="card"><h2>Carte 1</h2><p>Court.</p><a href="#">Lien</a></div>
      <div class="card"><h2>Carte 2</h2><p>Un texte beaucoup plus long pour que cette carte soit plus haute que les autres.</p><a href="#">Lien</a></div>
      <div class="card"><h2>Carte 3</h2><p>Moyen, un peu.</p><a href="#">Lien</a></div>
    </div>
  </main>
</body>
</html>
```

## Partie 1 : Box model (10 min)

1. `.card { width: 300px; padding: 20px; border: 5px solid navy; margin: 10px; }`
2. F12 → Elements → Computed. « Largeur réelle ? » → 350 px. Surprise.
3. Ajouter `*, *::before, *::after { box-sizing: border-box; }` → 300 px. « Tout le monde met cette ligne. »
4. Montrer la cascade : ajouter `.card { border-color: red; }` plus bas → gagne. Puis `div { border-color: green; }` encore plus bas → perd (moins spécifique). Montrer la règle barrée dans les DevTools.

## Partie 2 : Flexbox (20 min)

1. `.bar { display: flex; }` → logo et nav côte à côte. `justify-content: space-between;` → écartés. `align-items: center;`.
2. Changer `flex-direction: column` en direct dans les DevTools. « Les axes tournent : `justify` suit toujours la direction. »
3. `.cards { display: flex; gap: 1rem; }` → trois colonnes. Retirer la `width` de `.card`. Mettre `flex: 1;`.
4. Problème : les liens ne sont pas alignés en bas. **Demander à la salle** comment faire. Attendre.
5. Solution : `.card { display: flex; flex-direction: column; }` et `.card a { margin-top: auto; }`. « Un élément flex peut être un conteneur flex. »

   Remarque : c'est exactement la difficulté du TP1. Le montrer ici est volontaire. Les étudiants devront le refaire seuls sur de vrais contenus.

6. Réduire la fenêtre : les cartes s'écrasent. Transition vers le responsive.

## Partie 3 : Responsive mobile first (15 min)

1. Tout effacer dans `.cards`. Écrire la version mobile : `display: flex; flex-direction: column; gap: 1rem;`.
2. Ajouter :
   ```css
   @media (min-width: 640px) {
     .cards { flex-direction: row; flex-wrap: wrap; }
     .card { flex: 1 1 calc(50% - 1rem); }
   }
   ```
3. Ouvrir le mode responsive (Ctrl+Shift+M). Glisser la largeur. Montrer le point de rupture.
4. **Erreur volontaire** : écrire `flex: 1 1 50%;`. Les cartes passent une par ligne. Demander pourquoi (le `gap` s'ajoute). Corriger avec `calc`.
5. Ajouter la media query 960 px pour 3 colonnes. Conclure : « on n'a jamais annulé une règle, on a seulement ajouté. C'est ça, mobile first. »
6. (Si le temps) Montrer la même chose en Grid en 2 lignes, sans media query. « Joli, mais pour le TP, commencez par Flexbox. »
