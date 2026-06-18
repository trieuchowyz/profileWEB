<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Vui lòng kiểm tra lại thông tin.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Dùng Session mặc định của Laravel để đăng nhập
        $credentials = $validator->validated();
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Đăng nhập thành công, tạo session mới để bảo mật
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Đăng nhập thành công.',
                'user'    => Auth::user(),
            ]);
        }

        // Sai email hoặc mật khẩu
        return response()->json([
            'message' => 'Email hoặc mật khẩu không chính xác.',
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Đăng xuất xong đá về trang chủ
    }
}
