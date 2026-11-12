import { fetchSpotifyJson, formatArtists, formatDuration } from './spotifyCommon.js';

const container = document.querySelector('#song-container');

const searchForm = document.createElement('form');
searchForm.classList.add('spotify-search-form', 'spotify-search-form-centered');

const input = document.createElement('input');
input.type = 'text';
input.id = 'song-name-input';
input.classList.add('spotify-search-input');
input.placeholder = 'Cerca canzone...';
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

function renderTrackResults(data) {
    if (!container) return;
    container.innerHTML = '';
    container.classList.remove('hidden');

    const tracks = Array.isArray(data?.tracks?.items)
        ? data.tracks.items.filter(Boolean)
        : [];

    if (!tracks.length) {
        showMessage('Nessuna canzone trovata.');
        return;
    }

    const h3 = document.createElement('h3');
    h3.textContent = 'Risultati:';
    container.appendChild(h3);

    const listDiv = document.createElement('div');
    listDiv.classList.add('spotify-result-list');

    for (const track of tracks) {
        const card = document.createElement('div');
        card.classList.add('spotify-result-card');
        card.dataset.trackId = track.id;

        const img = document.createElement('img');
        const images = track.album?.images;
        if (Array.isArray(images) && images.length > 0 && images[0]?.url) {
            img.src = images[0].url;
        }
        img.alt = track.name || 'Brano';
        img.classList.add('spotify-result-img');
        card.appendChild(img);

        const infoDiv = document.createElement('div');
        infoDiv.classList.add('spotify-result-info');

        const title = document.createElement('div');
        title.classList.add('spotify-result-title');
        title.textContent = track.name || 'Senza titolo';
        infoDiv.appendChild(title);

        const artist = document.createElement('div');
        artist.classList.add('spotify-result-artist');
        artist.textContent = formatArtists(track.artists);
        infoDiv.appendChild(artist);

        card.appendChild(infoDiv);
        card.addEventListener('click', onTrackClick);
        listDiv.appendChild(card);
    }

    container.appendChild(listDiv);
}

function renderTrackDetails(data) {
    if (!container) return;
    if (!data) {
        showMessage('Impossibile caricare i dettagli della canzone.', true);
        return;
    }

    container.innerHTML = '';

    const albumCard = document.createElement('div');
    albumCard.classList.add('spotify-album-card');

    const infoDiv = document.createElement('div');
    infoDiv.classList.add('spotify-album-info');

    const title = document.createElement('div');
    title.classList.add('spotify-album-title');
    title.textContent = data.name || 'Brano';
    infoDiv.appendChild(title);

    const metaArtist = document.createElement('div');
    metaArtist.classList.add('spotify-album-meta');
    metaArtist.textContent = 'Artista: ' + (formatArtists(data.artists) || 'N/D');
    infoDiv.appendChild(metaArtist);

    const metaAlbum = document.createElement('div');
    metaAlbum.classList.add('spotify-album-meta');
    metaAlbum.textContent = 'Album: ' + (data.album?.name || 'N/D');
    infoDiv.appendChild(metaAlbum);

    const metaDuration = document.createElement('div');
    metaDuration.classList.add('spotify-album-meta');
    metaDuration.textContent = 'Durata: ' + formatDuration(data.duration_ms);
    infoDiv.appendChild(metaDuration);

    albumCard.appendChild(infoDiv);

    const images = data.album?.images;
    if (Array.isArray(images) && images.length > 0 && images[0]?.url) {
        const img = document.createElement('img');
        img.src = images[0].url;
        img.alt = data.name || 'Copertina';
        img.classList.add('spotify-album-cover');
        albumCard.appendChild(img);
    }
    container.appendChild(albumCard);

    const backBtn = document.createElement('a');
    backBtn.href = '#';
    backBtn.classList.add('spotify-back-btn');
    backBtn.textContent = 'Torna ai risultati';
    backBtn.addEventListener('click', function (e) {
        e.preventDefault();
        searchForm.dispatchEvent(new Event('submit', { cancelable: true }));
    });
    container.appendChild(backBtn);
}

async function searchTracks(query) {
    try {
        // Limite massimo consentito in Spotify Developer Mode per ricerca: 10 risultati
        const url = 'https://api.spotify.com/v1/search?q=' + encodeURIComponent(query) + '&type=track&limit=10';
        const data = await fetchSpotifyJson(url);
        renderTrackResults(data);
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
    searchTracks(query);
}

async function onTrackClick(event) {
    const trackId = event.currentTarget.dataset.trackId;
    if (!trackId) return;

    showMessage('Caricamento canzone...');

    try {
        const data = await fetchSpotifyJson('https://api.spotify.com/v1/tracks/' + encodeURIComponent(trackId));
        renderTrackDetails(data);
    } catch (error) {
        showMessage('Errore nel caricamento della canzone: ' + error.message, true);
    }
}

searchForm.addEventListener('submit', onSubmit);
