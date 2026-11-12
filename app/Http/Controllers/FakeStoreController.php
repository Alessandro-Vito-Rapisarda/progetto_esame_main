<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FakeStoreController extends Controller
{
    private const CACHE_KEY = 'fakestore_products';
    private const BACKUP_CACHE_KEY = 'fakestore_products_backup';

    // Proxy con cache e IPv4 forzato per evitare timeout/handshake falliti lato browser
    public function products()
    {
        $cached = Cache::get(self::CACHE_KEY);
        if (is_array($cached) && !empty($cached)) {
            return response()->json($cached);
        }

        try {
            $risposta = Http::withOptions(['force_ip_resolve' => 'v4'])
                ->connectTimeout(5)
                ->timeout(10)
                ->retry(2, 200, null, false)
                ->get('https://fakestoreapi.com/products');

            if ($risposta->successful()) {
                $prodotti = $risposta->json();
                if (is_array($prodotti) && !empty($prodotti)) {
                    Cache::put(self::CACHE_KEY, $prodotti, 900);
                    Cache::put(self::BACKUP_CACHE_KEY, $prodotti, 86400);
                    return response()->json($prodotti);
                }
            }
        } catch (\Throwable $e) {
            // Usa la copia di backup in cache se l'upstream non risponde temporaneamente
        }

        $backup = Cache::get(self::BACKUP_CACHE_KEY);
        if (is_array($backup) && !empty($backup)) {
            return response()->json($backup);
        }

        return response()->json(['error' => 'Impossibile caricare i prodotti da FakeStore.'], 502);
    }
}
