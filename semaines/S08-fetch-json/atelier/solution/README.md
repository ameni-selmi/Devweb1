# Corrigé atelier S08 : ClubHub final

C'est la version complète de ClubHub, fil rouge du cours.

## Installation

```bash
mysql -u clubhub -p clubhub < database/schema.sql
mysql -u clubhub -p clubhub < database/seed.sql
cp config.example.php config.php
php -S localhost:8000
```

Ouvrir `http://localhost:8000/index.php`. Mot de passe de tous les comptes : `demo1234`.

## Ce que couvre le corrigé

* `controllers/api/register.php` : inscription en JSON (405, 401, 404, 422, 409, 200).
* `controllers/api/cancel.php` : annulation en JSON.
* `controllers/api/events.php` : recherche en JSON, avec un choix explicite des champs envoyés.
* `js/app.js`, section 2 : recherche côté serveur avec debounce et cartes construites avec `createElement` / `textContent`.
* `js/app.js`, section 5 : `postJson()`, inscription et annulation sans rechargement, repli sur le formulaire classique si le réseau casse.

Sans JavaScript, tout fonctionne comme au TP5.

## Ce que ClubHub montre, du début à la fin du cours

| Séance | Ajout |
|---|---|
| S01 à S03 | HTML sémantique, CSS responsive, JavaScript (DOM, événements, validation, thème) |
| S04 | PHP, formulaires, validation serveur, `e()` |
| S05 | Sessions, comptes, `password_hash`, pages protégées, PRG, flash |
| S06 | MySQL, PDO, requêtes préparées, JOIN, contraintes, transaction |
| S07 | Front controller, contrôleurs, templates, repositories, rôles, contrôle de propriété |
| S08 | API JSON, fetch, amélioration progressive |
