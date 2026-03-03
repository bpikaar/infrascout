<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'contact_id' => 'nullable|exists:contacts,id',
            'contact' => 'required_without:contact_id|string|max:255',
            'phone' => 'nullable|string|max:50',
            'mail' => 'nullable|email|max:255',
            'street' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,gif,heic,webp|max:2048',
        ];
    }
}
