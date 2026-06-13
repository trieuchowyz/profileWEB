<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemplateManagementService
{
    /**
     * Tạo template mới, upload thumbnail và lưu view_path.
     *
     * @param array             $data
     * @param UploadedFile|null $thumbnail
     * @return Template
     */
    public function create(array $data, ?UploadedFile $thumbnail = null): Template
    {
        $data['slug']      = $this->generateUniqueSlug($data['name']);
        $data['thumbnail'] = $thumbnail ? $this->storeThumbnail($thumbnail) : null;

        return Template::create($data);
    }

    /**
     * Cập nhật thông tin template.
     * Nếu có thumbnail mới thì xoá ảnh cũ và lưu ảnh mới.
     *
     * @param Template          $template
     * @param array             $data
     * @param UploadedFile|null $thumbnail
     * @return Template
     */
    public function update(Template $template, array $data, ?UploadedFile $thumbnail = null): Template
    {
        // Cập nhật slug nếu name thay đổi
        if (isset($data['name']) && $data['name'] !== $template->name) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $template->id);
        }

        // Xử lý thumbnail mới
        if ($thumbnail) {
            $this->deleteThumbnail($template->thumbnail);
            $data['thumbnail'] = $this->storeThumbnail($thumbnail);
        }

        $template->update($data);

        return $template->refresh();
    }

    /**
     * Xoá template.
     * Xoá thumbnail khỏi Storage trước khi xoá record.
     *
     * @param Template $template
     * @return void
     *
     * @throws \Exception Nếu template đang được dùng bởi CV nào đó
     */
    public function delete(Template $template): void
    {
        // Kiểm tra template có đang được dùng bởi CV nào không
        if ($template->resume()->exists()) {
            throw new \Exception(
                "Cannot delete template \"{$template->name}\" because it is used by one or more resumes."
            );
        }

        $this->deleteThumbnail($template->thumbnail);

        $template->delete();
    }

    /**
     * Bật/tắt trạng thái active của template.
     *
     * @param Template $template
     * @param bool     $isActive
     * @return Template
     */
    public function toggleActive(Template $template, bool $isActive): Template
    {
        $template->update(['is_active' => $isActive]);

        return $template->refresh();
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Upload thumbnail vào Storage và trả về đường dẫn tương đối.
     *
     * @param UploadedFile $file
     * @return string  VD: "templates/thumbnails/abc123.webp"
     */
    private function storeThumbnail(UploadedFile $file): string
    {
        return $file->store('templates/thumbnails', 'public');
    }

    /**
     * Xoá thumbnail khỏi Storage nếu tồn tại.
     *
     * @param string|null $path
     * @return void
     */
    private function deleteThumbnail(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Tạo slug duy nhất từ tên template.
     *
     * @param string   $name
     * @param int|null $excludeId  Bỏ qua template hiện tại khi update
     * @return string
     */
    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i    = 1;

        while (
            Template::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}