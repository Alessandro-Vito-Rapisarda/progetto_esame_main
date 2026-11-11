// Validazione lato browser delle quantita' del carrello (1-99, come CartRequest lato server)
(function () {
    const forms = document.querySelectorAll('.cart-qty-form');

    function onSubmit(e) {
        const input = e.currentTarget.querySelector('input[name="quantita"]');
        const raw = input.value.trim();
        const value = Number(raw);

        if (raw === '' || !Number.isInteger(value) || value < 1 || value > 99) {
            e.preventDefault();
            alert('La quantità deve essere un numero intero tra 1 e 99.');
            input.focus();
        }
    }

    for (const form of forms) {
        form.addEventListener('submit', onSubmit);
    }
})();
