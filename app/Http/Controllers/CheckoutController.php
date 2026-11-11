<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Carrello;
use App\Models\Ordine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function showForm(Request $request)
    {
        $carrello = Carrello::perUtente((int) $request->session()->get('user_id'));
        $carrello->load('prodotti.immagini');

        if ($carrello->prodotti->isEmpty()) {
            return redirect('shopping');
        }

        return view('checkout', ['prodotti' => $carrello->prodotti, 'totale' => $carrello->totale()]);
    }

    public function processOrder(CheckoutRequest $request)
    {
        $carrello = Carrello::perUtente((int) $request->session()->get('user_id'));
        $carrello->load('prodotti');

        if ($carrello->prodotti->isEmpty()) {
            return redirect('shopping');
        }

        $ordine = DB::transaction(function () use ($carrello, $request) {
            return Ordine::daCarrello($carrello, $request->input('indirizzo_spedizione'));
        });

        return redirect('ordine/' . $ordine->id);
    }
}
