<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\DeanshipFaculty;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ScholarshipController extends Controller
{
    public function Scholarships()
    {
        $universityId = Auth::user()->university_id;

        $scholarships = Scholarship::where('university_id', $universityId)
            ->with(['deanshipFaculty', 'major'])
            ->latest()
            ->get();

        return view('university.Scholarships', compact('scholarships'));
    }

    public function create()
    {
        $universityId = Auth::user()->university_id;

        $deanshipFaculties = DeanshipFaculty::where('university_id', $universityId)
            ->orderBy('name')
            ->get();

        $majors = Major::whereHas('deanshipFaculty', function ($query) use ($universityId) {
            $query->where('university_id', $universityId);
        })
            ->with('deanshipFaculty')
            ->orderBy('title')
            ->get();

        return view('university.Scholarships-create', compact(
            'deanshipFaculties',
            'majors'
        ));
    }

    public function store(Request $request)
    {
        $universityId = Auth::user()->university_id;

        $validated = $request->validate([
            'deanship_faculty_id' => [
                'nullable',
                'integer',
                Rule::exists('deanships_faculties', 'id')
                    ->where('university_id', $universityId),
            ],

            'major_id' => [
                'nullable',
                'integer',
                Rule::exists('majors', 'id'),
            ],

            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'min_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'max_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'type' => ['required', 'string', 'max:100'],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (
            isset($validated['deanship_faculty_id']) &&
            isset($validated['major_id'])
        ) {
            $majorBelongsToFaculty = Major::where('id', $validated['major_id'])
                ->where('deanship_faculty_id', $validated['deanship_faculty_id'])
                ->exists();

            if (!$majorBelongsToFaculty) {
                return back()
                    ->withErrors([
                        'major_id' => 'التخصص المحدد لا يتبع الكلية أو العمادة المختارة.',
                    ])
                    ->withInput();
            }
        }

        $validated['university_id'] = $universityId;
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('scholarships', 'public');
        }

        Scholarship::create($validated);

        return redirect()
            ->route('university.Scholarships')
            ->with('success', 'تمت إضافة المنحة بنجاح.');
    }

    public function edit(Scholarship $scholarship)
    {
        $this->authorizeUniversity($scholarship);

        $universityId = Auth::user()->university_id;

        $deanshipFaculties = DeanshipFaculty::where('university_id', $universityId)
            ->orderBy('name')
            ->get();

        $majors = Major::whereHas('deanshipFaculty', function ($query) use ($universityId) {
            $query->where('university_id', $universityId);
        })
            ->with('deanshipFaculty')
            ->orderBy('title')
            ->get();

        return view('university.Scholarships-edit', compact(
            'scholarship',
            'deanshipFaculties',
            'majors'
        ));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        $this->authorizeUniversity($scholarship);

        $universityId = Auth::user()->university_id;

        $validated = $request->validate([
            'deanship_faculty_id' => [
                'nullable',
                'integer',
                Rule::exists('deanships_faculties', 'id')
                    ->where('university_id', $universityId),
            ],

            'major_id' => [
                'nullable',
                'integer',
                Rule::exists('majors', 'id'),
            ],

            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'min_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'max_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'discount_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'type' => ['required', 'string', 'max:100'],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (
            isset($validated['deanship_faculty_id']) &&
            isset($validated['major_id'])
        ) {
            $majorBelongsToFaculty = Major::where('id', $validated['major_id'])
                ->where('deanship_faculty_id', $validated['deanship_faculty_id'])
                ->exists();

            if (!$majorBelongsToFaculty) {
                return back()
                    ->withErrors([
                        'major_id' => 'التخصص المحدد لا يتبع الكلية أو العمادة المختارة.',
                    ])
                    ->withInput();
            }
        }

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('cover_image')) {
            if ($scholarship->cover_image) {
                Storage::disk('public')->delete($scholarship->cover_image);
            }

            $validated['cover_image'] = $request->file('cover_image')
                ->store('scholarships', 'public');
        }

        $scholarship->update($validated);

        return redirect()
            ->route('university.Scholarships')
            ->with('success', 'تم تعديل المنحة بنجاح.');
    }

    public function destroy(Scholarship $scholarship)
    {
        $this->authorizeUniversity($scholarship);

        if ($scholarship->cover_image) {
            Storage::disk('public')->delete($scholarship->cover_image);
        }

        $scholarship->delete();

        return redirect()
            ->route('university.Scholarships')
            ->with('success', 'تم حذف المنحة بنجاح.');
    }

    private function authorizeUniversity(Scholarship $scholarship)
    {
        abort_unless(
            $scholarship->university_id === Auth::user()->university_id,
            403
        );
    }
}