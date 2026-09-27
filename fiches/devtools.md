# Aide-mémoire : les DevTools (F12)

Réflexe du cours : **quand quelque chose ne marche pas, F12 avant tout.**

## Les onglets à connaître

| Onglet | Pour | Séances |
|---|---|---|
| **Elements** | Voir le HTML réel (le DOM), les règles CSS appliquées et barrées, le box model | S01, S02 |
| **Console** | Les erreurs JavaScript (fichier + ligne), tester une ligne de JS | S03 |
| **Network** | Chaque requête : méthode, URL, statut, headers, données envoyées, réponse | S01, S04 à S08 |
| **Application** | Cookies, `localStorage`, session | S03, S05 |
| **Sources** | Points d'arrêt dans le JavaScript | S03 |

## Raccourcis

| Raccourci | Action |
|---|---|
| F12 ou Ctrl+Shift+I (Cmd+Option+I sur Mac) | Ouvrir les DevTools |
| Ctrl+Shift+C | Choisir un élément dans la page |
| Ctrl+Shift+M | Mode responsive (téléphone, tablette) |
| Ctrl+Shift+R | Recharger sans cache |
| Ctrl+U | Voir le code source reçu du serveur |
| Ctrl+Shift+P, puis « Disable JavaScript » | Tester le site sans JS |

## Network : lire une requête

1. Ouvrir l'onglet **avant** l'action (ou recharger).
2. Cocher **Preserve log** pour garder les requêtes après une redirection (utile pour voir le POST puis le 302).
3. Filtrer : **Doc** (pages), **Fetch/XHR** (appels `fetch`), **CSS**, **JS**, **Img**.
4. Cliquer une requête :
   * **Headers** : méthode, statut, `Location` (redirection), `Set-Cookie`, `Content-Type` ;
   * **Payload** : les données envoyées (formulaire ou JSON) ;
   * **Preview / Response** : ce que le serveur a répondu.
5. Clic droit → **Copy as cURL** : rejouer la requête dans un terminal.

## Diagnostic rapide

| Symptôme | Où regarder | Cause fréquente |
|---|---|---|
| Le style ne s'applique pas | Elements (règle barrée ?), Network (CSS en 404 ?) | Chemin du fichier, spécificité, cache |
| « Rien ne se passe » au clic | Console | Erreur JS, sélecteur qui renvoie `null` |
| Le formulaire n'envoie pas une valeur | Network → Payload | Attribut `name` manquant |
| Page blanche | Network (statut 500 ?), terminal de `php -S` | Erreur PHP fatale |
| Je suis déconnecté à chaque page | Application → Cookies | `session_start()` absent, cookie bloqué |
| `fetch` échoue | Network → Fetch/XHR → Response | Le PHP a renvoyé du HTML ou une erreur au lieu de JSON |
| Le site est cassé sur téléphone | Mode responsive (Ctrl+Shift+M) | Largeur fixe en px, `viewport` absent |

## Accessibilité rapide

* Elements → sélecteur de couleur d'un texte : le **ratio de contraste** s'affiche (visez au moins 4,5).
* Onglet **Lighthouse** → Accessibilité : un rapport automatique (utile, mais pas suffisant).
* Naviguer toute la page avec **Tab** seulement : chaque lien et bouton doit être atteignable et visible.
