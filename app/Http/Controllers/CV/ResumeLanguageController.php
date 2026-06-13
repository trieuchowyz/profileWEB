<?php

namespace App\Http\Controllers\CV;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use App\Models\ResumeLanguage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResumeLanguageController extends Controller
{
    /**
     * Lấy danh sách language của 1 CV.
     *
     * GET /api/cv/resumes/{resumeId}/languages
     */
    public function index(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $languages = ResumeLanguage::where('resume_id', $resumeId)->get();

        return response()->json(['data' => $languages]);
    }

    /**
     * Thêm một language vào CV.
     *
     * POST /api/cv/resumes/{resumeId}/languages
     */
    public function store(Request $request, int $resumeId): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'language'    => ['required', 'string', 'max:100'],
            'proficiency' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $language = ResumeLanguage::create(
            array_merge($validator->validated(), ['resume_id' => $resumeId])
        );

        return response()->json(['message' => 'Language added successfully.', 'data' => $language], 201);
    }

    /**
     * Cập nhật một language.
     *
     * PATCH /api/cv/resumes/{resumeId}/languages/{id}
     */
    public function update(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $language = ResumeLanguage::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'language'    => ['sometimes', 'string', 'max:100'],
            'proficiency' => ['sometimes', 'nullable', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
        }

        $language->update($validator->validated());

        return response()->json(['message' => 'Language updated successfully.', 'data' => $language->refresh()]);
    }

    /**
     * Xoá một language.
     *
     * DELETE /api/cv/resumes/{resumeId}/languages/{id}
     */
    public function destroy(Request $request, int $resumeId, int $id): JsonResponse
    {
        Resume::where('id', $resumeId)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        ResumeLanguage::where('id', $id)
            ->where('resume_id', $resumeId)
            ->firstOrFail()
            ->delete();

        return response()->json(['message' => 'Language deleted successfully.']);
    }
}