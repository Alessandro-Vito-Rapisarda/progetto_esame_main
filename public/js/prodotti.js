// "Aggiungi al carrello" senza ricaricare la pagina (se JS e' disattivo il form funziona comunque)
(function () {
    const forms = document.querySelectorAll('.add-to-cart-form');

    function showMessage(text, isError) {
        let box = document.querySelector('#carrello-msg');

        if (!box) {
            box = document.createElement('div');
            box.id = 'carrello-msg';
            document.body.appendChild(box);
        }

        box.textContent = text;
        box.className = 'carrello-msg ' + (isError ? 'carrello-msg-errore' : 'carrello-msg-success') + ' show';

        setTimeout(function () {
            box.classList.remove('show');
        }, 2500);
    }

    function onJson(data) {
        if (data && data.success) {
            showMessage(data.message, false);
        } else if (data && data.errors) {
            showMessage(Object.values(data.errors)[0][0], true);
        } else if (data && data.error) {
            showMessage(data.error, true);
        } else {
            showMessage('Operazione non riuscita.', true);
        }
    }

    function onResponse(response) {
        if (response.status === 401) {
            window.location.href = window.location.origin + '/login';
            return null;
        }
        return response.json();
    }

    function onError() {
        showMessage('Errore di connessione.', true);
    }

    function onSubmit(e) {
        const form = e.currentTarget;
        const id = Number(form.querySelector('input[name="prodotto_id"]').value);
        const qta = Number(form.querySelector('input[name="quantita"]').value);

        e.preventDefault();

        if (!Number.isInteger(id) || id < 1 || !Number.isInteger(qta) || qta < 1 || qta > 99) {
            showMessage('Dati del prodotto non validi.', true);
            return;
        }

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(form)
        })
        .then(onResponse)
        .then(function (data) {
            if (data) {
                onJson(data);
            }
        })
        .catch(onError);
    }

    for (const form of forms) {
        form.addEventListener('submit', onSubmit);
    }

    // Nasconde il messaggio mostrato dal server dopo un redirect
    const flash = document.querySelector('#carrello-msg.show');
    if (flash) {
        setTimeout(function () {
            flash.classList.remove('show');
        }, 2500);
    }
})();
