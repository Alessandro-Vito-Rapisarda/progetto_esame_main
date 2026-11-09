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

function onTokenJson(data) {
    if (!data || !data.access_token) return null;
    return data.access_token;
}

export function requestToken() {
    return fetch('/spotify/token')
        .then(onResponse, onError)
        .then(onTokenJson);
}