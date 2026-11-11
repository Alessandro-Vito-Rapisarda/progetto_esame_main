<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return ['nome.max' => 'La ricerca può avere al massimo 100 caratteri.'];
    }
}
