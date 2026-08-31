<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ==============================================================================
 * فاليديشن رفع ملف الخطة الدراسية (Study Plan Upload)
 * ==============================================================================
 * يفحص: وجود major_id فعليًا، صلاحية academic_year، وأن الملف PDF فعلي (مو
 * بس امتداد بالاسم — mimes يتحقق من محتوى الملف الفعلي).
 */
class StoreStudyPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        // الفحص الفعلي لملكية major_id (هل تابع لجامعة المستخدم) يتم عبر
        // StudyPlanPolicy داخل الـController نفسه بعد ما نتأكد الـmajor موجود،
        // لأن FormRequest ما عنده وصول مباشر لسهولة لموديل Major قبل الفاليديشن.
        return auth()->check() && auth()->user()->role === 'university';
    }

    public function rules(): array
    {
        return [
            'major_id'      => ['required', 'integer', 'exists:majors,id'],
            'academic_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'strict'        => ['sometimes', 'boolean'],
            'file'          => ['required', 'file', 'mimes:pdf', 'max:20480'], // 20MB
        ];
    }

    public function messages(): array
    {
        return [
            'major_id.required'      => 'يجب اختيار التخصص.',
            'major_id.exists'        => 'التخصص المحدد غير موجود.',
            'academic_year.required' => 'يجب تحديد السنة الدراسية.',
            'file.required'          => 'يجب إرفاق ملف الخطة الدراسية.',
            'file.mimes'             => 'يجب أن يكون الملف بصيغة PDF فقط.',
            'file.max'               => 'حجم الملف يجب ألا يتجاوز 20 ميجابايت.',
        ];
    }
}