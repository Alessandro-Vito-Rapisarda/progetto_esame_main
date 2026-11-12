import { fetchSpotifyJson, formatArtists, formatDuration } from './spotifyCommon.js';

const container = document.querySelector('#album-container');

const searchForm = document.createElement('form');
searchForm.classList.add('spotify-search-form-centered');

const input = document.createElement('input');
input.type = 'text';
input.id = 'album-id-input';
input.classList.add('spotify-search-input');
input.placeholder = 'Cerca album...';
input.required = true;

const button = document.createElement('button');
button.type = 'submit';
button.classList.add('spotify-search-btn');
button.textContent = 'Cerca';

searchForm.appendChild(input);
searchForm.appendChild(button);

if (container && container.parentNode) {
    container.parentNode.insertBefore(searchForm, container);
    container.classList.add('hidden');
}

function showMessage(text, isError = false) {
    if (!container) return;
    container.classList.remove('hidden');
    container.innerHTML = '';
    const p = document.createElement('p');
    p.textContent = text;
    if (isError) {
        p.classList.add('error-msg');
    }
    container.appendChild(p);
}

function renderAlbumResults(data) {
    if (!container) return;
    container.innerHTML = '';
    container.classList.remove('hidden');

    const albums = Array.isArray(data?.albums?.items)
        ? data.albums.items.filter(Boolean)
        : [];

    if (!albums.length) {
        showMessage('Nessun album trovato.');
        return;
    }

    const h3 = document.createElement('h3');
    h3.textContent = 'Risultati:';
    container.appendChild(h3);

    const listDiv = document.createElement('div');
    listDiv.classList.add('spotify-result-list');

    for (const album of albums) {
        const card = document.createElement('div');
        card.classList.add('spotify-result-card');
        card.dataset.albumId = album.id;

        const img = document.createElement('img');
        if (Array.isArray(album.images) && album.images.length > 0 && album.images[0]?.url) {
            img.src = album.images[0].url;
        }
        img.alt = album.name || 'Album';
        img.classList.add('spotify-result-img');
        card.appendChild(img);

        const infoDiv = document.createElement('div');
        infoDiv.classList.add('spotify-result-info');

        const titleDiv = document.createElement('div');
        titleDiv.classList.add('spotify-result-title');
        titleDiv.textContent = album.name || 'Senza titolo';
        infoDiv.appendChild(titleDiv);

        const artistDiv = document.createElement('div');
        artistDiv.classList.add('spotify-result-artist');
        artistDiv.textContent = formatArtists(album.artists);
        infoDiv.appendChild(artistDiv);

        const dateDiv = document.createElement('div');
        dateDiv.classList.add('spotify-result-meta');
        dateDiv.textContent = album.release_date || '';
        infoDiv.appendChild(dateDiv);

        card.appendChild(infoDiv);
        card.addEventListener('click', onCardClick);
        listDiv.appendChild(card);
    }

    container.appendChild(listDiv);
}

function renderAlbumDetails(data) {
    if (!container) return;
    if (!data) {
        showMessage('Impossibile caricare i dettagli dell\'album.', true);
        return;
    }

    container.innerHTML = '';

    const backBtn = document.createElement('a');
    backBtn.href = '#';
    backBtn.classList.add('spotify-back-btn');
    backBtn.textContent = 'Torna ai risultati';
    backBtn.addEventListener('click', function (e) {
        e.preventDefault();
        searchForm.dispatchEvent(new Event('submit', { cancelable: true }));
    });
    container.appendChild(backBtn);

    const albumCard = document.createElement('div');
    albumCard.classList.add('spotify-album-card');

    const infoDiv = document.createElement('div');
    infoDiv.classList.add('spotify-album-info');

    const titleDiv = document.createElement('div');
    titleDiv.classList.add('spotify-album-title');
    titleDiv.textContent = data.name || 'Album';
    infoDiv.appendChild(titleDiv);

    const metaArtist = document.createElement('div');
    metaArtist.classList.add('spotify-album-meta');
    metaArtist.textContent = 'Artista: ' + (formatArtists(data.artists) || 'N/D');
    infoDiv.appendChild(metaArtist);

    const metaDate = document.createElement('div');
    metaDate.classList.add('spotify-album-meta');
    metaDate.textContent = 'Data di rilascio: ' + (data.release_date || 'N/D');
    infoDiv.appendChild(metaDate);

    albumCard.appendChild(infoDiv);

    if (Array.isArray(data.images) && data.images.length > 0 && data.images[0]?.url) {
        const cover = document.createElement('img');
        cover.src = data.images[0].url;
        cover.alt = data.name || 'Copertina album';
        cover.classList.add('spotify-album-cover');
        albumCard.appendChild(cover);
    }
    container.appendChild(albumCard);

    const tracksContainer = document.createElement('div');
    tracksContainer.classList.add('spotify-album-tracks');

    const tracksTitle = document.createElement('div');
    tracksTitle.classList.add('spotify-album-tracks-title');
    tracksTitle.textContent = 'Tracce:';
    tracksContainer.appendChild(tracksTitle);

    const ul = document.createElement('ul');
    ul.classList.add('spotify-album-tracks-list');

    const tracks = Array.isArray(data?.tracks?.items) ? data.tracks.items.filter(Boolean) : [];
    for (const track of tracks) {
        const li = document.createElement('li');
        const num = track.track_number ?? '';
        const prefix = num ? num + '. ' : '';
        li.textContent = prefix + (track.name || 'Traccia') + ' (' + formatDuration(track.duration_ms) + ')';
        ul.appendChild(li);
    }

    tracksContainer.appendChild(ul);
    container.appendChild(tracksContainer);
}

async function searchAlbums(query) {
    try {
        // Limite massimo consentito in Spotify Developer Mode per ricerca: 10 risultati
        const url = 'https://api.spotify.com/v1/search?type=album&limit=10&q=' + encodeURIComponent(query);
        const data = await fetchSpotifyJson(url);
        renderAlbumResults(data);
    } catch (error) {
        showMessage('Errore di connessione con Spotify: ' + error.message, true);
    }
}

function onSubmit(e) {
    e.preventDefault();
    const query = input.value.trim();
    if (!query) {
        if (container) container.classList.add('hidden');
        return;
    }

    showMessage('Caricamento...');
    searchAlbums(query);
}

async function onCardClick(event) {
    const albumId = event.currentTarget.dataset.albumId;
    if (!albumId) return;

    showMessage('Caricamento album...');

    try {
        const data = await fetchSpotifyJson('https://api.spotify.com/v1/albums/' + encodeURIComponent(albumId));
        renderAlbumDetails(data);
    } catch (error) {
        showMessage('Errore nel caricamento dell\'album: ' + error.message, true);
    }
}

searchForm.addEventListener('submit', onSubmit);
