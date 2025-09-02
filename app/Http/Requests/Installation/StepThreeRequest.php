<?php

namespace App\Http\Requests\Installation;

use Illuminate\Foundation\Http\FormRequest;

class StepThreeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'adminName' => 'required|string|max:255',
            'adminEmail' => 'required|email|max:255|unique:users,email',
            'adminPassword' => 'required|string|min:8|confirmed',
            'adminPasswordConfirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'adminName.required' => 'Administrator name is required.',
            'adminName.max' => 'Administrator name cannot exceed 255 characters.',
            'adminEmail.required' => 'Administrator email is required.',
            'adminEmail.email' => 'Please enter a valid email address.',
            'adminEmail.unique' => 'This email address is already registered.',
            'adminEmail.max' => 'Email address cannot exceed 255 characters.',
            'adminPassword.required' => 'Password is required.',
            'adminPassword.min' => 'Password must be at least 8 characters long.',
            'adminPassword.confirmed' => 'Password confirmation does not match.',
            'adminPasswordConfirmation.required' => 'Password confirmation is required.',
        ];
    }
}