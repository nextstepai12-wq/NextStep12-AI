<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LookupController;

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

// مسارات البيانات المرجعية (Lookups)
Route::prefix('lookups')->group(function () {
    Route::get('/branches', [LookupController::class, 'branches']);
    Route::get('/universities', [LookupController::class, 'universities']);
    Route::get('/universities/{id}/majors', [LookupController::class, 'universityMajors']);
});

// المسارات التي تتطلب تسجيل دخول
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()->load('profile')
        ]);
    });
});
