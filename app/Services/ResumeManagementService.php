<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ResumeManagementService
{
    /**
     * Lấy danh sách CV của user (không cần load chi tiết).
     *
     * @param User $user
     * @return Collection
     */
    public function listByUser(User $user): Collection
    {
        return Resume::where('user_id', $user->id)
            ->with(['templates'])
            ->orderByDesc('updated_at')
            ->get();
    }

    /**
     * Lấy toàn bộ data của 1 CV (eager load tất cả quan hệ).
     *
     * @param int  $resumeId
     * @param User $user      Dùng để kiểm tra ownership
     * @return Resume
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getFullResume(int $resumeId, User $user): Resume
    {
        return Resume::where('id', $resumeId)
            ->where('user_id', $user->id)
            ->with([
                'templates',
                'educations',
                'experiences',
                'skills',
                'projects',
                'languages',
                'socialLinks',
            ])
            ->firstOrFail();
    }

    /**
     * Lấy CV công khai bằng slug (không cần xác thực).
     *
     * @param string $slug
     * @return Resume
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getPublicResume(string $slug): Resume
    {
        return Resume::where('slug', $slug)
            ->where('is_public', true)
            ->with([
                'templates',
                'educations',
                'experiences',
                'skills',
                'projects',
                'languages',
                'socialLinks',
            ])
            ->firstOrFail();
    }

    /**
     * Tạo CV mới cho user.
     *
     * @param User  $user
     * @param array $data
     * @return Resume
     */
    public function create(User $user, array $data): Resume
    {
        $data['user_id'] = $user->id;
        $data['slug']    = $this->generateUniqueSlug($data['title']);

        return Resume::create($data);
    }

    /**
     * Cập nhật thông tin cơ bản của CV (không bao gồm các section con).
     *
     * @param Resume $resume
     * @param array  $data
     * @return Resume
     */
    public function update(Resume $resume, array $data)
    {
        // 1. Cập nhật mảng custom_styles (Gộp style cũ và mới nếu user chỉ gửi 1 màu)
        if (isset($data['custom_styles'])) {
            $currentStyles = is_array($resume->custom_styles) ? $resume->custom_styles : [];
            $data['custom_styles'] = array_merge($currentStyles, $data['custom_styles']);
        }

        // 2. Cập nhật thông tin thẳng vào model
        $resume->update($data);

        return $resume->fresh(); // Trả về bản ghi mới nhất
    }

    /**
     * Xoá CV và toàn bộ các bảng con liên quan.
     *
     * @param Resume $resume
     * @return void
     */
    public function delete(Resume $resume): void
    {
        // Các bảng con nên có cascade delete ở migration.
        // Gọi thêm ở đây để đảm bảo trong trường hợp không có cascade.
        $resume->educations()->delete();
        $resume->experiences()->delete();
        $resume->skills()->delete();
        $resume->projects()->delete();
        $resume->languages()->delete();
        $resume->socialLinks()->delete();

        $resume->delete();
    }

    /**
     * Sao chép một CV (duplicate).
     *
     * @param Resume $resume
     * @return Resume
     */
    public function duplicate(Resume $resume): Resume
    {
        $newTitle = $resume->title . ' (Copy)';

        $newResume = $resume->replicate(['slug']);
        $newResume->title = $newTitle;
        $newResume->slug  = $this->generateUniqueSlug($newTitle);
        $newResume->save();

        // Clone từng section con
        foreach ($resume->educations as $item) {
            $newResume->educations()->create($item->only($item->getFillable()));
        }
        foreach ($resume->experiences as $item) {
            $newResume->experiences()->create($item->only($item->getFillable()));
        }
        foreach ($resume->skills as $item) {
            $newResume->skills()->create($item->only($item->getFillable()));
        }
        foreach ($resume->projects as $item) {
            $newResume->projects()->create($item->only($item->getFillable()));
        }
        foreach ($resume->languages as $item) {
            $newResume->languages()->create($item->only($item->getFillable()));
        }
        foreach ($resume->socialLinks as $item) {
            $newResume->socialLinks()->create($item->only($item->getFillable()));
        }

        return $newResume->load([
            'educations', 'experiences', 'skills',
            'projects', 'languages', 'socialLinks',
        ]);
    }

    /**
     * Bật/tắt chế độ công khai của CV.
     *
     * @param Resume $resume
     * @param bool   $isPublic
     * @return Resume
     */
    public function togglePublic(Resume $resume, bool $isPublic): Resume
    {
        $resume->update(['is_public' => $isPublic]);

        return $resume->refresh();
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Tạo slug duy nhất từ title.
     *
     * @param string   $title
     * @param int|null $excludeId  ID của resume hiện tại khi update (để bỏ qua khi check trùng)
     * @return string
     */
    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            Resume::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
    
}
