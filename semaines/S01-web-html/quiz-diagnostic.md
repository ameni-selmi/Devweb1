# Quiz diagnostic (S01, non noté, 10 minutes)

Ce quiz n'est **pas noté**. Il sert à adapter le cours à votre niveau. Répondez honnêtement ; « je ne sais pas » est une bonne réponse.

**Nom :** ............................ **Formation précédente :** ............................

## Partie A : votre expérience

Pour chaque ligne, cochez une case : 0 = jamais utilisé · 1 = un peu · 2 = à l'aise

| | 0 | 1 | 2 |
|---|---|---|---|
| HTML | ☐ | ☐ | ☐ |
| CSS | ☐ | ☐ | ☐ |
| JavaScript | ☐ | ☐ | ☐ |
| PHP | ☐ | ☐ | ☐ |
| SQL (SELECT, INSERT, JOIN) | ☐ | ☐ | ☐ |
| Git (commit, push) | ☐ | ☐ | ☐ |
| Programmation orientée objet (n'importe quel langage) | ☐ | ☐ | ☐ |
| Un framework web (Laravel, Django, React, Spring...) | ☐ | ☐ | ☐ |

## Partie B : quelques questions

1. Que signifie le code HTTP `404` ?
2. Quelle est la différence entre une requête `GET` et une requête `POST` ?
3. Écrivez la balise HTML d'un lien vers `contact.html`.
4. En CSS, comment rendre le texte de tous les paragraphes rouge ?
5. Écrivez une requête SQL qui récupère tous les étudiants de 1re année (colonne `year`), dans une table `students`.
6. Le code JavaScript d'une page s'exécute-t-il sur le serveur ou dans le navigateur ?
7. Que peut-il arriver si on écrit : `"SELECT * FROM users WHERE email = '" + email + "'"` ?

---

## Corrigé (enseignant)

1. Ressource non trouvée (erreur du client).
2. GET : lire, données dans l'URL. POST : envoyer, données dans le corps.
3. `<a href="contact.html">Contact</a>`
4. `p { color: red; }`
5. `SELECT * FROM students WHERE year = 1;`
6. Dans le navigateur.
7. Injection SQL.

**Lecture des résultats** : compter les étudiants à « 2 » en SQL et en OOP (ça confirme qu'on peut aller vite en S06 et S07), et repérer les étudiants à « 0 » partout (les placer en binôme avec un étudiant plus à l'aise, et les suivre en atelier).
