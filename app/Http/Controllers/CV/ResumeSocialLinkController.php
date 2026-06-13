<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeSocialLink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeSocialLinkController extends Controller
{
    /**
     * Lấy danh sách social link của 1 CV.
     *
     * GET /api/cv/resumes/{resumeId}/social-links
     */
    public function index(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $links = ResumeSocialLink::where('resume_id', $resumeId)->get();

        return response()->json(['data' => $links]);
    }

    /**
     * Thêm một social link vào CV.
     *
     * POST /api/cv/resumes/{resumeId}/social-links
     */
    public function store(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'platform' => ['required', 'string', 'max:100'],
            'url'      => ['required', 'url', 'max:500'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $link = ResumeSocialLink::create(
            array_merge($validator->validated(), ['resume_id' => $resumeId])
        );

        return response()->json(['message' => 'Social link added successfully.', 'data' => $link], 201);
    }

    /**
     * Cập nhật một social link.
     *
     * PATCH /api/cv/resumes/{resumeId}/social-links/{id}
     */
    public function update(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $link = ResumeSocialLink::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'platform' => ['sometimes', 'string', 'max:100'],
            'url'      => ['sometimes', 'url', 'max:500'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $link->update($validator->validated());

        return response()->json(['message' => 'Social link updated successfully.', 'data' => $link->refresh()]);
    }

    /**
     * Xoá một social link.
     *
     * DELETE /api/cv/resumes/{resumeId}/social-links/{id}
     */
    public function destroy(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        ResumeSocialLink::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail()
            ->delete();

        return response()->json(['message' => 'Social link deleted successfully.']);
    }
}