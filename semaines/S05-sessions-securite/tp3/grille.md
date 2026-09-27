# TP3 : Grille de correction (sur 20)

Temps visé : 8 à 10 minutes par binôme. Lancer `php -S localhost:8000` dans leur dossier. Commencer par les **tests de sécurité**, puis les fonctionnalités, puis lire `auth.php`.

**Binôme :** ................................................

## Tests de sécurité (à faire en premier, 3 minutes)

| Test | Attendu | OK ? |
|---|---|---|
| Ouvrir `compte.php` sans être connecté | Redirection vers la connexion | |
| Ouvrir `data/users.json` après création d'un compte | Seulement des hachages `$2y$...` | |
| `curl -X POST -d "rules=1" "localhost:8000/evenement.php?id=1"` sans cookie | Redirection (302), pas d'inscription | |
| Ouvrir `deconnexion.php` directement (GET) | Ne déconnecte pas (405 ou redirection sans effet) | |
| Nom de compte `<script>alert(1)</script>` puis page « Mon compte » | Aucune alerte | |
| Connexion avec un bon email et un mauvais mot de passe, puis un email inconnu | Même message les deux fois | |

## Grille

| # | Critère | Points | Note |
|---|---|---|---|
| | **Session et structure (3 pts)** | | |
| 1 | `bootstrap.php` inclus en premier partout, `session_start()` une seule fois | 1 | |
| 2 | `currentUser()` et `requireLogin()` corrects, `requireLogin()` en haut de chaque page protégée | 2 | |
| | **Comptes (7 pts)** | | |
| 3 | Création de compte : 4 validations serveur, messages sous les champs, valeurs gardées (sauf mot de passe) | 2 | |
| 4 | `password_hash()` à la création, `password_verify()` à la connexion | 2 | |
| 5 | Connexion : message unique en cas d'échec, `session_regenerate_id(true)` | 1,5 | |
| 6 | Déconnexion en POST, session vidée et cookie supprimé | 1,5 | |
| | **Pages (4 pts)** | | |
| 7 | « Mon compte » protégée, affiche les informations (échappées) | 2 | |
| 8 | En-tête qui change selon l'état connecté / non connecté | 2 | |
| | *Sous total Base* | *14* | |
| | **Plus (3 pts)** | | |
| 9 | Messages flash affichés une seule fois | 0,5 | |
| 10 | Inscription à un événement réservée aux connectés, `requireLogin()` dans le traitement POST | 1 | |
| 11 | Post/Redirect/Get : F5 après une inscription ne renvoie rien | 0,5 | |
| 12 | Liste des inscriptions dans « Mon compte » + annulation en POST | 1 | |
| | **Défi (3 pts)** | | |
| 13 | Défi(s) réalisé(s) et expliqué(s) | 3 | |
| | **Pénalités** | | |
| | Un test de sécurité échoue (par test) | −2 | |
| | Mot de passe en clair quelque part (fichier, session, log) | −5 | |
| | `md5`, `sha1` ou hachage maison | −4 | |
| | Rendu en retard (par tranche de 24 h) | −2 | |
| | **Total** | **/20** | |

## Questions orales possibles

* « Montrez moi le cookie de session dans les DevTools. Qu'y a-t-il dedans ? Où sont les données ? »
* « Pourquoi `session_regenerate_id(true)` à la connexion ? »
* « Pourquoi le même message si l'email n'existe pas ? »
* « Le formulaire est caché aux visiteurs. Pourquoi appeler `requireLogin()` dans le traitement du POST ? »
* « Que se passe-t-il si j'appuie sur F5 juste après m'être inscrit ? Montrez la redirection dans l'onglet Network. »
* « Déconnectez vous et reconnectez vous. Où sont les inscriptions ? Pourquoi ? »

## Repères

| Note | Ce que ça ressemble |
|---|---|
| < 10 | Connexion qui ne marche pas, ou page protégée accessible, ou mots de passe en clair |
| 10 à 14 | Base complète, tests de sécurité réussis |
| 15 à 17 | Base + flash + PRG + inscription aux événements |
| 18 à 20 | Tout, plus un défi bien fait et bien expliqué |
