<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Prodotto;

class ProdottoController extends Controller
{
    public function index(SearchRequest $request)
    {
        $nome = $request->validated('nome');

        $prodotti = Prodotto::with('immagini')->cercaNome($nome)->orderBy('id')->get();

        return view('prodotti', ['prodotti' => $prodotti, 'ricerca' => $nome]);
    }

    public function show(int $id)
    {
        $prodotto = Prodotto::with('immagini')->find($id);

        if (!$prodotto) {
            return redirect('prodotti');
        }

        return view('prodotto', ['prodotto' => $prodotto]);
    }
}
