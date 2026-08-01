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
        $universitiesCount = University::count();
        $majorsCount = Major::count();
        $studentsCount = User::where('role', 'student')->count();
        
        // Ensure some nice baseline display if DB is empty for demo
        if ($universitiesCount == 0) $universitiesCount = 10;
        if ($majorsCount == 0) $majorsCount = 120;
        if ($studentsCount == 0) $studentsCount = '5K';

        return view('home', compact('universitiesCount', 'majorsCount', 'studentsCount'));
    }
}
