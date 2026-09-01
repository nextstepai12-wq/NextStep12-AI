<?php

namespace App\Services;

use App\Models\Major;
use App\Models\University;

/**
 * ==============================================================================
 * خدمة التحقق من صحة الخطة الدراسية المستخرجة (StudyPlanValidationService)
 * ==============================================================================
 * تعمل بين status=extracted و confirm(): تفحص raw_extracted_data (أو نسخة معدّلة
 * من شاشة المراجعة) وترجع Errors/Warnings منظمة، بدون رمي Exception عام.
 *
 * ملاحظة مهمة: AI Service (src/validator.py) يسوي فحص مشابه على مستوى الاستخراج،
 * لكن بيانات هذا الجدول قد تُعدَّل يدويًا بشاشة المراجعة بعدها — لذلك لازم
 * إعادة التحقق هنا مرة ثانية قبل الحفظ النهائي في confirm()، لا نعتمد فقط على
 * فحص AI Service الأصلي.
 */
class StudyPlanValidationService
{
    // يطابق COURSE_TYPE_MAP بـStudyPlanImportService — نقبل العربي والإنجليزي معًا
    private const VALID_COURSE_TYPES = [
        'تخصص', 'كلية', 'جامعة',
        'specialization', 'college', 'university',
    ];

    /**
     * @return array{ok: bool, errors: string[], warnings: string[]}
     */
    public function validate(array $extractedResult, Major $major): array
    {
        $errors = [];
        $warnings = [];

        $data = $extractedResult['data'] ?? null;

        if (!is_array($data)) {
            $errors[] = 'لا توجد بيانات مستخرجة صالحة للتحقق منها.';
            return $this->result($errors, $warnings);
        }

        $years = $data['years'] ?? [];
        if (empty($years)) {
            $errors[] = 'لا توجد سنوات دراسية ضمن البيانات المستخرجة.';
            return $this->result($errors, $warnings);
        }

        [$allCourses, $courseErrors, $courseWarnings] = $this->validateYears($years);
        $errors = array_merge($errors, $courseErrors);
        $warnings = array_merge($warnings, $courseWarnings);

        $warnings = array_merge($warnings, $this->validatePrerequisites($allCourses));

        // مقارنة الجامعة المكتشفة من AI مع جامعة التخصص الفعلية (best-effort، تحذير فقط)
        $uniWarning = $this->checkUniversityMatch($data, $major);
        if ($uniWarning) {
            $warnings[] = $uniWarning;
        }

        return $this->result($errors, $warnings);
    }

    /**
     * @return array{0: array<int, array{code: string, year: int, semester: int, prerequisites: array}>, 1: string[], 2: string[]}
     */
    private function validateYears(array $years): array
    {
        $errors = [];
        $warnings = [];
        $allCourses = [];
        $seenCodes = []; // code => ['year' => .., 'semester' => ..]

        foreach ($years as $year) {
            $yearNumber = isset($year['year_number']) ? (int) $year['year_number'] : null;

            if ($yearNumber === null || $yearNumber < 1 || $yearNumber > 10) {
                $errors[] = "رقم سنة دراسية غير صالح: " . json_encode($year['year_number'] ?? null, JSON_UNESCAPED_UNICODE);
                continue;
            }

            $semesters = $year['semesters'] ?? [];
            if (count($semesters) > 6) {
                $errors[] = "السنة {$yearNumber}: عدد فصول أكثر من 6 ({$this->count($semesters)}).";
            }

            foreach ($semesters as $semester) {
                $semNumber = isset($semester['semester_number']) ? (int) $semester['semester_number'] : null;

                if ($semNumber === null || $semNumber < 1 || $semNumber > 6) {
                    $errors[] = "السنة {$yearNumber}: رقم فصل دراسي غير صالح (" . json_encode($semester['semester_number'] ?? null, JSON_UNESCAPED_UNICODE) . ").";
                    continue;
                }

                $courses = $semester['courses'] ?? [];
                if (empty($courses)) {
                    $warnings[] = "السنة {$yearNumber} - الفصل {$semNumber}: لا يوجد مقررات.";
                    continue;
                }

                foreach ($courses as $courseData) {
                    $this->validateSingleCourse(
                        $courseData, $yearNumber, $semNumber,
                        $seenCodes, $allCourses, $errors, $warnings
                    );
                }
            }
        }

        return [$allCourses, $errors, $warnings];
    }

    private function validateSingleCourse(
        array $courseData,
        int $yearNumber,
        int $semNumber,
        array &$seenCodes,
        array &$allCourses,
        array &$errors,
        array &$warnings
    ): void {
        $rawCode = $courseData['course_code'] ?? '';
        $code = strtoupper(str_replace(' ', '', trim((string)$rawCode)));
        $name = trim((string)($courseData['course_name_ar'] ?? ''));
        $location = "السنة {$yearNumber} - الفصل {$semNumber}";

        if ($code === '') {
            $errors[] = "{$location}: مقرر بدون رمز (course_code فارغ).";
            return; // بدون رمز ما نقدر نكمل باقي الفحوصات لهذا المقرر
        }

        if ($name === '' || mb_strlen($name) < 2) {
            $errors[] = "{$code}: اسم المقرر (course_name_ar) مفقود أو قصير جدًا.";
        }

        if (isset($seenCodes[$code])) {
            $prev = $seenCodes[$code];
            $errors[] = "تكرار رمز المقرر {$code}: ظهر أيضًا بالسنة {$prev['year']} - الفصل {$prev['semester']}.";
        } else {
            $seenCodes[$code] = ['year' => $yearNumber, 'semester' => $semNumber];
        }

        $hours = $courseData['credit_hours'] ?? 0;
        if (is_numeric($hours)) {
            $total = (int) $hours;
        } else {
            $total = (int) ($hours['total'] ?? 0);
        }

        if ($total < 0) {
            $errors[] = "{$code}: ساعات معتمدة سالبة غير مسموحة.";
        }

        if ($total === 0) {
            $warnings[] = "{$code}: الساعات المعتمدة صفر — يُنصح بمراجعتها يدويًا قبل التأكيد.";
        }

        $type = $courseData['course_type'] ?? 'specialization';
        if (!in_array($type, self::VALID_COURSE_TYPES, true)) {
            $errors[] = "{$code}: نوع مقرر غير معروف (" . json_encode($type, JSON_UNESCAPED_UNICODE) . ") — يجب أن يكون أحد: " . implode('، ', array_slice(self::VALID_COURSE_TYPES, 0, 3)) . ".";
        }

        $prereqs = $courseData['prerequisites'] ?? [];
        if (is_string($prereqs)) {
            $prereqs = array_filter(array_map('trim', explode(',', $prereqs)));
        }

        $allCourses[] = [
            'code' => $code,
            'year' => $yearNumber,
            'semester' => $semNumber,
            'prerequisites' => $prereqs,
        ];
    }

    /**
     * @param array<int, array{code: string, prerequisites: array}> $allCourses
     * @return string[] warnings فقط (نفس منطق AI Service validator.py: "prereq not seen yet" تحذير مو خطأ)
     */
    private function validatePrerequisites(array $allCourses): array
    {
        $warnings = [];
        $allCodes = array_column($allCourses, 'code');

        foreach ($allCourses as $course) {
            foreach ($course['prerequisites'] as $rawPrereq) {
                $prereq = strtoupper(str_replace(' ', '', trim((string) $rawPrereq)));

                if ($prereq === '') {
                    continue;
                }

                if ($prereq === $course['code']) {
                    $warnings[] = "{$course['code']}: المقرر مُعرَّف كمتطلب سابق لنفسه — تجاهُله موصى به.";
                    continue;
                }

                if (!in_array($prereq, $allCodes, true)) {
                    $warnings[] = "{$course['code']}: المتطلب السابق {$prereq} غير موجود ضمن مقررات هذه الخطة (سيُحفظ كنص فقط بدون ربط فعلي).";
                }
            }
        }

        return $warnings;
    }

    /**
     * فحص best-effort (تحذير فقط) بمقارنة نصية بسيطة — لا يوجد حاليًا جدول ربط
     * رسمي بين معرّفات AI Service الداخلية (مثل "najah", "birzeit" من palestinian.py)
     * وجدول universities.id الرقمي عندنا. لذلك لا نستطيع مطابقة دقيقة 100%،
     * فقط مقارنة نصية لاسم الجامعة كتحذير استرشادي.
     */
    private function checkUniversityMatch(array $data, Major $major): ?string
    {
        $detectedNameAr = trim($data['university']['name_ar'] ?? '');
        if ($detectedNameAr === '') {
            return null; // AI ما قدر يحدد جامعة، تجاهل الفحص
        }

        $actualUniversity = $major->faculty_id
            ? $major->faculty?->university
            : ($major->deanship_id ? $major->deanship?->university : null);

        if (!$actualUniversity instanceof University) {
            return null;
        }

        $actualName = trim($actualUniversity->name);

        // مقارنة نصية متساهلة (احتواء بالاتجاهين) لتفادي false positive بسبب اختلافات صياغة بسيطة
        if (
            $actualName !== '' &&
            !str_contains($actualName, $detectedNameAr) &&
            !str_contains($detectedNameAr, $actualName)
        ) {
            return "تنبيه: الجامعة المكتشفة من ملف PDF (\"{$detectedNameAr}\") لا تتطابق نصيًا مع جامعة التخصص المُسجَّلة (\"{$actualName}\"). يُنصح بمراجعة الملف قبل التأكيد.";
        }

        return null;
    }

    private function count(array $items): int
    {
        return count($items);
    }

    /**
     * @return array{ok: bool, errors: string[], warnings: string[]}
     */
    private function result(array $errors, array $warnings): array
    {
        return [
            'ok' => empty($errors),
            'errors' => array_values($errors),
            'warnings' => array_values($warnings),
        ];
    }
}