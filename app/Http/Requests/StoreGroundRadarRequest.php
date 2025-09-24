<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'ground_radar.onderzoeksgebied' => ['required_if:ground_radar_enabled, 1'],
            'ground_radar.scanrichting' => ['required_if:ground_radar_enabled, 1'],
            'ground_radar.ingestelde_detectiediepte' => ['nullable','numeric','min:0'],
            'ground_radar.reflecties' => ['nullable','string'],
            'ground_radar.interpretatie' => ['required_if:ground_radar_enabled, 1'],
        ];
    }

    public function messages(): array
    {
        return [
            'ground_radar.onderzoeksgebied.required_if' => 'Selecteer het onderzoeksgebied.',
            'ground_radar.scanrichting.required_if' => 'Selecteer de scanrichting.',
            'ground_radar.interpretatie.required_if' => 'Selecteer een interpretatie.',
//            'ground_radar.onderzoeksgebied.in' => 'Ongeldig onderzoeksgebied.',
//            'ground_radar.scanrichting.in' => 'Ongeldige scanrichting.',
//            'ground_radar.interpretatie.in' => 'Ongeldige interpretatie.',
        ];
    }

    public function attributes(): array
    {
        return [
            'ground_radar_enabled' => 'grondradar',
            'ground_radar.onderzoeksgebied' => 'onderzoeksgebied',
            'ground_radar.scanrichting' => 'scanrichting',
            'ground_radar.ingestelde_detectiediepte' => 'ingestelde detectiediepte',
            'ground_radar.reflecties' => 'reflecties',
            'ground_radar.interpretatie' => 'interpretatie',
        ];
    }

    protected function prepareForValidation(): void
    {
        // keep normalization minimal; mirroring the style used by other modular requests
    }
}
