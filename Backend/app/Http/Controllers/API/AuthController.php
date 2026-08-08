<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\VerifyResetCodeRequest;
use App\Mail\ResetPasswordCodeMail;
use App\Models\PasswordResetCode;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * إنشاء حساب جديد للطالب
     */
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
            ]);

            $profileData = [
                'user_id' => $user->id,
                'student_type' => $request->student_type,
                'phone' => $request->phone,
                'city' => $request->city,
            ];

            if ($request->student_type === 'new_student') {
                $profileData['high_school_branch_id'] = $request->high_school_branch_id;
                $profileData['high_school_score'] = $request->high_school_score;
            } else if ($request->student_type === 'university_student') {
                $profileData['current_university_id'] = $request->university_id;
                $profileData['current_major_id'] = $request->major_id;
                $profileData['academic_level'] = $request->academic_level;
                $profileData['gpa'] = $request->gpa;
            }

            $profile = StudentProfile::create($profileData);

            DB::commit();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'تم إنشاء الحساب بنجاح',
                'data' => [
                    'user' => $user->load('profile'),
                    'token' => $token
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء إنشاء الحساب',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * تسجيل الدخول
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات الدخول غير صحيحة'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        $redirectUrl = '/';
        if ($user->role === 'admin') {
            $redirectUrl = '/admin/dashboard';
        } else if ($user->role === 'student') {
            $redirectUrl = '/student/questionnaire';
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الدخول بنجاح',
            'data' => [
                'user' => $user->load('profile'),
                'token' => $token,
                'redirect_url' => $redirectUrl
            ]
        ]);
    }


public function forgotPassword(ForgotPasswordRequest $request)
{
    try {
        $email = $request->email;
        $code = (string) random_int(100000, 999999);

        PasswordResetCode::where('email', $email)->delete();

        PasswordResetCode::create([
            'email'           => $email,
            'code'            => Hash::make($code),
            'code_expires_at' => now()->addMinutes(2),
        ]);

        Mail::to($email)->send(new ResetPasswordCodeMail($code));

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إرسال الكود إلى بريدك الإلكتروني',
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'تعذر إرسال الكود',
            'error'   => $e->getMessage(),   // مؤقتاً للتشخيص، احذفيه لما تخلصي
        ], 500);
    }
}
/**
 * التحقق من كود إعادة التعيين
 */
public function verifyResetCode(VerifyResetCodeRequest $request)
{
    try {
        $record = PasswordResetCode::where('email', $request->email)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$record) {
            return response()->json([
                'status'  => 'error',
                'message' => 'لا يوجد كود صالح لهذا البريد الإلكتروني، اطلب كود جديد',
            ], 404);
        }

        if (now()->greaterThan($record->code_expires_at)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'انتهت صلاحية الكود، اطلب كود جديد',
            ], 410);
        }

        if (!Hash::check($request->code, $record->code)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'الكود غير صحيح',
            ], 422);
        }

        // الكود صحيح -> نولد token مؤقت يستخدم بخطوة تغيير كلمة المرور
        $token = Str::random(60);

        $record->update([
            'token'            => $token,
            'token_expires_at' => now()->addMinutes(10),
            'verified_at'      => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم التحقق من الكود بنجاح',
            'data'    => [
                'token' => $token,
            ],
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status'  => 'error',
            'message' => 'حدث خطأ أثناء التحقق من الكود',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

/**
 * تغيير كلمة المرور باستخدام الـ token المؤقت
 */
public function resetPassword(ResetPasswordRequest $request)
{
    try {
        $record = PasswordResetCode::where('email', $request->email)
            ->where('token', $request->token)
            ->whereNotNull('verified_at')
            ->first();

        if (!$record) {
            return response()->json([
                'status'  => 'error',
                'message' => 'رابط إعادة التعيين غير صالح',
            ], 404);
        }

        if (now()->greaterThan($record->token_expires_at)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'انتهت صلاحية الرابط، أعد العملية من البداية',
            ], 410);
        }

        DB::beginTransaction();

        $user = User::where('email', $request->email)->firstOrFail();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $record->delete();

        DB::commit();

        return response()->json([
            'status'  => 'success',
            'message' => 'تم تغيير كلمة المرور بنجاح',
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status'  => 'error',
            'message' => 'حدث خطأ أثناء تغيير كلمة المرور',
            'error'   => $e->getMessage(),
        ], 500);
    }
}
}

