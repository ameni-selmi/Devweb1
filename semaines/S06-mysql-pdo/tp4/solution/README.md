# Corrigé TP4

À publier **après** la date limite du rendu.

## Installation

```bash
mysql -u clubhub -p clubhub < database/schema.sql
mysql -u clubhub -p clubhub < database/seed.sql
cp config.example.php config.php
php -S localhost:8000
```

Comptes : `amine@campus.example`, `sarra@campus.example`, `robotique@campus.example` (et un compte par club), mot de passe `demo1234`.

## Ce que couvre le corrigé

* Base et Plus complets.
* Défis : **transaction** pour la dernière place (`registerUser()`, `SELECT ... FOR UPDATE`), **recherche côté serveur** (`searchEvents()`, `evenements.php?q=`), et événements passés non annulables dans « Mon compte ».

## Réponse à la question 5

Avec `prepare()`, l'email `' OR '1'='1` est envoyé à MySQL comme une **valeur**, séparée de la requête. MySQL cherche un utilisateur dont l'email est exactement ce texte. Il n'en trouve pas, la connexion est refusée. Si la requête avait été construite par concaténation, l'apostrophe aurait fermé la chaîne SQL et la condition `OR '1'='1'` serait devenue vraie pour toutes les lignes.

## Points à commenter en correction collective

* `includes/users.php` : **mêmes fonctions** qu'en S05 → `connexion.php` et `creer-compte.php` n'ont pas changé d'une ligne ;
* `EVENT_SELECT` : le `LEFT JOIN` + `COUNT(r.id)` qui calcule les places restantes ;
* `registerUser()` : la base garantit l'unicité (`UNIQUE`), le PHP traduit l'erreur en message ;
* `cancelRegistration()` : `WHERE user_id = ? AND event_id = ?` rend impossible l'annulation de l'inscription d'un autre.

Ce dossier est le **starter du TP5**.
