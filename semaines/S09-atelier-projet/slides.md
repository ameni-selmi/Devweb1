---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · Amani Selmi · S09 · Atelier projet et revue de code'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Séance 9 : Atelier projet et revue de code

**Amani Selmi, PhD-Engineer**

---

## Aujourd'hui

1. Ce que j'ai vu au jalon 1 (15 min)
2. **Revue de code croisée** (30 min)
3. Travail sur le projet, points individuels

Il reste **deux séances** avant la soutenance. La séance 10 se termine par le **gel** des fonctionnalités.

---

## Ce que j'ai vu au jalon 1 : les bonnes nouvelles

* Des idées vraiment originales, avec de vrais utilisateurs
* La structure du cours reprise dans la plupart des projets
* Des schémas de base de données propres, avec des contraintes

<!-- Adapter cette slide et la suivante à ce qui a été vu réellement pendant le jalon 1. -->

---

## Ce que j'ai vu au jalon 1 : les pièges

| Piège | Correction |
|---|---|
| La mécanique centrale n'a pas commencé | Faites la version **minimale** cette semaine, même moche |
| Beaucoup de pages CRUD, rien de calculé | Moins de pages, plus de logique |
| Un seul membre commite | Répartissez **par fichiers**, commitez chacun |
| SQL dans les templates | Déplacez le dans un repository |
| Pas de `seed.sql` | Sans données, pas de démo |

---

## Découper la mécanique centrale

Exemple : « appariement de binômes de révision »

1. **Version 0** : une fonction PHP qui prend deux listes et renvoie les paires. Testée à la main.
2. **Version 1** : les données viennent de la base, résultat affiché dans un tableau.
3. **Version 2** : des critères en plus (créneaux, niveau), un score.
4. **Version 3** : l'interface, le style, fetch si le temps le permet.

Une version 1 qui marche vaut mieux qu'une version 3 à moitié faite.

---

## La revue de code : pourquoi

* Lire le code des autres, c'est **la moitié** du métier de développeur
* Un regard extérieur trouve des failles que vous ne voyez plus
* Vous verrez d'autres façons de résoudre les mêmes problèmes

<div class="regle">

On critique le **code**, jamais les personnes. Chaque remarque négative vient avec une proposition.

</div>

---

## La revue de code : comment (30 min)

1. **5 min** : le binôme A installe le projet du binôme B (avec le README !)
2. **15 min** : A remplit la grille `revue-de-code.md` sur le projet de B
3. **5 min** : A explique ses remarques à B
4. **5 min** : on échange les rôles pour la partie orale

Les binômes sont formés au tableau. Chaque binôme repart avec **une** grille remplie sur son projet.

---

## Ce qu'on regarde

* **Ça s'installe ?** Le README suffit il ?
* **Sécurité** : les cinq attaques de la checklist
* **Structure** : SQL dans les repositories, logique dans les contrôleurs, HTML dans les templates
* **Lisibilité** : noms clairs, fonctions courtes, pas de code mort
* **La mécanique** : est ce qu'elle marche ? Qu'est ce qui la casse ?

---

## Après la revue

Transformez chaque remarque utile en **tâche** :

```
- [ ] Échapper le nom dans templates/match.php (revue)
- [ ] Vérifier le propriétaire dans controllers/group-edit.php (revue)
- [ ] Ajouter l'installation de la base au README (revue)
```

Dans un fichier `TODO.md` ou dans les *issues* GitHub. Et commencez par la sécurité.

---

## La suite

| Séance | Étape |
|---|---|
| S09 (aujourd'hui) | Revue de code, mécanique centrale |
| **S10** | Préparation de la soutenance, **jalon 2 : tout est gelé** |
| **S11** | Soutenance : démo, questions individuelles, modification en direct |

Au travail !
