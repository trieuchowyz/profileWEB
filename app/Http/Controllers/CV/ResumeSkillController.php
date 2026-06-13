<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeSkill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeSkillController extends Controller
{
    /**
     * Lấy danh sách skill của 1 CV.
     *
     * GET /api/cv/resumes/{resumeId}/skills
     */
    public function index(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $skills = ResumeSkill::where('resume_id', $resumeId)
            ->orderBy('order_index')
            ->get();

        return response()->json(['data' => $skills]);
    }

    /**
     * Thêm một skill vào CV.
     *
     * POST /api/cv/resumes/{resumeId}/skills
     */
    public function store(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name'        => ['required', 'string', 'max:255'],
            'level'       => ['nullable', 'string', 'max:100'],
            'order_index' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $skill = ResumeSkill::create(
            array_merge($validator->validated(), ['resume_id' => $resumeId])
        );

        return response()->json(['message' => 'Skill added successfully.', 'data' => $skill], 201);
    }

    /**
     * Cập nhật một skill.
     *
     * PATCH /api/cv/resumes/{resumeId}/skills/{id}
     */
    public function update(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $skill = ResumeSkill::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name'        => ['sometimes', 'string', 'max:255'],
            'level'       => ['sometimes', 'nullable', 'string', 'max:100'],
            'order_index' => ['sometimes', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $skill->update($validator->validated());

        return response()->json(['message' => 'Skill updated successfully.', 'data' => $skill->refresh()]);
    }

    /**
     * Xoá một skill.
     *
     * DELETE /api/cv/resumes/{resumeId}/skills/{id}
     */
    public function destroy(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        ResumeSkill::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail()
            ->delete();

        return response()->json(['message' => 'Skill deleted successfully.']);
    }
}