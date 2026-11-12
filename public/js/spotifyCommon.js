let cachedToken = null;
let tokenExpiresAt = 0;

function withTimeoutSignal(ms) {
    if (typeof AbortSignal !== 'undefined' && typeof AbortSignal.timeout === 'function') {
        return AbortSignal.timeout(ms);
    }
    return undefined;
}

export async function requestSpotifyToken(forceRefresh = false) {
    const now = Date.now();
    if (!forceRefresh && cachedToken && now < tokenExpiresAt) {
        return cachedToken;
    }

    const url = forceRefresh ? '/spotify/token?refresh=1' : '/spotify/token';
    const response = await fetch(url, { signal: withTimeoutSignal(12000) });

    if (!response.ok) {
        throw new Error('Impossibile ottenere il token Spotify (HTTP ' + response.status + ')');
    }

    const data = await response.json();
    if (!data || !data.access_token) {
        throw new Error('Token Spotify non valido');
    }

    cachedToken = data.access_token;
    const expiresInSec = typeof data.expires_in === 'number' ? data.expires_in : 3600;
    tokenExpiresAt = Date.now() + Math.max(30, expiresInSec - 120) * 1000;

    return cachedToken;
}

export async function fetchSpotifyJson(url) {
    let token = await requestSpotifyToken(false);
    let response = await fetch(url, {
        headers: { Authorization: 'Bearer ' + token },
        signal: withTimeoutSignal(12000),
    });

    if (response.status === 401) {
        cachedToken = null;
        tokenExpiresAt = 0;
        token = await requestSpotifyToken(true);
        response = await fetch(url, {
            headers: { Authorization: 'Bearer ' + token },
            signal: withTimeoutSignal(12000),
        });
    }

    if (!response.ok) {
        throw new Error('Risposta Spotify non valida (HTTP ' + response.status + ')');
    }

    return response.json();
}

export function formatArtists(artists) {
    if (!Array.isArray(artists)) {
        return '';
    }
    return artists
        .filter((artist) => artist && artist.name)
        .map((artist) => artist.name)
        .join(', ');
}

export function formatDuration(durationMs) {
    if (typeof durationMs !== 'number' || Number.isNaN(durationMs) || durationMs < 0) {
        return 'N/D';
    }
    const minutes = Math.floor(durationMs / 60000);
    const seconds = Math.floor((durationMs % 60000) / 1000);
    return minutes + ':' + (seconds < 10 ? '0' + seconds : seconds);
}
