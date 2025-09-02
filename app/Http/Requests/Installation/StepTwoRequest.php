<?php

namespace App\Http\Requests\Installation;

use Illuminate\Foundation\Http\FormRequest;

class StepTwoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'brandPrimaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'brandSecondaryColor' => 'required|string|regex:/^#[A-Fa-f0-9]{6}$/',
            'seoTitle' => 'required|string|max:255',
            'seoDescription' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'brandPrimaryColor.required' => 'Primary brand color is required.',
            'brandPrimaryColor.regex' => 'Primary color must be a valid hex color (e.g., #3B82F6).',
            'brandSecondaryColor.required' => 'Secondary brand color is required.',
            'brandSecondaryColor.regex' => 'Secondary color must be a valid hex color (e.g., #1E40AF).',
            'seoTitle.required' => 'SEO title is required.',
            'seoTitle.max' => 'SEO title cannot exceed 255 characters.',
            'seoDescription.required' => 'SEO description is required.',
            'seoDescription.max' => 'SEO description cannot exceed 500 characters.',
        ];
    }
}