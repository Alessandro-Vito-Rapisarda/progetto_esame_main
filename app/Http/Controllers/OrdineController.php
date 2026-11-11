<?php

namespace App\Http\Controllers;

use App\Models\Ordine;
use Illuminate\Http\Request;

class OrdineController extends Controller
{
    public function show(Request $request, int $id)
    {
        $ordine = Ordine::where('utente_id', $request->session()->get('user_id'))
                        ->with('ordineProdotti.prodotto')
                        ->findOrFail($id);

        return view('ordine_confermato', ['ordine' => $ordine]);
    }
}
