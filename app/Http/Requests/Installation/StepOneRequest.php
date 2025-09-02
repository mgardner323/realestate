<?php

namespace App\Http\Requests\Installation;

use Illuminate\Foundation\Http\FormRequest;

class StepOneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'agencyName' => 'required|string|max:255',
            'agencyEmail' => 'required|email|max:255',
            'agencyPhone' => 'nullable|string|max:50',
            'agencyAddress' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'agencyName.required' => 'Agency name is required.',
            'agencyName.max' => 'Agency name cannot exceed 255 characters.',
            'agencyEmail.required' => 'Agency email is required.',
            'agencyEmail.email' => 'Please enter a valid email address.',
            'agencyEmail.max' => 'Email address cannot exceed 255 characters.',
            'agencyPhone.max' => 'Phone number cannot exceed 50 characters.',
            'agencyAddress.max' => 'Address cannot exceed 500 characters.',
        ];
    }
}