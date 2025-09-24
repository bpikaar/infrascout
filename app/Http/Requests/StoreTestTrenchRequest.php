<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestTrenchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'test_trench_enabled' => ['nullable', 'boolean'],
            'test_trench.proefsleuf_gemaakt' => ['required_if:test_trench_enabled, 1'],
            'test_trench.manier_van_graven' => ['required_if:test_trench_enabled, 1'],
            'test_trench.type_grondslag' => ['required_if:test_trench_enabled, 1'],
            'test_trench.klic_melding_gedaan' => ['nullable', 'boolean'],
            'test_trench.klic_nummer' => ['nullable', 'string'],
            'test_trench.locatie' => ['nullable', 'string'],
            'test_trench.doel' => ['nullable', 'string'],
            'test_trench.bevindingen' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'test_trench.proefsleuf_gemaakt.required_if' => 'Geef aan of er een proefsleuf gemaakt is.',
            'test_trench.manier_van_graven.required_if' => 'Selecteer een manier van graven.',
//            'test_trench.manier_van_graven.in' => 'Ongeldige keuze voor manier van graven.',
            'test_trench.type_grondslag.required_if' => 'Selecteer een type grondslag.',
//            'test_trench.type_grondslag.in' => 'Ongeldige keuze voor type grondslag.',
        ];
    }

    public function attributes(): array
    {
        return [
            'test_trench_enabled' => 'proefsleuf',
            'test_trench.proefsleuf_gemaakt' => 'proefsleuf gemaakt',
            'test_trench.manier_van_graven' => 'manier van graven',
            'test_trench.type_grondslag' => 'type grondslag',
            'test_trench.klic_melding_gedaan' => 'KLIC melding gedaan',
            'test_trench.klic_nummer' => 'KLIC nummer',
            'test_trench.locatie' => 'locatie',
            'test_trench.doel' => 'doel',
            'test_trench.bevindingen' => 'bevindingen',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Keep normalization minimal and let validation handle required_if logic similar to StoreRadioDetectionRequest.
        // If you prefer boolean normalization for nested fields, re-enable merging here.
    }
}
