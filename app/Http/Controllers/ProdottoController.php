<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Prodotto;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class ProdottoController extends BaseController
{
    public function getProdotti()
    {
        $prodotti = DB::table('prodotti')->get();

        if ($prodotti->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Nessun prodotto trovato.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'prodotti' => $prodotti
        ]);
    }

    public function index()
    {
        $prodotti = Prodotto::with('immagini')->get();
        
        return view('prodotti')->with(['prodotti' => $prodotti]);
    }

    public function show($id)
    {
        $prodotto = Prodotto::with('immagini')->find($id);
        
        if (!$prodotto) {
            return redirect('prodotti');
        }

        $backUrl = 'prodotti';

        return view('prodotto')->with(['prodotto' => $prodotto, 'backUrl' => $backUrl]);
    }

    public function showJson($id)
    {
        $prodotto = Prodotto::with('immagini')->find($id);
        
        if (!$prodotto) {
            return response()->json(['error' => 'Prodotto non trovato'], 404);
        }
        
        return response()->json($prodotto);
    }


    public function search(Request $request): JsonResponse
     {
        $nome = $request->query('nome');

        if (!$nome) {
            return response()->json([
                'success' => false,
                'message' => 'Parametro "nome" mancante'
            ], 400);
        }

        $product = Prodotto::where('nome', 'LIKE', "%{$nome}%")->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Prodotto non trovato'
        ], 404);
    }
}