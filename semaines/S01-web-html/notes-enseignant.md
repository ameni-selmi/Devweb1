# S01 : Notes pour l'enseignante

## Objectif de la séance

À la fin, chaque étudiant doit pouvoir :

1. raconter le trajet d'une requête, de l'URL à l'affichage ;
2. ouvrir les DevTools et lire une requête et une réponse ;
3. écrire une page HTML valide et sémantique avec un formulaire.

Le message le plus important de la séance : **le client demande, le serveur répond, puis il oublie tout.** Tout le reste du cours s'appuie sur cette idée.

## Préparation (avant la séance)

* [ ] Vérifier en salle : navigateur récent, VS Code (ou autre éditeur), Git.
* [ ] Publier le dépôt du cours et donner le lien aux étudiants.
* [ ] Préparer le quiz diagnostic (`quiz-diagnostic.md`) sur papier ou dans un formulaire en ligne.
* [ ] Ouvrir à l'avance : un site simple (par exemple le site de votre établissement) et `example.com` pour la démo DevTools.
* [ ] Avoir la solution de l'atelier ouverte dans un onglet, pour montrer le résultat attendu.

## Déroulé minuté

| Temps | Activité | Remarques |
|---|---|---|
| 0:00 | Présentation (slides 1 à 5) | Rester court. Le point clé : pas de framework, projet original, IA autorisée mais compréhension exigée. |
| 0:15 | Quiz diagnostic | 10 min, non noté. Le but : savoir qui a déjà fait du HTML, du SQL, du PHP. Ramasser. |
| 0:25 | Question « que se passe-t-il quand... » (slide 6) | 3 min en binôme, puis mise en commun au tableau. Ne pas corriger tout de suite. |
| 0:30 | Cours HTTP (slides 7 à 14) | Revenir aux réponses du tableau et les remettre dans l'ordre. |
| 0:50 | Démo DevTools (slide 15) | Voir `live-coding.md`, partie 1. |
| 1:00 | Cours HTML (slides 16 à 23) | Aller vite sur ce qu'ils savent. Insister sur sémantique, `name`, `label`. |
| 1:15 | Pause | |
| 1:25 | Live coding : page d'accueil ClubHub | Voir `live-coding.md`, partie 2. |
| 1:45 | Atelier (énoncé dans `atelier/`) | Circuler. Vérifier les `label`, les `name`, le validateur. |
| 2:50 | Clôture | Annoncer TP1 noté la semaine prochaine, sur ces pages. Les pages doivent être finies et sur Git. |

## Points d'attention

* **Ne pas refaire un cours de programmation.** Ces étudiants savent ce qu'est une variable. Si un groupe est très débutant (voir quiz), le noter pour les accompagner en atelier, pas pour ralentir tout le monde.
* **Faire lire les DevTools très tôt.** C'est l'outil qui répond à 80 % de leurs questions pendant le semestre. Le réflexe « F12, onglet Network » doit être acquis dès aujourd'hui.
* **HTML ≠ apparence.** Beaucoup ont appris `<b>`, `<br><br><br>`, `<table>` pour la mise en page. Casser ça tout de suite.
* **Attribut `name`** : sans lui, la donnée n'est jamais envoyée au serveur. C'est l'erreur n° 1 en S04. Le dire dès maintenant.

## Questions à poser pendant le cours

* « Si le serveur ne peut jamais parler en premier, comment fait WhatsApp Web pour afficher un nouveau message ? » (Réponse courte : le client redemande souvent, ou garde une connexion ouverte, WebSocket. Juste pour faire réfléchir.)
* « Pourquoi le fragment `#agenda` n'est-il pas envoyé au serveur ? » (Il sert seulement au navigateur pour se placer dans la page.)
* « Pourquoi un GET ne doit-il pas supprimer de données ? » (Les liens sont suivis par des robots, préchargés, mis en cache, ajoutés aux favoris.)
* « Un `required` en HTML, ça protège le serveur ? » (Non, on l'enlève dans les DevTools en 5 secondes. À montrer.)

## Erreurs fréquentes en atelier

| Erreur | Réaction |
|---|---|
| `<div class="header">` au lieu de `<header>` | Demander : « quelle balise a ce sens ? » |
| Plusieurs `<h1>` ou titres qui sautent (`h1` → `h4`) | Montrer l'outline dans le validateur |
| `input` sans `label` | Cliquer sur le texte : rien ne se passe. Ajouter `for`/`id`. |
| `input` sans `name` | Le noter maintenant, on le verra casser en S04 |
| Liens cassés (`Evenements.html` vs `evenements.html`) | Sur Linux/serveur, la casse compte |
| `<br>` pour espacer | « L'espace, c'est le CSS, semaine prochaine. » |

## Ce qui doit être prêt pour S02

Les 3 pages HTML de chaque binôme, dans leur dépôt Git. Si un binôme n'a pas fini, il peut partir de `atelier/solution/` (c'est le *starter* du TP1). Personne ne doit être bloqué au TP1 à cause de S01.
