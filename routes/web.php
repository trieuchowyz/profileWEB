<?php

use Illuminate\Support\Facades\Route;

// Auth
use App\Http\Controllers\Auth\AuthController;

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

<<<<<<< HEAD
// Models
use App\Models\Template;
use App\Models\Resume;

// =======================================================================
// 1. PUBLIC ROUTES (Không yêu cầu đăng nhập)
// =======================================================================

// 1.1. Trang chủ hiển thị danh sách mẫu CV
Route::get('/', function () {
    $templates = Template::where('is_active', true)->get();
    return view('client.home', compact('templates'));
})->name('home');

// 1.2. Xác thực (Auth)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 1.3. Xem CV & Xuất PDF công khai
// API trả về JSON data của CV public
Route::get('/cv/public/{slug}', [ResumeController::class, 'showPublic'])->name('cv.public');
=======
// Tự động chuyển hướng từ trang gốc (/) sang Dashboard Admin
 Route::get('/', function () {
     return redirect('/admin/dashboard');
 });

// Route::get('/', function () {
//     return view('client.home'); // Trỏ về file resources/views/home.blade.php của user
// });

// -----------------------------------------------------------------------
// PUBLIC ROUTES (Không yêu cầu đăng nhập)
// -----------------------------------------------------------------------
Route::get('/auth/register', function () {
    return view('auth.register');
})->name('auth.register');
Route::post('/auth/register', [RegisterController::class, 'register'])->name('auth.register.submit');

Route::get('/auth/login', function () {
    return view('auth.login');
})->name('auth.login');
Route::post('/auth/login', [LoginController::class, 'login'])->name('auth.login.submit');
>>>>>>> 24a87749c57191d309991196f79958282a21f712

// Xuất PDF CV public
Route::get('/system/public/{slug}/export/pdf', [ResumeExportController::class, 'downloadPublicPdf'])->name('cv.export.public');

// Khung hiển thị CV thật - được dùng trong iframe hoặc để người ngoài xem
Route::get('/cv/preview/{slug}', function ($slug) {
    $resume = Resume::with([
        'educations', 'experiences', 'skills', 
        'projects', 'languages', 'socialLinks', 'templates'
    ])->where('slug', $slug)->firstOrFail();

    $view = $resume->templates ? $resume->templates->view_path : 'cv.template1';
    return view($view, compact('resume'));
})->name('cv.preview');

// Trang Builder (Chỉnh sửa CV chia 2 nửa màn hình)
Route::get('/cv/builder/{slug}', function ($slug) {
    $resume = Resume::where('slug', $slug)->firstOrFail();
    return view('client.builder', compact('resume'));
})->name('cv.builder');

// Các trang thông tin tĩnh
Route::get('/chinh-sach-bao-mat', function () {
    return view('client.privacy');
})->name('client.privacy');

<<<<<<< HEAD
// =======================================================================
// 2. PROTECTED USER ROUTES (Yêu cầu đăng nhập - middleware: auth)
// =======================================================================

Route::middleware('auth')->group(function () {
=======
Route::get('/dieu-khoan-su-dung', function () {
    return view('client.terms');
})->name('client.terms');
// -----------------------------------------------------------------------
// PROTECTED USER ROUTES (Yêu cầu )
// -----------------------------------------------------------------------

Route::middleware('')->group(function () {
    // Auth & Profile
    Route::post('/auth/logout',     [LoginController::class, 'logout']);
    Route::get('/profile',          [ProfileController::class, 'show']);
    Route::patch('/profile/name',   [ProfileController::class, 'updateName']);
    Route::post('/profile/avatar',  [ProfileController::class, 'updateAvatar']);
    Route::delete('/profile/avatar',[ProfileController::class, 'removeAvatar']);
>>>>>>> 24a87749c57191d309991196f79958282a21f712

    // Trang cá nhân & Quản lý
    Route::get('/my-cvs', function () {
        return view('profile.cvs');
    })->name('profile.cvs');

<<<<<<< HEAD
    Route::get('/profile',          [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile/name',   [ProfileController::class, 'updateName'])->name('profile.updateName');
    Route::post('/profile/avatar',  [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
    Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar'])->name('profile.removeAvatar');
=======
// CV Management
Route::middleware('')->prefix('cv')->group(function () {
    Route::get('/resumes',                        [ResumeController::class, 'index']);
    Route::post('/resumes',                       [ResumeController::class, 'store']);
    Route::get('/resumes/{id}',                   [ResumeController::class, 'show']);
    Route::patch('/resumes/{id}',                 [ResumeController::class, 'update']);
    Route::delete('/resumes/{id}',                [ResumeController::class, 'destroy']);
    Route::post('/resumes/{id}/duplicate',        [ResumeController::class, 'duplicate']);
    Route::patch('/resumes/{id}/visibility',      [ResumeController::class, 'toggleVisibility']);
>>>>>>> 24a87749c57191d309991196f79958282a21f712

    // Xem API và Xuất CV cá nhân (Private)
    Route::get('/cv/{id}', [ResumeController::class, 'show'])->name('cv.show'); 
    Route::get('/system/resumes/{id}/export/pdf', [ResumeExportController::class, 'downloadPdf'])->name('cv.export.private');

<<<<<<< HEAD
    // System Templates (User xem mẫu)
    Route::get('/system/templates',     [SystemTemplateController::class, 'index'])->name('system.templates.index');
    Route::get('/system/templates/{id}', [SystemTemplateController::class, 'show'])->name('system.templates.show');
=======
// System User Routes
Route::middleware('')->prefix('system')->group(function () {
    Route::get('/templates',     [SystemTemplateController::class, 'index']);
    Route::get('/templates/{id}',[SystemTemplateController::class, 'show']);
});
>>>>>>> 24a87749c57191d309991196f79958282a21f712

    // CV Management API/Resources
    Route::prefix('cv')->name('cv.')->group(function () {
        Route::get('/resumes',                        [ResumeController::class, 'index'])->name('index');
        Route::post('/resumes',                       [ResumeController::class, 'store'])->name('store');
        Route::patch('/resumes/{id}',                 [ResumeController::class, 'update'])->name('update');
        Route::delete('/resumes/{id}',                [ResumeController::class, 'destroy'])->name('destroy');
        Route::post('/resumes/{id}/duplicate',        [ResumeController::class, 'duplicate'])->name('duplicate');
        Route::patch('/resumes/{id}/visibility',      [ResumeController::class, 'toggleVisibility'])->name('visibility');

<<<<<<< HEAD
        // Sub-resources
        Route::apiResource('resumes.educations',   ResumeEducationController::class)->except(['show']);
        Route::apiResource('resumes.experiences',  ResumeExperienceController::class)->except(['show']);
        Route::apiResource('resumes.skills',       ResumeSkillController::class)->except(['show']);
        Route::apiResource('resumes.projects',     ResumeProjectController::class)->except(['show']);
        Route::apiResource('resumes.languages',    ResumeLanguageController::class)->except(['show']);
        Route::apiResource('resumes.social-links', ResumeSocialLinkController::class)->except(['show']);
    });
});

=======
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

>>>>>>> 24a87749c57191d309991196f79958282a21f712

// =======================================================================
// 3. ADMIN ROUTES (Yêu cầu đăng nhập & quyền Admin)
// =======================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Stats
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Quản lý Templates
    Route::get('templates',               [AdminTemplateController::class, 'index'])->name('templates.index');
    Route::post('templates',              [AdminTemplateController::class, 'store'])->name('templates.store');
    Route::put('templates/{template}',    [AdminTemplateController::class, 'update'])->name('templates.update');
    Route::delete('templates/{template}', [AdminTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::post('templates/{template}/toggle', [AdminTemplateController::class, 'toggleActive'])->name('templates.toggle');

    // Quản lý Resumes
    Route::get('resumes', [AdminResumeController::class, 'index'])->name('resumes.index');
    Route::delete('resumes/{id}', [AdminResumeController::class, 'destroy'])->name('resumes.destroy');

    // Quản lý Users
    Route::get('users',           [UserController::class, 'index'])->name('users.index');
    Route::post('users',          [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}',    [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});