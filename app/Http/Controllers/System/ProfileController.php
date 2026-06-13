<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Services\UserProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct(protected UserProfileService $profileService) {}

    /**
     * Get the authenticated user's profile.
     *
     * GET /api/profile
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'user'       => $user,
            'avatar_url' => $this->profileService->getAvatarUrl($user),
        ]);
    }

    /**
     * Update the authenticated user's display name.
     *
     * PATCH /api/profile/name
     */
    public function updateName(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = $this->profileService->updateName(
            $request->user(),
            $validator->validated()['name']
        );

        return response()->json([
            'message' => 'Name updated successfully.',
            'user'    => $user,
        ]);
    }

    /**
     * Upload a new avatar for the authenticated user.
     *
     * POST /api/profile/avatar
     */
    public function updateAvatar(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'avatar' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // 2 MB
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = $this->profileService->updateAvatar(
            $request->user(),
            $request->file('avatar')
        );

        return response()->json([
            'message'    => 'Avatar updated successfully.',
            'user'       => $user,
            'avatar_url' => $this->profileService->getAvatarUrl($user),
        ]);
    }

    /**
     * Remove the authenticated user's avatar.
     *
     * DELETE /api/profile/avatar
     */
    public function removeAvatar(Request $request): JsonResponse
    {
        $user = $this->profileService->removeAvatar($request->user());

        return response()->json([
            'message'    => 'Avatar removed successfully.',
            'user'       => $user,
            'avatar_url' => $this->profileService->getAvatarUrl($user),
        ]);
    }
}
