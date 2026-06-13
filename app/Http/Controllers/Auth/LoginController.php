<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * Handle a login request.
     *
     * POST /api/auth/login
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $result = $this->authService->login(
                $validator->validated(),
                $request->userAgent() ?? 'web'
            );
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Invalid credentials.',
                'errors'  => $e->errors(),
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful.',
            'user'    => $result['user'],
            'token'   => $result['token'],
        ]);
    }

    /**
     * Log out the current device (revoke current token).
     *
     * POST /api/auth/logout
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    /**
     * Log out from all devices (revoke all tokens).
     *
     * POST /api/auth/logout-all
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $this->authService->logoutAll($request->user());

        return response()->json([
            'message' => 'Logged out from all devices.',
        ]);
    }
}
