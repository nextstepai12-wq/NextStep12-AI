<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LookupController;
  use App\Http\Controllers\API\UniversityController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// مسارات المصادقة
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// routes/api.php
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-reset-code', [AuthController::class, 'verifyResetCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);




// مسارات البيانات المرجعية (Lookups)
Route::prefix('lookups')->group(function () {
    Route::get('/branches', [LookupController::class, 'branches']);
    Route::get('/universities/{id}/majors', [LookupController::class, 'universityMajors']);

});

Route::get('/universities', [UniversityController::class, 'index']);
Route::get('/universities/{id}', [UniversityController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()->load('profile')
        ]);
    });
});

// =====================================================================
// مسار اختباري لخدمة استخراج الخطة الدراسية عبر AI
// =====================================================================
Route::match(['get', 'post'], '/test-ai-extraction', function (\Illuminate\Http\Request $request, \App\Services\StudyPlanImportService $importService) {
    if ($request->isMethod('get')) {
        $majors = \App\Models\Major::select('id', 'title')->get();
        $optionsHtml = $majors->map(fn($m) => "<option value='{$m->id}'>ID {$m->id}: {$m->title}</option>")->implode('');
        if (empty($optionsHtml)) {
            $optionsHtml = "<option value='1'>ID 1 (محتمل)</option>";
        }

        return response("
        <!DOCTYPE html>
        <html lang='ar' dir='rtl'>
        <head>
            <meta charset='UTF-8'>
            <title>اختبار استخراج الخطة الدراسية AI</title>
            <style>
                body { font-family: system-ui, sans-serif; padding: 40px; background: #f4f6fa; }
                .card { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
                .form-group { margin-bottom: 20px; }
                label { display: block; font-weight: bold; margin-bottom: 8px; }
                input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
                button { background: #2f6bff; color: white; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; }
                button:hover { background: #1652e0; }
            </style>
        </head>
        <body>
            <div class='card'>
                <h2>اختبار استخراج الخطة الدراسية (AI)</h2>
                <form action='/api/test-ai-extraction' method='POST' enctype='multipart/form-data'>
                    <div class='form-group'>
                        <label>اختر التخصص (Major ID):</label>
                        <select name='major_id' required>{$optionsHtml}</select>
                    </div>
                    <div class='form-group'>
                        <label>السنة الدراسية:</label>
                        <input type='number' name='academic_year' value='2024' required>
                    </div>
                    <div class='form-group'>
                        <label>اختر ملف الخطة الدراسية (PDF):</label>
                        <input type='file' name='file' accept='.pdf' required>
                    </div>
                    <div class='form-group'>
                        <label><input type='checkbox' name='strict' value='1'> Strict Mode (تدقيق صارم)</label>
                    </div>
                    <button type='submit'>إرسال واستخراج الخطة 🚀</button>
                </form>
            </div>
        </body>
        </html>
        ");
    }

    $request->validate([
        'major_id' => 'required|integer',
        'academic_year' => 'required|integer',
        'file' => 'required|file|mimes:pdf',
    ]);

    $major = \App\Models\Major::find($request->major_id);
    if (!$major) {
        return response()->json([
            'status' => 'error',
            'message' => "التخصص رقم {$request->major_id} غير موجود في قاعدة البيانات. يرجى إضافة تخصص أولاً أو التأكد من الـ ID."
        ], 404);
    }
    
    // محاكاة مستخدم (جلب أول مستخدم أو إنشاؤه في قاعدة البيانات لتمرير قيد المفتاح الأجنبي)
    $user = \App\Models\User::first();
    if (!$user) {
        $user = \App\Models\User::create([
            'name' => 'مستخدم اختباري للجامعة',
            'email' => 'test_university@nextstep-ai.local',
            'password' => bcrypt('password123'),
            'role' => 'university',
            'university_id' => $major->faculty ? $major->faculty->university_id : ($major->deanship ? $major->deanship->university_id : 1),
        ]);
    }

    try {
        $studyPlan = $importService->uploadAndProcess(
            file: $request->file('file'),
            major: $major,
            uploadedBy: $user,
            academicYear: (int) $request->academic_year,
            strict: (bool) $request->boolean('strict')
        );
        
        return response()->json([
            'status' => 'success',
            'study_plan_id' => $studyPlan->id,
            'processing_status' => $studyPlan->status,
            'processing_error' => $studyPlan->processing_error,
            'extracted_data' => $studyPlan->raw_extracted_data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

