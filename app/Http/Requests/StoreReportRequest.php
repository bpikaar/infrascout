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

            // New cables array
            'cables'        => ['nullable', 'array'],
            'cables.*.id' => ['nullable', 'integer', 'exists:cables,id'],
            // If id is NOT present, we require the fields for a new cable
            'cables.*.cable_type' => ['required_without:cables.*.id', 'string', 'max:255'],
            'cables.*.material' => ['required_without:cables.*.id', 'in:GPLK,XLPE,Kunststof'],
            'cables.*.diameter' => ['nullable', 'numeric'],
            'description'   => ['required', 'string'],
            'work_hours'    => ['required', 'string', 'max:255'],
            'travel_time'   => ['required', 'string', 'max:255'],
            'images'        => ['nullable', 'array'],
            'images.*'      => ['nullable', 'image', 'max:2048'],
        ];
    }
}
