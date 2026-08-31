<?php

namespace App\Services;

use App\Exceptions\AIServiceException;
use App\Models\Course;
use App\Models\Major;
use App\Models\StudyPlan;
use App\Models\StudyPlanCourse;
use App\Models\StudyPlanCoursePrerequisite;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * الخدمة المسؤولة عن دورة حياة استيراد الخطة الدراسية كاملة:
 * Upload -> Process (AI) -> Validate (Step 5) -> Review -> Confirm (Transaction) -> Save
 */
class StudyPlanImportService
{
    private const COURSE_TYPE_MAP = [
        'تخصص' => 'specialization',
        'كلية'  => 'college',
        'جامعة' => 'university',
        'specialization' => 'specialization',
        'college'         => 'college',
        'university'      => 'university',
    ];

    public function __construct(
        private readonly AIServiceClient $aiClient,
        private readonly StudyPlanValidationService $validator,
    ) {
    }

    public function uploadAndProcess(
        UploadedFile $file,
        Major $major,
        User $uploadedBy,
        int $academicYear,
        bool $strict = false
    ): StudyPlan {
        if (!$major->faculty_id && !$major->deanship_id) {
            throw new RuntimeException('التخصص غير مربوط بأي كلية أو عمادة، لا يمكن تحديد الجامعة.');
        }

        $universityId = $major->faculty_id
            ? $major->faculty->university_id
            : $major->deanship->university_id;

        $safeFilename = Str::uuid()->toString() . '.pdf';
        $storedPath = "study-plans/{$universityId}/{$major->id}/{$safeFilename}";

        Storage::disk('local')->put($storedPath, file_get_contents($file->getRealPath()));

        $studyPlan = StudyPlan::create([
            'major_id'                  => $major->id,
            'university_id'             => $universityId,
            'academic_year'             => $academicYear,
            'source_pdf_path'           => $storedPath,
            'source_pdf_original_name'  => $file->getClientOriginalName(),
            'status'                    => 'pending',
            'uploaded_by'               => $uploadedBy->id,
        ]);

        Log::info('StudyPlan: upload received', ['study_plan_id' => $studyPlan->id, 'major_id' => $major->id]);

        $this->process($studyPlan, $strict);

        return $studyPlan->fresh();
    }

    public function process(StudyPlan $studyPlan, bool $strict = false): StudyPlan
    {
        $studyPlan->update(['status' => 'processing', 'processing_error' => null]);
        Log::info('StudyPlan: processing started', ['study_plan_id' => $studyPlan->id]);

        try {
            $result = $this->aiClient->parseStudyPlan(
                storedPath: $studyPlan->source_pdf_path,
                originalName: $studyPlan->source_pdf_original_name,
                universityId: null,
                strict: $strict,
            );
        } catch (AIServiceException $e) {
            $studyPlan->update([
                'status'            => 'failed',
                'processing_error'  => $e->getMessage(),
            ]);
            Log::error('StudyPlan: processing failed', [
                'study_plan_id' => $studyPlan->id,
                'error'         => $e->getMessage(),
            ]);
            return $studyPlan->fresh();
        }

        $success = (bool) ($result['success'] ?? false);
        $data    = $result['data'] ?? null;
        $errors  = $result['errors'] ?? [];

        if (!$success || !$data) {
            $studyPlan->update([
                'status'            => 'failed',
                'processing_error'  => implode(' | ', $errors) ?: 'فشل الاستخراج دون سبب محدد.',
                'raw_extracted_data'=> $result,
            ]);
            Log::warning('StudyPlan: AI extraction unsuccessful', [
                'study_plan_id' => $studyPlan->id,
                'errors_count'  => count($errors),
            ]);
            return $studyPlan->fresh();
        }

        $studyPlan->update([
            'status'              => 'extracted',
            'raw_extracted_data'  => $result,
            'total_credit_hours'  => $data['program']['total_credit_hours'] ?? null,
            'version_label'       => $data['approval']['version'] ?? null,
            'ucas_code'           => $data['approval']['ucas_code'] ?? null,
            'title'               => $studyPlan->title ?? ('خطة ' . $studyPlan->academic_year),
        ]);

        Log::info('StudyPlan: extraction completed', [
            'study_plan_id' => $studyPlan->id,
            'courses_count' => $data['statistics']['total_courses'] ?? null,
            'warnings'      => count($result['warnings'] ?? []),
        ]);

        return $studyPlan->fresh();
    }

    /**
     * تشغيل فحص Step 5 بشكل مستقل — يُستخدم بشاشة المراجعة لعرض Errors/Warnings
     * للمستخدم قبل ما يضغط "تأكيد"، بدون أي تعديل على قاعدة البيانات.
     *
     * @param array|null $editedYears نسخة معدّلة من data.years (لو المستخدم عدّل بشاشة المراجعة)،
     *                                لو null نستخدم raw_extracted_data كما هي.
     * @return array{ok: bool, errors: string[], warnings: string[]}
     */
    public function validate(StudyPlan $studyPlan, ?array $editedYears = null): array
    {
        $raw = $studyPlan->raw_extracted_data ?? [];

        if ($editedYears !== null) {
            $raw['data']['years'] = $editedYears;
        }

        return $this->validator->validate($raw, $studyPlan->major);
    }

    /**
     * تأكيد الخطة نهائيًا. الآن يمر أولًا عبر StudyPlanValidationService (Step 5) —
     * لو فيه Errors (مو Warnings) نوقف العملية بالكامل قبل فتح أي Transaction،
     * ونرجع النتيجة بدل ما نرمي Exception عام غير واضح.
     *
     * @throws RuntimeException لو الخطة غير قابلة للتعديل (isEditable() = false) فقط.
     *                          أخطاء الفاليديشن نفسها لا تُرمى كـException، بل تُرجَع
     *                          ضمن مفتاح 'validation' بالنتيجة، لأنها متوقعة وتُعرض
     *                          بواجهة المراجعة، مو خطأ نظام.
     *
     * @return array{study_plan: StudyPlan, validation: array{ok: bool, errors: string[], warnings: string[]}}
     */
    public function confirm(StudyPlan $studyPlan, User $confirmedBy, ?array $editedYears = null): array
    {
        if (!$studyPlan->isEditable()) {
            throw new RuntimeException("لا يمكن تأكيد خطة بحالة \"{$studyPlan->status}\".");
        }

        $years = $editedYears ?? ($studyPlan->raw_extracted_data['data']['years'] ?? []);

        if (empty($years)) {
            throw new RuntimeException('لا توجد بيانات مقررات لحفظها.');
        }

        // ── Step 5: فحص قبل أي حفظ ──
        $validation = $this->validate($studyPlan, $editedYears);

        if (!$validation['ok']) {
            Log::warning('StudyPlan: confirm blocked by validation errors', [
                'study_plan_id' => $studyPlan->id,
                'errors_count'  => count($validation['errors']),
            ]);
            return [
                'study_plan' => $studyPlan,
                'validation' => $validation,
            ];
        }

        Log::info('StudyPlan: saving started', ['study_plan_id' => $studyPlan->id]);

        DB::transaction(function () use ($studyPlan, $confirmedBy, $years) {
            StudyPlan::where('major_id', $studyPlan->major_id)
                ->where('id', '!=', $studyPlan->id)
                ->update(['is_current' => false]);

            $studyPlan->studyPlanCourses()->delete();

            $prerequisitesQueue = [];

            foreach ($years as $year) {
                foreach ($year['semesters'] ?? [] as $semester) {
                    foreach ($semester['courses'] ?? [] as $index => $courseData) {
                        $spCourse = $this->saveCourseRow($studyPlan, $courseData, $index);
                        if (!empty($courseData['prerequisites'])) {
                            $prerequisitesQueue[] = [
                                'study_plan_course_id' => $spCourse->id,
                                'codes'                 => $courseData['prerequisites'],
                            ];
                        }
                    }
                }
            }

            $this->linkPrerequisites($studyPlan, $prerequisitesQueue);

            $studyPlan->update([
                'status'       => 'confirmed',
                'is_current'   => true,
                'confirmed_by' => $confirmedBy->id,
                'confirmed_at' => now(),
            ]);
        });

        Log::info('StudyPlan: saving completed', ['study_plan_id' => $studyPlan->id]);

        return [
            'study_plan' => $studyPlan->fresh(),
            'validation' => $validation,
        ];
    }

    private function saveCourseRow(StudyPlan $studyPlan, array $courseData, int $orderIndex): StudyPlanCourse
    {
        $code = strtoupper(str_replace(' ', '', trim($courseData['course_code'] ?? '')));

        if ($code === '' || empty($courseData['course_name_ar'])) {
            throw new RuntimeException("بيانات مقرر ناقصة (رمز أو اسم): " . json_encode($courseData, JSON_UNESCAPED_UNICODE));
        }

        $hours = $courseData['credit_hours'] ?? ['total' => 0, 'theory' => 0, 'practical' => 0];
        $type  = self::COURSE_TYPE_MAP[$courseData['course_type'] ?? ''] ?? 'specialization';

        $course = Course::firstOrCreate(
            ['university_id' => $studyPlan->university_id, 'code' => $code],
            [
                'name_ar'                  => $courseData['course_name_ar'],
                'default_total_hours'      => $hours['total'] ?? 0,
                'default_theory_hours'     => $hours['theory'] ?? 0,
                'default_practical_hours'  => $hours['practical'] ?? 0,
                'default_type'             => $type,
            ]
        );

        return StudyPlanCourse::create([
            'study_plan_id'   => $studyPlan->id,
            'course_id'       => $course->id,
            'year_number'     => $courseData['year_number'],
            'semester_number' => $courseData['semester_number'],
            'order_index'     => $orderIndex,
        ]);
    }

    private function linkPrerequisites(StudyPlan $studyPlan, array $queue): void
    {
        $codeMap = $studyPlan->studyPlanCourses()
            ->with('course:id,code')
            ->get()
            ->keyBy(fn ($spc) => $spc->course->code);

        foreach ($queue as $item) {
            foreach ($item['codes'] as $rawCode) {
                $prereqCode = strtoupper(str_replace(' ', '', trim($rawCode)));
                if ($prereqCode === '') {
                    continue;
                }

                StudyPlanCoursePrerequisite::create([
                    'study_plan_course_id'               => $item['study_plan_course_id'],
                    'prerequisite_code'                  => $prereqCode,
                    'prerequisite_study_plan_course_id'  => $codeMap->get($prereqCode)?->id,
                ]);
            }
        }
    }
}