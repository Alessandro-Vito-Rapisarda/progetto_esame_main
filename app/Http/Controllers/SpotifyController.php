<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
{
    // Restituisce al browser solo il token Spotify (le chiavi restano sul server)
    public function getToken(Request $request)
    {
        $clientId = config('services.spotify.client_id');
        $clientSecret = config('services.spotify.client_secret');

        if (!$clientId || !$clientSecret) {
            return response()->json(['error' => 'Chiavi Spotify non configurate'], 503);
        }

        $cacheKey = 'spotify_token_' . md5($clientId . ':' . $clientSecret);

        if (!$request->boolean('refresh')) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) && !empty($cached['access_token'])) {
                return response()->json($cached);
            }
        }

        try {
            // Forza IPv4 per evitare timeout su connessioni dove IPv6 non e' instradato
            $risposta = Http::withOptions(['force_ip_resolve' => 'v4'])
                ->asForm()
                ->withBasicAuth($clientId, $clientSecret)
                ->connectTimeout(5)
                ->timeout(10)
                ->retry(2, 200, null, false)
                ->post('https://accounts.spotify.com/api/token', ['grant_type' => 'client_credentials']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Spotify non raggiungibile'], 502);
        }

        if (!$risposta->successful() || !$risposta->json('access_token')) {
            return response()->json(['error' => 'Token Spotify non ottenuto'], 502);
        }

        $expiresIn = (int) ($risposta->json('expires_in') ?? 3600);
        $payload = [
            'access_token' => $risposta->json('access_token'),
            'expires_in' => $expiresIn,
        ];

        Cache::put($cacheKey, $payload, max(60, $expiresIn - 120));

        return response()->json($payload);
    }
}
