<?php

namespace App\Http\Requests;

use App\VisibilityLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreVideoRequest extends FormRequest
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
            //
            'title' => 'required|bail|string|max:100',
            'file' => ['required', 'json'],
            'description' => 'nullable|string|max:255',
            'visibility' => ['required', Rule::in(VisibilityLevel::cases())],
            'grantAccessTo' => ['required_if:visibility,restricted', 'array'],
            'grantAccessTo.*' => ['exists:users,id']
        ];
    }
}
