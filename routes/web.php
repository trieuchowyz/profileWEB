<?php

use Illuminate\Support\Facades\Route;

// --- Khai báo đúng Namespace theo cấu trúc thư mục của bạn ---

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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Tự động chuyển hướng từ trang gốc (/) sang Dashboard Admin
Route::get('/', function () {
    return redirect('/admin/dashboard');
});

// --- ROUTE GIAO DIỆN ADMIN (Sử dụng view) ---
// Tạm bỏ auth:sanctum để test giao diện hiển thị.
Route::prefix('admin')->group(function () {
    // URL: http://127.0.0.1:8000/admin/dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    // URL: http://127.0.0.1:8000/admin/templates/view
    Route::get('/templates/view', function () {
        return view('admin.templates.index');
    });
});

// -----------------------------------------------------------------------
// PUBLIC ROUTES
// -----------------------------------------------------------------------
Route::post('/auth/register', [RegisterController::class, 'register']);
Route::post('/auth/login',    [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout',     [LoginController::class, 'logout']);
    Route::get('/profile',          [ProfileController::class, 'show']);
    Route::patch('/profile/name',   [ProfileController::class, 'updateName']);
    Route::post('/profile/avatar',  [ProfileController::class, 'updateAvatar']);
    Route::delete('/profile/avatar',[ProfileController::class, 'removeAvatar']);
});

// Public (không cần auth)
Route::get('/cv/public/{slug}', [ResumeController::class, 'showPublic']);

// Protected
Route::middleware('auth:sanctum')->prefix('cv')->group(function () {
    Route::get('/resumes',                        [ResumeController::class, 'index']);
    Route::post('/resumes',                       [ResumeController::class, 'store']);
    Route::get('/resumes/{id}',                   [ResumeController::class, 'show']);
    Route::patch('/resumes/{id}',                 [ResumeController::class, 'update']);
    Route::delete('/resumes/{id}',                [ResumeController::class, 'destroy']);
    Route::post('/resumes/{id}/duplicate',        [ResumeController::class, 'duplicate']);
    Route::patch('/resumes/{id}/visibility',      [ResumeController::class, 'toggleVisibility']);
});

Route::middleware('auth:sanctum')->prefix('cv')->group(function () {
    Route::apiResource('resumes.educations',   ResumeEducationController::class)->except(['show']);
    Route::apiResource('resumes.experiences',  ResumeExperienceController::class)->except(['show']);
    Route::apiResource('resumes.skills',       ResumeSkillController::class)->except(['show']);
    Route::apiResource('resumes.projects',     ResumeProjectController::class)->except(['show']);
    Route::apiResource('resumes.languages',    ResumeLanguageController::class)->except(['show']);
    Route::apiResource('resumes.social-links', ResumeSocialLinkController::class)->except(['show']);
});

// Public (không cần auth)
Route::get('/system/public/{slug}/export/pdf', [ResumeExportController::class, 'downloadPublicPdf']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/system/resumes/{id}/export/pdf', [ResumeExportController::class, 'downloadPdf']);
});

// User routes
Route::middleware('auth:sanctum')->prefix('system')->group(function () {
    Route::get('/templates',     [SystemTemplateController::class, 'index']);
    Route::get('/templates/{id}',[SystemTemplateController::class, 'show']);
});

// Admin routes (API dữ liệu - Đang giữ nguyên middleware)
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/templates',                          [AdminTemplateController::class, 'index']);
    Route::get('/templates/{id}',                     [AdminTemplateController::class, 'show']);
    Route::post('/templates',                         [AdminTemplateController::class, 'store']);
    Route::post('/templates/{id}',                    [AdminTemplateController::class, 'update']);
    Route::delete('/templates/{id}',                  [AdminTemplateController::class, 'destroy']);
    Route::patch('/templates/{id}/toggle-active',     [AdminTemplateController::class, 'toggleActive']);
});