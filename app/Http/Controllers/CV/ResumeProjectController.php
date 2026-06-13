<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeProject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeProjectController extends Controller
{
    /**
     * Lấy danh sách project của 1 CV.
     *
     * GET /api/cv/resumes/{resumeId}/projects
     */
    public function index(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $projects = ResumeProject::where('resume_id', $resumeId)
            ->orderBy('order_index')
            ->get();

        return response()->json(['data' => $projects]);
    }

    /**
     * Thêm một project vào CV.
     *
     * POST /api/cv/resumes/{resumeId}/projects
     */
    public function store(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name'        => ['required', 'string', 'max:255'],
            'role'        => ['nullable', 'string', 'max:255'],
            'link'        => ['nullable', 'url', 'max:500'],
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['nullable', 'string'],
            'order_index' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $project = ResumeProject::create(
            array_merge($validator->validated(), ['resume_id' => $resumeId])
        );

        return response()->json(['message' => 'Project added successfully.', 'data' => $project], 201);
    }

    /**
     * Cập nhật một project.
     *
     * PATCH /api/cv/resumes/{resumeId}/projects/{id}
     */
    public function update(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $project = ResumeProject::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name'        => ['sometimes', 'string', 'max:255'],
            'role'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'link'        => ['sometimes', 'nullable', 'url', 'max:500'],
            'start_date'  => ['sometimes', 'nullable', 'date'],
            'end_date'    => ['sometimes', 'nullable', 'date', 'after_or_equal:start_date'],
            'description' => ['sometimes', 'nullable', 'string'],
            'order_index' => ['sometimes', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $project->update($validator->validated());

        return response()->json(['message' => 'Project updated successfully.', 'data' => $project->refresh()]);
    }

    /**
     * Xoá một project.
     *
     * DELETE /api/cv/resumes/{resumeId}/projects/{id}
     */
    public function destroy(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        ResumeProject::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail()
            ->delete();

        return response()->json(['message' => 'Project deleted successfully.']);
    }
}