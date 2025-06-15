<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'courses' => 'required|array|min:1',
            'courses.*.courses_title' => 'required|string|max:255',
            'courses.*.modules' => 'required|array|min:1',
            'courses.*.modules.*.title' => 'required|string|max:255',
            'courses.*.modules.*.body' => 'required|string',
        ];
    }
}
