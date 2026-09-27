#!/usr/bin/env bash
# Raccourci : génère tous les fichiers du cours dans build/ (voir PRODUCTION.md)
set -e
cd "$(dirname "$0")/.."
python3 outils/build_all.py "$@"
