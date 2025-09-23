<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
        $rules = [
            'project_id'    => ['required', 'exists:projects,id'],
            'date_of_work'  => ['required', 'date'],
            'field_worker'   => ['required', 'exists:users,id'],

            // New cables array
            'cables'        => ['nullable', 'array'],
            'cables.*.id' => ['nullable', 'integer', 'exists:cables,id'],
            // If id is NOT present, we require the fields for a new cable
            'cables.*.cable_type' => ['required_without:cables.*.id', 'string', 'max:255'],
            'cables.*.material' => ['required_without:cables.*.id', 'in:GPLK,XLPE,Kunststof'],
            'cables.*.diameter' => ['nullable', 'numeric'],

            // If id is NOT present, we require the fields for a new pipe
            'pipes'        => ['nullable', 'array'],
            'pipes.*.id' => ['nullable', 'integer', 'exists:pipes,id'],
            'pipes.*.pipe_type' => ['required_without:pipes.*.id', 'string', 'max:255'],
            'pipes.*.material' => ['required_without:pipes.*.id', 'string', 'max:255'],
            'pipes.*.diameter' => ['nullable', 'numeric'],
            'description'   => ['required', 'string'],
            'work_hours'    => ['required', 'string', 'max:255'],
            'travel_time'   => ['required', 'string', 'max:255'],
            'images'        => ['nullable', 'array'],
            'images.*'      => ['nullable', 'image', 'max:2048'],
        ];

        // Merge RadioDetection rules (keeps separation of concerns)
        $rdRules = app(StoreRadioDetectionRequest::class)->rules();
        // These rules are defined with full keys (radio_detection.*), so we can merge directly
        $rules = array_merge($rules, $rdRules);

        return $rules;
    }

    public function messages(): array
    {
        // Allow radio detection custom messages to flow through
        return array_merge(parent::messages(), app(StoreRadioDetectionRequest::class)->messages());
    }

    public function attributes(): array
    {
        return array_merge(parent::attributes(), app(StoreRadioDetectionRequest::class)->attributes());
    }

    protected function prepareForValidation(): void
    {
        $cables = $this->input('cables', []);
        if (is_array($cables)) {
            $cables = array_values(array_filter($cables, function ($row) {
                if (!is_array($row)) return false;
                // Keep if existing id OR any creation field filled
                return !empty($row['id']) || (trim($row['cable_type'] ?? '') !== '' || trim($row['material'] ?? '') !== '' || trim((string)($row['diameter'] ?? '')) !== '');
            }));
        }
        $pipes = $this->input('pipes', []);
        if (is_array($pipes)) {
            $pipes = array_values(array_filter($pipes, function ($row) {
                if (!is_array($row)) return false;
                return !empty($row['id']) || (trim($row['pipe_type'] ?? '') !== '' || trim($row['material'] ?? '') !== '' || trim((string)($row['diameter'] ?? '')) !== '');
            }));
        }
        $this->merge([
            'cables' => $cables,
            'pipes' => $pipes,
        ]);
    }
}
