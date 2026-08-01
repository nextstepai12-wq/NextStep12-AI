<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\HighSchoolBranch;
use App\Models\University;
use App\Models\Major;

class LookupController extends Controller
{
    /**
     * جلب جميع فروع الثانوية العامة الفعالة
     */
    public function branches()
    {
        $branches = HighSchoolBranch::select('id', 'name')
            ->where('is_active', true)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $branches
        ]);
    }

    /**
     * جلب قائمة الجامعات المتاحة
     */
    public function universities()
    {
        $universities = University::select('id', 'name')->get();

        return response()->json([
            'status' => 'success',
            'data' => $universities
        ]);
    }

    /**
     * جلب التخصصات المتاحة لجامعة محددة
     */
    public function universityMajors($id)
    {
        $university = University::find($id);
        
        if (!$university) {
            return response()->json([
                'status' => 'error',
                'message' => 'University not found'
            ], 404);
        }

        $majors = Major::select('majors.id', 'majors.title')
            ->whereHas('deanshipFaculty', function ($query) use ($id) {
                $query->where('university_id', $id);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $majors
        ]);
    }
}
