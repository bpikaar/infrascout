<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRadioDetectionRequest extends FormRequest
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
            // Radio detection optional block
            'radio_detection_enabled' => ['nullable', 'boolean'],
            'radio_detection.signaal_op_kabel' => ['required_with:radio_detection_enabled', 'string'],
            'radio_detection.signaal_sterkte' => ['required_with:radio_detection_enabled', 'string'],
            'radio_detection.frequentie' => ['required_with:radio_detection_enabled', 'string'],
            'radio_detection.aansluiting' => ['required_with:radio_detection_enabled', 'in:Passief,Actief'],
            'radio_detection.zender_type' => ['required_with:radio_detection_enabled', 'in:Radiodetection TX10,Vivax TX10'],
            'radio_detection.sonde_type' => ['nullable', 'in:Rioolsonde,Joepert,Joekeloekie,Boorsonde'],
            'radio_detection.geleider_frequentie' => ['nullable', 'in:285hz,320hz,1khz,4khz cd,8khz,8440khz,33khz'],
        ];
    }

    public function messages(): array
    {
        return [
            'radio_detection.signaal_op_kabel.required_with' => 'Vul ":attribute" in.',
            'radio_detection.signaal_sterkte.required_with' => 'Vul ":attribute" in.',
            'radio_detection.frequentie.required_with' => 'Vul ":attribute" in.',
            'radio_detection.aansluiting.required_with' => 'Selecteer een ":attribute".',
            'radio_detection.zender_type.required_with' => 'Selecteer een ":attribute".',

            'radio_detection.aansluiting.in' => 'De gekozen :attribute is ongeldig. Toegestane waarden: Passief of Actief.',
            'radio_detection.zender_type.in' => 'De gekozen :attribute is ongeldig.',
            'radio_detection.sonde_type.in' => 'De gekozen :attribute is ongeldig.',
            'radio_detection.geleider_frequentie.in' => 'De gekozen :attribute is ongeldig.',
        ];
    }

    public function attributes(): array
    {
        return [
            'radio_detection_enabled' => 'radiodetectie',
            'radio_detection.signaal_op_kabel' => 'signaal op kabel',
            'radio_detection.signaal_sterkte' => 'signaalsterkte',
            'radio_detection.frequentie' => 'frequentie',
            'radio_detection.aansluiting' => 'aansluiting',
            'radio_detection.zender_type' => 'zender type',
            'radio_detection.sonde_type' => 'sonde type',
            'radio_detection.geleider_frequentie' => 'geleider frequentie',
        ];
    }

    protected function prepareForValidation(): void
    {
        $enabled = filter_var($this->input('radio_detection_enabled', false), FILTER_VALIDATE_BOOL);
        $this->merge(['radio_detection_enabled' => $enabled]);
    }
}
