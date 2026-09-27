# Soutenances : guide pour l'enseignant

## Organisation

* 12 minutes par binôme + 3 minutes pour noter = 15 minutes. **12 binômes par séance de 3 h.**
* Au delà de 12 binômes : commencer les soutenances dans la dernière heure de S10, ou prévoir un créneau en plus.
* Les étudiants lancent l'application **sur leur machine** (ou sur l'URL en ligne). Ils doivent être prêts à la minute où ils passent.
* Avoir le dépôt Git ouvert sur **votre** machine, au dernier commit avant S11.

## Déroulé

| Temps | Étape |
|---|---|
| 0:00 à 4:00 | Démo par le binôme. Couper à 4 min. |
| 4:00 à 9:00 | Questions individuelles : 2 à 3 questions par étudiant, l'autre ne répond pas. |
| 9:00 à 12:00 | Modification en direct, par un étudiant choisi par vous. |

## Banque de questions

### Trajet d'une requête (AA1)
* « Je clique sur ce bouton. Montrez moi, dans les DevTools, la requête envoyée. Quelle méthode ? Quelles données ? »
* « Quel fichier PHP reçoit cette requête ? Montrez la ligne. »
* « Que renvoie le serveur ? Un code 200 ? Une redirection ? Pourquoi ? »

### Frontend (AA2, AA3)
* « Pourquoi cette carte passe en une colonne sur téléphone ? Montrez la règle. »
* « Ce JavaScript s'exécute où ? Qu'est ce qui se passe si je désactive JavaScript ? »
* « Où est l'écouteur d'événement de ce bouton ? »

### Serveur et sessions (AA4)
* « Comment le serveur sait il que vous êtes connecté ? Montrez le cookie dans les DevTools. »
* « Où est vérifié que cette page est protégée ? Et si j'enlève cette ligne ? »
* « Pourquoi une redirection après ce formulaire ? »

### Base de données (AA5)
* « Montrez la requête SQL de cette page. Pourquoi `prepare` ? Que se passe-t-il si on concatène ? »
* « Expliquez ce JOIN. Que renvoie-t-il si l'utilisateur n'a aucune réservation ? »
* « Pourquoi cette colonne est elle `UNIQUE` ? »

### Mécanique centrale
* « Expliquez l'algorithme de [appariement / classement / calcul]. Que se passe-t-il dans le cas [cas limite] ? »

## Banque de modifications en direct (3 min)

Choisir une modification adaptée au projet :

* Ajouter un champ à un formulaire et l'enregistrer en base (nouvelle colonne incluse).
* Ajouter une validation côté serveur (par exemple longueur minimale) avec un message d'erreur.
* Trier une liste autrement (changer l'`ORDER BY`), ou ajouter un filtre.
* Afficher une nouvelle information venant d'une autre table (modifier un JOIN).
* Protéger une page qui ne l'est pas encore.
* Changer une couleur du thème partout (variable CSS).

Si l'étudiant n'y arrive pas en 3 minutes mais explique correctement la démarche (quels fichiers, quelles lignes), B3 peut valoir 1 sur 2.
