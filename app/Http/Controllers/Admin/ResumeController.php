<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index(Request $request)
    {
        // Quan hệ trong Model của bạn đang đặt tên là users() và templates()
        $query = Resume::with(['users', 'templates'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('users', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $resumes = $query->paginate(10)->withQueryString();
        
        $totalResumes = Resume::count();
        $publicResumes = Resume::where('is_public', true)->count();
        $privateResumes = Resume::where('is_public', false)->count();

        return view('admin.resumes', compact('resumes', 'totalResumes', 'publicResumes', 'privateResumes'));
    }

    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
        $resume->delete();

        return redirect()->route('admin.resumes.index')
                         ->with('success', 'Đã xoá hồ sơ CV thành công!');
    }
}