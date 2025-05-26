<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/schedules/report', [ScheduleController::class, 'generateReport'])->name('schedules.report');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// routes/web.php
Route::delete('/activity-logs', [DashboardController::class, 'deleteLogs'])->name('activity-logs.delete');


// Resource routes for CRUD
Route::resource('students', StudentController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('rooms', RoomController::class);
Route::resource('subjects', SubjectController::class);
Route::resource('users', UserController::class);

// route input put it above the schedule resource because already using get method of schedule
Route::get('/schedules/input', [ScheduleController::class, 'input'])->name('schedules.input');
Route::resource('schedules', ScheduleController::class);

// Route::get('/schedules/{id}', [ScheduleController::class, 'show'])->name('schedules.show');
Route::put('schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
// Route::delete('schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');




Route::get('/teachers/{teacherId}/students/{scheduleDate}', [ScheduleController::class, 'showTeacherStudents'])
    ->name('teachers.students');


Route::delete('/schedules/delete-room-date/{room}/{date}', [ScheduleController::class, 'destroyByRoomAndDate'])
    ->name('schedules.deleteByRoomAndDate');



Route::patch('/schedules/{id}/status', [ScheduleController::class, 'updateStatus'])->name('schedules.updateStatus');
Route::get('/teachers/{teacher}/students/{scheduleDate}', [TeacherController::class, 'getStudents'])->name('teachers.students');
Route::post('/schedules/add', [ScheduleController::class, 'addStudentToSchedule'])->name('schedules.add');


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// route for schedule avail button put it below the schedule resource 
Route::get('/schedules/available', [ScheduleController::class, 'available'])->name('schedules.available');






});

require __DIR__.'/auth.php';
