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
// المسارات التي تتطلب تسجيل دخول
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()->load('profile')
        ]);


    });
    // =====================================================================
// مسار اختباري لخدمة استخراج الخطة الدراسية عبر AI
// =====================================================================
Route::post('/test-ai-extraction', function (\Illuminate\Http\Request $request, \App\Services\StudyPlanImportService $importService) {
    $request->validate([
        'major_id' => 'required|integer|exists:majors,id',
        'academic_year' => 'required|integer',
        'file' => 'required|file|mimes:pdf',
    ]);

    $major = \App\Models\Major::findOrFail($request->major_id);
    
    // محاكاة مستخدم
    $user = \App\Models\User::first();
    if (!$user) {
        $user = clone new \App\Models\User();
        $user->id = 1;
        $user->role = 'university';
        $user->university_id = $major->faculty ? $major->faculty->university_id : ($major->deanship ? $major->deanship->university_id : 1);
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



});



// =====================================================================
// مسار اختباري لخدمة استخراج الخطة الدراسية عبر AI
// =====================================================================
Route::post('/test-ai-extraction', function (Request $request, \App\Services\StudyPlanImportService $importService) {
    $request->validate([
        'major_id' => 'required|integer|exists:majors,id',
        'academic_year' => 'required|integer',
        'file' => 'required|file|mimes:pdf',
    ]);

    // جلب التخصص
    $major = \App\Models\Major::findOrFail($request->major_id);
    
    // محاكاة مستخدم (إن لم يكن هناك مستخدم مسجل الدخول)
    // هذا مهم لأن الـ Service تتطلب User كـ uploader
    $user = \App\Models\User::first();
    if (!$user) {
        $user = clone new \App\Models\User();
        $user->id = 1;
        $user->role = 'university';
        $user->university_id = $major->faculty ? $major->faculty->university_id : ($major->deanship ? $major->deanship->university_id : 1);
    }

    try {
        // تمرير الملف للخدمة وإرجاع النتيجة
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
