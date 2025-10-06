<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGroundRadarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ground_radar_enabled' => ['nullable','boolean'],
            'ground_radar.radarbeeld' => ['required_if:ground_radar_enabled,1', 'nullable', Rule::in(['Slecht','Matig','Goed','Zeer Goed'])],
            'ground_radar.ingestelde_detectiediepte' => ['nullable','numeric','min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'ground_radar.radarbeeld.required_if' => 'Selecteer het radarbeeld.',
            'ground_radar.radarbeeld.in' => 'Ongeldig radarbeeld.',
        ];
    }

    public function attributes(): array
    {
        return [
            'ground_radar_enabled' => 'grondradar',
            'ground_radar.radarbeeld' => 'radarbeeld',
            'ground_radar.ingestelde_detectiediepte' => 'ingestelde detectiediepte',
        ];
    }

    protected function prepareForValidation(): void
    {
        // keep normalization minimal; mirroring the style used by other modular requests
    }
}
