<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\University;
use App\Models\Major;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $universitiesCount = University::count() ?: 10;
        $majorsCount = Major::count() ?: 120;
        $studentsCount = User::where('role', 'student')->count() ?: '5K';

        return view('index', compact('universitiesCount', 'majorsCount', 'studentsCount'));
    }

    public function universities()
    {
        // جلب جميع الجامعات من قاعدة البيانات
        $universities = University::all(); 
        
        return view('universities', compact('universities'));
    }

    public function showUniversity(University $university)
    {
        // تحميل العمادات والكليات مع التخصصات التابعة لها — eager loading لتجنب N+1
        $university->load(['deanships.majors', 'faculties.majors', 'scholarships']);

        // دمج العمادات والكليات في collection واحدة كما يتوقع الـ view
        $university->deanshipsFaculties = $university->deanships->concat($university->faculties);

        // حساب الإحصائيات في Controller وليس في Blade
        $deanshipsCount = $university->deanshipsFaculties->count();
        $majorsCount = $university->deanshipsFaculties->sum(fn($d) => $d->majors->count());

        return view('university-details', compact('university', 'deanshipsCount', 'majorsCount'));
    }
}