# S08 : Script de live coding

## Partie 1 : un endpoint et un fetch minimal (15 min)

Dans `live-coding/demo/`, lancer `php -S localhost:8000`.

1. Ouvrir `api-heure.php` directement dans le navigateur : du JSON brut. Firefox et Chrome l'affichent joliment. « C'est une page comme une autre, qui renvoie des données au lieu de HTML. » Montrer le header `Content-Type: application/json` dans Network.
2. Ouvrir `index.html`. Lire le script ensemble : `async`, `await fetch`, `response.ok`, `response.json()`.
3. Cliquer plusieurs fois. Montrer que « Page chargée à » **ne change pas** : la page n'a pas été rechargée. Dans Network → Fetch/XHR : une petite requête par clic.
4. **Erreur volontaire** : changer l'URL en `api-heur.php` (faute de frappe). Cliquer : sans le test `response.ok`, `response.json()` échoue sur la page 404 en HTML (`Unexpected token '<'`). Avec le test : message propre. « `fetch` ne lève pas d'erreur pour un 404. C'est à vous de vérifier. »
5. **Erreur volontaire 2** : ajouter une faute PHP dans `api-heure.php` (par exemple une variable non définie avec `display_errors` activé). Le JSON est cassé par le message d'erreur. Le lire dans Network → Response.

## Partie 2 : l'inscription de ClubHub en fetch (15 min)

Sur le corrigé du TP5 (`atelier/starter/`), montrer **seulement** l'essentiel, les étudiants feront le reste en atelier :

1. Écrire `jsonResponse()` dans `helpers.php`.
2. Écrire un `controllers/api/register.php` minimal : 405 si pas POST, 401 si pas connecté, lecture de `jsonBody()`, `register()`, réponse 200 ou 409.
3. Tester **dans la console du navigateur**, connecté, sur n'importe quelle page du site :
   ```js
   const r = await fetch('index.php?page=api-inscription', {
     method: 'POST',
     headers: { 'Content-Type': 'application/json' },
     body: JSON.stringify({ eventId: 2, rules: true }),
   });
   r.status; await r.json();
   ```
   Recommencer : 409. « Voilà l'API, testée sans une ligne de JS dans le site. »
4. Même requête avec `curl`, sans cookie : 401. « N'importe qui peut appeler cette URL. D'où les mêmes vérifications que pour une page. »
5. Montrer le debounce en direct avec la recherche du corrigé (`atelier/solution/`) : taper vite, compter les requêtes dans Network. Enlever le `setTimeout` : une requête par lettre.

Le reste (brancher le formulaire, mettre à jour le DOM) est l'atelier.
