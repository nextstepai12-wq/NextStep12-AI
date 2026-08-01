<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\HighSchoolBranch;
use App\Models\University;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WebAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        $branches = HighSchoolBranch::where('is_active', true)->get();
        $universities = University::all();
        return view('auth.register', compact('branches', 'universities'));
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/student/questionnaire');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

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

            StudentProfile::create($profileData);

            DB::commit();

            Auth::login($user);

            return redirect('/student/questionnaire');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء إنشاء الحساب: ' . $e->getMessage())->withInput();
        }
    }
}
