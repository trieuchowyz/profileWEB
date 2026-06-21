<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Kiểm tra xem người dùng có tick vào ô remember không
    $remember = $request->boolean('remember');

    // Thêm biến $remember vào tham số thứ 2 của Auth::attempt
    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->intended('/'); 

    }
    
    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.',
    ]);
}

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Đăng ký xong quay về trang login với thông báo
        return redirect()->route('login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

