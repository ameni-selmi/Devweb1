# Installation de l'environnement

À faire **avant la séance 4**. Comptez 30 minutes. En cas de problème, venez 10 minutes avant la séance.

## Ce qu'il faut

| Outil | Pour | Version |
|---|---|---|
| Un navigateur récent | Tout le cours | Chrome, Firefox ou Edge |
| Un éditeur | Écrire le code | VS Code (conseillé) |
| Git | Rendre les TP | 2.x |
| PHP | Séances 4 à 11 | 8.1 ou plus |
| MySQL ou MariaDB | Séances 6 à 11 | MySQL 8 ou MariaDB 10.6 et plus |

## Option A : un paquet tout en un (le plus simple)

Installe PHP, MySQL (MariaDB) et phpMyAdmin d'un coup.

| Système | Paquet |
|---|---|
| Windows | XAMPP, WAMP ou Laragon |
| macOS | MAMP ou XAMPP |
| Linux | voir l'option B (plus simple sous Linux) |

Avec XAMPP :

1. Installez XAMPP, lancez le *Control Panel*, démarrez **Apache** et **MySQL**.
2. Votre dossier de travail est `C:\xampp\htdocs\` (Windows). Mettez y votre dossier `clubhub`.
3. Ouvrez `http://localhost/clubhub/bonjour.php`.
4. phpMyAdmin : `http://localhost/phpmyadmin`. Utilisateur `root`, mot de passe vide par défaut.

Pour utiliser `php` dans un terminal avec XAMPP sous Windows, ajoutez `C:\xampp\php` à la variable d'environnement `PATH`.

## Option B : installer séparément

**Windows** : `winget install PHP.PHP.8.3` puis `winget install Oracle.MySQL` (ou installez MariaDB depuis mariadb.org).

**macOS** (avec Homebrew) :
```bash
brew install php mysql
brew services start mysql
```

**Linux (Debian, Ubuntu)** :
```bash
sudo apt install php-cli php-mysql php-mbstring mariadb-server
sudo systemctl start mariadb
```

Puis, dans le dossier du projet :
```bash
php -S localhost:8000
```
et ouvrez `http://localhost:8000/bonjour.php`.

## Vérifier

```bash
php -v                    # PHP 8.1 ou plus
php -m | grep -i pdo      # doit afficher PDO et pdo_mysql (Windows : findstr au lieu de grep)
git --version
mysql --version
```

Si `pdo_mysql` manque : dans `php.ini`, enlevez le `;` devant `extension=pdo_mysql`, puis relancez.

## Créer l'utilisateur MySQL du cours (séance 6)

Ne travaillez pas avec `root` dans votre code. Dans un terminal MySQL (`mysql -u root -p`) ou dans phpMyAdmin, onglet SQL :

```sql
CREATE DATABASE clubhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'clubhub'@'localhost' IDENTIFIED BY 'clubhub';
GRANT ALL PRIVILEGES ON clubhub.* TO 'clubhub'@'localhost';
```

## VS Code : extensions conseillées

* **PHP Intelephense** : aide à la saisie PHP
* **Live Server** : seulement pour les séances 1 à 3 (HTML, CSS, JS). À partir de la séance 4, utilisez le serveur PHP.
* **GitLens** (facultatif)

Pas d'extension qui génère du code à votre place pour les TP : vous devez pouvoir tout expliquer.

## Git : première configuration

```bash
git config --global user.name "Prénom Nom"
git config --global user.email "vous@exemple.com"
```

Voir `fiches/git-essentiel.md`.
