<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'name' => 'required|string|max:255', // Must be a string, max 255 characters
            'nik' => 'required|string|size:16|unique:clients,nik', // Exactly 16 characters and must be unique in 'clients' table
            'phone' => 'required|string|max:20|unique:clients,phone', // Unique phone number with max length 20
            'address' => 'required|string|max:500', // Address is required and cannot exceed 500 characters
            'latitude' => 'required|numeric', // Latitude must be a number
            'longitude' => 'required|numeric', // Longitude must be a number
        ];
    }

}
