---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · S01 · Comment fonctionne le Web + HTML'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Semaine 1 : Comment fonctionne le Web + HTML

---

## Ce cours en une phrase

Construire une vraie application web **sans framework**, pour comprendre ce que les frameworks font à votre place.

* 11 semaines, 3 h par semaine
* Beaucoup de pratique : environ 70 % du temps
* Une application fil rouge : **ClubHub**
* Un projet final **original**, pas un énième CRUD

<!-- Insister : ils savent déjà programmer. Ici on apprend le Web, pas la programmation. -->

---

## La stack du cours

| Où ? | Technologie | Rôle |
|---|---|---|
| Navigateur (*frontend*) | HTML | Structure et sens |
| Navigateur | CSS | Apparence |
| Navigateur | JavaScript | Interaction |
| Serveur (*backend*) | PHP | Logique, pages dynamiques |
| Serveur | MySQL | Données |

Pas de Bootstrap, pas de React, pas de Laravel. **Volontairement.**

---

## Évaluation

| | Poids |
|---|---|
| TP1 : HTML/CSS | 15 % |
| TP2 : JavaScript | 7,5 % |
| TP3 : PHP, sessions | 7,5 % |
| TP4 : MySQL, PDO | 15 % |
| TP5 : Structure | 15 % |
| **Projet final** (binôme, soutenance) | **40 %** |

---

## L'IA : autorisée, mais...

> Vous devez pouvoir **expliquer** et **modifier** chaque ligne de votre code, seul, pendant la soutenance.

* Questions individuelles à la soutenance
* Petite modification demandée en direct
* Code non compris = code non compté

<!-- Dire clairement : l'IA est un outil de travail normal en 2026. Le but est que VOUS compreniez. -->

---

<!-- _class: question -->

## Question

Vous tapez `https://www.ecole.tn` et vous appuyez sur Entrée.

**Que se passe-t-il jusqu'à l'affichage de la page ?**

<!-- Laisser 3 minutes. Noter les réponses au tableau. On va les ordonner ensemble. -->

---

## Le modèle client / serveur

```
  Client (navigateur)                     Serveur
  ┌──────────────┐     1. requête HTTP    ┌──────────────┐
  │              │ ─────────────────────▶ │              │
  │   Chrome,    │                        │  Apache,     │
  │   Firefox    │ ◀───────────────────── │  PHP, MySQL  │
  └──────────────┘     2. réponse HTTP    └──────────────┘
```

* Le **client** demande. Le **serveur** répond.
* Le serveur ne peut **jamais** parler en premier.
* Une requête = une réponse. Puis c'est terminé.

---

## Les étapes

1. **URL** analysée : protocole, domaine, chemin
2. **DNS** : `www.ecole.tn` → `196.203.x.x`
3. Connexion **TCP** (+ **TLS** si HTTPS)
4. Envoi de la **requête** HTTP
5. Le serveur prépare la **réponse**
6. Le navigateur lit le HTML, puis demande le CSS, le JS, les images...
7. **Affichage**

Une page = souvent **des dizaines** de requêtes.

---

## Anatomie d'une URL

```
https://www.ecole.tn:443/clubs/robotique?tri=date#agenda
└─┬─┘   └────┬─────┘ └┬┘ └──────┬──────┘ └───┬──┘ └──┬─┘
protocole  domaine   port     chemin      query   fragment
```

* Le **fragment** (`#agenda`) n'est jamais envoyé au serveur.
* La **query string** (`?tri=date`) sera très utile en PHP (`$_GET`).

---

## Une requête HTTP, c'est du texte

```http
GET /clubs/robotique?tri=date HTTP/1.1
Host: www.ecole.tn
User-Agent: Mozilla/5.0 ...
Accept: text/html
Accept-Language: fr-FR
```

* Première ligne : **méthode**, **chemin**, version
* Puis des **headers** (en-têtes)
* Puis, parfois, un **body** (corps)

---

## Une réponse HTTP

```http
HTTP/1.1 200 OK
Content-Type: text/html; charset=UTF-8
Content-Length: 5120
Set-Cookie: session=abc123

<!DOCTYPE html>
<html lang="fr">
...
```

* **Code de statut** + headers + body (ici du HTML)

---

## Les méthodes à connaître

| Méthode | Usage | Données envoyées |
|---|---|---|
| **GET** | Lire une ressource | Dans l'URL (`?q=...`) |
| **POST** | Envoyer / modifier | Dans le body |
| PUT, PATCH, DELETE | API (on les verra peu) | Body |

<div class="regle">

Règle : un **GET** ne doit jamais modifier de données.

</div>

---

## Les codes de statut

| Famille | Sens | Exemples |
|---|---|---|
| 2xx | Succès | `200 OK`, `201 Created` |
| 3xx | Redirection | `301`, `302 Found` |
| 4xx | Erreur **du client** | `400`, `403 Forbidden`, `404 Not Found` |
| 5xx | Erreur **du serveur** | `500 Internal Server Error` |

Un `404`, c'est vous. Un `500`, c'est le serveur (souvent votre PHP...).

---

## HTTP est sans état (*stateless*)

Le serveur **oublie tout** entre deux requêtes.

* Il ne sait pas que vous étiez là il y a 2 secondes.
* Il ne sait pas que vous êtes connecté.

Alors comment fonctionne un panier ou une connexion ?
→ **Cookies et sessions** (semaine 5).

---

## HTTPS

HTTP + **TLS** = la même chose, mais **chiffrée**.

* Personne sur le réseau ne peut lire ou modifier les échanges.
* Le certificat prouve l'identité du serveur.
* Obligatoire dès qu'il y a un mot de passe (en pratique : partout).

---

## Démo : les DevTools

**F12** → onglet **Network** (Réseau)

1. Ouvrir un site, recharger la page
2. Cliquer sur la première requête
3. Lire : méthode, statut, headers, réponse
4. Compter les requêtes. Combien pour une seule page ?

<!-- DÉMO en direct, voir live-coding.md partie 1. -->

---

<!-- _class: titre -->

# HTML
## Le sens et la structure

---

## HTML décrit le **sens**, pas l'apparence

```html
<h1>ClubHub</h1>
<p>Les événements des clubs de l'école.</p>
<a href="evenements.html">Voir les événements</a>
```

* `<h1>` = titre principal (pas « gros texte »)
* L'apparence, c'est le travail du CSS.
* Le navigateur, Google, un lecteur d'écran lisent le **sens**.

---

## Le squelette d'une page

```html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ClubHub</title>
</head>
<body>
  <!-- le contenu visible -->
</body>
</html>
```

`head` = informations sur la page. `body` = ce qu'on voit.

---

## Les balises sémantiques

```
┌──────────────── <header> ────────────────┐
│  logo           <nav> liens </nav>       │
├──────────────── <main> ──────────────────┤
│  <h1>                                    │
│  <section>  <article> <article>          │
│  </section>                              │
├──────────────── <footer> ────────────────┤
└──────────────────────────────────────────┘
```

`<div>` et `<span>` : seulement quand **aucune** balise n'a de sens.

---

## Les formulaires : le lien avec le serveur

```html
<form action="inscription.php" method="post">
  <label for="email">Email</label>
  <input type="email" id="email" name="email" required>

  <button type="submit">S'inscrire</button>
</form>
```

* `action` : **où** envoyer · `method` : GET ou POST
* `name` : le **nom** de la donnée côté serveur
* `label for` = `input id` : accessibilité + clic sur le texte

---

## Types d'`input` utiles

| Type | Pour |
|---|---|
| `text`, `email`, `password` | Texte |
| `number`, `date`, `datetime-local` | Nombres, dates |
| `checkbox`, `radio` | Choix |
| `select` / `textarea` | Liste, texte long |

Attributs : `required`, `min`, `max`, `minlength`, `placeholder`

<div class="piege">

Piège : la validation HTML se contourne en 5 secondes. Le serveur devra **toujours** revérifier.

</div>

---

## Tableaux : pour des données, pas pour la mise en page

```html
<table>
  <thead>
    <tr><th>Événement</th><th>Date</th><th>Places</th></tr>
  </thead>
  <tbody>
    <tr><td>Atelier Arduino</td><td>14/10</td><td>20</td></tr>
  </tbody>
</table>
```

---

## Checklist d'une bonne page HTML

* `lang="fr"`, `charset`, `viewport`, un `title` utile
* Un seul `<h1>`, des titres dans l'ordre (`h2`, puis `h3`)
* Balises sémantiques plutôt que `<div>`
* Chaque `input` a un `label`
* Chaque `img` a un `alt`
* Le code passe le validateur : **validator.w3.org**

---

## Atelier : ClubHub, version 0

3 pages en **HTML pur**, sans CSS :

1. `index.html` : accueil
2. `evenements.html` : liste des événements
3. `evenement.html` : un événement + formulaire d'inscription

Énoncé : `semaines/S01-web-html/atelier/enonce.md`

**Semaine prochaine : TP1 noté (CSS) sur ces pages.**
