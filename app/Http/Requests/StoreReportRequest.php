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
            'project_id'        => ['required', 'exists:projects,id'],
            'date_of_work'      => ['required', 'date'],
            'field_worker'       => ['required', 'exists:users,id'],

            // New cables array
            'cables'            => ['nullable', 'array'],
            'cables.*.id'       => ['nullable', 'integer', 'exists:cables,id'],
            // If id is NOT present, we require the fields for a new cable
            'cables.*.cable_type' => ['required_without:cables.*.id', 'string', 'max:255'],
            'cables.*.material' => ['required_without:cables.*.id', 'in:GPLK,XLPE,Kunststof'],
            'cables.*.diameter' => ['nullable', 'numeric'],

            // If id is NOT present, we require the fields for a new pipe
            'pipes'             => ['nullable', 'array'],
            'pipes.*.id'        => ['nullable', 'integer', 'exists:pipes,id'],
            'pipes.*.pipe_type' => ['required_without:pipes.*.id', 'string', 'max:255'],
            'pipes.*.material'  => ['required_without:pipes.*.id', 'string', 'max:255'],
            'pipes.*.diameter'  => ['nullable', 'numeric'],
            'description'       => ['required', 'string'],
            'work_hours'        => ['required', 'string', 'max:255'],
            'travel_time'       => ['required', 'string', 'max:255'],

            // Results and follow-up (optional)
            'results_summary'   => ['nullable', 'string'],
            'advice'            => ['nullable', 'string'],
            'follow_up'         => ['nullable', 'string'],
            'problem_solved'    => ['nullable', 'boolean'],
            'question_answered' => ['nullable', 'boolean'],
            'images'            => ['nullable', 'array'],
            'images.*'          => ['nullable', 'image', 'max:51200'],
        ];

        // Merge RadioDetection rules (keeps separation of concerns)
        $rdRules = app(StoreRadioDetectionRequest::class)->rules();
        // These rules are defined with full keys (radio_detection.*), so we can merge directly
        $rules = array_merge($rules, $rdRules);

        // Merge Gyroscope rules
        $gyroRules = app(StoreGyroscopeRequest::class)->rules();
        $rules = array_merge($rules, $gyroRules);

        // Merge TestTrench rules
        $ttRules = app(StoreTestTrenchRequest::class)->rules();
        $rules = array_merge($rules, $ttRules);

        // Merge GroundRadar rules
        $radarRules = app(StoreGroundRadarRequest::class)->rules();
        $rules = array_merge($rules, $radarRules);

        // Merge CableFailure rules
        $cfRules = app(StoreCableFailureRequest::class)->rules();
        $rules = array_merge($rules, $cfRules);

        // Merge GPSMeasurement rules
        $gpsRules = app(StoreGPSMeasurementRequest::class)->rules();
        $rules = array_merge($rules, $gpsRules);

        return $rules;
    }

    public function messages(): array
    {
        // Allow radio detection custom messages to flow through
        return array_merge(
            parent::messages(),
            app(StoreRadioDetectionRequest::class)->messages(),
            app(StoreGyroscopeRequest::class)->messages(),
            app(StoreTestTrenchRequest::class)->messages(),
            app(StoreGroundRadarRequest::class)->messages(),
            app(StoreCableFailureRequest::class)->messages(),
            app(StoreGPSMeasurementRequest::class)->messages()
        );
    }

    public function attributes(): array
    {
        return array_merge(
            parent::attributes(),
            app(StoreRadioDetectionRequest::class)->attributes(),
            app(StoreGyroscopeRequest::class)->attributes(),
            app(StoreTestTrenchRequest::class)->attributes(),
            app(StoreGroundRadarRequest::class)->attributes(),
            app(StoreCableFailureRequest::class)->attributes(),
            app(StoreGPSMeasurementRequest::class)->attributes(),
            [
                'results_summary'   => 'Samenvatting resultaten',
                'advice'            => 'Advies / aanbevelingen',
                'follow_up'         => 'Vervolgacties',
                'problem_solved'    => 'Probleem opgelost',
                'question_answered' => 'Vraag opdrachtgever beantwoord',
            ]
        );
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
        // Normalize feature toggles so `required_if:* ,1` rules work reliably
        $radioEnabled = filter_var($this->input('radio_detection_enabled', false), FILTER_VALIDATE_BOOL) ? 1 : 0;
        $gyroEnabled  = filter_var($this->input('gyroscope_enabled', false), FILTER_VALIDATE_BOOL) ? 1 : 0;
        $ttEnabled    = filter_var($this->input('test_trench_enabled', false), FILTER_VALIDATE_BOOL) ? 1 : 0;
        $radarEnabled = filter_var($this->input('ground_radar_enabled', false), FILTER_VALIDATE_BOOL) ? 1 : 0;
        $cableFailureEnabled = filter_var($this->input('cable_failure_enabled', false), FILTER_VALIDATE_BOOL) ? 1 : 0;
        $gpsMeasurementEnabled = filter_var($this->input('gps_measurement_enabled', false), FILTER_VALIDATE_BOOL) ? 1 : 0;

        // Normalize local boolean checkboxes
        $problemSolved = filter_var($this->input('problem_solved', false), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $questionAnswered = filter_var($this->input('question_answered', false), FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        $this->merge([
            'cables' => $cables,
            'pipes' => $pipes,
            'radio_detection_enabled' => $radioEnabled,
            'gyroscope_enabled' => $gyroEnabled,
            'test_trench_enabled' => $ttEnabled,
            'ground_radar_enabled' => $radarEnabled,
            'cable_failure_enabled' => $cableFailureEnabled,
            'gps_measurement_enabled' => $gpsMeasurementEnabled,
            'problem_solved' => $problemSolved,
            'question_answered' => $questionAnswered,
        ]);
    }
}
