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
}