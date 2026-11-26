<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Models\Course;
use App\Models\Staff;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('pages.home', [
        'courseCount' => Course::count(),
        'staffCount' => Staff::count(),
    ]);
})->name('home');

Route::get('/courses', function () {
    return view('pages.courses', [
        'courses' => Course::orderBy('code')->get(),
    ]);
})->name('courses.index');

Route::get('/courses/{course:code}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/staff', function () {
    return view('pages.staff', [
        'staffMembers' => Staff::orderBy('id')->get(),
    ]);
})->name('staff.index');

Route::view('/admissions', 'pages.admissions')->name('admissions');

Route::view('/social', 'pages.social')->name('social');

Route::get('/contact', function () {
    return view('pages.contact', [
        'hod' => Staff::where('email', config('portal.hod_email'))->first(),
    ]);
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::resource('courses', AdminCourseController::class)->except(['show']);
        Route::resource('staff', AdminStaffController::class)->only(['index', 'store', 'destroy']);
        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    });

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
