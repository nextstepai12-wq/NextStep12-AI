<?php

namespace App\Services;

use App\Exceptions\AIServiceException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * عميل التواصل مع AI Service (FastAPI - Ai_Services/api.py).
 * مسؤوليته الوحيدة: إرسال ملف PDF واستقبال ParserResponse كما هو،
 * بدون أي منطق أعمال (Business Logic) — هذا من مسؤولية StudyPlanImportService.
 */
class AIServiceClient
{
    private string $baseUrl;
    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.Ai_Service.base_url'), '/');
        $this->timeout = (int) config('services.Ai_Service.timeout', 120);
    }

    /**
     * يرسل ملف PDF مخزّن (على disk المحلي) إلى POST /api/parse
     * ويرجّع الـResponse الخام كـarray (نفس شكل ParserResponse من models.py).
     *
     * @param  string      $storedPath      المسار داخل storage/app (disk: local)
     * @param  string      $originalName    الاسم الأصلي للملف (يُرسل كاسم الملف بالـmultipart فقط، لا علاقة له بالتخزين)
     * @param  string|null $universityId    فرض جامعة معينة (اختياري - يطابق query param في api.py)
     * @param  bool        $strict          معاملة التحذيرات كأخطاء (يطابق query param في api.py)
     *
     * @throws AIServiceException
     */
    public function parseStudyPlan(
        string $storedPath,
        string $originalName,
        ?string $universityId = null,
        bool $strict = false
    ): array {
        if (!Storage::disk('local')->exists($storedPath)) {
            throw new AIServiceException('ملف الخطة الدراسية غير موجود على الخادم.');
        }

        $fileContents = Storage::disk('local')->get($storedPath);

        // api.py يقرأ university_id و strict كـ Query Params (FastAPI Query),
        // وليس كحقول داخل الـmultipart body — لذلك نبنيها ضمن الـURL صراحة.
        $queryParams = array_filter([
            'university_id' => $universityId,
            'strict'        => $strict ? 'true' : 'false',
        ], fn ($v) => $v !== null);

        $url = $this->baseUrl . '/api/parse' . (
            $queryParams ? ('?' . http_build_query($queryParams)) : ''
        );

        try {
            $response = Http::timeout($this->timeout)
                ->attach('file', $fileContents, $originalName)
                ->post($url);
        } catch (ConnectionException $e) {
            Log::error('AI Service: connection failed', ['message' => $e->getMessage()]);
            throw new AIServiceException('تعذر الاتصال بخدمة الذكاء الاصطناعي. تأكد أن الخدمة تعمل.', previous: $e);
        }

        if ($response->failed()) {
            Log::error('AI Service: non-2xx response', [
                'status' => $response->status(),
                'body'   => str($response->body())->limit(500)->toString(),
            ]);
            throw new AIServiceException("فشلت خدمة الذكاء الاصطناعي بمعالجة الملف (HTTP {$response->status()}).");
        }

        $data = $response->json();

        if (!is_array($data)) {
            Log::error('AI Service: invalid JSON response');
            throw new AIServiceException('استجابة غير صالحة من خدمة الذكاء الاصطناعي.');
        }

        return $data;
    }
}