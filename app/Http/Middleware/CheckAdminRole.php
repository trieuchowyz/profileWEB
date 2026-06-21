<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem user đã đăng nhập chưa và có phải là admin không
        // Chú ý thay đổi 'role' và 'admin' cho khớp với cấu trúc Database của bạn
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Nếu là user thường cố tình truy cập link admin, đẩy về trang chủ hoặc báo lỗi 403
        return redirect('/'); 
    }
}