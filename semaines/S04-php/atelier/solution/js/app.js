// ClubHub : JavaScript (séance 4 : le formulaire est maintenant envoyé au serveur)
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
// 2. Filtre, recherche et tri des événements (evenements.html)
// ------------------------------------------------------------
const filtersForm = document.querySelector('.filters');

if (filtersForm) {
  const searchInput = document.querySelector('#search');
  const clubSelect = document.querySelector('#club-filter');
  const sortSelect = document.querySelector('#sort');
  const list = document.querySelector('.event-list');
  const cards = Array.from(list.querySelectorAll('.event-card'));
  const countText = document.querySelector('.results-count');
  const emptyMessage = document.querySelector('.empty-message');

  // Enlève les accents et met en minuscules : « Échecs » devient « echecs »
  function normalize(text) {
    return text.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase().trim();
  }

  function matches(card, query, club) {
    const text = normalize(card.textContent);
    const clubOk = club === '' || card.dataset.club === club;
    const queryOk = query === '' || text.includes(query);
    return clubOk && queryOk;
  }

  function sortCards(sortBy) {
    const sorted = [...cards].sort((a, b) => {
      if (sortBy === 'places') {
        return Number(b.dataset.places) - Number(a.dataset.places);
      }
      return a.dataset.date.localeCompare(b.dataset.date);   // "10-14" < "10-17"
    });
    // appendChild déplace un élément qui existe déjà : pas besoin de le supprimer avant
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

  // 'input' se déclenche à chaque frappe, 'change' quand on choisit une option
  searchInput.addEventListener('input', update);
  clubSelect.addEventListener('change', update);
  sortSelect.addEventListener('change', update);

  // Empêche l'envoi du formulaire de filtre (Entrée dans la recherche)
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
  ];

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
