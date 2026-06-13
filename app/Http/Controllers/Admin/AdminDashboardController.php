<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resume;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Hiển thị trang dashboard admin với các thống kê tổng quan.
     */
    public function index()
    {
        // ── Thống kê tổng quan ──────────────────────────────────────────────
        $totalUsers     = User::count();
        $totalResumes   = Resume::count();
        $totalTemplates = Template::count();
        $activeTemplates = Template::where('is_active', true)->count();

        // ── Tăng trưởng trong 30 ngày gần nhất ─────────────────────────────
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $newUsersThisMonth    = User::where('created_at', '>=', $thirtyDaysAgo)->count();
        $newResumesThisMonth  = Resume::where('created_at', '>=', $thirtyDaysAgo)->count();

        // Tính % so với 30 ngày trước đó
        $sixtyDaysAgo = Carbon::now()->subDays(60);
        $newUsersPrevMonth   = User::whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->count();
        $newResumesPrevMonth = Resume::whereBetween('created_at', [$sixtyDaysAgo, $thirtyDaysAgo])->count();

        $userGrowthPercent   = $newUsersPrevMonth > 0
            ? round((($newUsersThisMonth - $newUsersPrevMonth) / $newUsersPrevMonth) * 100, 1)
            : ($newUsersThisMonth > 0 ? 100 : 0);

        $resumeGrowthPercent = $newResumesPrevMonth > 0
            ? round((($newResumesThisMonth - $newResumesPrevMonth) / $newResumesPrevMonth) * 100, 1)
            : ($newResumesThisMonth > 0 ? 100 : 0);

        // ── Biểu đồ đăng ký user 7 ngày gần nhất ──────────────────────────
        $userChartData = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo);
            return [
                'date'  => $date->format('d/m'),
                'count' => User::whereDate('created_at', $date->toDateString())->count(),
            ];
        });

        // ── Biểu đồ CV tạo mới 7 ngày gần nhất ─────────────────────────────
        $resumeChartData = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::now()->subDays($daysAgo);
            return [
                'date'  => $date->format('d/m'),
                'count' => Resume::whereDate('created_at', $date->toDateString())->count(),
            ];
        });

        // ── Template phổ biến nhất (dựa vào số lần dùng) ───────────────────
        $popularTemplates = Template::withCount('resume')
            ->orderBy('resume_count', 'desc')
            ->take(5)
            ->get();

        // ── 10 user đăng ký gần nhất ─────────────────────────────────────
        $recentUsers = User::latest()->take(10)->get();

        // ── 10 CV tạo gần nhất ───────────────────────────────────────────
        $recentResumes = Resume::with('users')
            ->latest()
            ->take(10)
            ->get();

        // ── Tỉ lệ CV public / private ─────────────────────────────────────
        $publicResumes  = Resume::where('is_public', true)->count();
        $privateResumes = Resume::where('is_public', false)->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalResumes',
            'totalTemplates',
            'activeTemplates',
            'newUsersThisMonth',
            'newResumesThisMonth',
            'userGrowthPercent',
            'resumeGrowthPercent',
            'userChartData',
            'resumeChartData',
            'popularTemplates',
            'recentUsers',
            'recentResumes',
            'publicResumes',
            'privateResumes'
        ));
    }

    /**
     * Trả về dữ liệu thống kê dạng JSON cho các widget Ajax.
     */
    public function stats()
    {
        return response()->json([
            'total_users'      => User::count(),
            'total_resumes'    => Resume::count(),
            'total_templates'  => Template::count(),
            'active_templates' => Template::where('is_active', true)->count(),
            'public_resumes'   => Resume::where('is_public', true)->count(),

        ]);
    }
}
