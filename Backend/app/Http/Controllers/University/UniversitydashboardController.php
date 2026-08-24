<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\University;
use App\Models\Scholarship;
use App\Models\DeanshipFaculty;


class UniversitydashboardController extends Controller
{
    public function dashboard()
    {
        $Major = Major::class;
        $University = University::class;
        $Scholarship = Scholarship::class;
        $DeanshipFaculty = DeanshipFaculty::class;


        return view('university.dashboard' , compact('Major', 'University', 'Scholarship', 'DeanshipFaculty'));
    }

}
