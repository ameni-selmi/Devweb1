// ClubHub : JavaScript (séance 8 : fetch et JSON, sans rechargement de page)
// Ce fichier est chargé sur toutes les pages avec l'attribut defer :
// il s'exécute quand le HTML est entièrement lu, donc le DOM existe déjà.
// Chaque fonctionnalité vérifie d'abord que ses éléments existent sur la page.

// ------------------------------------------------------------
// 1. Mode sombre (toutes les pages)
// ------------------------------------------------------------
const THEME_KEY = 'clubhub-theme';

function applyTheme(theme) {
  document.documentElement.dataset.theme = theme;   // <html data-theme="dark">
  const button = document.querySelector('.theme-toggle');
  if (button) {
    const isDark = theme === 'dark';
    button.textContent = isDark ? 'Mode clair' : 'Mode sombre';
    button.setAttribute('aria-pressed', String(isDark));
  }
}

function readSavedTheme() {
  try {
    return localStorage.getItem(THEME_KEY);
  } catch {
    return null;   // localStorage peut être bloqué (navigation privée)
  }
}

function saveTheme(theme) {
  try {
    localStorage.setItem(THEME_KEY, theme);
  } catch {
    // tant pis : le thème ne sera pas mémorisé
  }
}

applyTheme(readSavedTheme() ?? 'light');

const themeButton = document.querySelector('.theme-toggle');
if (themeButton) {
  themeButton.addEventListener('click', () => {
    const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
    applyTheme(next);
    saveTheme(next);
  });
}

// ------------------------------------------------------------
// 2. Filtre, recherche et tri des événements (page evenements)
//    Séance 8 : la recherche texte interroge le serveur (fetch) si la liste a data-api.
// ------------------------------------------------------------
const filtersForm = document.querySelector('.filters');

if (filtersForm) {
  const searchInput = document.querySelector('#search');
  const clubSelect = document.querySelector('#club-filter');
  const sortSelect = document.querySelector('#sort');
  const list = document.querySelector('.event-list');
  const countText = document.querySelector('.results-count');
  const emptyMessage = document.querySelector('.empty-message');
  const apiUrl = list.dataset.api;          // "index.php?page=api-evenements" ou undefined
  let cards = Array.from(list.querySelectorAll('.event-card'));

  function normalize(text) {
    return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
  }

  function matches(card, query, club) {
    const clubOk = club === '' || card.dataset.club === club;
    // Avec l'API, le serveur a déjà filtré par texte (titre, club ET description)
    const queryOk = apiUrl !== undefined || query === '' || normalize(card.textContent).includes(query);
    return clubOk && queryOk;
  }

  function sortCards(sortBy) {
    const sorted = [...cards].sort((a, b) => {
      if (sortBy === 'places') {
        return Number(b.dataset.places) - Number(a.dataset.places);
      }
      return a.dataset.date.localeCompare(b.dataset.date);
    });
    sorted.forEach((card) => list.appendChild(card));
  }

  function update() {
    const query = normalize(searchInput.value);
    const club = clubSelect.value;
    let visible = 0;

    for (const card of cards) {
      const show = matches(card, query, club);
      card.hidden = !show;
      if (show) visible++;
    }

    sortCards(sortSelect.value);
    countText.textContent = visible === 1 ? '1 événement affiché' : `${visible} événements affichés`;
    emptyMessage.hidden = visible !== 0;
  }

  // Crée une carte à partir d'un objet JSON. Même HTML que templates/partials/event-card.php.
  // textContent partout : les données du serveur ne deviennent jamais du HTML.
  function createCard(event) {
    const article = document.createElement('article');
    article.className = 'event-card';
    article.dataset.club = event.clubSlug;
    article.dataset.date = event.startsAt;
    article.dataset.places = String(event.placesLeft);

    const add = (tag, className, text) => {
      const element = document.createElement(tag);
      if (className) element.className = className;
      element.textContent = text;
      article.appendChild(element);
      return element;
    };

    add('p', 'club', event.club);
    add('h2', '', event.title);
    add('p', 'meta', event.dateLabel);
    add('p', 'meta', event.location);
    const places = add('p', event.placesLeft <= 0 ? 'places is-full' : 'places', '');
    const strong = document.createElement('strong');
    strong.textContent = event.placesLabel;
    places.appendChild(strong);
    const link = add('a', '', 'Voir le détail');
    link.href = event.url;
    return article;
  }

  async function searchOnServer() {
    const url = `${apiUrl}&q=${encodeURIComponent(searchInput.value.trim())}`;
    try {
      const response = await fetch(url);
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      const data = await response.json();
      list.replaceChildren(...data.events.map(createCard));
      cards = Array.from(list.querySelectorAll('.event-card'));
      update();
    } catch (error) {
      countText.textContent = 'La recherche est indisponible pour le moment.';
      console.error(error);
    }
  }

  // Attendre que l'utilisateur arrête de taper (300 ms) avant d'interroger le serveur
  let searchTimer;
  searchInput.addEventListener('input', () => {
    if (apiUrl === undefined) {
      update();
      return;
    }
    clearTimeout(searchTimer);
    searchTimer = setTimeout(searchOnServer, 300);
  });
  clubSelect.addEventListener('change', update);
  sortSelect.addEventListener('change', update);
  filtersForm.addEventListener('submit', (event) => event.preventDefault());

  update();
}

// ------------------------------------------------------------
// 3. Validation du formulaire d'inscription (evenement.html)
// ------------------------------------------------------------
const registrationForm = document.querySelector('#registration-form');

if (registrationForm) {
  // On désactive les bulles du navigateur pour afficher nos propres messages.
  // Les attributs required restent utiles si JavaScript est désactivé.
  registrationForm.noValidate = true;

  const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Une règle = un champ + une fonction qui renvoie un message d'erreur, ou '' si tout va bien
  const rules = [
    {
      field: document.querySelector('#name'),
      check: (value) => (value.trim().length >= 3 ? '' : 'Le nom doit contenir au moins 3 caractères.'),
    },
    {
      field: document.querySelector('#email'),
      check: (value) => {
        if (value.trim() === '') return "L'email est obligatoire.";
        return EMAIL_PATTERN.test(value.trim()) ? '' : "Cet email n'est pas valide.";
      },
    },
    {
      field: document.querySelector('#level'),
      check: (value) => (value !== '' ? '' : 'Choisissez votre niveau.'),
    },
    {
      field: document.querySelector('#rules'),
      check: (_value, field) => (field.checked ? '' : 'Vous devez accepter le règlement.'),
    },
  ].filter((rule) => rule.field !== null);   // selon la page, certains champs n'existent pas

  function showError(field, message) {
    const errorElement = document.querySelector(`#${field.id}-error`);
    errorElement.textContent = message;
    field.classList.toggle('is-invalid', message !== '');
    field.setAttribute('aria-invalid', String(message !== ''));
    if (message !== '') {
      field.setAttribute('aria-describedby', errorElement.id);
    }
  }

  function validateRule(rule) {
    const message = rule.check(rule.field.value, rule.field);
    showError(rule.field, message);
    return message === '';
  }

  registrationForm.addEventListener('submit', (event) => {
    const results = rules.map(validateRule);
    const firstInvalid = rules.find((_rule, index) => !results[index]);

    if (firstInvalid) {
      event.preventDefault();
      firstInvalid.field.focus();
    }
    // Sinon : on laisse partir le formulaire. Le serveur PHP revérifie tout.
  });

  // Dès que l'utilisateur corrige un champ, on revalide ce champ seulement
  for (const rule of rules) {
    const eventName = rule.field.type === 'checkbox' || rule.field.tagName === 'SELECT' ? 'change' : 'input';
    rule.field.addEventListener(eventName, () => {
      if (rule.field.classList.contains('is-invalid')) {
        validateRule(rule);
      }
    });
  }

  // ----------------------------------------------------------
  // 4. Compteur de caractères de la motivation
  // ----------------------------------------------------------
  const motivation = document.querySelector('#motivation');
  const counter = document.querySelector('#motivation-count');
  const max = Number(motivation.getAttribute('maxlength'));

  function updateCounter() {
    const length = motivation.value.length;
    counter.textContent = `${length} / ${max}`;
    counter.classList.toggle('is-near-limit', length >= max * 0.9);
  }

  motivation.addEventListener('input', updateCounter);
  updateCounter();
}

// ------------------------------------------------------------
// 5. Envoyer des données au serveur en JSON (fetch POST)
// ------------------------------------------------------------

/** POST en JSON. Renvoie { ok, status, data }. Lance une erreur seulement si le réseau est coupé. */
async function postJson(url, payload) {
  const response = await fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
    body: JSON.stringify(payload),
  });
  const data = await response.json();
  return { ok: response.ok, status: response.status, data };
}

/** Affiche un message dans le style des messages flash, au début de <main>. */
function showMessage(text, type = 'success') {
  document.querySelector('.flash-live')?.remove();
  const message = document.createElement('p');
  message.className = `flash flash-${type} flash-live`;
  message.setAttribute('role', 'status');
  message.textContent = text;
  document.querySelector('main').prepend(message);
}

// 5a. S'inscrire sans recharger la page (page d'un événement)
const registration = document.querySelector('.registration[data-api]');

if (registrationForm && registration) {
  // La validation (section 3) est branchée AVANT : si elle a bloqué l'envoi, on ne fait rien
  registrationForm.addEventListener('submit', async (event) => {
    if (event.defaultPrevented) return;
    event.preventDefault();   // on remplace l'envoi classique par fetch

    const button = registrationForm.querySelector('button[type="submit"]');
    button.disabled = true;

    try {
      const { ok, status, data } = await postJson(registration.dataset.api, {
        eventId: Number(registration.dataset.eventId),
        motivation: document.querySelector('#motivation').value,
        rules: document.querySelector('#rules').checked,
      });

      if (ok) {
        document.querySelector('#places-label').textContent = data.placesLabel;
        const done = document.createElement('p');
        done.className = 'form-success';
        done.textContent = 'Vous êtes inscrit à cet événement.';
        registrationForm.replaceWith(done);
        showMessage(data.message);
      } else if (status === 401) {
        window.location.href = registration.dataset.loginUrl;   // pas connecté : on va se connecter
      } else {
        showMessage(data.error, 'error');
        button.disabled = false;
      }
    } catch (error) {
      // Réseau coupé : on laisse le formulaire classique faire son travail
      registrationForm.submit();
    }
  });
}

// 5b. Annuler sans recharger la page (Mon compte)
document.querySelectorAll('.cancel-form[data-api]').forEach((form) => {
  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    if (!window.confirm('Annuler cette inscription ?')) return;

    try {
      const { ok, data } = await postJson(form.dataset.api, { eventId: Number(form.dataset.eventId) });
      if (ok) {
        form.closest('tr').remove();
        showMessage(data.message, 'info');
      } else {
        showMessage(data.error, 'error');
      }
    } catch (error) {
      form.submit();
    }
  });
});
