<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Models\DeanshipFaculty;
use App\Models\Major;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrowseDeanshipsController extends Controller
{
    /**
     * عرض صفحة استعراض العمادات والتخصصات
     */
    public function index(Request $request)
    {
        $university = Auth::user()->university;

        // جلب كل العمادات التابعة للجامعة مع عدد التخصصات لكل واحدة
        $deanships = DeanshipFaculty::where('university_id', $university->id)
            ->withCount('majors')
            ->get();

        return view('university.browse-deanships', compact('deanships'));
    }

    /**
     * تحميل تخصصات عمادة معيّنة عبر AJAX
     */
    public function majors(DeanshipFaculty $deanshipFaculty): JsonResponse
    {
        // التأكد أن العمادة تابعة لجامعة المستخدم الحالي
        $university = Auth::user()->university;

        if ($deanshipFaculty->university_id !== $university->id) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        $majors = $deanshipFaculty->majors()->select([
            'id',
            'title',
            'cover_image',
            'study_plan_image',
            'study_plan_file_url',
            'total_credit_hours',
            'description',
        ])->get();

        return response()->json([
            'deanship' => [
                'id'   => $deanshipFaculty->id,
                'name' => $deanshipFaculty->name,
            ],
            'majors' => $majors,
        ]);
    }
}
