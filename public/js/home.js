function onResponse(response) {
    if (!response.ok) {
        console.log('Risposta non valida');
        return null;
    }
    return response.json();
}

function onError(error) {
    console.log('Error: ' + error);
}

const hamburgerSearchForm = document.querySelector('#hamburger-search-form');

if (hamburgerSearchForm) {
    const hamburgerSearchInput = hamburgerSearchForm.querySelector('input[name="nome"]');
    function onHamburgerJson(data) {
        const oldError = document.querySelector('#hamburger-search-error');
        if (oldError) {
            oldError.remove();
        }
        const errorDiv = document.createElement('div');
        errorDiv.id = 'hamburger-search-error';
        if (!data) {
             errorDiv.textContent = 'Errore durante la ricerca.';
        } else if (data.success && data.product && data.product.id) {
            location.href = 'http://127.0.0.1:8000/prodotto/' + data.product.id;
            return;
        } else {
            errorDiv.textContent = data.message;
            if (!errorDiv.textContent) errorDiv.textContent = 'Prodotto non trovato';
        }
        const parent = hamburgerSearchForm.parentNode;
        if (parent) {
             parent.insertBefore(errorDiv, hamburgerSearchForm.nextSibling);
        }
    }

    function handleHamburgerSubmit(e) {
        e.preventDefault();
        const name = hamburgerSearchInput.value;
        fetch('http://127.0.0.1:8000/prodotti/search?nome=' + encodeURIComponent(name))
            .then(onResponse, onError)
            .then(onHamburgerJson);
    }

    hamburgerSearchForm.addEventListener('submit', handleHamburgerSubmit);
}

const hamburgerBtn = document.querySelector('#hamburger-btn');
const navLinks = document.querySelector('#nav-links');

if (hamburgerBtn && navLinks) {
    const hamburgerIcon = hamburgerBtn.querySelector('.hamburger-icon');

    function toggleMenu() {
        navLinks.classList.toggle('open');
        const isOpen = navLinks.classList.contains('open');
        hamburgerBtn.setAttribute('aria-expanded', isOpen);
        if (hamburgerIcon) {
            if (isOpen) {
                hamburgerIcon.innerHTML = '&#10005;';
            } else {
                hamburgerIcon.innerHTML = '&#9776;';
            }
        }
    }
    hamburgerBtn.addEventListener('click', toggleMenu);
    document.addEventListener('click', function(e) {
        if (!hamburgerBtn.contains(e.target) && !navLinks.contains(e.target)) {
            navLinks.classList.remove('open');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
            if (hamburgerIcon) hamburgerIcon.innerHTML = '&#9776;';
        }
    });
}

const accountBtn = document.querySelector('#account-btn');
const accountDropdown = document.querySelector('#account-dropdown');

if (accountBtn && accountDropdown) {
    accountBtn.addEventListener('click', function(e) {
        e.preventDefault();
        accountDropdown.classList.toggle('show');
    });
    document.addEventListener('click', function(e) {
        if (!accountBtn.contains(e.target) && !accountDropdown.contains(e.target)) {
            accountDropdown.classList.remove('show');
        }
    });
}

const searchBtn = document.querySelector('#search-btn');
const searchDropdown = document.querySelector('#search-dropdown');
const searchInput = document.querySelector('#search-input');

if (searchBtn && searchDropdown && searchInput) {
    searchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        searchDropdown.classList.toggle('show');
        if (searchDropdown.classList.contains('show')){
            searchInput.focus();
        }
    });
    document.addEventListener('click', function(e) {
        if (!searchBtn.contains(e.target) && !searchDropdown.contains(e.target)) {
            searchDropdown.classList.remove('show');
        }
    });
}

const searchForm = document.querySelector('#search-form');

if (searchForm && searchInput) {
    const resultDiv = document.querySelector('#result');
    if (resultDiv) resultDiv.classList.add('hidden');
    
    function onSearchJson(data) {
        if (resultDiv) {
            resultDiv.innerHTML = '';
            resultDiv.classList.remove('search-result-error');
        }
        if (!data) {
            if (resultDiv) {
                resultDiv.classList.remove('hidden');
                const p = document.createElement('p');
                p.textContent = 'Errore durante la ricerca.';
                resultDiv.classList.add('search-result-error');
                resultDiv.appendChild(p);
            }
            return;
        }
        if (data.success && data.product && data.product.id) {
            location.href = 'http://127.0.0.1:8000/prodotto/' + data.product.id;
        } else {
            if (resultDiv) {
                resultDiv.classList.remove('hidden');
                const p = document.createElement('p');
                p.textContent = data.message;
                if(!p.textContent) p.textContent = 'Prodotto non trovato';
                resultDiv.classList.add('search-result-error');
                resultDiv.appendChild(p);
            }
        }
    }
    function handleSearchSubmit(e) {
        e.preventDefault();
        const name = searchInput.value;
        fetch('http://127.0.0.1:8000/prodotti/search?nome=' + encodeURIComponent(name))
            .then(onResponse, onError)
            .then(onSearchJson);
    }
    searchForm.addEventListener('submit', handleSearchSubmit);
}

const footerHamburger = document.querySelector('#footer-hamburger');
const footerApiMenu = document.querySelector('#footer-api-menu');

if (footerHamburger && footerApiMenu) {
    footerHamburger.addEventListener('click', function() {
        footerApiMenu.classList.toggle('open');
    });
    document.addEventListener('click', function(e) {
        if (!footerHamburger.contains(e.target) && !footerApiMenu.contains(e.target)) {
            footerApiMenu.classList.remove('open');
        }
    });
}

const hamburgerExtras = document.querySelector('#hamburger-extra-buttons');

if (hamburgerBtn && hamburgerExtras) {
    function updateHamburgerExtras() {
        const isOpen = navLinks.classList.contains('open');
        if (isOpen) {
            hamburgerExtras.classList.add('show')
        } else {
            hamburgerExtras.classList.remove('show');
        }
    }
    hamburgerBtn.addEventListener('click', updateHamburgerExtras);
    document.addEventListener('resize', updateHamburgerExtras);
    document.addEventListener('click', function(e) {
        if (!hamburgerBtn.contains(e.target) && !navLinks.contains(e.target)) {
            hamburgerExtras.classList.remove('show');
        }
    });
}