# Atelier S08 : ClubHub sans rechargement

**Non noté** · En binôme · Durée : 30 min en séance (puis travail sur le projet)
Ce que vous apprenez ici est l'option **Avancé « fetch + endpoint JSON »** du projet.

## Objectifs

* Écrire un endpoint PHP qui reçoit et renvoie du JSON.
* Appeler cet endpoint avec `fetch`, `async` et `await`.
* Mettre à jour la page sans la recharger, sans faille, et sans casser la version sans JavaScript.

## Ce qu'on vous donne

`atelier/starter/` : le corrigé du TP5.

## Travail demandé

### Base

1. **Helpers** : dans `src/helpers.php`, ajoutez `jsonResponse(array $data, int $status = 200): never` et `jsonBody(): array` (voir les slides).
2. **Endpoint d'inscription** : route `api-inscription` → `controllers/api/register.php`. Il accepte seulement POST (sinon 405), et reçoit `{"eventId": 3, "motivation": "...", "rules": true}`. Il renvoie :

   | Cas | Code | JSON |
   |---|---|---|
   | Pas connecté | 401 | `{"error": "..."}` |
   | Événement inconnu | 404 | `{"error": "..."}` |
   | Règlement non accepté, motivation trop longue | 422 | `{"error": "...", "fields": {...}}` |
   | Déjà inscrit, complet | 409 | `{"error": "..."}` |
   | Inscrit | 200 | `{"registered": true, "message": "...", "placesLabel": "18 places restantes"}` |

   Testez le **avant** d'écrire le JS, avec `curl` ou la console du navigateur.
3. **Le JavaScript** : sur la page d'un événement, quand le formulaire est valide, envoyez le avec `fetch` au lieu de recharger la page. En cas de succès : mettez à jour le nombre de places, remplacez le formulaire par « Vous êtes inscrit », affichez le message. En cas d'erreur : affichez le message d'erreur.

   Indices : ajoutez `data-api` et `data-event-id` sur la section `.registration`, et un `id` sur le texte des places.

4. **Sans JavaScript**, le formulaire classique doit toujours marcher (testez en désactivant JavaScript).

### Plus

5. **Annuler sans recharger** : route `api-annulation`, et dans « Mon compte », le bouton « Annuler » supprime la ligne du tableau sans recharger la page (après une confirmation).

### Défi

6. **Recherche en direct** : route `api-evenements&q=...` qui renvoie les événements en JSON (choisissez les champs : pas toute la ligne). Sur la liste des événements, la recherche interroge le serveur 300 ms après la dernière frappe, et reconstruit les cartes avec `createElement` et `textContent`. Le filtre par club et le tri marchent toujours.

## Vérifier

* F12 → Network → **Fetch/XHR** : vous voyez vos requêtes, leur *Payload* et leur réponse.
* Pendant une inscription en fetch, **aucune** requête de type *document* ne part.
* `curl -X POST -H "Content-Type: application/json" -d '{"eventId":1,"rules":true}' "localhost:8000/index.php?page=api-inscription"` renvoie **401** (pas de cookie de session).

## Aide

* Fiche : `fiches/javascript-pour-programmeurs.md` (section Asynchrone)
* `Unexpected token '<'` dans `response.json()` : le serveur a renvoyé du HTML (souvent une erreur PHP). Regardez la réponse dans l'onglet Network.
* `$_POST` est vide : normal avec du JSON, lisez `php://input` avec `jsonBody()`.
