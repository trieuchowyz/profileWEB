<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeExperience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeExperienceController extends Controller
{
    /**
     * Lấy danh sách experience của 1 CV.
     *
     * GET /api/cv/resumes/{resumeId}/experiences
     */
    public function index(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $experiences = ResumeExperience::where('resume_id', $resumeId)
            ->orderBy('order_index')
            ->get();

        return response()->json(['data' => $experiences]);
    }

    /**
     * Thêm một experience vào CV.
     *
     * POST /api/cv/resumes/{resumeId}/experiences
     */
    public function store(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'company'     => ['required', 'string', 'max:255'],
            'position'    => ['required', 'string', 'max:255'],
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current'  => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'order_index' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $experience = ResumeExperience::create(
            array_merge($validator->validated(), ['resume_id' => $resumeId])
        );

        return response()->json(['message' => 'Experience added successfully.', 'data' => $experience], 201);
    }

    /**
     * Cập nhật một experience.
     *
     * PATCH /api/cv/resumes/{resumeId}/experiences/{id}
     */
    public function update(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $experience = ResumeExperience::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'company'     => ['sometimes', 'string', 'max:255'],
            'position'    => ['sometimes', 'string', 'max:255'],
            'start_date'  => ['sometimes', 'nullable', 'date'],
            'end_date'    => ['sometimes', 'nullable', 'date', 'after_or_equal:start_date'],
            'is_current'  => ['sometimes', 'boolean'],
            'description' => ['sometimes', 'nullable', 'string'],
            'order_index' => ['sometimes', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $experience->update($validator->validated());

        return response()->json(['message' => 'Experience updated successfully.', 'data' => $experience->refresh()]);
    }

    /**
     * Xoá một experience.
     *
     * DELETE /api/cv/resumes/{resumeId}/experiences/{id}
     */
    public function destroy(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        ResumeExperience::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail()
            ->delete();

        return response()->json(['message' => 'Experience deleted successfully.']);
    }
}
