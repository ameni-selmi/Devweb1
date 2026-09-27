# S01 : Script de live coding

## Partie 1 : Démo DevTools (10 min)

But : montrer que HTTP est du texte, et qu'une page = beaucoup de requêtes.

1. Ouvrir `https://example.com`. F12 → onglet **Network**. Cocher **Disable cache**. Recharger (Ctrl+R).
2. Cliquer sur la première ligne (`example.com`).
   * Onglet **Headers** : montrer *Request Method* `GET`, *Status Code* `200`.
   * Montrer les *Request Headers* (`Host`, `User-Agent`, `Accept-Language`).
   * Montrer les *Response Headers* (`Content-Type: text/html`).
   * Onglet **Response** : « c'est juste du texte, du HTML ».
3. Ouvrir le site de l'école (ou un site plus riche). Recharger.
   * Lire le compteur en bas : « 87 requests ». Demander : « combien de requêtes pour une seule page ? »
   * Filtrer par type : Doc, CSS, JS, Img. « Le navigateur lit le HTML, puis demande tout le reste. »
4. Taper une URL qui n'existe pas (`/nimporte-quoi`). Montrer le `404`.
5. (Bonus) Clic droit sur une requête → *Copy as cURL*. Coller dans un terminal. « Le navigateur n'est qu'un client parmi d'autres. »

Phrase de conclusion : « À partir d'aujourd'hui, quand quelque chose ne marche pas, votre premier réflexe est F12. »

## Partie 2 : Page d'accueil ClubHub (20 min)

But : montrer la démarche, pas seulement le résultat. Taper en direct, faire des erreurs et les corriger.

1. Créer le dossier `clubhub/`, ouvrir dans VS Code, créer `index.html`.
2. Taper `!` + Tab (Emmet) → squelette. **Expliquer chaque ligne** : `lang`, `charset`, `viewport`.
   * Changer `lang="en"` en `lang="fr"`, mettre un vrai `title`.
3. Construire la structure en réfléchissant à voix haute :
   * « Il y a un bandeau en haut avec le nom et les liens → `header` + `nav`. »
   * « Le contenu principal → `main`. »
   * « En bas, les infos → `footer`. »
4. Dans `main` : un `h1`, un paragraphe, puis une `section` « Prochains événements » avec deux `article` (titre `h3`, club, date, lien).
   * Utiliser `<time datetime="2026-10-14T14:00">14 octobre, 14 h</time>` et expliquer pourquoi (machine lisible).
5. **Erreur volontaire** : mettre un `h4` directement sous le `h2`. Ouvrir validator.w3.org (onglet *Validate by Direct Input*), coller, montrer l'avertissement. Corriger.
6. Ouvrir la page dans le navigateur. « C'est moche. Tant mieux : c'est le travail du CSS. Le HTML est juste. »
7. Ouvrir F12 → onglet **Elements** : montrer l'arbre. « Cet arbre, c'est le DOM. En semaine 3, on le modifiera avec JavaScript. »

Le code final de cette partie est `atelier/solution/index.html` (en version simplifiée). Ne pas faire les deux autres pages : c'est l'atelier.
