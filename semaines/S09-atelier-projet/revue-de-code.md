# Grille de revue de code croisée

**Relecteurs (binôme A) :** ................................ **Projet relu (binôme B) :** ................................

Durée : 15 minutes. Soyez précis : indiquez le **fichier** et la **ligne**. Chaque problème vient avec une **proposition**.

## 1. Installation (3 min)

| Question | Oui | Non | Remarque |
|---|---|---|---|
| Le README explique comment installer la base et lancer le site | ☐ | ☐ | |
| Nous avons réussi à lancer le projet en moins de 5 minutes | ☐ | ☐ | |
| Des comptes de démonstration sont donnés | ☐ | ☐ | |
| `config.php` n'est pas dans le dépôt | ☐ | ☐ | |

## 2. Les cinq attaques (5 min)

| Attaque | Résistée ? | Où ça casse (fichier, ligne) |
|---|---|---|
| `<script>alert(1)</script>` dans chaque champ texte, puis affichage | ☐ | |
| `' OR '1'='1` dans la recherche et la connexion | ☐ | |
| Ouvrir une page protégée sans être connecté | ☐ | |
| Changer un `id` pour viser la ressource d'un autre utilisateur | ☐ | |
| Envoyer un formulaire vide ou absurde (JS désactivé ou `curl`) | ☐ | |

Et les commandes `grep` de `fiches/securite-checklist.md` : résultats ?

.................................................................................................

## 3. Structure et lisibilité (4 min)

| Question | Oui | Non | Exemple |
|---|---|---|---|
| Le SQL est seulement dans des repositories (ou des fichiers dédiés) | ☐ | ☐ | |
| Les templates n'ont pas de logique (pas de SQL, pas de `$_POST`) | ☐ | ☐ | |
| Les noms (fichiers, fonctions, variables) sont clairs | ☐ | ☐ | |
| Pas de gros blocs copiés collés | ☐ | ☐ | |
| Le site est utilisable sur téléphone | ☐ | ☐ | |

## 4. La mécanique centrale (3 min)

* Qu'est ce que l'application calcule, joue, apparie, classe, planifie ou visualise ?

.................................................................................................

* Fonctionne-t-elle ? Avez vous réussi à la casser (cas limite, données vides, valeurs extrêmes) ?

.................................................................................................

## 5. Bilan

**Trois choses bien faites :**

1. .................................................................................................
2. .................................................................................................
3. .................................................................................................

**Les trois corrections les plus importantes, par ordre de priorité :**

1. .................................................................................................
2. .................................................................................................
3. .................................................................................................

**Une idée que nous allons reprendre dans notre propre projet :**

.................................................................................................

---

*À rendre au binôme B à la fin de la revue. Le binôme B la garde dans son dépôt (`docs/revue-S09.md`).*
