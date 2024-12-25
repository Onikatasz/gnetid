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
        return \Illuminate\Support\Facades\Auth::check(); // Only authenticated users can create a new client
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
            'nik' => 'required|string|size:16|unique:clients,nik,' . $this->route('client')->id,
            'phone' => 'required|string|max:20|unique:clients,phone,' . $this->route('client')->id,
            'address' => 'required|string|max:500',
        ];
    }

}
