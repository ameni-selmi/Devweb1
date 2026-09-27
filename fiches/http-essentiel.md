# Aide-mémoire : HTTP

## Le cycle

1. Le **client** (navigateur) envoie une **requête** (*request*).
2. Le **serveur** renvoie une **réponse** (*response*).
3. C'est fini. Le serveur **oublie tout** (*stateless*).

## Une requête

```http
POST /inscription.php HTTP/1.1          ← méthode, chemin, version
Host: localhost:8000                     ← headers
Content-Type: application/x-www-form-urlencoded
Cookie: PHPSESSID=abc123

name=Amine&email=amine%40ecole.tn        ← body (seulement en POST)
```

## Une réponse

```http
HTTP/1.1 302 Found                       ← statut
Location: /merci.php                     ← headers
Set-Cookie: PHPSESSID=abc123

(body : souvent du HTML, ou du JSON)
```

## Méthodes

| Méthode | Sens | Données | Exemple |
|---|---|---|---|
| GET | lire | dans l'URL : `?q=arduino&page=2` | afficher, rechercher, filtrer |
| POST | envoyer, modifier | dans le body | formulaire d'inscription, connexion |

Un GET ne modifie **jamais** de données.

## Codes de statut

| Code | Sens |
|---|---|
| 200 OK | Tout va bien |
| 201 Created | Ressource créée (API) |
| 301 / 302 | Redirection (header `Location`) |
| 400 Bad Request | Requête invalide |
| 401 Unauthorized | Pas connecté |
| 403 Forbidden | Connecté, mais pas le droit |
| 404 Not Found | N'existe pas |
| 405 Method Not Allowed | Mauvaise méthode (GET au lieu de POST) |
| 500 Internal Server Error | Le serveur a planté (souvent : erreur PHP) |

## Headers utiles

| Header | Rôle |
|---|---|
| `Content-Type` | Type du contenu : `text/html`, `application/json` |
| `Location` | Où rediriger |
| `Set-Cookie` / `Cookie` | Le serveur dépose un cookie / le navigateur le renvoie |

## Anatomie d'une URL

```
https://www.ecole.tn:443/clubs/robotique?tri=date#agenda
protocole  domaine   port   chemin      query   fragment (jamais envoyé)
```

## Voir tout ça

**F12 → Network**, recharger, cliquer sur une requête : *Headers*, *Payload*, *Response*.
