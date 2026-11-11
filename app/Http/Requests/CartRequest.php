<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'prodotto_id' => ['required', 'integer', 'exists:prodotti,id'],
        ];

        // La rimozione non richiede la quantita'
        if (!$this->isMethod('DELETE')) {
            $rules['quantita'] = ['nullable', 'integer', 'min:1', 'max:99'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'prodotto_id.required' => 'Prodotto mancante.',
            'prodotto_id.integer' => 'Prodotto non valido.',
            'prodotto_id.exists' => 'Il prodotto richiesto non esiste.',
            'quantita.integer' => 'La quantità deve essere un numero intero.',
            'quantita.min' => 'La quantità minima è 1.',
            'quantita.max' => 'La quantità massima è 99.',
        ];
    }
}
