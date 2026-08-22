<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\DeanshipFaculty;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function Majors()
    {
        $majors = Major::with('deanshipFaculty')->latest()->get();
        $deanshipFaculties = DeanshipFaculty::latest()->get();

        return view('university.Majors', compact('majors', 'deanshipFaculties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deanship_faculty_id' => ['required', 'exists:deanships_faculties,id'],
            'title' => ['required', 'string', 'max:255'],
            'min_high_school_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'credit_hour_fee' => ['nullable', 'numeric', 'min:0'],
            'total_credit_hours' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'career_opportunities' => ['nullable', 'string'],
        ], [
            'deanship_faculty_id.required' => 'يجب اختيار الكلية أو العمادة.',
            'deanship_faculty_id.exists' => 'الكلية أو العمادة المحددة غير موجودة.',
            'title.required' => 'اسم التخصص مطلوب.',
            'title.string' => 'اسم التخصص يجب أن يكون نصًا.',
            'title.max' => 'اسم التخصص يجب ألا يتجاوز 255 حرفًا.',
            'min_high_school_score.numeric' => 'معدل الثانوية يجب أن يكون رقمًا.',
            'min_high_school_score.min' => 'معدل الثانوية لا يمكن أن يكون أقل من 0.',
            'min_high_school_score.max' => 'معدل الثانوية لا يمكن أن يتجاوز 100.',
            'credit_hour_fee.numeric' => 'سعر الساعة يجب أن يكون رقمًا.',
            'credit_hour_fee.min' => 'سعر الساعة لا يمكن أن يكون سالبًا.',
            'total_credit_hours.integer' => 'عدد الساعات يجب أن يكون رقمًا صحيحًا.',
            'total_credit_hours.min' => 'عدد الساعات يجب أن تكون ساعة واحدة على الأقل.',
        ]);

        Major::create($validated);

        return redirect()
            ->route('university.Majors')
            ->with('success', 'تم إضافة التخصص بنجاح.');
    }

    public function update(Request $request, Major $major)
    {
        $validated = $request->validate([
            'deanship_faculty_id' => ['required', 'exists:deanships_faculties,id'],
            'title' => ['required', 'string', 'max:255'],
            'min_high_school_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'credit_hour_fee' => ['nullable', 'numeric', 'min:0'],
            'total_credit_hours' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'career_opportunities' => ['nullable', 'string'],
        ], [
            'deanship_faculty_id.required' => 'يجب اختيار الكلية أو العمادة.',
            'deanship_faculty_id.exists' => 'الكلية أو العمادة المحددة غير موجودة.',
            'title.required' => 'اسم التخصص مطلوب.',
            'title.string' => 'اسم التخصص يجب أن يكون نصًا.',
            'title.max' => 'اسم التخصص يجب ألا يتجاوز 255 حرفًا.',
            'min_high_school_score.numeric' => 'معدل الثانوية يجب أن يكون رقمًا.',
            'min_high_school_score.min' => 'معدل الثانوية لا يمكن أن يكون أقل من 0.',
            'min_high_school_score.max' => 'معدل الثانوية لا يمكن أن يتجاوز 100.',
            'credit_hour_fee.numeric' => 'سعر الساعة يجب أن يكون رقمًا.',
            'credit_hour_fee.min' => 'سعر الساعة لا يمكن أن يكون سالبًا.',
            'total_credit_hours.integer' => 'عدد الساعات يجب أن يكون رقمًا صحيحًا.',
            'total_credit_hours.min' => 'عدد الساعات يجب أن تكون ساعة واحدة على الأقل.',
        ]);

        $major->update($validated);

        return redirect()
            ->route('university.Majors')
            ->with('success', 'تم تعديل التخصص بنجاح.');
    }

    public function destroy(Major $major)
    {
        $major->delete();

        return redirect()
            ->route('university.Majors')
            ->with('success', 'تم حذف التخصص بنجاح.');
    }
}
