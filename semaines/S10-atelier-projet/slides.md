---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · Amani Selmi · S10 · Préparer la soutenance'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Séance 10 : Préparer la soutenance

**Amani Selmi, PhD-Engineer**

---

## Aujourd'hui

1. Comment se passe la soutenance (15 min)
2. Travail : finir, nettoyer, répéter
3. **Jalon 2** : à la fin de la séance, les fonctionnalités sont **gelées**
4. Planning des soutenances

---

## Gel des fonctionnalités : pourquoi

Après aujourd'hui, **plus de nouvelles fonctionnalités**. Seulement :

* corriger des bugs
* corriger la sécurité
* nettoyer le code
* finir le README
* répéter la démo

Une nouvelle fonctionnalité la veille de la soutenance, c'est un bug pendant la démo.

---

## La soutenance : 12 minutes

| Temps | Quoi | Qui |
|---|---|---|
| 4 min | **Démo** de l'application et de sa mécanique centrale | Le binôme |
| 5 min | **Questions individuelles** | Chacun seul |
| 3 min | **Modification en direct** | Un membre, choisi par moi |

Puis 3 minutes pour que je note.

---

## La démo : 4 minutes, pas une de plus

1. **Qui** est l'utilisateur, **quel** problème (30 s)
2. Le parcours principal, avec des données réalistes (1 min 30)
3. **La mécanique centrale**, et pourquoi elle est intéressante (1 min 30)
4. Une option Avancé, si vous en avez une (30 s)

Préparez les comptes, les données, les onglets **avant**. Répétez avec un chronomètre.

---

## Les questions individuelles

Elles portent sur **votre** code. Exemples :

* « Je clique ici. Montrez moi la requête dans les DevTools. Quel fichier la reçoit ? »
* « Montrez la requête SQL de cette page. Pourquoi `prepare` ? »
* « Où est vérifié que cette page est protégée ? Et que cette ressource est à vous ? »
* « Expliquez l'algorithme de votre mécanique. Et dans ce cas limite ? »

Chacun doit connaître **tout** le projet, pas seulement sa partie.

---

## La modification en direct

Quelque chose de petit, dans **votre** code. Par exemple :

* ajouter un champ à un formulaire et l'enregistrer en base
* ajouter une validation côté serveur avec un message
* trier une liste autrement, ou ajouter un filtre
* afficher une information d'une autre table
* protéger une page

Vous avez 3 minutes. Si vous n'y arrivez pas, **expliquez** la démarche : ça compte aussi.

---

## Comment vous serez notés

| Partie | Points | Commun ou individuel |
|---|---|---|
| Le produit (Base, Solide, Avancé, originalité, README) | 14 | Commun |
| Démo | 1 | Commun |
| Questions | 3 | **Individuel** |
| Modification en direct | 2 | **Individuel** |

Si vous ne pouvez pas expliquer une partie de **votre** code, ses points ne vous sont pas comptés.

Grille complète : `projet/grille.md`

---

## Le README final

* [ ] Nom, utilisateur, problème (5 lignes)
* [ ] Comptes de démonstration
* [ ] Installation : étapes **exactes**
* [ ] Schéma de la base
* [ ] **Le trajet d'une requête** : du clic à la base et retour, fichiers et fonctions
* [ ] Options Avancé réalisées
* [ ] Qui a fait quoi

---

## Checklist de la veille

* [ ] Base réinitialisée avec `schema.sql` + `seed.sql` : tout marche
* [ ] Les cinq attaques de la checklist sécurité : résistées
* [ ] Dernier commit poussé, vérifié sur GitHub
* [ ] Démo répétée **deux fois** avec un chronomètre
* [ ] Chaque membre a relu le code de l'autre
* [ ] Ordinateur chargé, projet lancé, onglets prêts

Fiche : `semaines/S10-atelier-projet/preparation-soutenance.md`

---

## Au travail

* Maintenant : finir la mécanique, corriger les remarques de la revue
* Je passe voir chaque binôme pour le **jalon 2**
* En fin de séance : le planning des soutenances
