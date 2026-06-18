<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Vui lòng kiểm tra lại thông tin.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Tạo User mới
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', // Mặc định ai đăng ký cũng là user
        ]);

        // Đăng nhập luôn cho user sau khi đăng ký
        Auth::login($user);

        return response()->json([
            'message' => 'Đăng ký thành công.',
            'user'    => $user,
        ], 201);
    }
}
