#!/usr/bin/env bash
# Génère les slides (PDF + HTML) de toutes les semaines dans build/
# Usage : bash outils/build.sh          (toutes les semaines)
#         bash outils/build.sh S02      (une seule semaine)
set -e
cd "$(dirname "$0")/.."
mkdir -p build
for f in semaines/${1:-S}*/slides.md; do
  [ -f "$f" ] || continue
  nom=$(basename "$(dirname "$f")" | cut -d- -f1)
  echo "→ $nom"
  marp --theme outils/theme-devweb.css --allow-local-files "$f" -o "build/$nom.pdf"
  marp --theme outils/theme-devweb.css "$f" -o "build/$nom.html"
done
echo "Terminé : voir build/"
