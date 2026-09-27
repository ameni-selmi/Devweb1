# Préparer la soutenance (fiche étudiant)

## Le déroulé (12 minutes)

1. **Démo** (4 min), par le binôme.
2. **Questions individuelles** (5 min) : chacun répond seul, l'autre ne souffle pas.
3. **Modification en direct** (3 min) : un membre, choisi par l'enseignante, modifie le code.

## Préparer la démo

Écrivez le scénario sur papier, minute par minute :

| Temps | Ce que je montre | Qui parle |
|---|---|---|
| 0:00 | L'utilisateur et le problème | |
| 0:30 | Le parcours principal | |
| 2:00 | La mécanique centrale | |
| 3:30 | L'option Avancé (si elle existe) | |

* Préparez les comptes et les données **avant** (un seed réaliste, pas « test1, test2 »).
* Ouvrez les onglets à l'avance : un navigateur connecté en utilisateur, un autre en administrateur si besoin.
* Zoom du navigateur à 125 % ou plus : la salle doit pouvoir lire.
* Répétez **deux fois** avec un chronomètre. À 4 minutes, l'enseignante coupe.

## Préparer les questions

Chacun doit pouvoir répondre sur **tout** le projet. Entraînez vous à deux : l'un pose, l'autre répond, en montrant le code.

**Le trajet d'une requête**
* [ ] Je clique sur le bouton principal : quelle requête part (méthode, URL, données) ? Je sais la montrer dans F12 → Network.
* [ ] Quel fichier la reçoit ? Quelles fonctions sont appelées, dans quel ordre ?
* [ ] Que renvoie le serveur ? Pourquoi une redirection (ou un JSON) ?

**Le frontend**
* [ ] Pourquoi cette mise en page change sur téléphone ? Quelle règle CSS ?
* [ ] Où est ce JavaScript ? Que se passe-t-il si on le désactive ?

**Le serveur et la sécurité**
* [ ] Comment le serveur sait il qui est connecté ? Où est le cookie, que contient il ?
* [ ] Où est vérifié qu'une page est protégée ? Qu'une ressource vous appartient ?
* [ ] Pourquoi `e()` ? Pourquoi `prepare` ? Que se passe-t-il sans ?
* [ ] Comment sont stockés les mots de passe ?

**La base**
* [ ] Je sais dessiner le schéma et expliquer chaque relation.
* [ ] Je sais expliquer chaque JOIN du projet.
* [ ] Pourquoi cette contrainte `UNIQUE` (ou cette clé étrangère) ?

**La mécanique centrale**
* [ ] Je sais expliquer l'algorithme sans regarder le code.
* [ ] Je connais ses cas limites (liste vide, égalité, valeurs extrêmes) et ce que fait l'application.

## S'entraîner à la modification en direct

Faites chacun **au moins trois** de ces exercices, seul, en moins de 3 minutes, puis annulez avec `git restore .` :

* [ ] Ajouter un champ à un formulaire et l'enregistrer en base (avec la colonne SQL).
* [ ] Ajouter une validation serveur avec un message d'erreur.
* [ ] Changer le tri d'une liste, ou ajouter un filtre.
* [ ] Afficher une information qui vient d'une autre table.
* [ ] Protéger une page qui ne l'est pas.
* [ ] Changer la couleur principale du site partout.

## La veille

* [ ] Base réinitialisée avec `schema.sql` + `seed.sql`, et tout fonctionne.
* [ ] Les cinq attaques de `fiches/securite-checklist.md` : résistées.
* [ ] README complet (voir le cahier des charges).
* [ ] Dernier commit poussé et vérifié sur le site GitHub.
* [ ] Ordinateur chargé, chargeur dans le sac.

## Le jour J

* Arrivez 10 minutes avant votre passage, projet **déjà lancé**.
* Si quelque chose casse pendant la démo : restez calmes, expliquez ce qui devrait se passer. Ça arrive à tout le monde.
* Vous ne savez pas répondre ? Dites ce que vous savez, et comment vous chercheriez. C'est mieux qu'inventer.
