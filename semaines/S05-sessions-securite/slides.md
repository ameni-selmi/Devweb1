---
marp: true
theme: devweb
paginate: true
footer: 'Développement Web 1 · Amani Selmi · S05 · Sessions, connexion, sécurité'
---

<!-- _class: titre -->
<!-- _paginate: false -->
<!-- _footer: '' -->

# Développement Web 1
## Séance 5 : Sessions, connexion, sécurité

**Amani Selmi, PhD-Engineer**

---

## Aujourd'hui

1. Le problème : HTTP oublie tout
2. Les **cookies**, puis les **sessions**
3. Créer un compte, se connecter : **hacher** les mots de passe
4. Protéger une page **côté serveur**
5. Post/Redirect/Get et messages flash
6. **TP3 noté** : des comptes pour ClubHub

---

<!-- _class: question -->

## Question

Vous vous connectez sur un site. Vous cliquez sur un lien.

**Comment le serveur sait il encore qui vous êtes ?**

<!-- Rappeler la démo S04 : $visits++ vaut toujours 1. Chaque requête repart de zéro. -->

---

## Le cookie : une étiquette que le navigateur renvoie

```
1. Navigateur ── POST /connexion.php ─────────────▶ Serveur
2. Navigateur ◀─ Set-Cookie: PHPSESSID=k3j9x... ── Serveur
3. Navigateur ── GET /compte.php ─────────────────▶ Serveur
                 Cookie: PHPSESSID=k3j9x...
4. Navigateur ── GET /evenements.php ─────────────▶ Serveur
                 Cookie: PHPSESSID=k3j9x...
```

Le navigateur renvoie le cookie **à chaque requête** vers ce site.

---

## Pourquoi ne pas mettre `user_id=3` dans un cookie ?

Parce que l'utilisateur **peut modifier ses cookies**.

F12 → Application → Cookies → `user_id` = `1`… et vous voilà quelqu'un d'autre.

<div class="regle">

Le cookie contient seulement un **identifiant aléatoire**. Les vraies données restent **sur le serveur**.

</div>

---

## La session PHP

```
Navigateur                    Serveur
Cookie: PHPSESSID=k3j9x  ──▶  fichier de session k3j9x :
                                 user_id = 3
                                 flash = "Bonjour !"
```

```php
session_start();              // lit le cookie, charge $_SESSION
$_SESSION['user_id'] = 3;     // écrit côté serveur
echo $_SESSION['user_id'];    // lit, à la requête suivante
```

`session_start()` : **en haut**, avant tout HTML.

---

## Démo : voir la session

F12 → **Application** → **Cookies** → `localhost`

* Le cookie `PHPSESSID` : une longue chaîne aléatoire
* Supprimez le : vous êtes « déconnecté »
* Copiez le dans un autre navigateur : vous êtes **connecté** là bas

C'est pour ça qu'on vole des cookies (XSS de la séance 4 !) et qu'on utilise HTTPS.

<!-- DÉMO en direct, voir live-coding.md partie 1 -->

---

## Stocker un mot de passe ?

| Méthode | Si la base est volée... |
|---|---|
| En clair | Tous les mots de passe sont lus. Et réutilisés ailleurs. |
| Chiffré | La clé est souvent volée avec. |
| **Haché** (bcrypt) | Impossible à inverser. Lent à tester en force brute. |

Un **hachage** est une empreinte à sens unique.

---

## `password_hash` et `password_verify`

```php
// Création du compte
$hash = password_hash($password, PASSWORD_DEFAULT);
// "$2y$12$FywotzDTLYG.e8UmO.SQoe..."  ← c'est ÇA qu'on stocke

// Connexion
if (password_verify($passwordTapé, $user['password_hash'])) {
    // bon mot de passe
}
```

* Le **sel** (aléatoire) est inclus dans le hachage : deux fois le même mot de passe donne deux hachages différents.
* N'écrivez **jamais** votre propre fonction de hachage. Pas de `md5`, pas de `sha1`.

<div class="regle">

Règle de sécurité n° 2 : **aucun** mot de passe en clair, nulle part.

</div>

---

## La connexion, étape par étape

```php
$user = findUserByEmail($email);

if ($user !== null && password_verify($password, $user['password_hash'])) {
    session_regenerate_id(true);       // nouvel identifiant de session
    $_SESSION['user_id'] = $user['id'];
    redirect('compte.php');
}

$error = 'Email ou mot de passe incorrect.';
```

* **Même message** si l'email n'existe pas ou si le mot de passe est faux.
* `session_regenerate_id` : l'ancien identifiant (peut être connu d'un attaquant) ne sert plus.

---

## Protéger une page

```php
function requireLogin(): array
{
    $user = currentUser();
    if ($user === null) {
        redirect('connexion.php');
    }
    return $user;
}
```

```php
// compte.php : PREMIÈRE ligne après le bootstrap
$user = requireLogin();
```

<div class="regle">

Règle de sécurité n° 3 : chaque page protégée vérifie **elle même**. Cacher le lien ne protège rien.

</div>

---

<!-- _class: question -->

## Question

Le bouton « S'inscrire » est caché quand on n'est pas connecté.

**Est ce suffisant ?**

<!-- Non : curl -X POST -d "rules=1" localhost:8000/evenement.php?id=1. Le serveur doit refuser la requête POST elle même. -->

---

## Se déconnecter

```php
$_SESSION = [];
setcookie(session_name(), '', time() - 3600, ...);   // efface le cookie
session_destroy();
```

* En **POST**, pas avec un lien : un GET ne doit jamais modifier l'état.
* Sinon, `<img src="https://site.example/deconnexion.php">` sur n'importe quel site vous déconnecte.

---

## Le problème du F5

Après un formulaire POST, l'utilisateur recharge la page :

> « Confirmer le renvoi du formulaire ? »

Il clique Oui → **deuxième inscription**, deuxième paiement…

---

## Post/Redirect/Get (PRG)

```
POST /evenement.php?id=3  ──▶  traitement OK
                          ◀──  302 Location: evenement.php?id=3
GET  /evenement.php?id=3  ──▶
                          ◀──  200 page normale
```

```php
if ($errors === []) {
    // ... enregistrer ...
    redirect('evenement.php?id=' . $id);    // header('Location: ...'); exit;
}
```

Après la redirection, F5 recharge un **GET**. Sans danger.

---

## Mais comment afficher « Inscription confirmée » ?

La redirection crée une **nouvelle** requête. Les variables sont perdues.

→ Le **message flash** : rangé dans la session, affiché **une seule fois**.

```php
function flash(string $message): void {
    $_SESSION['flash'] = $message;
}

function takeFlash(): ?string {
    $message = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $message;
}
```

---

## Où en est ClubHub ?

| | S04 | S05 |
|---|---|---|
| Utilisateurs | aucun | comptes dans `users.json` |
| Connexion | | session + `password_hash` |
| Pages protégées | | « Mon compte » |
| Inscription à un événement | nom + email tapés | réservée aux connectés |
| Inscriptions gardées | nulle part | **dans la session** |

---

<!-- _class: question -->

## À la fin du TP

Inscrivez vous à deux événements. Déconnectez vous. Reconnectez vous.

**Où sont passées vos inscriptions ?**

<!-- Elles ont disparu avec la session. Et un autre utilisateur ne peut pas voir la liste des inscrits. Il faut un stockage partagé et durable : la base de données, séance 6. -->

---

## TP3 (noté)

Des comptes pour ClubHub :

* **Base** : créer un compte, se connecter, se déconnecter, page « Mon compte » protégée
* **Plus** : messages flash, PRG, s'inscrire à un événement une fois connecté
* **Défi** : retour à la page demandée après connexion, limite des tentatives...

Énoncé : `semaines/S05-sessions-securite/tp3/enonce.md`
Aide : `fiches/securite-checklist.md`

**Rendu : dépôt Git, ce soir 23 h 59.**
