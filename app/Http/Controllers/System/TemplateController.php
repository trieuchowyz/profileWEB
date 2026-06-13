<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Lấy danh sách tất cả template đang hoạt động.
     * Người dùng dùng để chọn mẫu CV khi tạo mới.
     *
     * GET /api/system/templates
     */
    public function index(): JsonResponse
    {
        $templates = Template::where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $templates]);
    }

    /**
     * Xem chi tiết 1 template (bao gồm default_styles để preview).
     *
     * GET /api/system/templates/{id}
     */
    public function show(int $id): JsonResponse
    {
        $template = Template::where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json(['data' => $template]);
    }
}