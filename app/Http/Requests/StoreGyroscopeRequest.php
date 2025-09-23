<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGyroscopeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gyroscope_enabled' => ['nullable', 'boolean'],
            'gyroscope.type_boring' => ['required_if:gyroscope_enabled,1'],
            'gyroscope.intredepunt' => ['required_if:gyroscope_enabled,1'],
            'gyroscope.uittredepunt' => ['required_if:gyroscope_enabled,1'],
            'gyroscope.lengte_trace' => ['nullable', 'numeric', 'min:0'],
            'gyroscope.bodemprofiel_ingemeten_met_gps' => ['nullable', 'boolean'],
            'gyroscope.diameter_buis' => ['nullable', 'numeric', 'min:0'],
            'gyroscope.materiaal' => ['nullable', Rule::in(['PVC','PE','HDPE','Gietijzer','Staal','RVS','Overig'])],
            'gyroscope.ingemeten_met' => ['nullable', Rule::in(['Trektouw', 'Cable-pusher (glasfiber pees)'])],
            'gyroscope.bijzonderheden' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'gyroscope.type_boring.required_if' => 'Selecteer het type boring.',
            'gyroscope.intredepunt.required_if' => 'Vul het intredepunt in.',
            'gyroscope.uittredepunt.required_if' => 'Vul het uittredepunt in.',
            'gyroscope.type_boring.in' => 'Ongeldige waarde voor type boring.',
            'gyroscope.materiaal.in' => 'Ongeldige materiaalkeuze.',
            'gyroscope.ingemeten_met.in' => 'Ongeldige keuze bij "Ingemeten met".',
        ];
    }

    public function attributes(): array
    {
        return [
            'gyroscope_enabled' => 'gyroscoop',
            'gyroscope.type_boring' => 'type boring',
            'gyroscope.intredepunt' => 'intredepunt',
            'gyroscope.uittredepunt' => 'uittredepunt',
            'gyroscope.lengte_trace' => 'lengte tracé (m)',
            'gyroscope.bodemprofiel_ingemeten_met_gps' => 'bodemprofiel ingemeten met GPS',
            'gyroscope.diameter_buis' => 'diameter buis (mm)',
            'gyroscope.materiaal' => 'materiaal',
            'gyroscope.ingemeten_met' => 'ingemeten met',
            'gyroscope.bijzonderheden' => 'bijzonderheden',
        ];
    }

    protected function prepareForValidation(): void
    {
//        $enabled = filter_var($this->input('gyroscope_enabled', false), FILTER_VALIDATE_BOOL);
        $gps = filter_var($this->input('gyroscope.bodemprofiel_ingemeten_met_gps', false), FILTER_VALIDATE_BOOL);
        $this->merge([
//            'gyroscope_enabled' => $enabled,
            'gyroscope' => array_merge($this->input('gyroscope', []), [
                'bodemprofiel_ingemeten_met_gps' => $gps,
            ]),
        ]);
    }
}
