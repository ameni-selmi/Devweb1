# Corrigé TP2

À publier **après** la date limite du rendu.

* Couvre la Base, le Plus, et le défi « accents » (`normalize('NFD')`).
* Les défis favoris, cartes générées et « pas de flash » sont corrigés au cas par cas.
  * Indice pour le flash : le script est chargé avec `defer`, donc il s'applique **après** le premier affichage. La correction classique est un tout petit script dans le `<head>`, sans `defer`, qui lit `localStorage` et pose `data-theme` avant l'affichage.

Points à commenter en correction collective :

* section 2 : **une seule** fonction `update()` lit la recherche, le club et le tri, puis décide pour chaque carte ;
* section 3 : les règles de validation sont des **données** (un tableau d'objets `{ field, check }`), le code qui affiche les erreurs est écrit une seule fois ;
* `registrationForm.noValidate = true` : les attributs `required` restent dans le HTML pour le cas où JavaScript est désactivé.

Ce dossier (HTML + CSS + JS) est la base de la séance 4 : les pages `.html` deviennent des pages `.php`.
