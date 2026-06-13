<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class UserProfileService
{
    /**
     * Update the user's display name.
     *
     * @param User   $user
     * @param string $name
     * @return User
     */
    public function updateName(User $user, string $name): User
    {
        $user->update(['name' => $name]);

        return $user->refresh();
    }

    /**
     * Upload and store a new avatar for the user.
     * Deletes the previous avatar if one exists.
     *
     * @param User         $user
     * @param UploadedFile $file
     * @return User
     */
    public function updateAvatar(User $user, UploadedFile $file): User
    {
        // Remove old avatar if it exists
        if (! empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store the new avatar under avatars/{userId}/filename
        $path = $file->store("avatars/{$user->id}", 'public');

        $user->update(['avatar' => $path]);

        return $user->refresh();
    }

    /**
     * Delete the user's current avatar (revert to default).
     *
     * @param User $user
     * @return User
     */
    public function removeAvatar(User $user): User
    {
        if (! empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return $user->refresh();
    }

    /**
     * Return the public URL for the user's avatar (or a default placeholder).
     *
     * @param User $user
     * @return string
     */
    public function getAvatarUrl(User $user): string
    {
        if (! empty($user->avatar) && Storage::disk('public')->exists($user->avatar)) {
            return Storage::disk('public')->url($user->avatar);
        }

        return asset('images/default-avatar.png');
    }
}
