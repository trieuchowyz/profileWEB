<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeEducation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeEducationController extends Controller
{
    /**
     * Lấy danh sách education của 1 CV.
     *
     * GET /api/cv/resumes/{resumeId}/educations
     */
    public function index(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $educations = ResumeEducation::where('resume_id', $resumeId)
            ->orderBy('order_index')
            ->get();

        return response()->json(['data' => $educations]);
    }

    /**
     * Thêm một education vào CV.
     *
     * POST /api/cv/resumes/{resumeId}/educations
     */
    public function store(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'institution' => ['required', 'string', 'max:255'],
            'degree'      => ['nullable', 'string', 'max:255'],
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current'  => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'order_index' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $education = ResumeEducation::create(
            array_merge($validator->validated(), ['resume_id' => $resumeId])
        );

        return response()->json(['message' => 'Education added successfully.', 'data' => $education], 201);
    }

    /**
     * Cập nhật một education.
     *
     * PATCH /api/cv/resumes/{resumeId}/educations/{id}
     */
    public function update(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $education = ResumeEducation::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'institution' => ['sometimes', 'string', 'max:255'],
            'degree'      => ['sometimes', 'nullable', 'string', 'max:255'],
            'start_date'  => ['sometimes', 'nullable', 'date'],
            'end_date'    => ['sometimes', 'nullable', 'date', 'after_or_equal:start_date'],
            'is_current'  => ['sometimes', 'boolean'],
            'description' => ['sometimes', 'nullable', 'string'],
            'order_index' => ['sometimes', 'integer', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $education->update($validator->validated());

        return response()->json(['message' => 'Education updated successfully.', 'data' => $education->refresh()]);
    }

    /**
     * Xoá một education.
     *
     * DELETE /api/cv/resumes/{resumeId}/educations/{id}
     */
    public function destroy(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        ResumeEducation::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail()
            ->delete();

        return response()->json(['message' => 'Education deleted successfully.']);
    }
}
