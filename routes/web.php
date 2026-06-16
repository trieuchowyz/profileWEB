<?php

use Illuminate\Support\Facades\Route;

// Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// System
use App\Http\Controllers\System\ProfileController;
use App\Http\Controllers\System\ResumeExportController;
use App\Http\Controllers\System\TemplateController as SystemTemplateController;

// CV
use App\Http\Controllers\CV\ResumeController;
use App\Http\Controllers\CV\ResumeEducationController;
use App\Http\Controllers\CV\ResumeExperienceController;
use App\Http\Controllers\CV\ResumeLanguageController;
use App\Http\Controllers\CV\ResumeProjectController;
use App\Http\Controllers\CV\ResumeSkillController;
use App\Http\Controllers\CV\ResumeSocialLinkController;

// Admin
use App\Http\Controllers\Admin\TemplateController as AdminTemplateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ResumeController as AdminResumeController;

// Tự động chuyển hướng từ trang gốc (/) sang Dashboard Admin
// Route::get('/', function () {
//     return redirect('/admin/dashboard');
// });

Route::get('/', function () {
    return view('client.home'); // Trỏ về file resources/views/home.blade.php của user
});

// -----------------------------------------------------------------------
// PUBLIC ROUTES (Không yêu cầu đăng nhập)
// -----------------------------------------------------------------------

Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/login',    [LoginController::class, 'login']);

Route::get('/cv/public/{slug}', [ResumeController::class, 'showPublic']);
Route::get('/system/public/{slug}/export/pdf', [ResumeExportController::class, 'downloadPublicPdf']);


// -----------------------------------------------------------------------
// PROTECTED USER ROUTES (Yêu cầu auth:sanctum)
// -----------------------------------------------------------------------

Route::middleware('auth:sanctum')->group(function () {
    // Auth & Profile
    Route::post('/auth/logout',     [LoginController::class, 'logout']);
    Route::get('/profile',          [ProfileController::class, 'show']);
    Route::patch('/profile/name',   [ProfileController::class, 'updateName']);
    Route::post('/profile/avatar',  [ProfileController::class, 'updateAvatar']);
    Route::delete('/profile/avatar',[ProfileController::class, 'removeAvatar']);

    // Export PDF
    Route::get('/system/resumes/{id}/export/pdf', [ResumeExportController::class, 'downloadPdf']);
});

// CV Management
Route::middleware('auth:sanctum')->prefix('cv')->group(function () {
    Route::get('/resumes',                        [ResumeController::class, 'index']);
    Route::post('/resumes',                       [ResumeController::class, 'store']);
    Route::get('/resumes/{id}',                   [ResumeController::class, 'show']);
    Route::patch('/resumes/{id}',                 [ResumeController::class, 'update']);
    Route::delete('/resumes/{id}',                [ResumeController::class, 'destroy']);
    Route::post('/resumes/{id}/duplicate',        [ResumeController::class, 'duplicate']);
    Route::patch('/resumes/{id}/visibility',      [ResumeController::class, 'toggleVisibility']);

    // Sub-resources
    Route::apiResource('resumes.educations',   ResumeEducationController::class)->except(['show']);
    Route::apiResource('resumes.experiences',  ResumeExperienceController::class)->except(['show']);
    Route::apiResource('resumes.skills',       ResumeSkillController::class)->except(['show']);
    Route::apiResource('resumes.projects',     ResumeProjectController::class)->except(['show']);
    Route::apiResource('resumes.languages',    ResumeLanguageController::class)->except(['show']);
    Route::apiResource('resumes.social-links', ResumeSocialLinkController::class)->except(['show']);
});

// System User Routes
Route::middleware('auth:sanctum')->prefix('system')->group(function () {
    Route::get('/templates',     [SystemTemplateController::class, 'index']);
    Route::get('/templates/{id}',[SystemTemplateController::class, 'show']);
});


// -----------------------------------------------------------------------
// ADMIN WEB ROUTES (prefix: admin)
// -----------------------------------------------------------------------

// Các route Admin không chứa middleware (Được khai báo trước để tránh ghi đè sai route logic)
// Các route Admin không chứa middleware (Được khai báo trước để tránh ghi đè sai route logic)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('admin.dashboard');
    Route::get('/stats', [DashboardController::class, 'stats'])
         ->name('admin.stats');
    Route::get('/templates/view', [AdminTemplateController::class, 'index'])
         ->name('admin.templates.view');
         
    // THÊM DÒNG NÀY VÀO ĐÂY:
    Route::get('/templates', function () {
        return redirect()->route('admin.templates.index');
    });
});

// web.php — thêm vào group admin middleware
Route::prefix('admin')->group(function () {
   

    // Templates
    Route::get('templates/view',           [AdminTemplateController::class, 'index'])->name('admin.templates.index');
    Route::post('templates',               [AdminTemplateController::class, 'store'])->name('admin.templates.store');
    Route::put('templates/{template}',     [AdminTemplateController::class, 'update'])->name('admin.templates.update');
    Route::delete('templates/{template}',  [AdminTemplateController::class, 'destroy'])->name('admin.templates.destroy');
    Route::post('templates/{template}/toggle', [AdminTemplateController::class, 'toggleActive'])->name('admin.templates.toggle');
    Route::get('resumes', [AdminResumeController::class, 'index'])->name('admin.resumes.index');
    Route::delete('resumes/{id}', [AdminResumeController::class, 'destroy'])->name('admin.resumes.destroy');

    // Users
    Route::get('users',                    [UserController::class, 'index'])->name('admin.users.index');
    Route::post('users',                   [UserController::class, 'store'])->name('admin.users.store');
    Route::put('users/{user}',             [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user}',          [UserController::class, 'destroy'])->name('admin.users.destroy');
});

