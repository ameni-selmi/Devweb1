---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · S02 · CSS'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Semaine 2
## CSS : box model, Flexbox, responsive

---

## Aujourd'hui

1. Comment le CSS s'applique : sélecteurs, cascade
2. Le **box model** : tout est une boîte
3. **Flexbox** : placer des éléments
4. **Responsive** : un site, tous les écrans
5. **TP1 noté** : styliser ClubHub d'après une maquette

---

## Relier le CSS au HTML

```html
<head>
  <link rel="stylesheet" href="css/style.css">
</head>
```

```css
/* sélecteur { propriété: valeur; } */
h1 {
  color: #1d4ed8;
  font-size: 2rem;
}
```

Un seul fichier CSS pour tout le site. Pas de `style="..."` dans le HTML.

---

## Les sélecteurs à connaître

| Sélecteur | Cible |
|---|---|
| `p` | tous les `<p>` |
| `.event-card` | les éléments avec `class="event-card"` |
| `#email` | l'élément avec `id="email"` (à éviter en CSS) |
| `nav a` | les `a` **dans** un `nav` |
| `a:hover`, `input:focus` | un état |
| `input[type="email"]` | un attribut |
| `a[aria-current="page"]` | le lien de la page actuelle |

---

## La cascade : qui gagne ?

Quand deux règles visent le même élément :

1. La plus **spécifique** gagne : `#id` > `.classe` > `balise`
2. À spécificité égale, la **dernière** écrite gagne
3. Certaines propriétés sont **héritées** (couleur, police), d'autres non (marges, bordures)

<div class="piege">

Piège : `!important` pour « forcer ». Si vous en avez besoin, votre CSS est mal organisé.

</div>

---

## Les unités

| Unité | Sens | Quand |
|---|---|---|
| `px` | pixel | bordures, ombres |
| `rem` | taille de police de la racine (16 px par défaut) | polices, espacements |
| `%` | pourcentage du parent | largeurs |
| `vw`, `vh` | % de la fenêtre | sections plein écran |
| `ch` | largeur d'un caractère | largeur d'un texte (`max-width: 60ch`) |

---

## Les variables CSS

```css
:root {
  --color-primary: #1d4ed8;
  --radius: 10px;
}

.button {
  background: var(--color-primary);
  border-radius: var(--radius);
}
```

Changer une couleur partout = changer **une** ligne.
Et en semaine 3 : le **mode sombre** en 5 lignes.

---

## Le box model : tout est une boîte

```
┌──────────────── margin ─────────────────┐
│  ┌───────────── border ──────────────┐  │
│  │  ┌────────── padding ─────────┐   │  │
│  │  │                            │   │  │
│  │  │         content            │   │  │
│  │  │                            │   │  │
│  │  └────────────────────────────┘   │  │
│  └───────────────────────────────────┘  │
└─────────────────────────────────────────┘
```

* `padding` : espace **intérieur** · `margin` : espace **extérieur**

---

## La ligne que tout le monde met

```css
*, *::before, *::after {
  box-sizing: border-box;
}
```

* Sans elle : `width: 300px` + `padding: 20px` = **340 px**
* Avec elle : `width: 300px` = **300 px**, padding compris

<!-- DÉMO : montrer la différence dans les DevTools, onglet Elements, panneau Computed. -->

---

## Block et inline

| `display: block` | `display: inline` |
|---|---|
| Prend toute la largeur | Prend la place du contenu |
| Va à la ligne | Reste dans le texte |
| `div`, `p`, `h1`, `section` | `a`, `span`, `strong` |
| width, margin : OK | width, margin verticale : ignorés |

`inline-block` : dans la ligne, mais accepte width et padding.

---

## Flexbox : le problème

Placer des éléments **côte à côte**, les aligner, répartir l'espace.

Avant Flexbox : `float`, `table`, et beaucoup de souffrance.

```css
.site-header {
  display: flex;
}
```

Les **enfants directs** deviennent des *flex items*.

---

## Flexbox : les propriétés du conteneur

```css
.container {
  display: flex;
  flex-direction: row;          /* ou column */
  justify-content: space-between; /* axe principal */
  align-items: center;          /* axe secondaire */
  flex-wrap: wrap;              /* retour à la ligne */
  gap: 1rem;                    /* espace entre les items */
}
```

<div class="regle">

Astuce : `justify` = sur l'axe de `flex-direction`. `align` = sur l'autre axe.

</div>

---

## Flexbox : les propriétés des enfants

```css
.event-card {
  flex: 1 1 300px;
  /* grow shrink basis :
     peut grandir, peut rétrécir, part de 300px */
}

.event-card a {
  margin-top: auto; /* pousse le lien en bas */
}
```

Jouez avec : **flexboxfroggy.com** (10 minutes, ce soir).

---

## Grid, en une slide

```css
.event-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1rem;
}
```

* Flexbox : **une** dimension (une ligne ou une colonne)
* Grid : **deux** dimensions (lignes et colonnes)

Pour le TP1, Flexbox suffit. Grid est accepté en bonus.

---

## Responsive : un site, tous les écrans

60 % du trafic web vient d'un téléphone.

1. La balise `viewport` (déjà dans votre HTML)
2. Des largeurs **fluides** (`%`, `max-width`), pas fixes
3. Des **media queries** pour changer la mise en page

---

## Mobile first

On écrit d'abord le CSS pour **petit écran**, puis on ajoute pour les grands.

```css
/* Base : téléphone, une colonne */
.event-list { display: flex; flex-direction: column; }

/* À partir de 640px : tablette */
@media (min-width: 640px) {
  .event-list { flex-direction: row; flex-wrap: wrap; }
  .event-card { flex: 1 1 calc(50% - 1rem); }
}
```

Pourquoi ? Le mobile est la version **la plus simple**. On ajoute, on n'enlève pas.

---

## Tester le responsive

F12 → icône **téléphone / tablette** (Ctrl+Shift+M)

* Tester à 360 px, 768 px, 1280 px
* Pas de barre de défilement horizontale
* Le texte reste lisible, les boutons cliquables

---

## Les DevTools pour le CSS

F12 → onglet **Elements**

* Cliquer sur un élément : voir **toutes** les règles qui s'appliquent
* Les règles barrées : perdues à la cascade
* Modifier une valeur en direct pour tester
* Panneau **Computed** : le box model de l'élément

<div class="piege">

Piège : les changements dans les DevTools ne sont **pas** enregistrés. Recopiez dans votre fichier.

</div>

---

## Accessibilité : 4 réflexes

* **Contraste** suffisant (DevTools → sélecteur de couleur → ratio)
* Ne jamais supprimer le contour de focus (`outline: none`) sans le remplacer
* Tailles en `rem`, pas en `px`, pour les polices
* Liens et boutons assez grands pour un doigt (44 px environ)

---

## TP1 (noté, 15 %)

Styliser ClubHub pour qu'il ressemble à la **maquette** fournie.

* Énoncé : `semaines/S02-css/tp1/enonce.md`
* Maquettes : `tp1/maquette/` (ordinateur et téléphone)
* Un seul fichier : `css/style.css`
* Pas de framework, pas de copier coller d'un template

**Rendu : dépôt Git, ce soir 23 h 59.**
