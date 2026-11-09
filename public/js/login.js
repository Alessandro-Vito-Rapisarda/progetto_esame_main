const form = document.querySelector('#login-form');
const msg = document.querySelector('#msg');
const username = document.querySelector('#username');
const password = document.querySelector('#password');
const submitBtn = document.querySelector('#submit');

function checkInputs() {
  if (username.value && password.value) {
    submitBtn.disabled = false;
    submitBtn.classList.add('enabled');
  } else {
    submitBtn.disabled = true;
    submitBtn.classList.remove('enabled');
  }
}

function onResponse(response) {
  if (!response.ok) {
    console.log('Risposta non valida');
    return null;
  }
  return response.json();
}

function onError(error) {
  console.log('Error: ' + error);
  msg.textContent = 'Errore di connessione.';
  msg.classList.remove('success-msg');
  msg.classList.add('error-msg');
}

function onJson(data) {
  if (!data) {
    msg.textContent = 'Errore di comunicazione col server.';
    msg.classList.remove('success-msg');
    msg.classList.add('error-msg');
    return;
  }

  if (data.success) {
    msg.textContent = 'Login riuscito! Reindirizzamento...';
    msg.classList.remove('error-msg');
    msg.classList.add('success-msg');
    window.location.href = data.redirect || '/';
  } else {
    msg.textContent = data.error;
     msg.classList.remove('success-msg');
    msg.style.classList.add('error-msg')
  }
}

function onSubmit(e) {
  e.preventDefault();
  msg.textContent = '';
  msg.classList.remove('success-msg', 'error-msg');
  const formData = new FormData(form);
  const tokenInput = form.querySelector('input[name=_token]');
  fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': tokenInput.value
      },
      body: formData
    })
    .then(onResponse, onError)
    .then(onJson);
}

username.addEventListener('input', checkInputs);
password.addEventListener('input', checkInputs);
form.addEventListener('submit', onSubmit);
checkInputs();