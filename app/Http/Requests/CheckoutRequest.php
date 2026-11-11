<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'indirizzo_spedizione' => ['required', 'string', 'min:5', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'indirizzo_spedizione.required' => 'Inserisci l\'indirizzo di spedizione.',
            'indirizzo_spedizione.min' => 'L\'indirizzo deve avere almeno 5 caratteri.',
            'indirizzo_spedizione.max' => 'L\'indirizzo può avere al massimo 255 caratteri.',
        ];
    }
}
