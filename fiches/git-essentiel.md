# Aide-mémoire : Git à deux

## Démarrer

```bash
git config --global user.name "Prénom Nom"        # une fois par ordinateur
git config --global user.email "vous@exemple.com"

git clone https://github.com/votre-compte/clubhub.git   # récupérer un dépôt
cd clubhub
```

Créer le dépôt : sur GitHub (ou GitLab), **New repository**, puis `git clone`. Ajoutez votre binôme et l'enseignante comme collaborateurs.

## Le cycle de tous les jours

```bash
git pull                     # 1. récupérer le travail de l'autre AVANT de commencer
# ... travailler ...
git status                   # 2. voir ce qui a changé
git add fichier.php          # 3. choisir ce qu'on enregistre (ou : git add .)
git commit -m "Ajoute la page de connexion"   # 4. enregistrer, avec un message clair
git push                     # 5. envoyer
```

**Un commit = une étape qui marche.** Plusieurs petits commits valent mieux qu'un gros « tout le TP ».

## De bons messages de commit

| Mauvais | Bon |
|---|---|
| `modif` | `Ajoute la validation serveur du formulaire d'inscription` |
| `fix` | `Corrige l'affichage des places sur mobile` |
| `tp4` | `Remplace users.json par la table users` |

## `.gitignore`

```
config.php
.DS_Store
*.log
```

Jamais dans Git : mots de passe, `config.php`, fichiers générés, dossiers `vendor/` ou `node_modules/`.

Vous avez commité `config.php` par erreur ?

```bash
git rm --cached config.php
echo "config.php" >> .gitignore
git commit -m "Retire config.php du dépôt"
```

(Et changez le mot de passe : il reste dans l'historique.)

## Travailler à deux sans se marcher dessus

* **Répartissez par fichiers** : l'un fait les contrôleurs et templates des événements, l'autre les comptes.
* `git pull` **avant** de commencer et **avant** de pousser.
* Poussez souvent (au moins à la fin de chaque séance).

## Conflit

`git pull` affiche `CONFLICT` :

1. Ouvrez le fichier : Git a marqué les deux versions.
   ```
   <<<<<<< HEAD
   votre version
   =======
   la version de l'autre
   >>>>>>> origin/main
   ```
2. Gardez la bonne version (ou un mélange), supprimez les marqueurs.
3. `git add fichier.php` puis `git commit`.

VS Code affiche des boutons « Accept Current / Incoming / Both » : pratique.

## Revenir en arrière

```bash
git log --oneline            # l'historique
git diff                     # ce qui a changé depuis le dernier commit
git restore fichier.php      # annuler les changements d'un fichier (non commités)
git revert <commit>          # annuler un commit déjà poussé (crée un nouveau commit)
```

## Rendre un TP

Le **dernier commit poussé avant l'heure limite** est corrigé. Vérifiez sur le site GitHub que tout y est.
