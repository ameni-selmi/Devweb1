# S04 : Notes pour l'enseignante

## Objectif de la séance

À la fin, chaque étudiant doit pouvoir :

1. lancer un serveur PHP et expliquer ce qu'il fait d'une requête ;
2. générer du HTML avec des boucles et des `require` ;
3. traiter un formulaire en PHP, avec validation serveur et réaffichage propre ;
4. expliquer la faille XSS et la corriger avec `e()`.

Le message clé : **le navigateur ne voit jamais le PHP. Il reçoit du HTML. Et le serveur ne croit rien de ce que le navigateur envoie.**

## Préparation

* [ ] **Tester l'installation en salle** avant la séance : `php -v` sur un poste. Si PHP n'est pas installé en salle, prévoir XAMPP (ou une clé USB avec une version portable). C'est le plus gros risque de la séance.
* [ ] Publier `atelier/starter/` et le corrigé du TP2.
* [ ] Imprimer ou afficher le cahier des charges du projet (`projet/specification.md`).
* [ ] Préparer le dossier de démo (voir `live-coding.md`).

## Déroulé minuté

| Temps | Activité | Remarques |
|---|---|---|
| 0:00 | Retour TP2 | Erreurs fréquentes. Rappeler la question de fin de S03 : le JS ne protège rien. |
| 0:10 | Installation (slide 6) | **Personne ne continue** tant que tout le monde ne voit pas `bonjour.php`. Les étudiants à l'aise aident les autres. |
| 0:25 | Slides 3 à 5 + live coding partie 1 | Le cycle d'une requête. Montrer Ctrl+U : aucun PHP visible. |
| 0:40 | Slides 7 à 12 : PHP pour programmeurs | Aller vite, ils connaissent la logique. Insister : tableaux associatifs, `foreach ... endforeach`, `require`. |
| 0:55 | Slides 13 à 19 + live coding partie 2 | `$_POST`, validation, XSS. La démo `curl` est **très** importante. |
| 1:10 | Pause | |
| 1:20 | Slides 20 à 27 : lancement du projet | 20 min. Distribuer `projet/specification.md`. Laisser 5 min de questions. Demander de former les binômes **aujourd'hui**. |
| 1:40 | Atelier | Circuler. Beaucoup de pages blanches : faire regarder le terminal. |
| 2:55 | Clôture | TP3 la semaine prochaine, sur cet atelier. Proposition de projet à rendre en S06. |

## Points d'attention

* **Page blanche** : c'est une erreur PHP fatale non affichée. Réflexe : regarder le terminal de `php -S`. Montrer `display_errors` pour le développement, et dire qu'on ne le laisse **jamais** en production.
* **`file://`** : des étudiants ouvrent `index.php` en double cliquant. Le navigateur affiche le code ou le télécharge. Toujours passer par `http://localhost`.
* **Chemins** : `require 'includes/header.php'` marche… jusqu'au jour où le fichier est inclus depuis un autre dossier. Imposer `__DIR__ . '/...'` dès maintenant, sans trop théoriser.
* **`$_POST['name']` sans `??`** : avertissement `Undefined array key`. Montrer `?? ''`.
* **Types** : `$_GET['id']` est une **chaîne**. Comparer `"3" === 3` donne `false`. D'où `filter_input(..., FILTER_VALIDATE_INT)` ou `(int)`. Bonne occasion de revenir sur `===`.
* **Radio et select réaffichés** : le Plus demande de garder la sélection. C'est répétitif, et c'est volontaire : en S07, ils seront contents de factoriser.
* **Le projet** : insister sur la règle 2 (mécanique centrale). Les binômes vont proposer des boutiques et des blogs. Leur demander tout de suite : « qu'est ce que votre application **calcule** ? »

## La démo curl (à ne pas rater)

Pendant que le serveur tourne, dans un autre terminal :

```bash
curl -X POST -d "name=A&email=nimportequoi&level=42" "http://localhost:8000/evenement.php?id=1"
```

Sans validation serveur, la page dit « Merci A ! ». Le JS n'a jamais été exécuté : `curl` n'est pas un navigateur. Puis ajouter la validation, relancer la même commande : les erreurs apparaissent dans le HTML renvoyé.

## Erreurs fréquentes

| Erreur | Réaction |
|---|---|
| Page blanche | Regarder le terminal, activer `display_errors` en développement |
| Le code PHP apparaît dans le navigateur | Ouvert en `file://`, ou fichier en `.html` au lieu de `.php` |
| `Undefined array key "name"` | `$_POST['name'] ?? ''` |
| `Cannot redeclare function e()` | `functions.php` inclus deux fois → `require_once`, ou ne l'inclure qu'en haut de la page |
| `Headers already sent` | Du HTML (ou un espace, ou un BOM) avant `http_response_code()` ou `header()` : faire tout le PHP **avant** le premier HTML |
| Le filtre JS ne marche plus | Les attributs `data-*` ont disparu de la boucle PHP |
