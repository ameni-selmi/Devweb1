# Aide-mémoire : HTML

## Squelette

```html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Titre utile · Nom du site</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>...</header>
  <main>...</main>
  <footer>...</footer>
  <script src="js/app.js" defer></script>
</body>
</html>
```

## Balises sémantiques

| Balise | Sens |
|---|---|
| `header` / `footer` | En-tête / pied (de la page ou d'une section) |
| `nav` | Navigation principale |
| `main` | Contenu principal (un seul par page) |
| `section` | Partie thématique, avec un titre |
| `article` | Contenu autonome (un événement, un post) |
| `aside` | Contenu secondaire |
| `h1` ... `h6` | Titres, dans l'ordre, un seul `h1` |
| `time datetime="10-14"` (ou `"2030-10-14T14:00"` avec année et heure) | Date lisible par une machine |
| `div`, `span` | Aucun sens. En dernier recours. |

## Texte et liens

```html
<p>Un paragraphe avec <strong>important</strong> et <em>accentué</em>.</p>
<a href="evenements.html">Lien interne</a>
<a href="https://mdn.dev">Lien externe</a>
<img src="img/arduino.jpg" alt="Carte Arduino Uno sur une table">
<ul><li>liste</li></ul>   <ol><li>liste numérotée</li></ol>
```

## Formulaires

```html
<form action="inscription.php" method="post">
  <label for="email">Email</label>
  <input type="email" id="email" name="email" required>

  <label for="level">Niveau</label>
  <select id="level" name="level">
    <option value="1">1re année</option>
  </select>

  <fieldset>
    <legend>Déjà utilisé un Arduino ?</legend>
    <label><input type="radio" name="experience" value="yes"> Oui</label>
    <label><input type="radio" name="experience" value="no"> Non</label>
  </fieldset>

  <label><input type="checkbox" name="rules" value="1" required> J'accepte</label>
  <textarea name="motivation" rows="4"></textarea>
  <button type="submit">Envoyer</button>
</form>
```

* **`name`** : sans lui, la donnée n'est **pas envoyée**.
* **`label for` = `input id`** : obligatoire (accessibilité).
* `required`, `minlength`, `min`, `max`, `pattern` : aide pour l'utilisateur, **pas une sécurité**.

## Tableau

```html
<table>
  <thead><tr><th scope="col">Nom</th><th scope="col">Places</th></tr></thead>
  <tbody><tr><td>Atelier</td><td>20</td></tr></tbody>
</table>
```

Pour des **données**. Jamais pour la mise en page.

## Vérifier

https://validator.w3.org → *Validate by Direct Input*
