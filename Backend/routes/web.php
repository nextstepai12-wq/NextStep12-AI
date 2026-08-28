<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LookupController;
use App\Http\Controllers\API\UniversityController;
use App\Http\Controllers\University\UniversitydashboardController;
use App\Http\Controllers\University\DeanshipFacultyController;
use App\Http\Controllers\University\MajorController;
use App\Http\Controllers\University\ScholarshipController;
use App\Http\Controllers\University\BrowseDeanshipsController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::get('/signup', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register']);
Route::post('/logout', function () { Auth::logout(); return redirect('/'); })->name('logout');

Route::get('/quiz', function () { return view('pages.quiz'); })->name('pages.quiz');
Route::get('/results', function () { return view('pages.results'); })->name('pages.results');
Route::get('/study-plan', function () { return view('pages.study-plan'); })->name('pages.study-plan');
Route::get('/universities', [HomeController::class, 'universities'])->name('universities.index');
Route::middleware('auth')->group(function () {
    Route::get('/student/questionnaire', function () { return view('pages.quiz'); });
    Route::get('/profile', function () { return view('pages.profile'); })->name('pages.profile');
    Route::get('/settings', function () { return view('pages.student-settings'); })->name('pages.settings');
    Route::get('/favorites', function () { return view('pages.favorites'); })->name('pages.favorites');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
});

Route::middleware(['auth', 'university'])->prefix('university')->group(function () {
    Route::get('/', [UniversitydashboardController::class, 'dashboard'])->name('university.dashboard');
    Route::get('/DeanshipFaculty', [DeanshipFacultyController::class, 'DeanshipFaculty'])->name('university.DeanshipFaculty');
    Route::get('/DeanshipFaculty/create', [DeanshipFacultyController::class, 'create'])->name('university.DeanshipFaculty.create');
    Route::post('/DeanshipFaculty', [DeanshipFacultyController::class, 'store'])->name('university.DeanshipFaculty.store');
    Route::get('/DeanshipFaculty/{deanshipFaculty}/edit', [DeanshipFacultyController::class, 'edit'])->name('university.DeanshipFaculty.edit');
    Route::put('/DeanshipFaculty/{deanshipFaculty}', [DeanshipFacultyController::class, 'update'])->name('university.DeanshipFaculty.update');
    Route::delete('/DeanshipFaculty/{deanshipFaculty}', [DeanshipFacultyController::class, 'destroy'])->name('university.DeanshipFaculty.destroy');    Route::get('/Majors', [MajorController::class, 'Majors'])->name('university.Majors');
    Route::post('/Majors', [MajorController::class, 'store'])->name('university.Majors.store');
    Route::put('/Majors/{major}', [MajorController::class, 'update'])->name('university.Majors.update');
    Route::delete('/Majors/{major}', [MajorController::class, 'destroy'])->name('university.Majors.destroy');
    Route::get('/Scholarships', [ScholarshipController::class, 'Scholarships'])->name('university.Scholarships');
    Route::get('/Scholarships/create', [ScholarshipController::class, 'create'])->name('university.Scholarships.create');
    Route::post('/Scholarships', [ScholarshipController::class, 'store'])->name('university.Scholarships.store');
    Route::get('/Scholarships/{scholarship}/edit', [ScholarshipController::class, 'edit'])->name('university.Scholarships.edit');
    Route::put('/Scholarships/{scholarship}', [ScholarshipController::class, 'update'])->name('university.Scholarships.update');
    Route::delete('/Scholarships/{scholarship}', [ScholarshipController::class, 'destroy'])->name('university.Scholarships.destroy');
    Route::get('/browse-deanships', [BrowseDeanshipsController::class, 'index'])
    ->name('university.browse-deanships');

Route::get('/browse-deanships/{deanshipFaculty}/majors', [BrowseDeanshipsController::class, 'majors'])
    ->name('university.browse.majors');


});

Route::middleware(['auth', 'student'])->prefix('student')->group(function () {
    Route::get('/dashboard', function () { return view('student.dashboard'); })->name('student.dashboard');
});
