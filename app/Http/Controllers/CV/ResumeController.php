<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Services\ResumeManagementService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeController extends Controller
{
    public function __construct(protected ResumeManagementService $resumeService) {}

    // =========================================================================
    // DANH SÁCH & CHI TIẾT
    // =========================================================================

    /**
     * Lấy danh sách CV của user đang đăng nhập.
     *
     * GET /api/cv/resumes
     */
    public function index(Request $request): JsonResponse
    {
        $resumes = $this->resumeService->listByUser($request->user());

        return response()->json([
            'data' => $resumes,
        ]);
    }

    /**
     * Lấy toàn bộ data của 1 CV (eager load tất cả section).
     *
     * GET /api/cv/resumes/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        try {
            $resume = $this->resumeService->getFullResume($id, $request->user());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        return response()->json(['data' => $resume]);
    }

    /**
     * Xem CV công khai qua slug (không cần đăng nhập).
     *
     * GET /api/cv/public/{slug}
     */
    public function showPublic(string $slug): JsonResponse
    {
        try {
            $resume = $this->resumeService->getPublicResume($slug);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Resume not found or not public.'], 404);
        }

        return response()->json(['data' => $resume]);
    }

    // =========================================================================
    // TẠO / CẬP NHẬT / XOÁ
    // =========================================================================

    /**
     * Tạo CV mới.
     *
     * POST /api/cv/resumes
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'          => ['required', 'string', 'max:255'],
            'template_id'    => ['nullable', 'integer', 'exists:templates,id'],
            'full_name'      => ['nullable', 'string', 'max:255'],
            'job_title'      => ['nullable', 'string', 'max:255'],
            'email'          => ['nullable', 'email', 'max:255'],
            'phone'          => ['nullable', 'string', 'max:50'],
            'address'        => ['nullable', 'string', 'max:500'],
            'summary'        => ['nullable', 'string'],
            'custom_styles'  => ['nullable', 'array'],
            'is_public'      => ['nullable', 'boolean'],
            'section_order'  => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $resume = $this->resumeService->create($request->user(), $validator->validated());

        return response()->json([
            'message' => 'Resume created successfully.',
            'data'    => $resume,
        ], 201);
    }

    /**
     * Cập nhật thông tin cơ bản của CV.
     *
     * PATCH /api/cv/resumes/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $resume = $this->resumeService->getFullResume($id, $request->user());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'         => ['sometimes', 'string', 'max:255'],
            'template_id'   => ['sometimes', 'nullable', 'integer', 'exists:templates,id'],
            'full_name'     => ['sometimes', 'nullable', 'string', 'max:255'],
            'job_title'     => ['sometimes', 'nullable', 'string', 'max:255'],
            'email'         => ['sometimes', 'nullable', 'email', 'max:255'],
            'phone'         => ['sometimes', 'nullable', 'string', 'max:50'],
            'address'       => ['sometimes', 'nullable', 'string', 'max:500'],
            'summary'       => ['sometimes', 'nullable', 'string'],
            'custom_styles' => ['sometimes', 'nullable', 'array'],
            'is_public'     => ['sometimes', 'boolean'],
            'section_order' => ['sometimes', 'nullable', 'array'],
            'pdf_path'      => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $updated = $this->resumeService->update($resume, $validator->validated());

        return response()->json([
            'message' => 'Resume updated successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * Xoá CV.
     *
     * DELETE /api/cv/resumes/{id}
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            $resume = $this->resumeService->getFullResume($id, $request->user());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        $this->resumeService->delete($resume);

        return response()->json(['message' => 'Resume deleted successfully.']);
    }

    // =========================================================================
    // CHỨC NĂNG ĐẶC BIỆT
    // =========================================================================

    /**
     * Sao chép (duplicate) một CV.
     *
     * POST /api/cv/resumes/{id}/duplicate
     */
    public function duplicate(Request $request, int $id): JsonResponse
    {
        try {
            $resume = $this->resumeService->getFullResume($id, $request->user());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        $newResume = $this->resumeService->duplicate($resume);

        return response()->json([
            'message' => 'Resume duplicated successfully.',
            'data'    => $newResume,
        ], 201);
    }

    /**
     * Bật/tắt chế độ công khai của CV.
     *
     * PATCH /api/cv/resumes/{id}/visibility
     */
    public function toggleVisibility(Request $request, int $id): JsonResponse
    {
        try {
            $resume = $this->resumeService->getFullResume($id, $request->user());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'is_public' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $updated = $this->resumeService->togglePublic($resume, $validator->validated()['is_public']);

        return response()->json([
            'message' => $updated->is_public ? 'Resume is now public.' : 'Resume is now private.',
            'data'    => $updated,
        ]);
    }
}
