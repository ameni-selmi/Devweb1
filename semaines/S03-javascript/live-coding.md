# S03 : Script de live coding

Démo sur un petit exemple, **pas sur ClubHub** (c'est le TP) : une liste de matériel à apporter à un atelier. Les fichiers de départ et d'arrivée sont dans `live-coding/demo/`.

## Fichier de départ : `index.html`

```html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Démo JS : matériel</title>
</head>
<body>
  <h1>Matériel pour l'atelier</h1>
  <form id="add-form">
    <label for="item">Objet</label>
    <input type="text" id="item" name="item">
    <button type="submit">Ajouter</button>
    <small id="item-error"></small>
  </form>
  <p id="count"></p>
  <ul id="list">
    <li>Ordinateur portable <button type="button" class="remove">×</button></li>
    <li>Câble USB <button type="button" class="remove">×</button></li>
  </ul>
  <script src="app.js" defer></script>
</body>
</html>
```

## Partie 1 : la console et le DOM (10 min)

1. Ouvrir la page, F12 → Console. Taper en direct :
   ```js
   document.querySelector('h1')
   document.querySelector('h1').textContent = 'Changé depuis la console'
   document.querySelectorAll('li').length
   ```
2. « Tout ce que je tape ici, je peux le mettre dans un fichier. » Créer `app.js` :
   ```js
   const list = document.querySelector('#list');
   const count = document.querySelector('#count');

   function updateCount() {
     const n = list.querySelectorAll('li').length;
     count.textContent = `${n} objet(s)`;
   }

   updateCount();
   ```
3. **Erreur volontaire** : enlever `defer` et mettre le script dans le `head`. Recharger. Lire l'erreur `Cannot read properties of null` ensemble : fichier, ligne. Remettre `defer`.

## Partie 2 : événements (15 min)

1. Ajouter un objet :
   ```js
   const form = document.querySelector('#add-form');
   const input = document.querySelector('#item');
   const error = document.querySelector('#item-error');

   form.addEventListener('submit', (event) => {
     event.preventDefault();
     const value = input.value.trim();

     if (value === '') {
       error.textContent = 'Écrivez un objet.';
       return;
     }
     error.textContent = '';

     const li = document.createElement('li');
     li.textContent = value;              // pas innerHTML !
     const button = document.createElement('button');
     button.type = 'button';
     button.className = 'remove';
     button.textContent = '×';
     li.appendChild(button);
     list.appendChild(li);

     input.value = '';
     input.focus();
     updateCount();
   });
   ```
2. Montrer d'abord **sans** `preventDefault()` : la page se recharge, l'objet disparaît, l'URL change (`?item=...`). « C'est le comportement normal d'un formulaire : il envoie une requête GET. » Ajouter `preventDefault()`.
3. **Démo XSS** : remplacer temporairement `li.textContent = value` par `li.innerHTML = value`. Taper `<img src=x onerror="alert('piraté')">`. L'alerte s'affiche. Remettre `textContent`. « En séance 4, on verra la même faille côté serveur. »
4. Supprimer un objet avec la **délégation d'événement** :
   ```js
   list.addEventListener('click', (event) => {
     if (event.target.classList.contains('remove')) {
       event.target.closest('li').remove();
       updateCount();
     }
   });
   ```
   Demander d'abord : « pourquoi un écouteur sur chaque bouton ne marche pas pour les nouveaux objets ? » (ils n'existaient pas quand on a branché les écouteurs).

## Partie 3 (si le temps) : localStorage (5 min)

Sauvegarder la liste à chaque changement :
```js
function save() {
  const items = [...list.querySelectorAll('li')].map((li) => li.firstChild.textContent);
  localStorage.setItem('demo-items', JSON.stringify(items));
}
```
Montrer F12 → Application → Local Storage. « C'est dans le navigateur. Le serveur n'en sait rien. Si j'ouvre la page sur un autre ordinateur, la liste est vide. » Transition vers S04 et S06.
