<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'student_type' => ['required', 'in:new_student,university_student'],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:100'],
        ];

        if ($this->input('student_type') === 'new_student') {
            $rules['high_school_branch_id'] = ['required', 'exists:high_school_branches,id'];
            $rules['high_school_score'] = ['required', 'numeric', 'min:50', 'max:100'];
        } elseif ($this->input('student_type') === 'university_student') {
            $rules['university_id'] = ['required', 'exists:universities,id'];
            $rules['major_id'] = ['required', 'exists:majors,id'];
            $rules['academic_level'] = ['nullable', 'string', 'max:50'];
            $rules['gpa'] = ['nullable', 'numeric', 'min:0', 'max:4'];
        }

        return $rules;
    }
}
