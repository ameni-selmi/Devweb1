---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · Amani Selmi · S03 · JavaScript dans le navigateur'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Séance 3 : JavaScript dans le navigateur

**Amani Selmi, PhD-Engineer**

---

## Aujourd'hui

1. JavaScript pour quelqu'un qui sait déjà programmer
2. Le **DOM** : la page vue comme un arbre d'objets
3. Les **événements** : réagir à l'utilisateur
4. Valider un formulaire, mémoriser une préférence
5. **TP2 noté** : rendre ClubHub interactif

---

## Où s'exécute JavaScript ?

```
  Navigateur                               Serveur
  ┌─────────────────────────┐              ┌──────────┐
  │ HTML  → structure       │   requête    │          │
  │ CSS   → apparence       │ ───────────▶ │  (rien   │
  │ JS    → comportement    │ ◀─────────── │  encore) │
  │  ↑ s'exécute ICI        │   fichiers   │          │
  └─────────────────────────┘              └──────────┘
```

* Le serveur envoie le fichier `.js`, le **navigateur** l'exécute.
* L'utilisateur peut lire, modifier ou désactiver votre JS.

---

## Charger un script

```html
  <script src="js/app.js" defer></script>
</body>
```

* `defer` : le script s'exécute quand **tout le HTML est lu**.
* Sans `defer` dans le `head` : le script cherche des éléments qui n'existent pas encore → `null`.
* Un seul fichier pour le site. Pas de `onclick="..."` dans le HTML.

---

## JS pour programmeurs : ce qui ressemble

```js
const max = 20;            // constante (à utiliser par défaut)
let places = 0;            // variable qui change

if (places < max) { places++; }

for (let i = 0; i < 3; i++) { console.log(i); }

function add(a, b) { return a + b; }
const addArrow = (a, b) => a + b;   // fonction fléchée
```

Syntaxe proche de C et Java. **Jamais** `var`.

---

## Ce qui est différent

| Point | En JavaScript |
|---|---|
| Typage | Dynamique : `let x = 3; x = "trois";` passe |
| Égalité | Toujours `===` (strict). `"3" == 3` est `true` ! |
| Chaînes | Gabarits : `` `${n} places` `` |
| Absence | `null` **et** `undefined` |
| Fonctions | Ce sont des valeurs : on les passe en paramètre |

<div class="piege">

Piège : `"5" + 1` donne `"51"`. Convertissez avec `Number(...)`.

</div>

---

## Tableaux et objets

```js
const event = { title: 'Atelier Arduino', places: 20 };
console.log(event.title);

const events = [event, { title: 'Tournoi blitz', places: 32 }];

events.filter((e) => e.places > 25);     // garder
events.map((e) => e.title);              // transformer
events.find((e) => e.title === 'X');     // trouver un seul
events.forEach((e) => console.log(e));   // parcourir
```

Vous utiliserez `filter`, `map`, `find` **tout le temps**.

---

## La console : votre terminal JS

F12 → onglet **Console**

* Tester une ligne de JS en direct
* Voir les **erreurs** (en rouge, avec le fichier et la ligne)
* `console.log(variable)` pour afficher une valeur

<div class="regle">

Règle : si « rien ne se passe », ouvrez la console **avant** de m'appeler.

</div>

---

<!-- _class: titre -->

# Le DOM
## La page est un arbre d'objets

---

## Le DOM (*Document Object Model*)

```
document
 └─ html
     ├─ head
     └─ body
         ├─ header
         ├─ main
         │   ├─ h1
         │   └─ div.event-list
         │       ├─ article.event-card
         │       └─ article.event-card
         └─ footer
```

Chaque balise devient un **objet** que JS peut lire et modifier.

---

## Trouver des éléments

```js
// Le premier élément qui correspond (ou null)
const title = document.querySelector('h1');
const form = document.querySelector('#registration-form');

// Tous les éléments qui correspondent (NodeList)
const cards = document.querySelectorAll('.event-card');
```

Ce sont les **sélecteurs CSS** que vous connaissez déjà.

---

## Lire et modifier

```js
title.textContent = 'Nouveau titre';          // texte
card.hidden = true;                           // cacher
card.classList.add('is-favorite');            // classes
card.classList.toggle('is-open');
input.value                                   // valeur d'un champ
card.dataset.club                             // data-club="photo"
document.documentElement.dataset.theme = 'dark';
```

<div class="piege">

Piège : `innerHTML = texteDeLUtilisateur` ouvre une faille (XSS). Utilisez `textContent`.

</div>

---

## Créer et supprimer

```js
const li = document.createElement('li');
li.textContent = 'Nouvel élément';
list.appendChild(li);        // ajoute à la fin

li.remove();                 // supprime
```

`appendChild` sur un élément déjà présent le **déplace**. Pratique pour trier.

---

## Les attributs `data-*`

```html
<article class="event-card" data-club="photo" data-places="15">
```

```js
card.dataset.club      // "photo"
card.dataset.places    // "15"  (une chaîne !)
Number(card.dataset.places)   // 15
```

Pour ranger des informations **pour le JS** dans le HTML.

---

<!-- _class: titre -->

# Les événements
## Réagir à l'utilisateur

---

## `addEventListener`

```js
const button = document.querySelector('.theme-toggle');

button.addEventListener('click', () => {
  console.log('Cliqué !');
});
```

Le navigateur **appelle votre fonction** quand l'événement arrive.
C'est de la programmation **événementielle** : vous ne contrôlez pas l'ordre.

---

## Les événements utiles

| Événement | Quand | Sur |
|---|---|---|
| `click` | clic | bouton, lien, n'importe quoi |
| `input` | à chaque frappe | `input`, `textarea` |
| `change` | valeur choisie | `select`, `checkbox` |
| `submit` | envoi du formulaire | `form` |
| `keydown` | touche pressée | `document`, champ |

---

## L'objet `event`

```js
form.addEventListener('submit', (event) => {
  event.preventDefault();       // n'envoie PAS le formulaire
  console.log(event.target);    // l'élément concerné
});
```

* `preventDefault()` : annule le comportement normal (envoi, lien suivi).
* Écoutez `submit` sur le **formulaire**, pas `click` sur le bouton : la touche Entrée compte aussi.

---

## Valider un formulaire

```js
form.noValidate = true;   // on gère nous mêmes les messages

form.addEventListener('submit', (event) => {
  const name = document.querySelector('#name');
  const error = document.querySelector('#name-error');

  if (name.value.trim().length < 3) {
    event.preventDefault();
    error.textContent = 'Au moins 3 caractères.';
    name.classList.add('is-invalid');
  }
});
```

---

<!-- _class: question -->

## Question

La validation JavaScript est parfaite.

**Le serveur doit il quand même vérifier les données ?**

<!-- Réponse : oui, toujours. Montrer : F12, désactiver JS, ou envoyer la requête avec curl. On le fera en séance 4. -->

---

## Mémoriser : `localStorage`

```js
localStorage.setItem('clubhub-theme', 'dark');
const theme = localStorage.getItem('clubhub-theme');  // 'dark' ou null
```

* Stocké **dans ce navigateur**, pour ce site
* Seulement des chaînes (`JSON.stringify` pour un objet)
* Parfait pour une **préférence** : thème, filtre
* Jamais pour une donnée importante ou secrète

---

## Organiser son fichier JS

```js
// 1. Trouver les éléments
const form = document.querySelector('#registration-form');

// 2. Écrire des petites fonctions
function showError(field, message) { /* ... */ }

// 3. Brancher les événements
if (form) {
  form.addEventListener('submit', onSubmit);
}
```

`if (form)` : le même fichier tourne sur **toutes** les pages.

---

## TP2 (noté)

Rendre ClubHub interactif :

* **Base** : filtre et recherche des événements, validation du formulaire
* **Plus** : compteur de caractères, mode sombre mémorisé, tri
* **Défi** : favoris, cartes générées depuis un tableau JS...

Énoncé : `semaines/S03-javascript/tp2/enonce.md`
Aide : `fiches/javascript-pour-programmeurs.md`

**Rendu : dépôt Git, ce soir 23 h 59.**
