// Démo S03 : version finale (à écrire en direct, pas à distribuer avant)
const list = document.querySelector('#list');
const count = document.querySelector('#count');
const form = document.querySelector('#add-form');
const input = document.querySelector('#item');
const error = document.querySelector('#item-error');

function updateCount() {
  const n = list.querySelectorAll('li').length;
  count.textContent = `${n} objet(s)`;
}

function save() {
  const items = [...list.querySelectorAll('li')].map((li) => li.firstChild.textContent.trim());
  localStorage.setItem('demo-items', JSON.stringify(items));
}

function addItem(value) {
  const li = document.createElement('li');
  li.textContent = value;              // pas innerHTML !
  const button = document.createElement('button');
  button.type = 'button';
  button.className = 'remove';
  button.textContent = '×';
  li.appendChild(button);
  list.appendChild(li);
}

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const value = input.value.trim();

  if (value === '') {
    error.textContent = 'Écrivez un objet.';
    return;
  }
  error.textContent = '';

  addItem(value);
  input.value = '';
  input.focus();
  updateCount();
  save();
});

// Délégation : un seul écouteur sur la liste, même pour les objets ajoutés plus tard
list.addEventListener('click', (event) => {
  if (event.target.classList.contains('remove')) {
    event.target.closest('li').remove();
    updateCount();
    save();
  }
});

// Au chargement : relire la liste sauvegardée
const saved = JSON.parse(localStorage.getItem('demo-items') ?? 'null');
if (saved) {
  list.textContent = '';
  saved.forEach(addItem);
}
updateCount();
