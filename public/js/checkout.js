// Validazione lato browser del checkout (stessa regola di CheckoutRequest lato server)
(function () {
    const form = document.querySelector('#checkout-form');
    const errorBox = document.querySelector('#checkout-error');
    const address = document.querySelector('#indirizzo_spedizione');

    if (!form) {
        return;
    }

    function showError(text) {
        errorBox.textContent = text;
        errorBox.classList.remove('hidden');
    }

    function onSubmit(e) {
        const value = address.value.trim();
        let error = '';

        if (value === '') {
            error = 'Inserisci l\'indirizzo di spedizione.';
        } else if (value.length < 5) {
            error = 'L\'indirizzo deve avere almeno 5 caratteri.';
        } else if (value.length > 255) {
            error = 'L\'indirizzo può avere al massimo 255 caratteri.';
        }

        if (error !== '') {
            e.preventDefault();
            showError(error);
            address.focus();
        }
    }

    function onInput() {
        errorBox.classList.add('hidden');
    }

    address.addEventListener('input', onInput);
    form.addEventListener('submit', onSubmit);
})();
