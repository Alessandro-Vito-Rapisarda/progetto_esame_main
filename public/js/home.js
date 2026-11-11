// Comportamenti della barra di navigazione e validazione della ricerca (caricato in tutte le pagine)
(function () {
    const MAX_SEARCH = 100;

    // ---------- Ricerca: validazione lato browser ----------
    function checkSearch(value) {
        const text = value.trim();

        if (text === '') {
            return 'Scrivi il nome di un prodotto.';
        }
        if (text.length > MAX_SEARCH) {
            return 'La ricerca può avere al massimo ' + MAX_SEARCH + ' caratteri.';
        }
        return '';
    }

    const searchForm = document.querySelector('#search-form');
    const searchInput = document.querySelector('#search-input');
    const resultDiv = document.querySelector('#result');

    function onSearchSubmit(e) {
        const error = checkSearch(searchInput.value);

        if (error !== '') {
            e.preventDefault();
            resultDiv.textContent = error;
            resultDiv.classList.remove('hidden');
            resultDiv.classList.add('search-result-error');
        }
    }

    function onSearchInput() {
        resultDiv.classList.add('hidden');
    }

    if (searchForm && searchInput && resultDiv) {
        searchForm.addEventListener('submit', onSearchSubmit);
        searchInput.addEventListener('input', onSearchInput);
    }

    const hamburgerSearchForm = document.querySelector('#hamburger-search-form');

    function onHamburgerSearchSubmit(e) {
        const input = hamburgerSearchForm.querySelector('input[name="nome"]');
        const error = checkSearch(input.value);
        const old = document.querySelector('#hamburger-search-error');

        if (old) {
            old.remove();
        }

        if (error !== '') {
            e.preventDefault();
            const errorDiv = document.createElement('div');
            errorDiv.id = 'hamburger-search-error';
            errorDiv.textContent = error;
            hamburgerSearchForm.parentNode.insertBefore(errorDiv, hamburgerSearchForm.nextSibling);
        }
    }

    if (hamburgerSearchForm) {
        hamburgerSearchForm.addEventListener('submit', onHamburgerSearchSubmit);
    }

    // ---------- Menu hamburger ----------
    const hamburgerBtn = document.querySelector('#hamburger-btn');
    const navLinks = document.querySelector('#nav-links');
    const hamburgerExtras = document.querySelector('#hamburger-extra-buttons');

    function setMenu(open) {
        const icon = hamburgerBtn.querySelector('.hamburger-icon');

        navLinks.classList.toggle('open', open);
        hamburgerBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (icon) {
            icon.innerHTML = open ? '&#10005;' : '&#9776;';
        }
        if (hamburgerExtras) {
            hamburgerExtras.classList.toggle('show', open);
        }
    }

    if (hamburgerBtn && navLinks) {
        hamburgerBtn.addEventListener('click', function () {
            setMenu(!navLinks.classList.contains('open'));
        });
        document.addEventListener('click', function (e) {
            if (!hamburgerBtn.contains(e.target) && !navLinks.contains(e.target)) {
                setMenu(false);
            }
        });
    }

    // ---------- Dropdown account e ricerca ----------
    const accountBtn = document.querySelector('#account-btn');
    const accountDropdown = document.querySelector('#account-dropdown');

    if (accountBtn && accountDropdown) {
        accountBtn.addEventListener('click', function (e) {
            e.preventDefault();
            accountDropdown.classList.toggle('show');
        });
        document.addEventListener('click', function (e) {
            if (!accountBtn.contains(e.target) && !accountDropdown.contains(e.target)) {
                accountDropdown.classList.remove('show');
            }
        });
    }

    const searchBtn = document.querySelector('#search-btn');
    const searchDropdown = document.querySelector('#search-dropdown');

    if (searchBtn && searchDropdown && searchInput) {
        searchBtn.addEventListener('click', function (e) {
            e.preventDefault();
            searchDropdown.classList.toggle('show');
            if (searchDropdown.classList.contains('show')) {
                searchInput.focus();
            }
        });
        document.addEventListener('click', function (e) {
            if (!searchBtn.contains(e.target) && !searchDropdown.contains(e.target)) {
                searchDropdown.classList.remove('show');
            }
        });
    }

    // ---------- Menu API nel footer ----------
    const footerHamburger = document.querySelector('#footer-hamburger');
    const footerApiMenu = document.querySelector('#footer-api-menu');

    if (footerHamburger && footerApiMenu) {
        footerHamburger.addEventListener('click', function () {
            footerApiMenu.classList.toggle('open');
        });
        document.addEventListener('click', function (e) {
            if (!footerHamburger.contains(e.target) && !footerApiMenu.contains(e.target)) {
                footerApiMenu.classList.remove('open');
            }
        });
    }
})();
