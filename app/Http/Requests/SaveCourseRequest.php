<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $normalized = [];

        foreach (['code', 'name', 'credits', 'prerequisites', 'description'] as $field) {
            $value = $this->input($field);

            if (is_string($value)) {
                $normalized[$field] = trim($value);
            }
        }

        if (isset($normalized['code'])) {
            $normalized['code'] = strtoupper($normalized['code']);
        }

        if (($normalized['prerequisites'] ?? null) === '') {
            $normalized['prerequisites'] = null;
        }

        $this->merge($normalized);
    }

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        $course = $this->route('course');

        return [
            'code' => [
                'required',
                'string',
                'regex:/^[A-Z]{3}[0-9]{3}$/',
                'max:6',
                Rule::unique('courses', 'code')->ignore($course instanceof Course ? $course->id : null),
            ],
            'name' => ['required', 'string', 'max:150'],
            'credits' => ['required', 'integer', 'between:1,4'],
            'prerequisites' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'code.regex' => 'Course code must be three uppercase letters followed by three digits.',
            'code.unique' => 'That course code is already used.',
            'credits.between' => 'Credits must be a whole number from 1 to 4.',
        ];
    }
}
