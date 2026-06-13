<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Services\PdfExportService;
use App\Services\ResumeManagementService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResumeExportController extends Controller
{
    public function __construct(
        protected ResumeManagementService $resumeService,
        protected PdfExportService        $pdfExportService,
    ) {}

    /**
     * Tải xuống CV dưới dạng file PDF.
     *
     * GET /api/system/resumes/{id}/export/pdf
     *
     * Query params:
     *   - mode=download (mặc định) : buộc trình duyệt tải về
     *   - mode=inline              : hiển thị thẳng trên trình duyệt
     */
    public function downloadPdf(Request $request, int $id): Response|StreamedResponse|JsonResponse
    {
        try {
            // Dùng ResumeManagementService để lấy đầy đủ data (eager load 6 sections)
            $resume = $this->resumeService->getFullResume($id, $request->user());
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Resume not found.'], 404);
        }

        $mode = in_array($request->query('mode'), ['inline', 'download'])
            ? $request->query('mode')
            : 'download';

        return $this->pdfExportService->export($resume, $mode);
    }

    /**
     * Xuất CV công khai dưới dạng file PDF (không cần đăng nhập).
     *
     * GET /api/system/public/{slug}/export/pdf
     *
     * Query params:
     *   - mode=download | mode=inline
     */
    public function downloadPublicPdf(Request $request, string $slug): Response|StreamedResponse|JsonResponse
    {
        try {
            $resume = $this->resumeService->getPublicResume($slug);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Resume not found or not public.'], 404);
        }

        $mode = in_array($request->query('mode'), ['inline', 'download'])
            ? $request->query('mode')
            : 'download';

        return $this->pdfExportService->export($resume, $mode);
    }
}
