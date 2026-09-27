# Atelier S04 : ClubHub en PHP

**Non noté** · En binôme · Durée : 1 h 10 en séance + travail personnel
Ce travail est le **starter du TP3** : il doit être fini avant la séance 5 (sinon, partez du corrigé publié).

## Objectifs

* Lancer un serveur PHP et comprendre ce qu'il fait.
* Découper une page en morceaux réutilisables (`require`).
* Générer du HTML à partir de données (boucles).
* Lire `$_GET` et `$_POST`, valider côté serveur, réafficher proprement.
* Échapper **toute** sortie avec `e()`.

## Ce qu'on vous donne

Dans `atelier/starter/` :

* les pages HTML, CSS et JS du TP2 (le JS laisse maintenant partir le formulaire quand il est valide) ;
* `data/events.php` : les 5 événements dans un tableau PHP (chaque événement a un `id`, un `title`, une `description`, un `program`, etc.) ;
* `bonjour.php` : pour tester l'installation.

## Étape 0 : le serveur (10 min)

1. Ouvrez un terminal **dans le dossier** du projet.
2. Lancez `php -S localhost:8000`.
3. Ouvrez `http://localhost:8000/bonjour.php`. Vous devez voir la version de PHP et l'heure.
4. Regardez le terminal : chaque requête reçue s'affiche. Rechargez la page, observez.

Avec XAMPP, WAMP ou MAMP : copiez le dossier dans `htdocs` et ouvrez `http://localhost/clubhub/bonjour.php`. Voir `fiches/installation.md`.

## Travail demandé

### Base

1. **Fonctions communes** : créez `includes/functions.php` avec :
   * la fonction `e()` (voir les slides) ;
   * `getEvents(): array` qui renvoie le tableau de `data/events.php` ;
   * `findEvent(int $id): ?array` qui renvoie l'événement de cet id, ou `null`.
2. **En-tête et pied de page** : créez `includes/header.php` (du `<!DOCTYPE html>` jusqu'à la fin du `<header>`) et `includes/footer.php` (du `<footer>` jusqu'à `</html>`). Le titre de l'onglet vient d'une variable `$pageTitle` définie par chaque page.
3. **`index.php`** : même contenu que `index.html`, mais les 2 événements sont générés par une boucle `foreach` sur les 2 premiers éléments de `getEvents()` (indice : `array_slice`).
4. **`evenements.php`** : les 5 cartes sont générées par une boucle. Chaque carte garde ses attributs `data-club`, `data-date`, `data-places` : le filtre JavaScript du TP2 doit **toujours marcher**. Le lien « Voir le détail » pointe vers `evenement.php?id=...`.
5. **`evenement.php`** : lit l'id dans l'URL et affiche **cet** événement (titre, club, date, lieu, places, description, programme, à apporter). Si l'id est absent, pas un nombre, ou inconnu : code **404** et un message clair avec un lien vers la liste.
6. **Traitement du formulaire** dans `evenement.php` (le formulaire s'envoie à lui même en `POST`) :
   * récupérez les champs avec `$_POST[...] ?? ''` et `trim()` ;
   * validez **côté serveur** les mêmes règles qu'en JS : nom ≥ 3 caractères, email valide (`filter_var`), niveau parmi 1, 2, 3, règlement accepté ;
   * s'il y a des erreurs : réaffichez le formulaire **avec les valeurs saisies** et chaque message sous son champ ;
   * sinon : à la place du formulaire, affichez « Merci [nom] ! Votre inscription à [événement] est bien reçue. »
7. **Sécurité** : chaque valeur affichée dans le HTML passe par `e()`. Testez en tapant `<script>alert(1)</script>` comme nom.

Supprimez les anciens fichiers `.html` quand tout marche.

### Plus

* Le lien de la page actuelle a `aria-current="page"` (variable `$currentPage` lue dans `header.php`).
* La liste des clubs du filtre est générée à partir des événements, **sans doublon**.
* La motivation est limitée à 300 caractères **côté serveur** aussi.
* Le niveau choisi et la réponse oui / non restent sélectionnés quand le formulaire est réaffiché avec des erreurs.

### Défi

* **Contourner le JS** : désactivez JavaScript (F12 → Ctrl+Shift+P → *Disable JavaScript*) et envoyez un formulaire vide. Puis envoyez une requête avec `curl` :
  `curl -X POST -d "name=A&email=faux" "http://localhost:8000/evenement.php?id=1"`
  Votre serveur doit refuser les deux. Notez ce que vous observez dans `reponses.md`.
* **Recharger après l'envoi** : après une inscription réussie, appuyez sur F5. Que propose le navigateur ? Pourquoi est ce un problème pour un vrai site ? (Réponse en séance 5.)
* **Recherche côté serveur** : faites marcher `evenements.php?q=arduino` **sans JavaScript** (le formulaire de filtre envoie un GET, PHP filtre le tableau).

## Rendu

Poussez sur votre dépôt `clubhub` avant la séance 5. Non noté, mais obligatoire pour le TP3.

## Aide

* Fiche : `fiches/php-pour-programmeurs.md`
* Fiche : `fiches/installation.md`
* Page blanche ? Regardez le **terminal** où tourne `php -S` : les erreurs PHP y sont affichées. Ajoutez aussi en haut de vos pages, **en développement seulement** : `ini_set('display_errors', '1'); error_reporting(E_ALL);`
