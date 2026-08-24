<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\DeanshipFaculty;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeanshipFacultyController extends Controller
{
     public function DeanshipFaculty()
    {
        $universityId = Auth::user()->university_id;

        $DeanshipFaculty = DeanshipFaculty::where('university_id', $universityId)
            ->latest()
            ->get();

        return view('university.DeanshipFaculty', compact('DeanshipFaculty'));
    }

    public function create()
    {
        return view('university.DeanshipFaculty-create');
    }

    public function store(Request $request)
    {
        $university = Auth::user()->university;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:deanship,faculty'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'description' => ['nullable', 'string'],
            'dean_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $validated['university_id'] = $university->id;

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('deanships-faculties', 'public');
        }

        DeanshipFaculty::create($validated);

        return redirect()
            ->route('university.DeanshipFaculty')
            ->with('success', 'تمت إضافة العمادة / الكلية بنجاح.');
    }

    public function edit(DeanshipFaculty $deanshipFaculty)
    {
        $this->authorizeUniversity($deanshipFaculty);

        return view('university.DeanshipFaculty-edit', compact('deanshipFaculty'));
    }

    public function update(Request $request, DeanshipFaculty $deanshipFaculty)
    {
        $this->authorizeUniversity($deanshipFaculty);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:deanship,faculty'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'description' => ['nullable', 'string'],
            'dean_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        if ($request->hasFile('cover_image')) {

            if ($deanshipFaculty->cover_image) {
                Storage::disk('public')->delete($deanshipFaculty->cover_image);
            }

            $validated['cover_image'] = $request->file('cover_image')
                ->store('deanships-faculties', 'public');
        }

        $deanshipFaculty->update($validated);

        return redirect()
            ->route('university.DeanshipFaculty')
            ->with('success', 'تم تعديل البيانات بنجاح.');
    }

    public function destroy(DeanshipFaculty $deanshipFaculty)
    {
        $this->authorizeUniversity($deanshipFaculty);

        if ($deanshipFaculty->cover_image) {
            Storage::disk('public')->delete($deanshipFaculty->cover_image);
        }

        $deanshipFaculty->delete();

        return redirect()
            ->route('university.DeanshipFaculty')
            ->with('success', 'تم حذف العمادة / الكلية بنجاح.');
    }

    private function authorizeUniversity(DeanshipFaculty $deanshipFaculty)
    {
        $university = Auth::user()->university;

        abort_unless(
            $deanshipFaculty->university_id === $university->id,
            403
        );
    }
}
