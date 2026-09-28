<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// الصفحة الرئيسية: متاحة للجميع (زوار ومسجلين)
Route::get('/', [HomeController::class, 'index'])->name('home');

// صفحات الدخول والتسجيل: لغير المسجلين بس
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // الأطباء: أي حد مسجل دخول يقدر يشوفهم (محتاجين وقت الحجز)
    Route::resource('doctor', DoctorController::class)->only(['index', 'show']);

    // الخدمات: أي حد مسجل دخول يشوف، والتعديل عليها بيتحكم فيه جوا الـController (admin/doctor)
    Route::resource('service', ServiceController::class);

    // الأقسام: العرض لأي مسجل، والتعديل Admin بس (متحكم فيه جوا الـController)
    Route::resource('department', DepartmentController::class);

    // المواعيد: الحجز بيتحكم فيه جوا الـController (patient)، والتعديل/الحذف (admin/doctor)
    Route::resource('appointment', AppointmentController::class);

    // إدارة كاملة: Admin بس
    Route::middleware('role:admin')->group(function () {
        Route::resource('doctor', DoctorController::class)->except(['index', 'show']);
        Route::resource('patient', PatientController::class);
        Route::resource('user', UserController::class);
    });

    // الزيارات والروشتات: Doctor و Admin
    Route::middleware('role:doctor,admin')->group(function () {
        Route::resource('visit', VisitController::class);
        Route::resource('prescription', PrescriptionController::class);
    });
});
