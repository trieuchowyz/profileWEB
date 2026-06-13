<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Register a new user.
     *
     * @param array $data ['name', 'email', 'password', 'role' (optional)]
     * @return User
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'], // hashed automatically via cast
            'role'     => $data['role'] ?? 'user',
        ]);

        return $user;
    }

    /**
     * Attempt to log in a user and return an API token (Sanctum).
     *
     * @param array $credentials ['email', 'password']
     * @param string $deviceName  Token name / device identifier
     * @return array ['user' => User, 'token' => string]
     *
     * @throws ValidationException
     */
    public function login(array $credentials, string $deviceName = 'web'): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($deviceName)->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Log out the currently authenticated user (revoke current token).
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        // Revoke the token that was used to authenticate the current request
        $user->currentAccessToken()->delete();
    }

    /**
     * Log out from all devices (revoke all tokens).
     *
     * @param User $user
     * @return void
     */
    public function logoutAll(User $user): void
    {
        $user->tokens()->delete();
    }
}