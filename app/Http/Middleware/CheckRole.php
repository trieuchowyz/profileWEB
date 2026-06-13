<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Tham số nhận vào từ route (ở đây là 'admin')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Kiểm tra xem user đã đăng nhập chưa
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 2. Kiểm tra xem role của user có khớp với role yêu cầu không
        // Giả sử bảng 'users' của bạn có cột tên là 'role'
        $user = Auth::user();
        if (!$user || $user->role !== $role) {
            return response()->json(['message' => 'Forbidden - Bạn không có quyền truy cập'], 403);
        }

        // Nếu hợp lệ, cho phép request đi tiếp vào Controller
        return $next($request);
    }
}