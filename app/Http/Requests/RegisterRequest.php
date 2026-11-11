<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    // Regole identiche a quelle applicate lato browser in public/js/register.js
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[A-Za-z0-9_.-]+$/', 'unique:utenti,username'],
            'password' => [
                'required', 'string', 'min:8', 'max:72',
                'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[\W_]/',
            ],
            'conferma' => ['required', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Inserisci uno username.',
            'username.min' => 'Lo username deve avere almeno 3 caratteri.',
            'username.max' => 'Lo username può avere al massimo 30 caratteri.',
            'username.regex' => 'Lo username può contenere solo lettere, numeri, punto, trattino e underscore.',
            'username.unique' => 'Nome utente già esistente.',
            'password.required' => 'Inserisci una password.',
            'password.min' => 'La password deve avere almeno 8 caratteri.',
            'password.max' => 'La password può avere al massimo 72 caratteri.',
            'password.regex' => 'Password insicura: servono maiuscola, minuscola, numero e carattere speciale.',
            'conferma.required' => 'Conferma la password.',
            'conferma.same' => 'Le password non corrispondono.',
        ];
    }
}
