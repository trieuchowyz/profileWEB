<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Services\TemplateManagementService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    public function __construct(protected TemplateManagementService $templateService) {}

    /**
     * Lấy toàn bộ template (kể cả inactive) — chỉ dành cho Admin.
     *
     * GET /api/admin/templates
     */
    public function index(): JsonResponse
    {
        $templates = Template::orderBy('name')->get();

        return response()->json(['data' => $templates]);
    }

    /**
     * Xem chi tiết 1 template bất kỳ.
     *
     * GET /api/admin/templates/{id}
     */
    public function show(int $id): JsonResponse
    {
        $template = Template::findOrFail($id);

        return response()->json(['data' => $template]);
    }

    /**
     * Tạo template mới kèm upload thumbnail.
     *
     * POST /api/admin/templates
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'           => ['required', 'string', 'max:255'],
            'view_path'      => ['required', 'string', 'max:500'],
            'thumbnail'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'default_styles' => ['nullable', 'array'],
            'is_active'      => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $template = $this->templateService->create(
            $validator->validated(),
            $request->file('thumbnail')
        );

        return response()->json([
            'message' => 'Template created successfully.',
            'data'    => $template,
        ], 201);
    }

    /**
     * Cập nhật template (có thể thay thumbnail).
     *
     * POST /api/admin/templates/{id}
     *
     * Dùng POST thay vì PATCH vì multipart/form-data
     * không hoạt động tốt với PATCH trong nhiều HTTP client.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $template = Template::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'           => ['sometimes', 'string', 'max:255'],
            'view_path'      => ['sometimes', 'string', 'max:500'],
            'thumbnail'      => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'default_styles' => ['sometimes', 'nullable', 'array'],
            'is_active'      => ['sometimes', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $updated = $this->templateService->update(
            $template,
            $validator->validated(),
            $request->file('thumbnail')
        );

        return response()->json([
            'message' => 'Template updated successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * Xoá template (chỉ được xoá nếu không có CV nào đang dùng).
     *
     * DELETE /api/admin/templates/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $template = Template::findOrFail($id);

        try {
            $this->templateService->delete($template);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 409); // Conflict
        }

        return response()->json(['message' => 'Template deleted successfully.']);
    }

    /**
     * Bật/tắt trạng thái active của template.
     *
     * PATCH /api/admin/templates/{id}/toggle-active
     */
    public function toggleActive(Request $request, int $id): JsonResponse
    {
        $template = Template::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'is_active' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $updated = $this->templateService->toggleActive(
            $template,
            $validator->validated()['is_active']
        );

        return response()->json([
            'message' => $updated->is_active ? 'Template activated.' : 'Template deactivated.',
            'data'    => $updated,
        ]);
    }
}