<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
}
