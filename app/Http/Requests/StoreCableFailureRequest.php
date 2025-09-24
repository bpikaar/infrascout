<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCableFailureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cable_failure_enabled' => ['nullable', 'boolean'],
            'cable_failure.type_storing' => ['required_if:cable_failure_enabled,1', 'nullable', Rule::in(['Kabelbreuk','Slechte verbinding','Kortsluiting','Overig'])],
            'cable_failure.locatie_storing' => ['nullable', 'string', 'max:255'],
            'cable_failure.methode_vaststelling' => ['nullable', Rule::in(['A-frame','TDR','Meggeren'])],
            'cable_failure.kabel_met_aftakking' => ['nullable', 'boolean'],
            'cable_failure.bijzonderheden' => ['nullable', 'string'],
            'cable_failure.advies' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'cable_failure.type_storing.required_if' => 'Selecteer het type storing.',
            'cable_failure.type_storing.in' => 'Ongeldige waarde voor type storing.',
            'cable_failure.methode_vaststelling.in' => 'Ongeldige methode voor vaststelling.',
        ];
    }

    public function attributes(): array
    {
        return [
            'cable_failure_enabled' => 'kabelstoring',
            'cable_failure.type_storing' => 'type storing',
            'cable_failure.locatie_storing' => 'locatie storing',
            'cable_failure.methode_vaststelling' => 'methode vaststelling',
            'cable_failure.kabel_met_aftakking' => 'kabel met aftakking',
            'cable_failure.bijzonderheden' => 'bijzonderheden',
            'cable_failure.advies' => 'advies',
        ];
    }

    protected function prepareForValidation(): void
    {
        $aftakking = filter_var($this->input('cable_failure.kabel_met_aftakking', false), FILTER_VALIDATE_BOOL);
        $this->merge([
            'cable_failure' => array_merge($this->input('cable_failure', []), [
                'kabel_met_aftakking' => $aftakking,
            ]),
        ]);
    }
}
