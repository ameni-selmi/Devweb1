# Production du cours : comment tout est organisé

Amani Selmi, PhD-Engineer

## Le principe

* **Les sources sont en texte** : Markdown pour les slides et les documents, vrai code pour les TP. Tout est dans ce dépôt Git.
* **Les fichiers à distribuer sont générés** dans `build/` : PowerPoint et Word **modifiables**, PDF, ZIP de code.
* **`COURSE_BIBLE.md` est la référence** : stack, conventions, application fil rouge, données d'exemple, règles de sécurité.
* **La solution de la semaine N est le starter de la semaine N+1.** Chaque solution a été lancée et testée (navigateur réel, serveur PHP, base MariaDB).

## Ce qui est généré

| Dossier | Contenu | Format |
|---|---|---|
| `build/slides/` | Une présentation par séance (S01 à S11) | `.pptx` modifiable + `.pdf` |
| `build/enseignant/` | Plan, course bible, notes de séance, scripts de live coding, grilles de TP, jalons, quiz, guide et planning des soutenances | `.docx` + `.pdf` |
| `build/etudiants/` | Énoncés, aide-mémoire, cahier des charges, grille du projet, modèle de proposition, grille de revue de code, préparation de la soutenance | `.docx` + `.pdf` |
| `build/code/` | Starter et corrigé de chaque TP et atelier, démos de live coding | `.zip` |

Les PowerPoint sont construits avec de **vraies zones de texte, de vrais tableaux et les notes de l'orateur** : vous pouvez tout modifier directement dans PowerPoint, Keynote ou LibreOffice.

## Deux façons de modifier

**1. Petite retouche pour une séance** : ouvrez le `.pptx` ou le `.docx` dans `build/` et modifiez le. Simple et rapide.

**2. Changement durable (à garder d'une année à l'autre)** : modifiez la source Markdown, puis régénérez :

```bash
python3 outils/build_all.py          # tout
python3 outils/build_all.py slides   # seulement les slides
python3 outils/build_all.py docs     # seulement les documents
python3 outils/build_all.py code     # seulement les ZIP
```

Attention : régénérer **écrase** les fichiers de `build/`. Si vous avez retouché un `.pptx` à la main, reportez la retouche dans `slides.md`.

Outils nécessaires : Node.js + `npm install -g pptxgenjs`, Python 3 + `pip install python-docx`, Pandoc, LibreOffice (pour les PDF).

## Où est quoi

| Je veux changer... | Fichier source |
|---|---|
| Les slides d'une séance | `semaines/SXX-.../slides.md` (notes de l'orateur dans les `<!-- ... -->`) |
| Le déroulé d'une séance | `semaines/SXX-.../notes-enseignant.md` |
| Un énoncé de TP | `semaines/SXX-.../tp*/enonce.md` |
| Une grille de correction | `semaines/SXX-.../tp*/grille.md` |
| Le code donné aux étudiants | `semaines/SXX-.../tp*/starter/` |
| Le corrigé | `semaines/SXX-.../tp*/solution/` |
| Le projet final | `projet/` |
| Les poids de l'évaluation | `plan/plan-semestre.md` et la slide « Évaluation » de `S01/slides.md` |
| Les couleurs des slides | `outils/build_slides.js` (objet `C` en haut du fichier) |

## Syntaxe des slides

```markdown
---
<!-- _class: titre -->          slide de titre bleue
<!-- _class: question -->       question à la salle
## Titre de la slide
Texte avec **gras**, *italique* et `code`.
* liste
1. liste numérotée
| tableau | ... |
<div class="piege">Encadré rouge</div>
<div class="regle">Encadré vert</div>
<!-- Tout autre commentaire devient une note de l'orateur. -->
---
```

Les mêmes fichiers `slides.md` s'ouvrent aussi avec **Marp** (extension VS Code « Marp for VS Code ») et le thème `outils/theme-devweb.css`, si vous préférez projeter en HTML.

## Publier pour les étudiants

Gardez deux dépôts :

* `devweb1-enseignant` (privé) : tout ce dépôt.
* `devweb1` (partagé avec le groupe) : sans les corrigés ni les documents enseignant. On y ajoute chaque corrigé **après** la date limite du TP.

```bash
rsync -av --exclude 'solution/' --exclude 'notes-enseignant.md' --exclude 'live-coding.md' \
  --exclude 'grille.md' --exclude 'jalon*.md' --exclude 'quiz-diagnostic.md' --exclude 'soutenance.md' \
  --exclude 'planning-modele.md' --exclude 'COURSE_BIBLE.md' --exclude 'build/' --exclude '.git/' \
  ./ ../devweb1-etudiants/
```

Attention : `projet/grille.md` reste visible des étudiants (c'est voulu : ils savent comment ils seront notés).

## Réutiliser ailleurs

Aucun nom d'établissement, aucun code de module, aucune année n'apparaît dans les supports. Pour un nouveau groupe :

* adaptez les poids de l'évaluation (`plan/plan-semestre.md`, slide 6 de S01) ;
* adaptez le volume horaire (section « Adapter à un autre volume horaire » du plan) ;
* vérifiez l'installation en salle (`fiches/installation.md`) ;
* les dates des événements de ClubHub sont calculées à partir du jour où la base est créée : rien à changer.

## État

| Séance | Slides | Notes | Live coding | Énoncé | Starter | Solution testée | Grille |
|---|---|---|---|---|---|---|---|
| S01 HTML | ✅ | ✅ | ✅ | ✅ atelier + quiz | | ✅ | |
| S02 CSS · TP1 | ✅ | ✅ | ✅ | ✅ | ✅ + maquettes | ✅ | ✅ |
| S03 JS · TP2 | ✅ | ✅ | ✅ + démo | ✅ | ✅ | ✅ | ✅ |
| S04 PHP | ✅ | ✅ | ✅ + démo | ✅ atelier | ✅ | ✅ | |
| S05 Sessions · TP3 | ✅ | ✅ | ✅ + démo | ✅ | ✅ | ✅ | ✅ |
| S06 MySQL · TP4 | ✅ | ✅ | ✅ + démo | ✅ | ✅ + SQL | ✅ | ✅ |
| S07 Structure · TP5 | ✅ | ✅ | ✅ (construction collective) | ✅ | ✅ | ✅ | ✅ |
| S08 fetch | ✅ | ✅ | ✅ + démo | ✅ atelier + jalon 1 | ✅ | ✅ | |
| S09 Revue de code | ✅ | ✅ | | ✅ grille de revue | | | |
| S10 Préparation | ✅ | ✅ | | ✅ fiche + jalon 2 | | | |
| S11 Soutenances | ✅ | ✅ | | ✅ planning | | | |
| Projet | | | | ✅ cahier des charges, modèle, grille, guide | | | |

Aide-mémoire : installation, HTTP, HTML, CSS, JavaScript, PHP, SQL et PDO, sécurité, DevTools, Git.
