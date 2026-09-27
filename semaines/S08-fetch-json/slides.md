---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · Amani Selmi · S08 · fetch et JSON'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Séance 8 : fetch et JSON

**Amani Selmi, PhD-Engineer**

---

## Aujourd'hui

1. Parler au serveur **sans recharger** la page
2. JSON : le format d'échange
3. Un endpoint PHP qui renvoie du JSON
4. `fetch`, `async` et `await`
5. La checklist sécurité, appliquée à **votre** projet
6. Atelier fetch, puis **jalon 1** du projet

---

## Jusqu'ici : une action = une page

```
clic « S'inscrire »
  → POST evenement&id=1  → 302 → GET evenement&id=1 → toute la page (40 Ko)
```

* L'écran clignote, la position de défilement est perdue
* On renvoie tout le menu, tout le footer... pour changer **une** ligne

---

## Avec fetch : une action = un petit échange

```
clic « S'inscrire »
  → POST api-inscription   {"eventId": 1, "rules": true}
  ← 200                    {"placesLabel": "18 places restantes"}
  → le JS met à jour UNE ligne de la page
```

Le serveur renvoie des **données**, le navigateur décide comment les afficher.

---

## JSON

```json
{
  "events": [
    { "id": 2, "title": "Sortie photo en ville", "placesLeft": 15 },
    { "id": 3, "title": "Conférence : l'IA", "placesLeft": 118 }
  ]
}
```

* Objets `{}`, tableaux `[]`, chaînes `""`, nombres, `true`, `false`, `null`
* Le même format en JS (`JSON.parse`) et en PHP (`json_decode`)
* Le langage commun de presque toutes les API du Web

---

## Côté PHP : renvoyer du JSON

```php
function jsonResponse(array $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

jsonResponse(['events' => $events]);
jsonResponse(['error' => 'Connectez vous.'], 401);
```

Pas de layout, pas de template : seulement des données.

---

## Choisir ce qu'on envoie

```php
$data = array_map(fn($event) => [
    'id' => $event['id'],
    'title' => $event['title'],
    'placesLeft' => (int) $event['places_left'],
], $events);
```

<div class="piege">

Piège : `jsonResponse($user)` envoie aussi `password_hash`. Toujours choisir les champs.

</div>

---

## Côté JS : `fetch`

```js
const response = await fetch('index.php?page=api-evenements&q=photo');
const data = await response.json();

console.log(data.events.length);
```

* `fetch` envoie une requête HTTP, **comme le navigateur**
* Il ne bloque pas la page : il renvoie une **promesse**
* `await` : « attends la réponse, puis continue »

---

## `async` / `await`

```js
async function loadEvents(query) {
  try {
    const response = await fetch(`index.php?page=api-evenements&q=${encodeURIComponent(query)}`);
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }
    const data = await response.json();
    render(data.events);
  } catch (error) {
    showMessage('La recherche est indisponible.', 'error');
  }
}
```

* `await` seulement dans une fonction `async`
* `fetch` ne lance **pas** d'erreur pour un 404 ou un 500 : vérifiez `response.ok`

---

## Envoyer des données en JSON

```js
const response = await fetch('index.php?page=api-inscription', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ eventId: 1, rules: true }),
});
```

```php
$body = json_decode(file_get_contents('php://input'), true);
$eventId = filter_var($body['eventId'] ?? null, FILTER_VALIDATE_INT);
```

Avec du JSON, `$_POST` est **vide** : on lit le corps brut.

---

## Les codes de statut deviennent utiles

| Code | Sens | Le JS fait |
|---|---|---|
| 200 | OK | Mettre à jour la page |
| 401 | Pas connecté | Aller à la page de connexion |
| 404 | Inconnu | Message d'erreur |
| 409 | Conflit (déjà inscrit, complet) | Message d'erreur |
| 422 | Données invalides | Messages sous les champs |

---

<!-- _class: question -->

## Question

L'API d'inscription est appelée par **notre** JavaScript.

**Faut il quand même vérifier la session, la validation et les places côté PHP ?**

<!-- Oui, exactement comme pour un formulaire. Un endpoint est une URL : n'importe qui peut l'appeler avec curl ou depuis la console. -->

---

## Un endpoint est une URL comme les autres

```bash
curl -X POST -H "Content-Type: application/json" \
     -d '{"eventId": 7, "rules": true}' \
     "http://localhost:8000/index.php?page=api-inscription"
```

* Même `Auth::user()`, même validation, même contrôle des places
* Même `e()`... côté JS : `textContent`, jamais `innerHTML`

<div class="regle">

Les quatre règles de sécurité s'appliquent **aussi** aux API.

</div>

---

## Afficher la réponse sans faille

```js
function createCard(event) {
  const article = document.createElement('article');
  const title = document.createElement('h2');
  title.textContent = event.title;     // jamais innerHTML
  article.appendChild(title);
  return article;
}

list.replaceChildren(...data.events.map(createCard));
```

Un titre d'événement `<img src=x onerror=...>` reste du **texte**.

---

## Amélioration progressive

1. La page marche **sans** JavaScript (formulaire classique, PRG)
2. Le JavaScript **intercepte** le formulaire et utilise `fetch`
3. Si le réseau casse : on laisse le formulaire classique partir

```js
form.addEventListener('submit', async (event) => {
  event.preventDefault();
  try { /* fetch */ } catch { form.submit(); }
});
```

Le site reste utilisable partout. Et la validation reste sur le serveur.

---

## Attendre que l'utilisateur arrête de taper

```js
let timer;
searchInput.addEventListener('input', () => {
  clearTimeout(timer);
  timer = setTimeout(searchOnServer, 300);
});
```

Sans ça : une requête **par lettre** tapée. Regardez l'onglet Network.

---

## Voir les échanges

F12 → **Network** → filtre **Fetch/XHR**

* La requête : méthode, URL, *Payload* (le JSON envoyé)
* La réponse : statut, *Preview* (le JSON reçu, lisible)
* Si ça ne marche pas : c'est **ici** qu'on regarde en premier

---

## Checklist sécurité : votre projet (15 min)

Avec votre binôme, sur **votre** code :

* [ ] `e()` sur toute sortie · `textContent` en JS
* [ ] `prepare` + `execute` partout (lancez les `grep` de la fiche)
* [ ] Mots de passe hachés
* [ ] Chaque page protégée appelle `requireLogin()` / `requireRole()`
* [ ] On ne peut pas modifier la ressource d'un autre en changeant un id
* [ ] Actions en POST, PRG après succès
* [ ] `config.php` hors de Git

Fiche : `fiches/securite-checklist.md`

---

## Atelier puis jalon 1

**30 min** : atelier fetch sur ClubHub (`semaines/S08-fetch-json/atelier/enonce.md`)

**Ensuite** : votre projet. Je passe voir chaque binôme pour le **jalon 1** :

* schéma de la base créé (`schema.sql`)
* pages principales en place (même simples)
* connexion qui fonctionne
* dépôt Git à jour, commits des **deux** membres
