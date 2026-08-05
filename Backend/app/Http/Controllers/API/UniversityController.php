<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\Major;
use Illuminate\Support\Facades\Schema;

class UniversityController extends Controller
{
    /**
     * دالة ثابتة (static) بتتحقق إذا الأعمدة الاختيارية موجودة فعلياً
     * بجدول universities، وبترجع بس اللي موجود منها.
     *
     */
    protected static function optionalUniversityColumns(): array
    {
        $optionalColumns = ['sector', 'students_count', 'ranking'];

        return array_values(array_filter($optionalColumns, function ($column) {
            return Schema::hasColumn('universities', $column);
        }));
    }

    public function index()
    {
        // الأعمدة الأساسية اللي موجودة أكيد 100%
        $baseColumns = ['id', 'name', 'cover_image', 'logo', 'location', 'description'];

        // ندمجهم مع أي أعمدة اختيارية موجودة فعلياً بالداتابيس
        $columns = array_merge($baseColumns, self::optionalUniversityColumns());

        $universities = University::select($columns)->get();

        $universities->each(function ($uni) {
            $uni->majors_count = Major::whereHas('deanshipFaculty', function ($q) use ($uni) {
                $q->where('university_id', $uni->id);
            })->count();

            // لو العمود مش موجود بالداتابيس، منرجعه null صراحةً
            // عشان الفرونت يستمر يشتغل بدون ما يعتمد على وجوده
            if (!isset($uni->sector)) $uni->sector = null;
            if (!isset($uni->students_count)) $uni->students_count = null;
            if (!isset($uni->ranking)) $uni->ranking = null;
        });

        return response()->json([
            'status' => 'success',
            'data' => $universities
        ]);
    }

    public function show($id)
    {
        $university = University::with('deanshipsFaculties')->find($id);

        if (!$university) {
            return response()->json([
                'status' => 'error',
                'message' => 'الجامعة غير موجودة'
            ], 404);
        }

        $university->majors_count = Major::whereHas('deanshipFaculty', function ($q) use ($id) {
            $q->where('university_id', $id);
        })->count();

        $university->deanships_count = $university->deanshipsFaculties->count();

        // نفس المنطق: لو الأعمدة مش موجودة، نرجعها null صراحةً
        if (!isset($university->sector)) $university->sector = null;
        if (!isset($university->students_count)) $university->students_count = null;
        if (!isset($university->ranking)) $university->ranking = null;

        return response()->json([
            'status' => 'success',
            'data' => $university
        ]);
    }
}
