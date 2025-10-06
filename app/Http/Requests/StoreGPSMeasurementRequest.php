<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGPSMeasurementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gps_measurement_enabled' => ['nullable','boolean'],
            'gps_measurement.gemeten_met' => ['required_if:gps_measurement_enabled,1','nullable', Rule::in(['Veldboek 1','Veldboek 2'])],
            'gps_measurement.data_verstuurd_naar_tekenaar' => ['nullable','boolean'],
            'gps_measurement.signaal' => ['required_if:gps_measurement_enabled,1','nullable', Rule::in(['Slecht','Matig','Goed'])],
            'gps_measurement.omgeving' => ['required_if:gps_measurement_enabled,1','nullable', Rule::in(['Open veld','Tussen bebouwing','Bosrijk gebied'])],
        ];
    }

    public function messages(): array
    {
        return [
            'gps_measurement.gemeten_met.required_if' => 'Selecteer waarmee gemeten is.',
            'gps_measurement.signaal.required_if' => 'Selecteer het signaal.',
            'gps_measurement.omgeving.required_if' => 'Selecteer de omgeving.',
        ];
    }

    public function attributes(): array
    {
        return [
            'gps_measurement_enabled' => 'gps-meting',
            'gps_measurement.gemeten_met' => 'gemeten met',
            'gps_measurement.data_verstuurd_naar_tekenaar' => 'data verstuurd naar tekenaar',
            'gps_measurement.signaal' => 'signaal',
            'gps_measurement.omgeving' => 'omgeving',
        ];
    }

    protected function prepareForValidation(): void
    {
        $sent = filter_var($this->input('gps_measurement.data_verstuurd_naar_tekenaar', false), FILTER_VALIDATE_BOOL);
        $this->merge([
            'gps_measurement' => array_merge($this->input('gps_measurement', []), [
                'data_verstuurd_naar_tekenaar' => $sent,
            ]),
        ]);
    }
}
