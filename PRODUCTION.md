# Suivi de production

## Workflow

1. **Tout est en texte dans un dépôt Git** : Markdown pour les documents, Marp (Markdown) pour les slides, vrai code pour les TP.
2. **`COURSE_BIBLE.md` est la source de vérité** : stack, conventions, application fil rouge, données d'exemple. On le lit avant de produire une nouvelle semaine.
3. **Une semaine par session de travail** : slides + notes + live coding + énoncé + starter + solution + grille.
4. **Chaque solution est testée** : le code PHP est lancé avec `php -S`, les pages sont ouvertes dans un navigateur, les slides sont générées.
5. **La solution de la semaine N est le starter de la semaine N+1.** C'est ce qui garantit la continuité de ClubHub.
6. **Build** : `bash outils/build.sh` génère les PDF et HTML des slides dans `build/`.

### Pourquoi ce format

* Diff et historique Git : on voit ce qui a changé d'une année à l'autre.
* Les slides Marp s'éditent comme du texte, se génèrent en PDF (à distribuer) et en HTML (à projeter). Export PowerPoint possible : `marp --pptx slides.md`.
* Le même dépôt sert aux étudiants (on publie une copie sans les dossiers `solution/` et `notes-enseignant.md`, voir plus bas).

### Publier pour les étudiants

Garder deux dépôts :

* `devweb1-enseignant` (privé) : tout.
* `devweb1` (public ou partagé avec la promo) : copie sans `solution/`, sans `notes-enseignant.md`, sans `live-coding.md`, sans `grille.md`, sans `projet/soutenance.md`. On y ajoute chaque solution **après** la date limite du TP.

Commande utile (à lancer depuis le dépôt enseignant) :

```bash
rsync -av --exclude 'solution/' --exclude 'notes-enseignant.md' --exclude 'live-coding.md' \
  --exclude 'grille.md' --exclude 'soutenance.md' --exclude 'build/' --exclude '.git/' \
  ./ ../devweb1-etudiants/
```

## État

| Semaine | Slides | Notes | Live coding | Énoncé | Starter | Solution testée | Grille |
|---|---|---|---|---|---|---|---|
| S01 HTML | ✅ | ✅ | ✅ | ✅ atelier | (aucun) | ✅ | (non noté) |
| S02 CSS · TP1 | ✅ | ✅ | ✅ | ✅ | ✅ + maquettes | ✅ | ✅ |
| S03 JS · TP2 | ⬜ | ⬜ | ⬜ | ⬜ | = solution TP1 | ⬜ | ⬜ |
| S04 PHP | ⬜ | ⬜ | ⬜ | ⬜ atelier | | ⬜ | |
| S05 Sessions · TP3 | ⬜ | ⬜ | ⬜ | ⬜ | | ⬜ | ⬜ |
| S06 MySQL · TP4 | ⬜ | ⬜ | ⬜ | ⬜ | | ⬜ | ⬜ |
| S07 Structure · TP5 | ⬜ | ⬜ | ⬜ | ⬜ | | ⬜ | ⬜ |
| S08 fetch/JSON | ⬜ | ⬜ | ⬜ | ⬜ | | ⬜ | |
| S09 à S11 | ⬜ | ⬜ | | | | | |
| Projet | | | | ✅ spécification, modèle, grille, soutenance | | | |

Fiches : ✅ HTML, ✅ HTTP, ✅ CSS, ✅ sécurité · ⬜ JavaScript, ⬜ PHP pour programmeurs, ⬜ PDO/SQL, ⬜ DevTools

## Prochaine session

Produire **S03 (JavaScript, TP2)**, en partant de `semaines/S02-css/tp1/solution/`. Contenu prévu (voir `plan/plan-semestre.md`) :

* filtre des événements par club et par recherche texte ;
* validation du formulaire d'inscription avec messages sous les champs ;
* compteur de caractères sur la motivation ;
* mode sombre avec les variables CSS ;
* fiche `fiches/javascript-pour-programmeurs.md`.

Pour reprendre avec Claude : « Lis `COURSE_BIBLE.md` et `PRODUCTION.md`, puis produis la semaine S03 complète en suivant les mêmes conventions que S02. »
