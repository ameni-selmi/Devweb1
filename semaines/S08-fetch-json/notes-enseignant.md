# S08 : Notes pour l'enseignante

## Objectif de la séance

À la fin, chaque étudiant doit pouvoir :

1. écrire un endpoint PHP qui renvoie du JSON avec le bon code HTTP ;
2. appeler cet endpoint avec `fetch` + `async`/`await` et mettre à jour le DOM sans faille ;
3. expliquer pourquoi une API doit être protégée exactement comme une page.

Et chaque binôme doit repartir avec son **jalon 1** évalué.

Le message clé : **fetch change l'expérience, pas la sécurité. Le serveur vérifie tout, toujours.**

## Préparation

* [ ] Publier le corrigé du TP5 (= `atelier/starter/`).
* [ ] Imprimer `jalon1.md` (une fiche par binôme) ou préparer un tableur.
* [ ] Préparer la démo (`live-coding/demo/`) : `php -S` dans ce dossier.
* [ ] Avoir la liste des binômes et leurs dépôts ouverts dans des onglets.

## Déroulé minuté

| Temps | Activité | Remarques |
|---|---|---|
| 0:00 | Retour TP5 | Deux minutes : IDOR vu dans les rendus ? |
| 0:05 | Slides 1 à 11 + live coding partie 1 | JSON, endpoint, fetch. |
| 0:25 | Slides 12 à 18 + live coding partie 2 | Sécurité des API, amélioration progressive, debounce. |
| 0:35 | Checklist sécurité (slide 19) | 15 min, **sur leur projet**. Les `grep` de la fiche TP4 marchent aussi sur leur code. |
| 0:50 | Pause | |
| 1:00 | Atelier fetch | 30 min maximum. Ceux qui ne finissent pas le termineront s'ils prennent l'option Avancé fetch. |
| 1:30 | Projet + **jalon 1** | Passer voir chaque binôme, 5 min, avec la fiche. Commencer par les binômes qui semblent en difficulté. |
| 2:55 | Clôture | Annoncer S09 : revue de code croisée. Chaque binôme doit avoir un dépôt à jour pour que l'autre puisse le lire. |

## Points d'attention

* **`response.ok`** : les étudiants pensent que `fetch` lève une erreur pour un 404. Ce n'est pas le cas. Le montrer dans la démo en appelant une URL qui n'existe pas.
* **`$_POST` vide** avec un corps JSON : erreur n° 1 de l'atelier. `jsonBody()` règle le problème.
* **Une erreur PHP casse le JSON** : `Unexpected token '<'`. Faire lire la réponse dans l'onglet Network.
* **CSRF** : on n'en a pas parlé en détail. Le cookie de session est en `SameSite=Lax` (depuis S05), ce qui bloque les POST venant d'un autre site dans les navigateurs récents. Si un étudiant pose la question, c'est la bonne réponse pour ce cours. Les frameworks ajoutent un jeton CSRF en plus.
* **Ne pas tout passer en fetch** : certains binômes vont vouloir faire une « application une page ». Leur rappeler que l'option Avancé demande **une** fonctionnalité bien faite, et que la version sans JavaScript doit marcher.

## Le jalon 1

* 5 minutes par binôme, avec `jalon1.md`. Écrire un conseil concret à chaque fois.
* Le plus important : **la mécanique centrale a-t-elle commencé ?** Si non, la découper avec eux tout de suite (par exemple : « d'abord l'appariement avec 2 critères, sans interface, affiché en tableau »).
* Déséquilibre dans le binôme (un seul membre commite) : en parler maintenant, calmement, avec les deux. Rappeler la soutenance individuelle.

## Erreurs fréquentes

| Erreur | Réaction |
|---|---|
| `Unexpected token '<'` | Le PHP a affiché une erreur ou du HTML : lire la réponse dans Network |
| `$_POST` vide | Corps JSON : `json_decode(file_get_contents('php://input'), true)` |
| Rien ne se passe au clic | `event.preventDefault()` oublié : la page se recharge avant la fin du fetch |
| Double inscription au double clic | Désactiver le bouton pendant la requête |
| `await is only valid in async functions` | Mettre `async` devant la fonction (ou la fonction fléchée) |
| Cartes reconstruites avec `innerHTML` et des gabarits | Faille XSS : `createElement` + `textContent` |
