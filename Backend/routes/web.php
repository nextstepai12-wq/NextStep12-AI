<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);

Route::get('/signup', [WebAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [WebAuthController::class, 'register']);

Route::post('/logout', function() {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
})->name('logout');

// Public Pages
Route::get('/quiz', function() { return view('pages.quiz'); })->name('pages.quiz');
Route::get('/results', function() { return view('pages.results'); })->name('pages.results');
Route::get('/study-plan', function() { return view('pages.study-plan'); })->name('pages.study-plan');

// Authenticated Pages
Route::middleware('auth')->group(function() {
    Route::get('/student/questionnaire', function () {
        return view('pages.quiz');
    });
    
    Route::get('/profile', function() { return view('pages.profile'); })->name('pages.profile');
    Route::get('/settings', function() { return view('pages.student-settings'); })->name('pages.settings');
    Route::get('/favorites', function() { return view('pages.favorites'); })->name('pages.favorites');
});

// Admin Placeholder
Route::get('/admin/dashboard', function () {
    return "Admin Dashboard (Under Construction)";
})->middleware('auth');
