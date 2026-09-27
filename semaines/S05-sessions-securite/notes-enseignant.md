# S05 : Notes pour l'enseignante

## Objectif de la séance

À la fin, chaque étudiant doit pouvoir :

1. expliquer ce que contient un cookie de session et où sont les vraies données ;
2. créer un compte et connecter un utilisateur avec `password_hash` / `password_verify` ;
3. protéger une page côté serveur ;
4. appliquer Post/Redirect/Get avec un message flash.

Le message clé : **le navigateur ne garde qu'un identifiant. Tout le reste est sur le serveur, et c'est le serveur qui décide.**

## Préparation

* [ ] Publier `tp3/starter/` et le corrigé de l'atelier S04.
* [ ] Préparer la démo de session (`live-coding/demo/`), avec deux navigateurs ouverts (par exemple Chrome et Firefox, ou une fenêtre privée).
* [ ] Vérifier que les binômes de projet sont formés. Rappeler la proposition à rendre en S06.

## Déroulé minuté

| Temps | Activité | Remarques |
|---|---|---|
| 0:00 | Retour atelier S04 | Questions sur `$_POST`, `e()`. Qui a fait le défi F5 ? Garder la réponse pour la slide PRG. |
| 0:10 | Slides 3 à 7 + live coding partie 1 | Cookie, session. La démo du vol de cookie entre deux navigateurs marque les esprits. |
| 0:30 | Slides 8 à 12 + live coding partie 2 | Hachage, connexion, page protégée. |
| 0:50 | Slides 13 à 17 : déconnexion, PRG, flash | Faire le lien avec le défi F5 de S04. |
| 1:05 | Pause | |
| 1:15 | Présentation du TP3 (slides 18 à 20) | Montrer ce qui est donné (`users.php`, squelette de `auth.php`). |
| 1:20 | **TP3** | Circuler. |
| 2:50 | Clôture | Poser la question de la slide 19 à voix haute. Annoncer S06 : MySQL. Proposition de projet à rendre avant la fin de la semaine prochaine. |

## Points d'attention

* **Pourquoi un fichier JSON ?** Des étudiants demanderont « pourquoi pas directement MySQL ? ». Réponse honnête : pour voir la logique de session seule, sans mélanger deux nouveautés. Et pour sentir les limites du fichier (pas de requêtes, pas de concurrence propre) avant S06.
* **`Headers already sent`** : très fréquent aujourd'hui, car `session_start()` et `header()` doivent passer avant tout affichage. Faire regarder la ligne indiquée dans l'erreur : c'est souvent un espace avant `<?php` ou un `echo` de débogage.
* **Session qui « ne marche pas »** : `session_start()` oublié sur une page (d'où le bootstrap unique), ou cookies bloqués.
* **`requireLogin()` en haut** : certains l'appellent après avoir inclus l'en-tête. La redirection échoue (en-têtes déjà envoyés). Règle : toute la logique PHP avant `require header.php`.
* **Le défi « open redirect »** : bonne occasion de montrer qu'une fonctionnalité innocente (revenir à la page demandée) devient une faille si on accepte n'importe quelle URL.
* **Les inscriptions dans la session** : c'est **volontaire**. Si un étudiant le trouve absurde, tant mieux : c'est exactement la motivation de S06. Ne pas « corriger » le TP en ajoutant un fichier `registrations.json`.

## Question de fin de séance

« Inscrivez vous à deux événements. Déconnectez vous. Reconnectez vous. Où sont vos inscriptions ? Et comment le Club Robotique pourrait il voir la liste de ses inscrits ? »

Attendu : la session est **par navigateur** et **temporaire**. Pour partager des données entre utilisateurs et les garder, il faut un stockage commun et durable, qu'on peut interroger : une base de données.

## Correction

Les tests de sécurité de la grille d'abord : ils prennent 3 minutes et donnent une idée claire du niveau. Si un test échoue, montrer l'attaque au binôme (c'est plus formateur que la note).

## Erreurs fréquentes

| Erreur | Réaction |
|---|---|
| `Headers already sent` | Tout le PHP avant le premier HTML ; pas d'espace avant `<?php` |
| Toujours déconnecté après la connexion | `session_start()` absent de la page suivante → bootstrap |
| `password_verify` renvoie toujours `false` | Le hachage est recalculé à la connexion au lieu d'être comparé, ou le mot de passe a été `trim()` à un endroit et pas à l'autre |
| Le message flash s'affiche deux fois, ou jamais | `unset` oublié, ou `takeFlash()` appelé avant la redirection |
| Lien « Déconnexion » en GET | Montrer l'attaque `<img src=".../deconnexion.php">` |
| « Mon compte » affiche l'utilisateur 1 pour tout le monde | L'id vient de l'URL (`?id=1`) au lieu de la session : faille grave, en parler |
