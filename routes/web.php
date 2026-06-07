<?php

use App\Livewire\Admin\ListAdmins;
use App\Livewire\Payment\ListPayments;
use App\Livewire\Salary\ListSalaries;
use App\Livewire\Sinf\CreateSinf;
use App\Livewire\Sinf\EditSinf;
use App\Livewire\Sinf\ListSinfs;
use App\Livewire\Student\CreateStudent;
use App\Livewire\Student\ListStudents;
use App\Livewire\Teacher\CreateTeacher;
use App\Livewire\Teacher\ListTeachers;
use App\Livewire\Users\ListUsers;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});
Route::middleware(['auth'])->group(function (){
    Route::get('/manage-users',ListUsers::class)->name('users.index');
    Route::get('/manage-teachers',ListTeachers::class)->name('teachers.index');
    Route::get('/teacher-create',CreateTeacher::class)->name('teachers.create');
    Route::get('/manage-students',ListStudents::class)->name('students.index');
    Route::get('/student-create',CreateStudent::class)->name('students.create');
    Route::get('/admin',ListAdmins::class)->name('admin.index');
    Route::get('/manage-classes',ListSinfs::class)->name('classes.index');
    Route::get('/sinf/create',CreateSinf::class)->name('sinfs.create');
    Route::get('/sinf/update/{record}',EditSinf::class)->name('sinf.edit');
    // Route::get('/finance-payment',ListPayments::class)->name('payment.index');
});
// Route::middleware(['auth'])->group(function (){
// });

require __DIR__.'/auth.php';
