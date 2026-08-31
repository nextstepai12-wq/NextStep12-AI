<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudyPlanRequest;
use App\Models\Major;
use App\Models\StudyPlan;
use App\Services\StudyPlanImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * ==============================================================================
 * StudyPlanController — إدارة استيراد الخطط الدراسية (University Panel)
 * ==============================================================================
 * كل Method هون يمر أولًا عبر UniversityMiddleware (role=university + university_id
 * موجود) المطبّق بمجموعة الراوت الأب بـweb.php، ثم StudyPlanPolicy للتأكد من
 * ملكية المورد تحديدًا (هل هذا major/study_plan تابع فعلًا لجامعة المستخدم).
 */
class StudyPlanController extends Controller
{
    public function __construct(
        private readonly StudyPlanImportService $importService,
    ) {
    }

    /**
     * عرض كل الخطط الدراسية الخاصة بجامعة المستخدم الحالي فقط.
     */
    public function index()
    {
        $studyPlans = StudyPlan::where('university_id', auth()->user()->university_id)
            ->with(['major:id,title', 'uploadedBy:id,name'])
            ->latest()
            ->paginate(20);

        return view('university.study-plans.index', compact('studyPlans'));
    }

    /**
     * فورم رفع خطة دراسية جديدة.
     */
    public function create()
    {
        // فقط تخصصات تابعة لجامعة المستخدم الحالي (عبر faculty أو deanship)
        $majors = Major::whereHas('faculty', function ($q) {
                $q->where('university_id', auth()->user()->university_id);
            })
            ->orWhereHas('deanship', function ($q) {
                $q->where('university_id', auth()->user()->university_id);
            })
            ->get(['id', 'title']);

        return view('university.study-plans.create', compact('majors'));
    }

    /**
     * استقبال الملف، تخزينه، وإرساله فورًا لـAi_Services عبر StudyPlanImportService.
     */
    public function store(StoreStudyPlanRequest $request)
    {
        $major = Major::findOrFail($request->validated('major_id'));

        // فحص ملكية: هل هذا التخصص فعليًا تابع لجامعة المستخدم؟
        $this->authorize('view', $major);

        $studyPlan = $this->importService->uploadAndProcess(
            file: $request->file('file'),
            major: $major,
            uploadedBy: auth()->user(),
            academicYear: (int) $request->validated('academic_year'),
            strict: (bool) $request->boolean('strict'),
        );

        return redirect()
            ->route('university.study-plans.review', $studyPlan)
            ->with('status', $studyPlan->status === 'failed'
                ? 'فشلت معالجة الملف: ' . $studyPlan->processing_error
                : 'تم استخراج الخطة بنجاح، راجع البيانات قبل التأكيد.');
    }

    /**
     * شاشة مراجعة البيانات المستخرجة قبل التأكيد النهائي.
     */
    public function review(StudyPlan $studyPlan)
    {
        $this->authorize('view', $studyPlan);

        $validation = $this->importService->validate($studyPlan);

        return view('university.study-plans.review', compact('studyPlan', 'validation'));
    }

    /**
     * تشغيل فحص الفاليديشن فقط (AJAX) بدون حفظ — يُستخدم لو المستخدم عدّل
     * بيانات بشاشة المراجعة وبده يتأكد قبل ما يضغط تأكيد نهائي.
     */
    public function validateData(Request $request, StudyPlan $studyPlan): JsonResponse
    {
        $this->authorize('view', $studyPlan);

        $editedYears = $request->input('years'); // null لو ما عدّل المستخدم شي

        $validation = $this->importService->validate($studyPlan, $editedYears);

        return response()->json($validation);
    }

    /**
     * التأكيد النهائي وحفظ المقررات فعليًا بالجداول (courses/study_plan_courses/...).
     */
    public function confirm(Request $request, StudyPlan $studyPlan)
    {
        $this->authorize('confirm', $studyPlan);

        $editedYears = $request->input('years'); // null لو ما عدّل المستخدم شي

        $result = $this->importService->confirm($studyPlan, auth()->user(), $editedYears);

        if (!$result['validation']['ok']) {
            return back()
                ->withErrors(['validation' => $result['validation']['errors']])
                ->with('warnings', $result['validation']['warnings']);
        }

        return redirect()
            ->route('university.study-plans.index')
            ->with('status', 'تم تأكيد الخطة الدراسية وحفظ المقررات بنجاح.');
    }
}