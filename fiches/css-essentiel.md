# Aide-mémoire : CSS

## Démarrage de chaque fichier

```css
:root {
  --color-primary: #1d4ed8;
  --color-text: #1e293b;
  --radius: 10px;
  --space: 1rem;
}

*, *::before, *::after { box-sizing: border-box; }

body { margin: 0; font-family: system-ui, sans-serif; line-height: 1.6; }
img { max-width: 100%; height: auto; }
main { max-width: 1100px; margin: 0 auto; padding: var(--space); }
```

## Sélecteurs

| | |
|---|---|
| `p` · `.card` · `#id` | balise · classe · id |
| `nav a` | descendant |
| `.card > h2` | enfant direct |
| `a:hover` · `input:focus` · `li:nth-child(even)` | états |
| `input[type="email"]` · `a[aria-current="page"]` | attributs |
| `label:has(input[type="checkbox"])` | parent qui contient |

**Qui gagne ?** id > classe > balise. À égalité : la dernière règle écrite.

## Box model

`margin` (extérieur) → `border` → `padding` (intérieur) → contenu.
Centrer un bloc : `margin: 0 auto;` + une `max-width`.

## Flexbox

```css
.parent {
  display: flex;
  flex-direction: row;            /* row | column */
  justify-content: space-between; /* axe principal : start | center | space-between */
  align-items: center;            /* axe secondaire : stretch | center | flex-start */
  flex-wrap: wrap;
  gap: 1rem;
}
.enfant { flex: 1 1 300px; }      /* grandir, rétrécir, taille de base */
.enfant-en-bas { margin-top: auto; }
```

N colonnes avec gap : `flex: 1 1 calc(100% / N - var(--space));`

## Grid (bonus)

```css
.grille {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1rem;
}
```

## Responsive, mobile first

```css
/* base = téléphone */
.list { display: flex; flex-direction: column; }

@media (min-width: 640px) { /* tablette */ }
@media (min-width: 960px) { /* ordinateur */ }
```

## Unités

`rem` pour les polices et espacements · `%` pour les largeurs · `px` pour les bordures · `ch` pour la largeur d'un texte.

## Déboguer

F12 → **Elements** : règles appliquées, règles barrées, box model (*Computed*).
Ctrl+Shift+M : mode responsive. Ctrl+Shift+R : recharger sans cache.
