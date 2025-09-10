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
        return [
            'project_id'    => ['required', 'exists:projects,id'],
            'date_of_work'  => ['required', 'date'],
            'field_worker'   => ['required', 'exists:users,id'],
            'cable_type'    => ['required', 'string', 'max:255'],
            'material'      => ['required', 'string', 'max:255'],
            'diameter'      => ['required', 'numeric'],
            'description'   => ['required', 'string'],
            'work_hours'    => ['required', 'string', 'max:255'],
            'travel_time'   => ['required', 'string', 'max:255'],
            'images'        => ['nullable', 'array'],
            'images.*'      => ['nullable', 'image', 'max:2048'],
        ];
    }
}
