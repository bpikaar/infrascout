<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lance_enabled' => ['nullable', 'boolean'],
            'lance.aanprikdiepte' => ['required_if:lance_enabled,1', 'nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'lance.aanprikdiepte.required_if' => 'Vul de aanprikdiepte in wanneer Lance is ingeschakeld.',
            'lance.aanprikdiepte.numeric' => 'Aanprikdiepte moet een getal zijn.',
            'lance.aanprikdiepte.min' => 'Aanprikdiepte moet 0 of hoger zijn.',
        ];
    }

    public function attributes(): array
    {
        return [
            'lance_enabled' => 'lance',
            'lance.aanprikdiepte' => 'aanprikdiepte (m)',
        ];
    }

    protected function prepareForValidation(): void
    {
        $enabled = filter_var($this->input('lance_enabled', false), FILTER_VALIDATE_BOOL) ? 1 : 0;
        $this->merge([
            'lance_enabled' => $enabled,
        ]);
    }
}

