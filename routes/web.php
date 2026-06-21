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

Route::get('/dieu-khoan-su-dung', function () {
    return view('client.terms');
})->name('client.terms');


// =======================================================================
// 2. PROTECTED USER ROUTES (Yêu cầu đăng nhập - middleware: auth)
// =======================================================================

Route::middleware('auth')->group(function () {

    // Khởi tạo CV mới từ Template có sẵn (Luồng tạo CV thật)
    Route::post('/cv/start/{template_id}', function ($template_id) {
        $user = auth()->user();
        
        // Tạo chuỗi slug ngẫu nhiên dể làm link CV
        $slug = 'cv-' . \Illuminate\Support\Str::slug($user->name) . '-' . time();
        
        // Tạo dữ liệu CV thật vào Database
        $resume = Resume::create([
            'user_id' => $user->id,
            'template_id' => $template_id,
            'title' => 'CV Không Tên',
            'slug' => $slug,
            'full_name' => $user->name,
            'email' => $user->email,
            'section_order' => ['summary', 'experiences', 'educations', 'skills', 'projects', 'languages', 'social_links'],
            'custom_styles' => [
                'primary_color' => '#2563eb',
                'heading_font' => 'Arial, sans-serif'
            ]
        ]);

        // Chuyển hướng thẳng vào trang Builder với cái slug vừa tạo
        return redirect()->route('cv.builder', ['slug' => $slug]);
    })->name('cv.start');

    // Trang cá nhân & Quản lý
    Route::get('/my-cvs', function () {
        return view('profile.cvs');
    })->name('profile.cvs');

    Route::get('/profile',           [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile/name',    [ProfileController::class, 'updateName'])->name('profile.updateName');
    Route::post('/profile/avatar',   [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
    Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar'])->name('profile.removeAvatar');

    // Xem API và Xuất CV cá nhân (Private)
    Route::get('/cv/{id}', [ResumeController::class, 'show'])->name('cv.show'); 
    Route::get('/system/resumes/{id}/export/pdf', [ResumeExportController::class, 'downloadPdf'])->name('cv.export.private');

    // System Templates (User xem mẫu)
    Route::get('/system/templates',      [SystemTemplateController::class, 'index'])->name('system.templates.index');
    Route::get('/system/templates/{id}', [SystemTemplateController::class, 'show'])->name('system.templates.show');

    // CV Management API/Resources
    Route::prefix('cv')->name('cv.')->group(function () {
        Route::get('/resumes',                        [ResumeController::class, 'index'])->name('index');
        Route::post('/resumes',                       [ResumeController::class, 'store'])->name('store');
        Route::patch('/resumes/{id}',                 [ResumeController::class, 'update'])->name('update');
        Route::delete('/resumes/{id}',                [ResumeController::class, 'destroy'])->name('destroy');
        Route::post('/resumes/{id}/duplicate',        [ResumeController::class, 'duplicate'])->name('duplicate');
        Route::patch('/resumes/{id}/visibility',      [ResumeController::class, 'toggleVisibility'])->name('visibility');

        // Sub-resources
        Route::apiResource('resumes.educations',   ResumeEducationController::class)->except(['show']);
        Route::apiResource('resumes.experiences',  ResumeExperienceController::class)->except(['show']);
        Route::apiResource('resumes.skills',       ResumeSkillController::class)->except(['show']);
        Route::apiResource('resumes.projects',     ResumeProjectController::class)->except(['show']);
        Route::apiResource('resumes.languages',    ResumeLanguageController::class)->except(['show']);
        Route::apiResource('resumes.social-links', ResumeSocialLinkController::class)->except(['show']);
    });
});


// =======================================================================
// 3. ADMIN ROUTES (Yêu cầu đăng nhập & quyền Admin)
// =======================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Stats
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats',     [DashboardController::class, 'stats'])->name('stats');

    // Quản lý Templates
    Route::get('templates',                    [AdminTemplateController::class, 'index'])->name('templates.index');
    Route::post('templates',                   [AdminTemplateController::class, 'store'])->name('templates.store');
    Route::get('templates/view',               [AdminTemplateController::class, 'index'])->name('templates.view');
    Route::put('templates/{template}',         [AdminTemplateController::class, 'update'])->name('templates.update');
    Route::delete('templates/{template}',      [AdminTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::post('templates/{template}/toggle', [AdminTemplateController::class, 'toggleActive'])->name('templates.toggle');

    // Quản lý Resumes
    Route::get('resumes',         [AdminResumeController::class, 'index'])->name('resumes.index');
    Route::delete('resumes/{id}', [AdminResumeController::class, 'destroy'])->name('resumes.destroy');

    // Quản lý Users
    Route::get('users',           [UserController::class, 'index'])->name('users.index');
    Route::post('users',          [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}',    [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// =======================================================================
// ROUTE TEST BUILDER (GIẢ LẬP DỮ LIỆU ĐỂ XEM GIAO DIỆN)
// =======================================================================

Route::get('/test-builder', function () {
    $resume = new \App\Models\Resume([
        'id' => 999,
        'title' => 'CV Test',
        'slug' => 'fake-slug',
        'full_name' => 'Nguyễn Văn Test',
        'job_title' => 'Fullstack Web Developer',
        'summary' => 'Đây là đoạn text giới thiệu bản thân test để xem giao diện render ra có mượt không.',
        'custom_styles' => [
            'primary_color' => '#2563eb',
            'heading_font' => 'Arial, sans-serif'
        ],
        'section_order' => ['summary', 'experiences', 'educations', 'skills']
    ]);

    return view('client.builder', compact('resume'));
});

Route::get('/cv/preview/fake-slug', function () {
    $resume = new \App\Models\Resume([
        'id' => 999,
        'title' => 'CV Test',
        'slug' => 'fake-slug',
        'full_name' => 'Nguyễn Văn Test',
        'job_title' => 'Fullstack Web Developer',
        'summary' => 'Đây là đoạn text giới thiệu bản thân test để xem giao diện render ra có mượt không.',
        'custom_styles' => [
            'primary_color' => '#2563eb',
            'heading_font' => 'Arial, sans-serif'
        ],
        'section_order' => ['summary', 'experiences', 'educations', 'skills']
    ]);

    // Khởi tạo các mảng rỗng để không bị lỗi báo thiếu dữ liệu (undefined) khi lặp @foreach
    $resume->setRelation('experiences', collect([]));
    $resume->setRelation('educations', collect([]));
    $resume->setRelation('skills', collect([]));
    $resume->setRelation('projects', collect([]));
    $resume->setRelation('languages', collect([]));
    $resume->setRelation('socialLinks', collect([]));
    $resume->setRelation('templates', null);

    return view('cv.template1', compact('resume'));
});

Route::get('/test-preview', function () {
    $resume = new \App\Models\Resume([
        'id' => 999,
        'title' => 'CV Test',
        'slug' => 'fake-slug',
        'full_name' => 'Nguyễn Văn Test',
        'job_title' => 'Fullstack Web Developer',
        'summary' => 'Đây là đoạn text giới thiệu bản thân test để xem giao diện render ra có mượt không.',
        'custom_styles' => [
            'primary_color' => '#2563eb',
            'heading_font' => 'Arial, sans-serif'
        ],
        'section_order' => ['summary', 'experiences', 'educations', 'skills']
    ]);

    // Khởi tạo các mảng rỗng để không bị lỗi
    $resume->setRelation('experiences', collect([]));
    $resume->setRelation('educations', collect([]));
    $resume->setRelation('skills', collect([]));
    $resume->setRelation('projects', collect([]));
    $resume->setRelation('languages', collect([]));
    $resume->setRelation('socialLinks', collect([]));
    $resume->setRelation('templates', null);

    return view('cv.template1', compact('resume'));
});
// =======================================================================
// ROUTE TỰ ĐỘNG TẠO DỮ LIỆU MẪU (CHẠY 1 LẦN)
// =======================================================================

Route::get('/setup-data', function () {
    // 1. Tạo Mẫu CV số 1: IT Hiện Đại
    \App\Models\Template::firstOrCreate(
        ['slug' => 'mau-it-hien-dai'],
        [
            'name' => 'Mẫu IT Hiện Đại (Màu Xanh)',
            'view_path' => 'cv.template1', // Trỏ đúng vào file template1.blade.php của bạn
            'thumbnail' => 'default.png', // Tạm thời để tên ảnh mặc định
            'is_active' => true,
            'default_styles' => [
                'primary_color' => '#2563eb',
                'heading_font' => 'Arial, sans-serif'
            ]
        ]
    );

    // 2. Tạo Mẫu CV số 2: Thanh Lịch
    \App\Models\Template::firstOrCreate(
        ['slug' => 'mau-thanh-lich'],
        [
            'name' => 'Mẫu Thanh Lịch (Màu Trầm)',
            'view_path' => 'cv.template1',
            'thumbnail' => 'default.png', 
            'is_active' => true,
            'default_styles' => [
                'primary_color' => '#475569',
                'heading_font' => "'Times New Roman', serif"
            ]
        ]
    );

    return "Đã tạo 2 Mẫu CV thành công! Bạn hãy quay lại trang chủ ( http://127.0.0.1:8000/ ) để xem nhé.";
});