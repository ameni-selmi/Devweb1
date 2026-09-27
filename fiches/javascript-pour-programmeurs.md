# Aide-mémoire : JavaScript pour programmeurs

Vous savez déjà programmer. Voici ce qu'il faut savoir pour écrire du JS propre dans le navigateur.

## Bases

```js
const max = 20;              // par défaut : const
let count = 0;               // si la valeur change
// var : jamais

const title = 'Atelier';     // chaînes : '...' ou "..."
const text = `${count} / ${max}`;   // gabarit (backticks)

if (count === max) { }       // toujours === et !==
for (const item of items) { }        // parcourir un tableau
while (condition) { }

function add(a, b) { return a + b; }
const double = (n) => n * 2;         // fonction fléchée
```

## Pièges quand on vient de C, Java ou Python

| Code | Résultat | Pourquoi |
|---|---|---|
| `"5" + 1` | `"51"` | `+` concatène si un côté est une chaîne |
| `"5" * 2` | `10` | conversion automatique |
| `"3" == 3` | `true` | `==` convertit : utilisez `===` |
| `0.1 + 0.2` | `0.30000000000000004` | nombres flottants |
| `[] + []` | `""` | ne cherchez pas |
| `typeof null` | `"object"` | historique |

Convertir : `Number("42")`, `String(42)`, `parseInt("42px", 10)`.

## Tableaux

```js
const events = [{ title: 'A', places: 20 }, { title: 'B', places: 32 }];

events.length
events.push(x)                          // ajouter à la fin
events.filter((e) => e.places > 25)     // nouveau tableau filtré
events.map((e) => e.title)              // nouveau tableau transformé
events.find((e) => e.title === 'B')     // premier élément trouvé ou undefined
events.some((e) => e.places === 0)      // au moins un ?
events.sort((a, b) => a.places - b.places)   // trie SUR PLACE
[...events]                             // copie
```

## Objets et JSON

```js
const event = { title: 'Atelier', places: 20 };
event.title                 // lire
event.places = 18           // modifier
const { title, places } = event;   // déstructuration

JSON.stringify(event)       // objet → chaîne
JSON.parse('{"a":1}')       // chaîne → objet
```

## Valeurs absentes

```js
value ?? 'défaut'           // si value est null ou undefined
user?.name                  // undefined au lieu d'une erreur si user est null
```

## DOM : trouver

```js
document.querySelector('.card')          // premier ou null
document.querySelectorAll('.card')       // tous (NodeList)
Array.from(document.querySelectorAll('.card'))   // vrai tableau
element.closest('article')               // ancêtre le plus proche
```

## DOM : modifier

```js
el.textContent = 'Texte'                 // sûr
el.hidden = true
el.classList.add('x') / .remove('x') / .toggle('x') / .contains('x')
el.dataset.club                          // attribut data-club
el.setAttribute('aria-invalid', 'true')
input.value / checkbox.checked / select.value

const li = document.createElement('li');
li.textContent = 'Nouveau';
list.appendChild(li);
li.remove();
```

**Jamais** `el.innerHTML = donnéeUtilisateur` (faille XSS).

## Événements

```js
button.addEventListener('click', (event) => { });
input.addEventListener('input', update);        // chaque frappe
select.addEventListener('change', update);      // choix
form.addEventListener('submit', (event) => {
  event.preventDefault();                       // bloquer l'envoi
});

// Délégation : un écouteur pour tous les enfants, même futurs
list.addEventListener('click', (event) => {
  if (event.target.matches('.remove')) { event.target.closest('li').remove(); }
});
```

## localStorage

```js
localStorage.setItem('clé', 'valeur');          // chaînes seulement
localStorage.getItem('clé');                    // valeur ou null
localStorage.setItem('liste', JSON.stringify(tableau));
```

## Asynchrone (séance 8)

```js
async function load() {
  const response = await fetch('api/events.php');
  const data = await response.json();
}
```

## Structure d'un fichier

```js
// 1. constantes et éléments
// 2. fonctions
// 3. écouteurs, protégés par if (element) si la page peut ne pas l'avoir
```

## Déboguer

* F12 → **Console** : les erreurs, avec fichier et ligne.
* `console.log(x)`, `console.table(tableau)`.
* F12 → **Sources** : mettre un point d'arrêt (clic sur le numéro de ligne).
